<template>
  <el-container>
    <el-header>
      <div class="left-panel">

        <el-button
          icon="el-icon-plus"
          v-auth="['system:SystemQueueMessage:save']"
          type="primary"
          @click="add"
        >新增</el-button>

        <el-button
          type="danger"
          plain
          icon="el-icon-delete"
          v-auth="['system:SystemQueueMessage:delete']"
          :disabled="selection.length==0"
          @click="batchDel"
        >删除</el-button>

      </div>
      <div class="right-panel">
        <div class="right-panel-search">

          <el-input v-model="queryParams.content_type" placeholder="内容类型" clearable></el-input>

          <el-tooltip class="item" effect="dark" content="搜索" placement="top">
            <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
          </el-tooltip>

          <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
            <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
          </el-tooltip>

          <el-popover placement="bottom-end" :width="450" trigger="click" >
            <template #reference>
              <el-button type="text" @click="povpoerShow = ! povpoerShow">
                更多筛选<el-icon><el-icon-arrow-down /></el-icon>
              </el-button>
            </template>
            <el-form label-width="80px">

            <el-form-item label="消息内容" prop="content">
                <el-input v-model="queryParams.content" placeholder="消息内容" clearable></el-input>
            </el-form-item>

            <el-form-item label="接收人" prop="receive_by">
                <el-input v-model="queryParams.receive_by" placeholder="接收人" clearable></el-input>
            </el-form-item>

            <el-form-item label="发送人" prop="send_by">
                <el-input v-model="queryParams.send_by" placeholder="发送人" clearable></el-input>
            </el-form-item>

            <el-form-item label="发送状态" prop="send_status">

            <el-select v-model="queryParams.send_status" style="width:100%" clearable placeholder="发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败">
                <el-option
                    v-for="(item, index) in message_send_status_data"
                    :key="index"
                    :label="item.label"
                    :value="item.value"
                >{{item.label}}</el-option>
            </el-select>
            </el-form-item>

            <el-form-item label="查看状态" prop="read_status">

            <el-select v-model="queryParams.read_status" style="width:100%" clearable placeholder="查看状态 0:未读 1: 已读">
                <el-option
                    v-for="(item, index) in message_read_status_data"
                    :key="index"
                    :label="item.label"
                    :value="item.value"
                >{{item.label}}</el-option>
            </el-select>
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
        row-key="id"
        :hidePagination="false"
        @selection-change="selectionChange"
        @switch-data="switchData"
        stripe
        remoteSort
      >
        <el-table-column type="selection" width="50"></el-table-column>


        <el-table-column
           label="内容类型"
           prop="content_type"
        />
        <el-table-column
           label="消息内容"
           prop="content"
        />
        <el-table-column
           label="接收人"
           prop="receive_name"
        />
        <el-table-column
           label="发送人"
           prop="send_name"
        />
        <el-table-column
           label="发送状态"
           prop="send_status"
        />
        <el-table-column
           label="查看状态"
           prop="read_status"
        />

        <!-- 正常数据操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-if="!isRecycle">
          <template #default="scope">

            <el-button
              type="text"
              size="small"
              @click="tableEdit(scope.row, scope.$index)"
              v-auth="['system:SystemQueueMessage:update']"
            >编辑</el-button>

            <el-button
              type="text"
              size="small"
              @click="deletes(scope.row.id)"
              v-auth="['system:SystemQueueMessage:delete']"
            >删除</el-button>

          </template>
        </el-table-column>

        <!-- 回收站操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-else>
          <template #default="scope">

            <el-button
              type="text"
              size="small"
              v-auth="['system:SystemQueueMessage:recovery']"
              @click="recovery(scope.row.id)"
            >恢复</el-button>

            <el-button
              type="text"
              size="small"
              v-auth="['system:SystemQueueMessage:realDelete']"
              @click="deletes(scope.row.id)"
            >删除</el-button>

          </template>
        </el-table-column>

      </maTable>
    </el-main>
  </el-container>

  <save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>

</template>

<script>
  import saveDialog from './save'

  export default {
    name: 'system:SystemQueueMessage',
    components: {
      saveDialog
    },

    async created() {
        await this.getDictData();
    },

    data() {
      return {
        dialog: {
          save: false
        },

        message_send_status_data: [],
        message_read_status_data: [],
        column: [],
        povpoerShow: false,
        dateRange:'',
        api: {
          list: this.$API.systemQueueMessage.getList,
          recycleList: this.$API.systemQueueMessage.getRecycleList,
        },
        selection: [],
        queryParams: {

          content_type: undefined,
          content: undefined,
          receive_by: undefined,
          send_by: undefined,
          send_status: undefined,
          read_status: undefined,
        },
        isRecycle: false,
      }
    },
    methods: {

      //添加
      add(){
        this.dialog.save = true
        this.$nextTick(() => {
          this.$refs.saveDialog.open()
        })
      },

      //编辑
      tableEdit(row){
        this.dialog.save = true
        this.$nextTick(() => {
          this.$refs.saveDialog.open('edit').setData(row)
        })
      },

      //查看
      tableShow(row){
        this.dialog.save = true
        this.$nextTick(() => {
          this.$refs.saveDialog.open('show').setData(row)
        })
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
            this.$API.systemQueueMessage.realDeletes(ids.join(','))
            this.$refs.table.upData(this.queryParams)
          } else {
            this.$API.systemQueueMessage.deletes(ids.join(','))
            this.$refs.table.upData(this.queryParams)
          }
          loading.close();
          this.$message.success("操作成功")
        })
      },

      // 单个删除
      async deletes(id) {
        await this.$confirm(`确定删除该数据吗？`, '提示', {
          type: 'warning'
        }).then(async () => {
          const loading = this.$loading();
          if (this.isRecycle) {
            await this.$API.systemQueueMessage.realDeletes(id)
            this.$refs.table.upData(this.queryParams)
          } else {
            await this.$API.systemQueueMessage.deletes(id)
            this.$refs.table.upData(this.queryParams)
          }
          loading.close();
          this.$message.success("操作成功")
        }).catch(()=>{})
      },

      // 恢复数据
      async recovery (id) {
        await this.$API.systemQueueMessage.recoverys(id).then(res => {
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

          content_type: undefined,
          content: undefined,
          receive_by: undefined,
          send_by: undefined,
          send_status: undefined,
          read_status: undefined,
        }
        this.$refs.table.upData(this.queryParams)
      },

      //本地更新数据
      handleSuccess(){
        this.$refs.table.upData(this.queryParams)
      },

      // 获取字典数据
      getDictData() {

          this.getDict('message_send_status').then(res => {
              this.message_send_status_data = res.data
          })
          this.getDict('message_read_status').then(res => {
              this.message_read_status_data = res.data
          })
      }
    }
  }
</script>
