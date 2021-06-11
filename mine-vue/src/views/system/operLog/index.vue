<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="登录时间" class="ma-inline-form-item">
          <el-date-picker
            size="small"
            type="daterange"
            v-model="dateRange"
            range-separator="至"
            format="yyyy-MM-dd"
            value-format="yyyy-MM-dd"
            @change="handleDateChange"
            start-placeholder="开始日期"
            end-placeholder="结束日期">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="操作用户" class="ma-inline-form-item" prop="username">
          <el-input size="small" v-model="queryParams.username" placeholder="请输入操作用户"></el-input>
        </el-form-item>
        <el-form-item label="业务名称" class="ma-inline-form-item" prop="service_name">
          <el-input size="small" v-model="queryParams.service_name" placeholder="请输入业务名称"></el-input>
        </el-form-item>
        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>
      </el-form>
    </template>
    <el-row :gutter="20">
      <el-col :span="1.5">
        <el-button size="small" icon="el-icon-delete" :disabled="btnIsDisabed" v-hasPermission="['system:post:delete']" @click="handleDeletes">删除</el-button>
      </el-col>
      <table-right-toolbar @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="dataList" row-key="id" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55">
      </el-table-column>
      <el-table-column prop="username" label="操作用户"></el-table-column>
      <el-table-column prop="service_name" label="业务名称"></el-table-column>
      <el-table-column prop="router" label="路由"></el-table-column>
      <el-table-column prop="ip" label="IP"></el-table-column>
      <el-table-column prop="ip_location" label="登录地点"></el-table-column>
      <el-table-column prop="request_data" label="请求数据"></el-table-column>
      <el-table-column prop="response_code" label="状态码"></el-table-column>
      <el-table-column prop="created_at" label="操作时间" width="160" ></el-table-column>
      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="text" @click="handleRecovery(scope.row.id)">详细</el-button>
        </template>
      </el-table-column>
    </el-table>
    <template slot="footer">
      <el-pagination @size-change="getList" @current-change="getList" layout="total, sizes, prev, pager, next, jumper" :page-sizes="[10, 20, 30, 50]" :current-page.sync="queryParams.page" :page-size.sync="queryParams.pageSize" :total="pageInfo.total">
      </el-pagination>
    </template>
  </ma-container>
</template>
<script>
import { getPageList, realDeletes } from '@/api/system/operLog'
export default {
  name: 'system-loginlog-index',
  data () {
    return {
      // 是否显示搜索
      showSearch: true,
      // 数据
      dataList: [],
      // 遮罩层
      loading: true,
      // 分页数据
      pageInfo: { total: 0 },
      // 按钮禁用
      btnIsDisabed: true,
      // 时间范围
      dateRange: null,
      // 搜索
      queryParams: {
        username: undefined,
        service_name: undefined,
        maxDate: undefined,
        minDate: undefined,
        pageSize: 10,
        page: 1
      }
    }
  },
  created () {
    this.getList()
  },
  methods: {
    // 获取数据
    getList () {
      this.loading = true
      getPageList(this.queryParams).then(res => {
        this.dataList = res.data.items
        this.pageInfo = res.data.pageInfo
        this.loading = false
      })
    },
    // 选择时间事件
    handleDateChange (values) {
      if (values !== null) {
        this.queryParams.minDate = values[0]
        this.queryParams.maxDate = values[1]
      }
    },
    // 显隐搜索
    switchShowSearch () {
      this.showSearch = !this.showSearch
    },
    // 真实删除数据
    handleRealDelete (id) {
      this.$confirm('此操作会将数据物理删除', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        realDeletes(id).then(res => {
          this.success(res.message)
          this.getList()
        })
      })
    },
    // 多选
    handleSelectionChange (items) {
      if (items.length > 0) {
        const ids = []
        items.forEach(item => {
          ids.push(item.id)
          this.btnIsDisabed = false
          this.ids = ids.join(',')
        })
      } else {
        this.btnIsDisabed = true
        this.ids = null
      }
    },
    // 批量删除
    handleDeletes () {
      this.handleRealDelete(this.ids)
    },
    // 搜索
    handleSearch () {
      this.getList()
    },
    // 重置搜索
    resetSearch () {
      this.$refs.queryParams.resetFields()
      this.dateRange = null
      this.queryParams.minDate = this.queryParams.maxDate = undefined
      this.handleSearch()
    }
  }
}
</script>
