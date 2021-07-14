<template>
  <ma-container>
    <template slot="header">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">

        <el-form-item label="依赖包名" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入依赖包名"></el-input>
        </el-form-item>

        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>

      </el-form>
    </template>

    <el-table v-loading="loading" :data="dataList">

      <el-table-column prop="name" label="依赖包名" width="260" fixed :show-overflow-tooltip="true"></el-table-column>

      <el-table-column prop="version" label="版本号" width="100"></el-table-column>

      <el-table-column prop="description" label="简介" :show-overflow-tooltip="true"></el-table-column>

      <el-table-column label="操作" width="80" >

        <template slot-scope="scope">
          <el-button
            type="text"
            v-hasPermission="['system:monitor:relyDetail']"
            @click="handleDetails(scope.row.name)"
          >详细</el-button>
        </template>

      </el-table-column>

    </el-table>

    <template slot="footer">

      <el-pagination
        @size-change="getList"
        @current-change="getList"
        layout="total, sizes, prev, pager, next, jumper"
        :page-sizes="[10, 20, 30, 50]"
        :current-page.sync="queryParams.page"
        :page-size.sync="queryParams.pageSize"
        :total="pageInfo.total"
      ></el-pagination>

    </template>

    <el-dialog
      title="依赖包详细"
      :visible.sync="relyVisible"
      width="50%"
      :before-close="handleClose"
    >
      <el-table v-loading="detailsLoading" :data="details">
        <el-table-column prop="name" label="名称" width="120" fixed ></el-table-column>
        <el-table-column prop="value" label="值" :show-overflow-tooltip="true">
          <template slot-scope="scope">
            <div v-html="scope.row.value"></div>
          </template>
        </el-table-column>
      </el-table>
    </el-dialog>
  </ma-container>
</template>
<script>

import { getPackagePageList, getPackageDetail } from '@/api/system/monitor'

export default {
  name: 'system-monitor-rely',

  data () {
    return {
      // dialog
      relyVisible: false,
      // 数据
      dataList: [],
      // 遮罩层
      loading: true,
      detailsLoading: true,
      // 分页数据
      pageInfo: { total: 0 },
      // 按钮禁用
      btnIsDisabed: true,
      // 时间范围
      dateRange: null,
      // 依赖包详细
      details: [],
      // 搜索
      queryParams: {
        name: undefined,
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
      getPackagePageList(this.queryParams).then(res => {
        this.dataList = res.data.items
        this.pageInfo = res.data.pageInfo
        this.loading = false
      })
    },

    // 显示dialog
    handleDetails (name) {
      this.relyVisible = true
      this.detailsLoading = true
      getPackageDetail(name).then(res => {
        this.details = res.data
        this.detailsLoading = false
      })
    },

    // 关闭dialog
    handleClose () {
      this.relyVisible = false
    },

    // 搜索
    handleSearch () {
      this.getList()
    },

    // 重置搜索
    resetSearch () {
      this.$refs.queryParams.resetFields()
      this.handleSearch()
    }
  }
}
</script>
