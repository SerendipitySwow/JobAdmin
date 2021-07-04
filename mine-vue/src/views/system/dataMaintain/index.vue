<template>
  <ma-container>

    <template slot="header" v-if="showSearch">
      <el-form
        :inline="true"
        ref="queryParams"
        :model="queryParams"
        label-width="80px"
      >
        <el-form-item label="表名" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入表名"></el-input>
        </el-form-item>

        <el-form-item label="表引擎" class="ma-inline-form-item" prop="engine">
          <el-select size="small" v-model="queryParams.engine" placeholder="表引擎">
            <el-option
              :label="item.label"
              :value="item.value"
              v-for="(item, index) in engines"
              :key="index"
            >{{item.label}}</el-option>
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

        <el-button
          size="small"
          icon="el-icon-magic-stick"
          :disabled="btnIsDisabed"
          v-hasPermission="['system:dataMaintain:optimize']"
          @click="handleOptimize
        ">优化表</el-button>

        <el-button
          size="small"
          icon="el-icon-delete"
          :disabled="btnIsDisabed"
          v-hasPermission="['system:dataMaintain:fragment']"
          @click="handleClear"
          >清理碎片</el-button>

      </el-col>

      <table-right-toolbar
        @refreshTable="getList"
        @toggleSearch="switchShowSearch"
      ></table-right-toolbar>

    </el-row>

    <el-table v-loading="loading" :data="dataList" row-key="Name" @selection-change="handleSelectionChange">

      <el-table-column type="selection" width="55">
      </el-table-column>

      <el-table-column prop="name" label="表名称" width="180" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="engine" label="表引擎">
      </el-table-column>

      <el-table-column prop="rows" label="总行数">
      </el-table-column>

      <el-table-column prop="data_free" label="碎片大小">
        <template slot-scope="scope">
          {{formatData(scope.row.data_free)}}
        </template>
      </el-table-column>

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

      <el-table-column prop="collation" label="字符集" width="180" :show-overflow-tooltip="true"></el-table-column>

      <el-table-column prop="create_time" label="创建时间">
        <template slot-scope="scope">
          {{scope.row.create_time.substr(0, 10)}}
        </template>
      </el-table-column>

      <el-table-column prop="comment" label="表注释" :show-overflow-tooltip="true"></el-table-column>

      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="text" v-hasPermission="['system:dataMaintain:columnList']" @click="handleDetail(scope.row.name)">查看</el-button>
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

    <el-dialog
      title="操作日志详细"
      :visible.sync="dialogVisible"
      width="50%"
      :before-close="handleDialogClose"
    >
        <el-table :data="columnList" stripe>
          <el-table-column prop="column_name" label="字段名称">
          </el-table-column>

          <el-table-column prop="column_type" label="字段类型">
          </el-table-column>

          <el-table-column prop="column_comment" label="字段注释">
          </el-table-column>
        </el-table>
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="dialogVisible = false" size="small">确 定</el-button>
        </span>
    </el-dialog>
  </ma-container>
</template>
<script>
import { getPageList, getColumnList, optimize, fragment } from '@/api/system/dataMaintain'
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
      },
      // modal
      dialogVisible: false,
      // 表结构数据
      columnList: [],
      // 选择的表名
      names: []
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
    // 显示表字段
    handleDetail (name) {
      getColumnList(name).then(res => {
        this.columnList = res.data
        this.dialogVisible = true
      })
    },
    // 表字段modal关闭
    handleDialogClose () {
      this.dialogVisible = false
    },
    // 优化表
    handleOptimize () {
      optimize({ tables: this.names }).then(res => {
        res.success && this.success(res.message)
      })
    },
    // 清理表碎片
    handleClear () {
      fragment({ tales: this.names }).then(res => {
        res.success && this.success(res.message)
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
        items.forEach(item => {
          this.names.push(item.name)
          this.btnIsDisabed = false
        })
      } else {
        this.btnIsDisabed = true
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
