<template>
  <el-container>
    <el-header>
      <div class="left-panel">
      </div>
      <div class="right-panel">
        <div class="right-panel-search">
          <el-input v-model="queryParams.username" clearable placeholder="请输入用户名"></el-input>

          <el-tooltip class="item" effect="dark" content="搜索" placement="top">
            <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
          </el-tooltip>

          <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
            <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
          </el-tooltip>

        </div>
      </div>
    </el-header>
    <el-main class="nopadding">
      <maTable
        ref="table"
        :api="api"
        stripe
        remoteSort
        remoteFilter
      >
        
        <el-table-column
          label="用户名"
          prop="username"
          :show-overflow-tooltip="true"
        ></el-table-column>

        <el-table-column
          label="昵称"
          prop="nickname"
        ></el-table-column>

        <el-table-column
          label="部门"
          prop="dept.name"
        ></el-table-column>

        <el-table-column
          label="登录IP"
          prop="login_ip"
        ></el-table-column>

        <el-table-column
          label="登录时间"
          prop="login_time"
        ></el-table-column>

        <el-table-column label="操作" fixed="right" align="right">
          <template #default="scope">

            <el-button
            type="text"
            v-auth="['setting:onlineUser:kick']"
            @click="handleKick(scope.row)"
          >强退用户</el-button>
            
          </template>
        </el-table-column>

      </maTable>
    </el-main>

    <el-dialog
      title="依赖包详细"
      v-model="dialogVisible"
      destroy-on-close
      @closed="dialogVisible = false"
      width="50%"
    >

      <el-table v-loading="detailsLoading" :data="details">
        <el-table-column prop="name" label="名称" width="120" fixed ></el-table-column>
        <el-table-column prop="value" label="值" :show-overflow-tooltip="true">
          <template #deault="scope">
            <div v-html="scope.row.value"></div>
          </template>
        </el-table-column>
      </el-table>

      <template #footer class="dialog-footer">
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </template>

    </el-dialog>

  </el-container>

</template>

<script>

  export default {
    name: 'system:monitor:rely',

    data() {
      return {
        dialogVisible: false,
        api: { list: this.$API.monitor.getOnlineUserPageList },
        queryParams: {
          username: undefined,
        }
      }
    },
    methods: {

      // 强制下线某用户
      handleKick (row) {
        this.$confirm(`确认要强制退出 ${row.username} 用户吗？`, '提示', {
          type: 'warning',
          confirmButtonText: '确定',
          cancelButtonText: '取消'
        }).then(() => {
          this.$API.monitor.kickUser({ id: row.id }).then(res => {
            this.$message.success(res.message)
          })
        }).catch(() => {})
      },

      //搜索
      handlerSearch(){
        this.$refs.table.upData(this.queryParams)
      },

      resetSearch() {
        this.queryParams = {
          username: undefined,
        }
        this.$refs.table.upData(this.queryParams)
      },
    },
  }
</script>

<style>
</style>
