<template>
  <el-container>
    <el-aside width="240px" v-loading="showDirloading">
      <el-container>
        <el-header>
          <el-input placeholder="过滤目录" v-model="filterText" clearable></el-input>
          <el-button type="primary" class="el-icon-plus" style="margin-left: 10px;" @click="add"> 新增</el-button>
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

                    <el-tooltip class="item" effect="dark" content="新增子目录" placement="top">
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

          <el-button
            type="danger"
            plain
            icon="el-icon-delete"
            v-auth="['system:post:delete']"
            :disabled="selection.length===0"
            @click="batchDel"
          >删除附件</el-button>

          <ma-resource-select :resource="false" @upload-data="handleSuccess" />

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
      <el-main class="nopadding">
        <maTable
          ref="table"
          :api="api"
          :column="column"
          :showRecycle="true"
          @selection-change="selectionChange"
          @switch-data="switchData"
          stripe
          remoteSort
          remoteFilter
        >
          <el-table-column type="selection" width="50"></el-table-column>

          <el-table-column
            label="原文件名"
            prop="origin_name"
            width="100"
            :show-overflow-tooltip="true"
          ></el-table-column>

          <el-table-column
            label="新文件名"
            prop="object_name"
            width="100"
            :show-overflow-tooltip="true"
          ></el-table-column>

          <el-table-column prop="storage_mode" label="存储模式">
            <template #default="scope">
              {{ getLable(scope.row.storage_mode) }}
            </template>
          </el-table-column>

          <el-table-column
            label="资源类型"
            prop="mime_type"
            width="100"
            :show-overflow-tooltip="true"
          ></el-table-column>

          <el-table-column
            label="存储目录"
            prop="storage_path"
            width="100"
            :show-overflow-tooltip="true"
          ></el-table-column>

          <el-table-column
            label="扩展名"
            prop="suffix"
            width="80"
          ></el-table-column>

          <el-table-column
            label="文件大小"
            prop="size_info"
            :show-overflow-tooltip="true"
          ></el-table-column>

          <el-table-column
            label="创建时间"
            prop="created_at"
            width="140"
            sortable='custom'
          ></el-table-column>

          <!-- 正常数据操作按钮 -->
          <el-table-column label="操作" fixed="right" align="right" width="100" v-if="!isRecycle">
            <template #default="scope">

              <el-button
                type="text"
                size="small"
                @click="review(scope.row)"
                v-auth="['system:post:update']"
              >预览</el-button>

              <el-button
                type="text"
                size="small"
                @click="deletes(scope.row.id)"
                v-auth="['system:post:delete']"
              >删除</el-button>

            </template>
          </el-table-column>

          <!-- 回收站操作按钮 -->
          <el-table-column label="操作" fixed="right" align="right" width="130" v-else>
            <template #default="scope">

              <el-button
                type="text"
                size="small"
                v-auth="['system:post:recovery']"
                @click="recovery(scope.row.id)"
              >恢复</el-button>

              <el-button
                type="text"
                size="small"
                v-auth="['system:post:realDelete']"
                @click="deletes(scope.row.id)"
              >删除</el-button>

            </template>
          </el-table-column>

        </maTable>
      </el-main>

      <el-dialog
        title="图片预览"
        v-model="dialogVisible"
        destroy-on-close
        @closed="dialogVisible = false"
        width="50%"
      >

        <el-image :src="record.url" lazy></el-image>

        <template #footer class="dialog-footer">
          <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
        </template>

      </el-dialog>

    </el-container>

    <dirs-dialog v-if="dialog.save" ref="dirDialog" @success="handleDirSuccess" @closed="dialog.save=false" />

  </el-container>
</template>

<script>
  import dirsDialog from './dirs'
  export default {
    name: 'system:attachment',

    components: {
      dirsDialog,
    },

    data() {
      return {
        dialog: {
          save: false
        },
        dialogVisible: false,
        column: [],
        povpoerShow: false,
        showDirloading: false,
        filterText: '',
        dateRange:'',
        api: {
          list: this.$API.attachment.getPageList,
          recycleList: this.$API.attachment.getRecyclePageList,
        },
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
          minDate: undefined
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
    },
    methods: {

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
          this.$refs.table.upData(this.queryParams)
          return
        }
        this.queryParams.storage_path = data.name
        this.$refs.table.upData(this.queryParams)
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

      //表格选择后回调事件
      selectionChange(selection){
        this.selection = selection;
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
        this.$refs.table.upData(this.queryParams)
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
        this.$refs.table.upData(this.queryParams)
      },

      // 字段映射标签
      getLable (value) {
        return (this.storageMode.filter(item => item.value == value))[0].label
      },

      //本地更新数据
      handleSuccess(data = null){
        this.$refs.table.reload(this.queryParams)
      }
    },
    watch: {
      filterText(val) {
        this.$refs.dirs.filter(val);
      }
    },
  }
</script>

<style>
  .custom-tree-node {display: flex;flex: 1;align-items: center;justify-content: space-between;font-size: 14px;padding-right: 5px;height:100%;}
  .custom-tree-node .label {display: flex;align-items: center;;height: 100%;}
  .custom-tree-node .label .el-tag {margin-left: 5px;}
  .custom-tree-node .do {display: none;}
  .custom-tree-node .do i {margin-left:5px;color: #999;padding:5px;}
  .custom-tree-node .do i:hover {color: #333;}

  .custom-tree-node:hover .do {display: inline-block;}
</style>
