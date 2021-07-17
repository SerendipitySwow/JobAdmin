<template>
  <el-dialog
    title="装载数据表"
    :visible.sync="dialogVisible"
    width="50%"
    :before-close="handleDialogClose"
  >
    <el-form
      :inline="true"
      ref="queryParams"
      :model="queryParams"
      label-width="40px"
    >
      <el-form-item label="表名" class="ma-inline-form-item" prop="name">
        <el-input size="small" v-model="queryParams.name" placeholder="请输入表名"></el-input>
      </el-form-item>

      <el-form-item class="ma-inline-form-item">
        <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
        <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
      </el-form-item>

    </el-form>

    <el-table
      v-loading="loading"
      :data="dataList"
      row-key="Name"
      @selection-change="handleSelectionChange"
      class="mt-10"
    >

      <el-table-column type="selection" width="55">
      </el-table-column>

      <el-table-column prop="name" label="表名称" width="200" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="comment" label="表注释" :show-overflow-tooltip="true"></el-table-column>

      <el-table-column prop="create_time" label="创建时间" width="110">
        <template slot-scope="scope">
          {{scope.row.create_time.substr(0, 10)}}
        </template>
      </el-table-column>

    </el-table>

    <span slot="footer" class="dialog-footer">
      <el-pagination
        @size-change="getList"
        @current-change="getList"
        layout="total, prev, pager, next"
        :page-sizes="[10, 20, 30, 50]"
        :current-page.sync="queryParams.page"
        :page-size.sync="queryParams.pageSize"
        :total="pageInfo.total"
        class="ma-fl"
      ></el-pagination>

      <el-button @click="handleDialogClose" size="small">关 闭</el-button>
      <el-button type="primary" @click="loadTable" size="small">确 定</el-button>
    </span>
  </el-dialog>
</template>
<script>

import { getPageList } from '@/api/system/dataMaintain'
import { loadTable } from '@/api/setting/generate'

export default {
  name: 'system-code-table',

  data () {
    return {
      // 数据
      dataList: [],
      // 遮罩层
      loading: true,
      // 分页数据
      pageInfo: { total: 0 },
      // 搜索
      queryParams: {
        name: undefined,
        engine: undefined,
        pageSize: 10,
        page: 1
      },
      // modal
      dialogVisible: false,
      // 选择的表名
      names: []
    }
  },

  methods: {

    // 显示表分页
    show () {
      this.dialogVisible = true
      this.names = []
      this.getList()
    },

    // 装载数据表
    loadTable () {
      loadTable({ names: this.names }).then(res => {
        if (res.success) {
          this.handleDialogClose()
          this.$emit('confirm')
        } 
      })
    },

    // 获取数据
    getList () {
      this.loading = true
      getPageList(this.queryParams).then(res => {
        this.dataList = res.data.items
        this.pageInfo = res.data.pageInfo
        this.loading = false
      })
    },

    // 表字段modal关闭
    handleDialogClose () {
      this.dialogVisible = false
    },

    // 多选
    handleSelectionChange (items) {
      if (items.length > 0) {
        this.names = items.map(item => {
          return { name: item.name, comment: item.comment }
        })
      } else {
        this.names = []
      }
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
