import { union, xor } from 'lodash'
export default { 
  computed: {
    preview(){
      return this.dataList.filter( item => item.mime_type.indexOf('image') > -1).map(v => this.viewImage(v.url))
    },
  },

  data() {
    return {
      dialog: {
        save: false
      },
      dialogVisible: false,
      povpoerShow: false,
      showDirloading: false,
      showFileloading: true,
      filterText: '',
      dateRange:'',
      dataList: [],
      checkList: [],
      pageInfo: {
        total: 0
      },
      // 存储模式
      storageMode: [
        { label: '本地存储', value: 1 },
        { label: '阿里云OSS存储', value: 2 },
        { label: '七牛云存储', value: 3 },
        { label: '腾讯COS存储', value: 4 }
      ],
      queryParams: {
        storage_mode: undefined,
        origin_name: undefined,
        storage_path: undefined,
        maxDate: undefined,
        minDate: undefined,
        pageSize: 30,
        page:1,
      },
      isRecycle: false,
      dirs:[],
      // 当前记录
      record: { url: '' },
      props: {
        label: 'name',
        children: 'children',
        isLeaf: 'leaf',
      },
    }
  },
  created () {
    this.loadDirs()
    this.getList()
  },
  methods: {

    getList () {
      this.showFileloading = true
      if (this.isRecycle) {
        this.$API.attachment.getRecyclePageList(this.queryParams).then(res => {
          this.dataList = res.data.items
          this.pageInfo = res.data.pageInfo
          this.showFileloading = false
        })
      } else {
        this.$API.attachment.getPageList(this.queryParams).then(res => {
          this.dataList = res.data.items
          this.pageInfo = res.data.pageInfo
          this.showFileloading = false
        })
      }
    },

    async loadNode(node, resolve) {
      if (node.data.name !== undefined) {
        let data = await this.loadDirs(node.data.name)
        if (data.length < 1) {
          this.$message.info('没有子目录')
          return resolve([])
        } else {
          return resolve(data)
        }
      }
    },

    async loadDirs (dir = '/') {
      let res = await this.$API.upload.getDirectory({path: dir})
      if (res.data.length < 0) {
        return []
      }
      if (res.success) {
        if (dir === '/') {
          this.dirs = res.data.map(item => {
            return {name: item.basename, leaf: false, children: []}
          })
          this.dirs.unshift({name: '所有目录文件', leaf: true, children: []})
          return []
        } else {
          let data = res.data.map(item => {
            return {name: item.basename, leaf: false, children: []}
          })
          return data
        }
      } else {
        this.$message.error('获取目录列表失败')
        return []
      }
    },

    //树过滤
    dirFilterNode(value, data){
      if (!value) return true;
      return data.name.indexOf(value) !== -1;
    },
    //树点击事件
    dirClick(data){
      if (this.queryParams.storage_path == data.name) {
        return
      }
      if (data.name == '所有目录文件') {
        this.queryParams.storage_path = undefined
        this.getList()
        return
      }
      this.queryParams.storage_path = data.name
      this.getList()
    },

    //添加
    add(node = null){
      this.dialog.save = true
      this.$nextTick(() => {
        this.$refs.dirDialog.open(node)
      })
    },

    // 删除目录
    handleDeleteDir(data, node) {
      console.log(node)
      this.$confirm(`确定删除 ${data.name} 目录吗？`, '提示', {
        type: 'warning'
      }).then(async () => {
        await this.$API.upload.deleteUploadDir({ name: data.name }).then(async res => {
          if (res.success) {
            await this.loadDirs()
            this.$message.success(res.message)
          } else {
            this.$message.error(res.message)
          }
        }).catch(e => {
          this.$message.error(e)
        })
      })
    },

    handleDirSuccess() {
      this.loadDirs()
    },

    //批量删除
    async batchDel(){
      await this.$confirm(`确定删除选中的 ${this.checkList.length} 项吗？`, '提示', {
        type: 'warning'
      }).then(() => {
        let ids = []
        this.checkList.map(item => ids.push(item.id))
        if (this.isRecycle) {
          this.$API.attachment.realDeletes(ids.join(',')).then(res => {
            if (res.success) {
              this.getList()
              this.$message.success(res.message)
            } else {
              this.$message.error(res.message)
            }
          })
        } else {
          this.$API.attachment.deletes(ids.join(',')).then(res => {
            if (res.success) {
              this.getList()
              this.$message.success(res.message)
            } else {
              this.$message.error(res.message)
            }
          })
        }
      })
    },

    // 单个删除
    async deletes(id) {
      await this.$confirm(`确定删除该数据吗？`, '提示', {
        type: 'warning'
      }).then(() => {
        if (this.isRecycle) {
          this.$API.attachment.realDeletes(id).then(res => {
            if (res.success) {
              this.getList()
              this.$message.success(res.message)
            } else {
              this.$message.error(res.message)
            }
          })
        } else {
          this.$API.attachment.deletes(id).then(res => {
            if (res.success) {
              this.getList()
              this.$message.success(res.message)
            } else {
              this.$message.error(res.message)
            }
          })
        }
      }).catch(()=>{})
    },

    // 恢复数据
    async recovery () {
      let ids = []
      this.checkList.map(item => ids.push(item.id))
      await this.$API.attachment.recoverys(ids.join(',')).then(res => {
        if (res.success) {
          this.$message.success(res.message)
          this.getList()
        } else {
          this.$message.error(res.message)
        }
      })
    },

    // 选择时间事件
    handleDateChange (values) {
      if (values !== null) {
        this.queryParams.minDate = values[0]
        this.queryParams.maxDate = values[1]
      }
    },

    //搜索
    handlerSearch(){
      this.getList()
    },

    // 切换数据类型回调
    switchData() {
      this.isRecycle = !this.isRecycle
      this.getList()
    },

    resetSearch() {
      this.queryParams = {
        storage_mode: undefined,
        storage_path: undefined,
        origin_name: undefined,
        maxDate: undefined,
        minDate: undefined
      }
    },

    //本地更新数据
    handleSuccess(){
      this.getList()
    },

    selectAdd (item) {
      this.checkList = xor(this.checkList, [item])
    },

    // 全选当前页
    selectAll () {
      this.checkList = union(this.checkList, this.dataList)
    },

    // 反选当前页
    selectInvert () {
      this.checkList = xor(this.checkList, this.dataList)
    }
  },
  watch: {
    filterText(val) {
      this.$refs.dirs.filter(val);
    }
  }
}
