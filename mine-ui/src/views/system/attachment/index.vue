<template>
  <el-container>
    <el-aside width="300px" v-loading="showDirloading">
      <el-container>
        <el-header>
          <el-input placeholder="过滤目录" v-model="filterText" clearable></el-input>
          <el-button type="primary" class="el-icon-plus" style="margin-left: 10px;" @click="add"> 新建</el-button>
        </el-header>
        <el-main class="nopadding">
          <el-tree
            ref="dirs"
            class="menu"
            node-key="name"
            :props="props"
            lazy
            :load="loadNode"
            :data="dirs"
            :current-node-key="''"
            :highlight-current="true"
            :expand-on-click-node="false"
            :filter-node-method="dirFilterNode"
            @node-click="dirClick"
          >
            <template #default="{node, data}">
              <span class="custom-tree-node">
                <span class="label">{{ node.label }}</span>
                <span class="do" v-if="node.label !== '所有目录文件'">

                    <el-tooltip class="item" effect="dark" content="新建子目录" placement="top">
                      <i
                        class="el-icon-plus"
                        v-auth="'system:menu:save'"
                        @click.stop="add(node, data)"
                      ></i>
                    </el-tooltip>

                    <el-tooltip class="item" effect="dark" content="删除" placement="top">
                      <i
                        class="el-icon-delete"
                        v-auth="'system:menu:delete'"
                        @click.stop="handleDeleteDir(data)"
                      ></i>
                    </el-tooltip>

                  </span>
              </span>
            </template>
          </el-tree>
        </el-main>
      </el-container>
    </el-aside>
    <el-container>
      <el-header>
        <div class="left-panel">

          <ma-resource-select :resource="false" @upload-data="handleSuccess" />

          <el-button-group>
            <el-button
              plain
              icon="el-icon-delete"
              v-auth="['system:post:delete']"
              @click="batchDel"
            >删除附件</el-button>

            <el-tooltip class="item" effect="dark" content="选择当前页所有" placement="top">
              <el-button size="small" icon="el-icon-check" @click="selectAll">全选</el-button>
            </el-tooltip>

            <el-tooltip class="item" effect="dark" content="反选当前页所有" placement="top">
              <el-button size="small" icon="el-icon-minus" @click="selectInvert">反选</el-button>
            </el-tooltip>

            <el-tooltip class="item" effect="dark" content="取消选择当前页" placement="top">
              <el-button size="small" icon="el-icon-close" @click="selectCancel">取消</el-button>
            </el-tooltip>

            <el-tooltip class="item" effect="dark" content="清除所有选中的" placement="top">
              <el-button size="small" icon="el-icon-error" @click="checkList = []">清除</el-button>
            </el-tooltip>
          </el-button-group>

        </div>
        <div class="right-panel">
          <div class="right-panel-search">
            <el-input v-model="queryParams.origin_name" clearable placeholder="请输入原文件名"></el-input>

            <el-tooltip class="item" effect="dark" content="搜索" placement="top">
              <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
            </el-tooltip>

            <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
              <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
            </el-tooltip>

            <el-popover placement="bottom-end" :width="450" trigger="click" >
              <template #reference>
                <el-button type="text" @click="povpoerShow = ! povpoerShow">
                  更多筛选<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
              </template>
              <el-form label-width="80px">

                <el-form-item label="存储模式" prop="status">
                  <el-select v-model="queryParams.storage_mode" clearable placeholder="请选择存储模式">
                    <el-option :label="item.label" :value="item.value" v-for="(item, index) in storageMode" :key="index">{{item.label}}</el-option>
                  </el-select>
                </el-form-item>

                <el-form-item label="创建时间">
                  <el-date-picker
                    clearable
                    v-model="dateRange"
                    type="daterange"
                    range-separator="至"
                    @change="handleDateChange"
                    value-format="YYYY-MM-DD"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                  ></el-date-picker>
                </el-form-item>

              </el-form>
            </el-popover>
          </div>
        </div>
      </el-header>
      <el-main class="nopadding file">
        <el-row class="file-list">
          <el-checkbox-group v-model="checkList">
            <ul class="el-upload-list el-upload-list--picture-card">
              <li
                v-for="(item, index) in dataList"
                :key="index"
                class="el-upload-list__item"
              >
                <div class="thumbnail">
                  <el-checkbox class="check" :label="item" > {{ index + 1 }}</el-checkbox>
                  <div class="mask">
                    <span class="del" @click.stop="remove(index)"><i class="el-icon-delete"></i></span>
                  </div>
                  <div class="icon" v-if="item.mime_type && item.mime_type.indexOf('image') === -1">
                    <i class="el-icon-document" />
                  </div>
                  <el-image v-else :src="item.url" fit="cover" :preview-src-list="preview" hide-on-click-modal append-to-body />
                  <el-tooltip placement="bottom">
                    <div class="filename"> {{ item.origin_name }} </div>
                    <template #content>

                      原名称：
                      <span>{{ item.origin_name }}</span>
                      <br />

                      <span>存储名称：{{ item.object_name }}<br /></span>

                      <span>存储目录：{{ item.storage_path }}<br /></span>

                      上传日期：
                      <span>{{ item.created_at }}</span>
                      <br />

                      <span>大小：{{ item.size_info }}</span>
                    </template>
                    <div class="name">{{ item.origin_name }}</div>

                  </el-tooltip>
                </div>
              </li>
            </ul>
          </el-checkbox-group>
        </el-row>

        <div class="scTable-page">
          <div class="scTable-pagination">
            <el-pagination background layout="total, prev, pager, next" :total="pageInfo.total" :page-size="queryParams.pageSize" :current-page="queryParams.page" @current-change="getList"></el-pagination>
          </div>
          <div class="scTable-do" v-if="!hideDo">

            <el-tooltip class="item" effect="dark" :content="getRecycleText" placement="top">
              <el-button
                @click="switchData"
                v-if="showRecycle"
                icon="el-icon-delete"
                circle
                style="margin-left:15px"
              ></el-button>
            </el-tooltip>
          </div>
        </div>
        
      </el-main>

    </el-container>

    <dirs-dialog v-if="dialog.save" ref="dirDialog" @success="handleDirSuccess" @closed="dialog.save=false" />

  </el-container>
</template>

<script>
  import dirsDialog from './dirs'
  import { union, xor, difference } from 'lodash'
  export default {
    name: 'system:attachment',

    components: {
      dirsDialog,
    },

    computed: {
      preview(){
        return this.dataList.filter( item => item.mime_type.indexOf('image') > -1).map(v => v.url)
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
        filterText: '',
        dateRange:'',
        api: {
          list: this.$API.attachment.getPageList,
          recycleList: this.$API.attachment.getRecyclePageList,
        },
        dataList: [],
        checkList: [],
        pageInfo: {},
        // 存储模式
        storageMode: [
          { label: '本地存储', value: 1 },
          { label: '阿里云OSS存储', value: 2 },
          { label: '七牛云存储', value: 3 },
          { label: '腾讯COS存储', value: 4 }
        ],
        selection: [],
        queryParams: {
          storage_mode: undefined,
          origin_name: undefined,
          storage_path: undefined,
          maxDate: undefined,
          minDate: undefined,
          pageSize: 50,
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
        this.$API.attachment.getPageList(this.queryParams).then(res => {
          this.dataList = res.data.items
          this.pageInfo = res.data.pageInfo
        })
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
      handleDeleteDir(node) {
        this.$confirm(`确定删除 ${node.name} 目录吗？`, '提示', {
          type: 'warning'
        }).then(async () => {
          await this.$API.upload.deleteUploadDir({ name: node.name }).then(async res => {
            if (res.success) {
              await this.loadDirs()
              this.$message.success(res.message)
            }
          }).catch(e => {
            this.$message.error(e)
          })
        })
      },

      handleDirSuccess() {
        this.loadDirs()
      },

      // 预览图片
      review (row) {
        this.record = row
        if (!/png|jpeg|jpg|png|bmp|gif/.test(row.mime_type)) {
          this.$message.error('非图片，无法预览')
          return false
        } else {
          this.dialogVisible = true
        }
      },

      //批量删除
      async batchDel(){
        await this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
          type: 'warning'
        }).then(() => {
          const loading = this.$loading();
          let ids = []
          this.selection.map(item => ids.push(item.id))
          if (this.isRecycle) {
            this.$API.attachment.realDeletes(ids.join(',')).then(() => {
              this.$refs.table.upData(this.queryParams)
            })
          } else {
            this.$API.attachment.deletes(ids.join(',')).then(() => {
              this.$refs.table.upData(this.queryParams)
            })
          }
          loading.close();
          this.$message.success("操作成功")
        })
      },

      // 单个删除
      async deletes(id) {
        await this.$confirm(`确定删除该数据吗？`, '提示', {
          type: 'warning'
        }).then(() => {
          const loading = this.$loading();
          if (this.isRecycle) {
            this.$API.attachment.realDeletes(id).then(() => {
              this.$refs.table.upData(this.queryParams)
            })
          } else {
            this.$API.attachment.deletes(id).then(() => {
              this.$refs.table.upData(this.queryParams)
            })
          }
          loading.close();
          this.$message.success("操作成功")
        }).catch(()=>{})
      },

      // 恢复数据
      async recovery (id) {
        await this.$API.attachment.recoverys(id).then(res => {
          this.$message.success(res.message)
          this.$refs.table.upData(this.queryParams)
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
      switchData(isRecycle) {
        this.isRecycle = isRecycle
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

      // 字段映射标签
      getLable (value) {
        return (this.storageMode.filter(item => item.value == value))[0].label
      },

      //本地更新数据
      handleSuccess(data = null){
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
      },

      // 取消当前页选择
      selectCancel () {
        this.checkList = difference(this.checkList, this.dataList)
      },
    },
    watch: {
      filterText(val) {
        this.$refs.dirs.filter(val);
      }
    },
  }
</script>

<style scoped lang="scss">
.el-main.nopadding {
  background: none;
}
.el-main.file .scTable-page {height:50px;display: flex;align-items: center;justify-content: space-between;padding:0 15px; border-top: 1px solid #e6e6e6; background: #fff}
[data-theme='dark'] .el-main.file .scTable-page {border-color: #434343; background: #2b2b2b !important;}

.custom-tree-node {display: flex;flex: 1;align-items: center;justify-content: space-between;font-size: 14px;padding-right: 5px;height:100%;}
.custom-tree-node .label {display: flex;align-items: center;;height: 100%;}
.custom-tree-node .label .el-tag {margin-left: 5px;}
.custom-tree-node .do {display: none;}
.custom-tree-node .do i {margin-left:5px;color: #999;padding:5px;}
.custom-tree-node .do i:hover {color: #333;}

.custom-tree-node:hover .do {display: inline-block;}

.thumbnail {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  position: relative;
  height: 150px;
}
.mask {display: none;position: absolute;top:0px;right:0px;line-height: 1;z-index: 1;}
.mask span {display: inline-block;width: 25px;height:25px;line-height: 23px;text-align: center;cursor: pointer;color: #fff;}
.mask span i {font-size: 12px;}
.mask .del {background: var(--el-color-primary);}
.thumbnail:hover .mask {display: inline-block;}
.el-upload-list--picture-card .el-upload-list__item {
  border-radius: 4px;
  border: none;
}
.file-list {
  display: flex;
  flex-direction: column;
  height: calc(100% - 50px);
  padding: 15px;
}
.filename {
  position: absolute;
  bottom: 2px;
  text-overflow: ellipsis;
  overflow: hidden;
  background: rgba(255,255,255, 0.2);
  padding: 0 5px;
  width: 100%;
  color: #555;
  cursor: pointer;
  height: 25px;
  line-height: 25px;
  font-size:12px;
  text-align: center;
}
.check {
  position: absolute;
  top: 2px;
  left: 5px;
  width: 120px;
  height: 20px;
  z-index: 9;
  overflow: hidden;
  color: #fff;
  text-shadow: 1px 1px 3px #333;
}
.icon {
  height: 148px;
  margin-right: 1px;
  color: #0960bd;
  font-size: 60px;
  text-align: center;
  padding: 12px 0;
}
</style>
