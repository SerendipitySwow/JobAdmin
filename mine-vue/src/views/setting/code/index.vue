<template>
  <ma-container>

    <template slot="header" v-if="showSearch">
      <el-form
        :inline="true"
        ref="queryParams"
        :model="queryParams"
        label-width="80px"
      >
        <el-form-item label="表名称" class="ma-inline-form-item" prop="table_name">
          <el-input size="small" v-model="queryParams.table_name" placeholder="请输入表名称"></el-input>
        </el-form-item>

        <el-form-item label="创建时间" class="ma-inline-form-item">
          <el-date-picker
            size="small"
            type="daterange"
            v-model="dateRange"
            range-separator="至"
            format="yyyy-MM-dd"
            value-format="yyyy-MM-dd"
            @change="handleDateChange"
            start-placeholder="开始日期"
            end-placeholder="结束日期"
          ></el-date-picker>
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
          :disabled="btnIsDisabed"
          @click="handleGenCodes"
        >生成代码</el-button>

        <el-button
          size="small"
          icon="el-icon-delete"
          v-hasPermission="['setting:code:delete']"
          :disabled="btnIsDisabed"
          @click="handleDeletes"
        >删除</el-button>

        <el-button
          size="small"
          icon="el-icon-upload2"
          v-hasPermission="['setting:code:loadTable']"
          @click="$refs.table.show()"
        >装载数据表</el-button>

      </el-col>

      <table-right-toolbar
        @refreshTable="getList"
        @toggleSearch="switchShowSearch"
      ></table-right-toolbar>

    </el-row>

    <el-table v-loading="loading" :data="dataList" row-key="id" @selection-change="handleSelectionChange">

      <el-table-column type="selection" width="55"></el-table-column>

      <el-table-column prop="table_name" label="表名称" width="180" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="table_comment" label="表描述" width="180" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="type" label="生成类型">
        <template slot-scope="scope">
          <el-tag size="small" v-if="scope.row.type === 'single'">单表CRUD</el-tag>
          <el-tag size="small" v-if="scope.row.type === 'tree'">树表CRUD</el-tag>
          <el-tag size="small" v-if="scope.row.type === 'parent_sub'">父子表CRUD</el-tag>
        </template>
      </el-table-column>

      <el-table-column prop="created_at" label="创建时间">
      </el-table-column>

      <el-table-column prop="updated_at" label="更新时间">
      </el-table-column>

      <el-table-column label="操作" align="center" width="245">
        <template slot-scope="scope">

          <el-button type="text" 
            v-hasPermission="['setting:code:preview']" 
            @click="handleDelete(scope.row.id)"
          >预览</el-button>

          <el-button type="text" 
            v-hasPermission="['setting:code:edit']" 
            @click="$refs.editForm.show(scope.row)"
          >编辑</el-button>

          <el-button type="text" 
            v-hasPermission="['setting:code:sync']" 
            @click="handleSync(scope.row.id)"
          >同步</el-button>
          
          <el-button type="text" 
            v-hasPermission="['setting:code:delete']" 
            @click="handleDelete(scope.row.id)"
          >删除</el-button>

          <el-button type="text" 
            v-hasPermission="['setting:code:generate']" 
            @click="handleDelete(scope.row.id)"
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

    <table-list ref="table" @confirm="confirm" />

    <edit-form ref="editForm" />
    
  </ma-container>
</template>
<script>

import { getPageList, deletes, sync } from '@/api/setting/generate'

import editForm from './edit'
import tableList from './table'
export default {
  name: 'setting-code',
  components: {
    tableList,
    editForm
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
      // 使用启用
      btnIsDisabed: true,
      // 日期时间范围
      dateRange: null,
      // 分页数据
      pageInfo: { total: 0 },
      // 搜索
      queryParams: {
        table_name: undefined,
        maxDate: undefined,
        minDate: undefined,
        pageSize: 10,
        page: 1
      },
      // ID列表
      ids: []
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

    // 同步数据表
    handleSync (id) {
      this.$confirm('此操作会导致字段设置信息丢失，确定同步吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        sync(id).then(res => {
          res.success && this.success(res.message)
        })
      })
    },

    // 批量删除
    handleDeletes () {
      this.handleDelete(this.ids)
    },
    
    // 删除
    handleDelete (id) {
      this.$confirm('此操作会将数据物理删除？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        deletes(id).then(res => {
          this.success(res.message)
          this.getList()
        })
      })
    },

    // 选择时间事件
    handleDateChange (values) {
      if (values !== null) {
        this.queryParams.minDate = values[0]
        this.queryParams.maxDate = values[1]
      }
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
      this.dateRange = null
      this.queryParams.minDate = this.queryParams.maxDate = undefined
      this.handleSearch()
    },

    // 多选生成
    handleGenCodes () {

    },

    // 生成代码
    genCode () {

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
  }
}
</script>
