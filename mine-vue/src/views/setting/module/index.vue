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
          icon="el-icon-puls"
          v-hasPermission="['setting:local:save']"
          @click="$refs.Form.create()"
        >创建新模块</el-button>

      </el-col>

      <table-right-toolbar
        @refreshTable="getList"
        @toggleSearch="switchShowSearch"
      ></table-right-toolbar>

    </el-row>

    <el-table v-loading="loading" :data="dataList">

      <el-table-column prop="name" label="名称" width="150">
      </el-table-column>

      <el-table-column prop="label" label="标签" width="150">
      </el-table-column>

      <el-table-column prop="version" label="版本" width="150">
      </el-table-column>

      <el-table-column prop="description" label="描述" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="installed" label="状态" width="100">
        <template slot-scope="scope">
          {{scope.row.installed ? '正常' : '已卸载'}}
        </template>
      </el-table-column>

      <el-table-column label="操作" align="center" width="150">
        <template slot-scope="scope">
          <el-button type="text" :disabled="scope.row.name == 'System' || scope.row.name == 'Setting'" v-hasPermission="['system:dataMaintain:columnList']" @click="handleDetail(scope.row.name)">卸载</el-button>
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

    <add-form ref="Form" @closeDialog="handleClose"></add-form>
  </ma-container>
</template>
<script>
import { getPageList } from '@/api/setting/module'
import addForm from './form'
export default {
  name: 'setting-local-index',
  components: {
    addForm
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
