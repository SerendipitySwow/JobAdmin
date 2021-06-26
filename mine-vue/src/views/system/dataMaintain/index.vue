<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="表名" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入表名"></el-input>
        </el-form-item>
        <el-form-item label="表引擎" class="ma-inline-form-item" prop="engine">
          <el-select size="small" v-model="queryParams.engine" placeholder="表引擎">
            <el-option :label="item.label" :value="item.value" v-for="(item, index) in engines" :key="index">{{item.label}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>
      </el-form>
    </template>
    <el-row :gutter="20">
      <el-col :span="1.5">
        <el-button size="small" icon="el-icon-magic-stick" :disabled="btnIsDisabed" v-hasPermission="['system:dataMaintain:save']">优化表</el-button>
        <el-button size="small" icon="el-icon-delete" :disabled="btnIsDisabed" v-hasPermission="['system:dataMaintain:import']">清理碎片</el-button>
      </el-col>
      <table-right-toolbar @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="dataList" row-key="Name" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55">
      </el-table-column>
      <el-table-column prop="name" label="表名称"></el-table-column>
      <el-table-column prop="engine" label="表引擎"></el-table-column>
      <el-table-column prop="rows" label="总行数"></el-table-column>
      <el-table-column prop="data_length" label="数据大小">
        <template slot-scope="scope">
          {{formatData(scope.row.data_length)}}
        </template>
      </el-table-column>
      <el-table-column prop="index_length" label="索引大小">
        <template slot-scope="scope">
          {{formatData(scope.row.index_length)}}
        </template>
      </el-table-column>
      <el-table-column prop="collation" label="字符集"></el-table-column>
      <el-table-column prop="create_time" label="创建时间">
        <template slot-scope="scope">
          {{scope.row.create_time.substr(0, 10)}}
        </template>
      </el-table-column>
      <el-table-column prop="comment" label="表注释"></el-table-column>
      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="text" v-hasPermission="['system:dataMaintain:update']" :value="scope.row.name">查看</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- <post-form ref="postForm" @closeDialog="handleClose"></post-form> -->
    <template slot="footer">
      <el-pagination @size-change="getList" @current-change="getList" layout="total, sizes, prev, pager, next, jumper" :page-sizes="[10, 20, 30, 50]" :current-page.sync="queryParams.page" :page-size.sync="queryParams.pageSize" :total="pageInfo.total">
      </el-pagination>
    </template>
  </ma-container>
</template>
<script>
import { getPageList } from '@/api/system/dataMaintain'
export default {
  name: 'system-dataMaintain-index',
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
      // 引擎选项
      engines: [],
      // 搜索
      queryParams: {
        name: undefined,
        engine: undefined,
        pageSize: 10,
        page: 1
      }
    }
  },
  created () {
    this.getList()
    this.getDicts('table_engine').then(res => {
      this.engines = res.data
    })
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
    formatData (data) {
      if (data < (1024 * 1024)) {
        return parseInt(data / 1024 / 1024) + 'Kb'
      } else {
        return parseInt(data / 1024 / 1024 / 1024) + 'Mb'
      }
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
