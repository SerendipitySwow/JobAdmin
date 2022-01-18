<template>
  <el-container>
    <el-header>
      <div class="left-panel">

        <el-button
            icon="el-icon-plus"
            v-auth="['task:mission:save']"
            type="primary"
            @click="add"
        >新增
        </el-button>

        <el-button
            type="danger"
            plain
            icon="el-icon-delete"
            v-auth="['task:mission:delete']"
            :disabled="selection.length==0"
            @click="batchDel"
        >删除
        </el-button>

      </div>
      <div class="right-panel">
        <div class="right-panel-search">

          <el-input v-model="queryParams.status" placeholder="任务状态 0:待处理 1:处理中 2:已处理 3:已取消 4:处理失败" clearable></el-input>

          <el-tooltip class="item" effect="dark" content="搜索" placement="top">
            <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
          </el-tooltip>

          <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
            <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
          </el-tooltip>

          <el-popover placement="bottom-end" :width="450" trigger="click">
            <template #reference>
              <el-button type="text" @click="povpoerShow = ! povpoerShow">
                更多筛选
                <el-icon>
                  <el-icon-arrow-down/>
                </el-icon>
              </el-button>
            </template>
            <el-form label-width="80px">

              <el-form-item label="重试间隔(秒)" prop="step">
                <el-input v-model="queryParams.step" placeholder="重试间隔(秒)" clearable></el-input>
              </el-form-item>

              <el-form-item label="执行时间" prop="runtime">
                <el-input v-model="queryParams.runtime" placeholder="执行时间" clearable></el-input>
              </el-form-item>

              <el-form-item label="任务内容" prop="content">
                <el-input v-model="queryParams.content" placeholder="任务内容" clearable></el-input>
              </el-form-item>

              <el-form-item label="任务执行时间" prop="timeout">
                <el-input v-model="queryParams.timeout" placeholder="任务执行时间" clearable></el-input>
              </el-form-item>

              <el-form-item label="任务名称" prop="name">
                <el-input v-model="queryParams.name" placeholder="任务名称" clearable></el-input>
              </el-form-item>

              <el-form-item label="执行当前的任务协程ID,用于取消当前任务" prop="coroutine_id">
                <el-input v-model="queryParams.coroutine_id" placeholder="执行当前的任务协程ID,用于取消当前任务" clearable></el-input>
              </el-form-item>

              <el-form-item label="当任务执行出现错误时,记录错误信息" prop="memo">
                <el-input v-model="queryParams.memo" placeholder="当任务执行出现错误时,记录错误信息" clearable></el-input>
              </el-form-item>

              <el-form-item label="执行任务完成的结果" prop="result">
                <el-input v-model="queryParams.result" placeholder="执行任务完成的结果" clearable></el-input>
              </el-form-item>

              <el-form-item label="重试次数" prop="retry_times">
                <el-input v-model="queryParams.retry_times" placeholder="重试次数" clearable></el-input>
              </el-form-item>

              <el-form-item label="consul运行服务的ID" prop="consul_service_id">
                <el-input v-model="queryParams.consul_service_id" placeholder="consul运行服务的ID" clearable></el-input>
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
            label="任务状态"
            prop="status"
        >
          <template #default="scope">
            <el-tag class="mx-1" size="large" v-if="scope.row.status === 0" type="">待处理</el-tag>
            <el-tag class="mx-1" size="large" v-if="scope.row.status === 1" type="info">处理中</el-tag>
            <el-tag class="mx-1" size="large" v-if="scope.row.status === 2" type="success">已处理</el-tag>
            <el-tag class="mx-1" size="large" v-if="scope.row.status === 3" type="warning">已取消</el-tag>
            <el-tag class="mx-1" size="large" v-if="scope.row.status === 3" type="danger">处理失败</el-tag>
          </template>
        </el-table-column>
        <el-table-column
            label="重试间隔(秒)"
            prop="step"
        />
        <el-table-column
            label="执行时间"
            prop="runtime"
        />
        <el-table-column
            label="任务内容"
            prop="content"
            :show-overflow-tooltip="true"
        />
        <el-table-column
            label="执行时间"
            prop="timeout"
        />
        <el-table-column
            label="任务名称"
            prop="name"
        />
        <el-table-column
            label="协程ID"
            prop="coroutine_id"
        />
        <el-table-column
            label="错误信息"
            prop="memo"
            :show-overflow-tooltip="true"
        />
        <el-table-column
            label="任务结果"
            prop="result"
            :show-overflow-tooltip="true"
        />
        <el-table-column
            label="重试次数"
            prop="retry_times"
        />
        <el-table-column
            label="Service"
            prop="consul_service_id"
        />

        <!-- 正常数据操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-if="!isRecycle">
          <template #default="scope">

            <el-button
                type="text"
                size="small"
                @click="tableShow(scope.row)"
                v-auth="['task:mission:view']"
            >查看
            </el-button>

            <el-button
                type="text"
                size="small"
                @click="tableEdit(scope.row, scope.$index)"
                v-auth="['task:mission:update']"
            >编辑
            </el-button>

            <el-button
                type="text"
                size="small"
                @click="deletes(scope.row.id)"
                v-auth="['task:mission:delete']"
            >删除
            </el-button>

          </template>
        </el-table-column>

        <!-- 回收站操作按钮 -->
        <el-table-column label="操作" fixed="right" align="right" width="130" v-else>
          <template #default="scope">

            <el-button
                type="text"
                size="small"
                v-auth="['task:mission:recovery']"
                @click="recovery(scope.row.id)"
            >恢复
            </el-button>

            <el-button
                type="text"
                size="small"
                v-auth="['task:mission:realDelete']"
                @click="deletes(scope.row.id)"
            >删除
            </el-button>

          </template>
        </el-table-column>

      </maTable>
    </el-main>
  </el-container>

  <save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>

  <info-dialog v-if="info.show" ref="infoDialog"  @success="handleSuccess" @closed="info.show=false"></info-dialog>

</template>

<script>
import saveDialog from './save'
import infoDialog from './info'

export default {
  name: 'task:mission',
  components: {
    saveDialog,
    infoDialog
  },
  async created(){
    await this.getDictData();
  },
  data(){
    return {
      dialog: {
        save: false
      },
      info:{
        show:false
      },
      column: [],
      povpoerShow: false,
      dateRange: '',
      api: {
        list: this.$API.missionTask.getList,
        recycleList: this.$API.missionTask.getRecycleList,
      },
      selection: [],
      queryParams: {
        status: undefined,
        step: undefined,
        runtime: undefined,
        content: undefined,
        timeout: undefined,
        name: undefined,
        coroutine_id: undefined,
        memo: undefined,
        result: undefined,
        retry_times: undefined,
        consul_service_id: undefined,
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
    }, //编辑
    tableEdit(row){
      this.dialog.save = true
      this.$nextTick(() => {
        this.$refs.info.open('edit').setData(row)
      })
    }, //查看
    tableShow(row){
      this.info.show = true
      this.$nextTick(() => {
        this.$refs.infoDialog.show()
      })
    }, //批量删除
    async batchDel(){
      await this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
        type: 'warning'
      }).then(() => {
        const loading = this.$loading();
        let ids = []
        this.selection.map(item => ids.push(item.id))
        if(this.isRecycle){
          this.$API.missionTask.realDeletes(ids.join(',')).then(res => {
            if(res.success){
              this.$message.success(res.message)
              this.$refs.table.upData(this.queryParams)
            }else{
              this.$message.error(res.message)
            }
          })
        }else{
          this.$API.missionTask.deletes(ids.join(',')).then(res => {
            if(res.success){
              this.$message.success(res.message)
              this.$refs.table.upData(this.queryParams)
            }else{
              this.$message.error(res.message)
            }
          })
        }
        loading.close();
      })
    }, // 单个删除
    async deletes(id){
      await this.$confirm(`确定删除该数据吗？`, '提示', {
        type: 'warning'
      }).then(async () => {
        const loading = this.$loading();
        if(this.isRecycle){
          await this.$API.missionTask.realDeletes(id)
          this.$refs.table.upData(this.queryParams)
        }else{
          await this.$API.missionTask.deletes(id)
          this.$refs.table.upData(this.queryParams)
        }
        loading.close();
        this.$message.success("操作成功")
      }).catch(() => {
      })
    }, // 恢复数据
    async recovery(id){
      await this.$API.missionTask.recoverys(id).then(res => {
        this.$message.success(res.message)
        this.$refs.table.upData(this.queryParams)
      })
    }, //表格选择后回调事件
    selectionChange(selection){
      this.selection = selection;
    }, // 选择时间事件
    handleDateChange(values){
      if(values !== null){
        this.queryParams.minDate = values[0]
        this.queryParams.maxDate = values[1]
      }
    }, //搜索
    handlerSearch(){
      this.$refs.table.upData(this.queryParams)
    }, // 切换数据类型回调
    switchData(isRecycle){
      this.isRecycle = isRecycle
    },
    resetSearch(){
      this.queryParams = {
        status: undefined,
        step: undefined,
        runtime: undefined,
        content: undefined,
        timeout: undefined,
        name: undefined,
        coroutine_id: undefined,
        memo: undefined,
        result: undefined,
        retry_times: undefined,
        consul_service_id: undefined,
      }
      this.$refs.table.upData(this.queryParams)
    }, //本地更新数据
    handleSuccess(){
      this.$refs.table.upData(this.queryParams)
    }, // 获取字典数据
    getDictData(){
    }
  }
}
</script>
