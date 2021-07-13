<template>
  <ma-container>

    <template slot="header" v-if="showSearch">
      <el-form
        :inline="true"
        ref="queryParams"
        :model="queryParams"
        label-width="80px"
      >
        <el-form-item label="模块名称" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入模块名称"></el-input>
        </el-form-item>

        <el-form-item label="模块标签" class="ma-inline-form-item" prop="label">
          <el-input size="small" v-model="queryParams.label" placeholder="请输入模块标签"></el-input>
        </el-form-item>

        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>

      </el-form>
    </template>

    <el-row :gutter="20">
      <el-col :span="1.5">

        <el-button
          size="small"
          icon="el-icon-download"
          v-hasPermission="['setting:code:generate']"
          @click="handleGenCode"
        >生成代码</el-button>

        <el-button
          size="small"
          icon="el-icon-upload2"
          v-hasPermission="['setting:code:loadTable']"
          @click="$refs.table.show()"
        >装载数据表</el-button>

        <el-button
          size="small"
          icon="el-icon-delete"
          v-hasPermission="['setting:code:delete']"
          @click="handleDelete"
        >删除</el-button>

      </el-col>

      <table-right-toolbar
        @refreshTable="getList"
        @toggleSearch="switchShowSearch"
      ></table-right-toolbar>

    </el-row>

    <el-table v-loading="loading" :data="dataList">

      <el-table-column prop="name" label="表名称" width="150">
      </el-table-column>

      <el-table-column prop="label" label="业务名" width="150">
      </el-table-column>

      <el-table-column prop="version" label="表描述" width="150">
      </el-table-column>

      <el-table-column prop="version" label="创建时间" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="version" label="更新时间" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column label="操作" align="center" width="245">
        <template slot-scope="scope">

          <el-button type="text" 
            v-hasPermission="['system:module:delete']" 
            @click="handleDelete(scope.row.name)"
          >预览</el-button>

          <el-button type="text" 
            v-hasPermission="['system:module:delete']" 
            @click="handleDelete(scope.row.name)"
          >编辑</el-button>

          <el-button type="text" 
            v-hasPermission="['system:module:delete']" 
            @click="handleDelete(scope.row.name)"
          >同步</el-button>
          
          <el-button type="text" 
            v-hasPermission="['system:module:delete']" 
            @click="handleDelete(scope.row.name)"
          >删除</el-button>

          <el-button type="text" 
            v-hasPermission="['system:module:delete']" 
            @click="handleDelete(scope.row.name)"
          >生成代码</el-button>

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
        :total="pageInfo.total">
      </el-pagination>
    </template>

    <table-list ref="table" @confirm="confirm"></table-list>

    <!-- <add-form ref="Form" @closeDialog="handleClose"></add-form> -->
  </ma-container>
</template>
<script>

import { getPageList, remove } from '@/api/setting/module'

// import addForm from './form'
import tableList from './table'
export default {
  name: 'setting-code',
  components: {
    tableList
    // addForm
  },
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
      // 搜索
      queryParams: {
        name: undefined,
        label: undefined,
        pageSize: 10,
        page: 1
      },
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

    // 装载数据表后处理方法
    confirm () {
      this.getList()
    },
    
    // 删除
    handleDelete (name) {
      this.$confirm('删除模块不可逆，确定要删除吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        remove(name).then(res => {
          this.success(res.message)
          this.getList()
        })
      })
    },

    // form组件关闭调用方法
    handleClose (e) {
      e && this.getList()
    },

    // 显隐搜索
    switchShowSearch () {
      this.showSearch = !this.showSearch
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
