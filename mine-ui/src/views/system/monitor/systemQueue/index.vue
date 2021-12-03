<template>
  <el-container>
    <el-header>
      <div class="left-panel">
        <el-button
          type="danger"
          plain
          icon="el-icon-delete"
          v-auth="['system:SystemQueue:delete']"
          :disabled="selection.length==0"
          @click="batchDel"
        >删除</el-button>

      </div>
      <div class="right-panel">
        <div class="right-panel-search">

          <el-input v-model="queryParams.uuid" placeholder="UUID" clearable></el-input>

          <el-tooltip class="item" effect="dark" content="搜索" placement="top">
            <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
          </el-tooltip>

          <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
            <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
          </el-tooltip>

          <el-popover placement="bottom-end" :width="450" trigger="click" >
            <template #reference>
              <el-button type="text" @click="povpoerShow = ! povpoerShow">
                更多筛选<el-icon>el-icon-arrow-down /></el-icon>
              </el-button>
            </template>
            <el-form label-width="80px">

            <el-form-item label="交换机名称" prop="exchange_name">
                <el-input v-model="queryParams.exchange_name" placeholder="交换机名称" clearable></el-input>
            </el-form-item>

            <el-form-item label="路由名称" prop="routing_key_name">
                <el-input v-model="queryParams.routing_key_name" placeholder="路由名称" clearable></el-input>
            </el-form-item>

            <el-form-item label="队列名称" prop="queue_name">
                <el-input v-model="queryParams.queue_name" placeholder="队列名称" clearable></el-input>
            </el-form-item>

            <el-form-item label="队列内容" prop="queue_content">
                <el-input v-model="queryParams.queue_content" placeholder="队列内容" clearable></el-input>
            </el-form-item>

            <el-form-item label="队列内容" prop="log_content">
                <el-input v-model="queryParams.log_content" placeholder="队列内容" clearable></el-input>
            </el-form-item>

            <el-form-item label="生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复" prop="produce_status">
                <el-input v-model="queryParams.produce_status" placeholder="生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复" clearable></el-input>
            </el-form-item>

            <el-form-item label="消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复" prop="consume_status">
                <el-input v-model="queryParams.consume_status" placeholder="消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复" clearable></el-input>
            </el-form-item>

            <el-form-item label="延迟时间（秒）" prop="delay_time">
                <el-input v-model="queryParams.delay_time" placeholder="延迟时间（秒）" clearable></el-input>
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
           label="UUID"
           prop="uuid"
        />
        <el-table-column
           label="交换机名称"
           prop="exchange_name"
        />
        <el-table-column
           label="路由名称"
           prop="routing_key_name"
        />
        <el-table-column
           label="队列名称"
           prop="queue_name"
        />
        <el-table-column
           label="队列内容"
           prop="queue_content"
        />
        <el-table-column
           label="队列内容"
           prop="log_content"
        />
        <el-table-column
           label="生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复"
           prop="produce_status"
        />
        <el-table-column
           label="消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复"
           prop="consume_status"
        />
        <el-table-column
           label="延迟时间（秒）"
           prop="delay_time"
        />

        <!-- 正常数据操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-if="!isRecycle">
          <template #default="scope">

            <el-button
              type="text"
              size="small"
              @click="tableEdit(scope.row, scope.$index)"
              v-auth="['system:SystemQueue:update']"
            >编辑</el-button>

            <el-button
              type="text"
              size="small"
              @click="deletes(scope.row.id)"
              v-auth="['system:SystemQueue:delete']"
            >删除</el-button>

          </template>
        </el-table-column>

        <!-- 回收站操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-else>
          <template #default="scope">

            <el-button
              type="text"
              size="small"
              v-auth="['system:SystemQueue:recovery']"
              @click="recovery(scope.row.id)"
            >恢复</el-button>

            <el-button
              type="text"
              size="small"
              v-auth="['system:SystemQueue:realDelete']"
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
    name: 'system:SystemQueue',
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

        column: [],
        povpoerShow: false,
        dateRange:'',
        api: {
          list: this.$API.systemQueue.getList,
          recycleList: this.$API.systemQueue.getRecycleList,
        },
        selection: [],
        queryParams: {

          uuid: undefined,
          exchange_name: undefined,
          routing_key_name: undefined,
          queue_name: undefined,
          queue_content: undefined,
          log_content: undefined,
          produce_status: undefined,
          consume_status: undefined,
          delay_time: undefined,
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
            this.$API.systemQueue.realDeletes(ids.join(','))
            this.$refs.table.upData(this.queryParams)
          } else {
            this.$API.systemQueue.deletes(ids.join(','))
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
            await this.$API.systemQueue.realDeletes(id)
            this.$refs.table.upData(this.queryParams)
          } else {
            await this.$API.systemQueue.deletes(id)
            this.$refs.table.upData(this.queryParams)
          }
          loading.close();
          this.$message.success("操作成功")
        }).catch(()=>{})
      },

      // 恢复数据
      async recovery (id) {
        await this.$API.systemQueue.recoverys(id).then(res => {
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

          uuid: undefined,
          exchange_name: undefined,
          routing_key_name: undefined,
          queue_name: undefined,
          queue_content: undefined,
          log_content: undefined,
          produce_status: undefined,
          consume_status: undefined,
          delay_time: undefined,
        }
        this.$refs.table.upData(this.queryParams)
      },

      //本地更新数据
      handleSuccess(){
        this.$refs.table.upData(this.queryParams)
      },

      // 获取字典数据
      getDictData() {

      }
    }
  }
</script>
