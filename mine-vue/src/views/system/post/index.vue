<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="岗位名称" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入岗位名称"></el-input>
        </el-form-item>
        <el-form-item label="岗位代码" class="ma-inline-form-item" prop="code">
          <el-input size="small" v-model="queryParams.code" placeholder="请输入岗位代码"></el-input>
        </el-form-item>
        <el-form-item label="状态" class="ma-inline-form-item" prop="status">
          <el-select size="small" v-model="queryParams.status" placeholder="岗位状态">
            <el-option label="启用" value="0">启用</el-option>
            <el-option label="停用" value="1">停用</el-option>
          </el-select>
        </el-form-item>
        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>
      </el-form>
    </template>
    <el-row :gutter="10">
      <el-col :span="1">
        <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:dept:save']" @click="$refs.deptForm.create()">新增部门</el-button>
      </el-col>
      <table-right-toolbar recycleCode="system-dept-recycle" @toggleData="switchDataType" @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="dataList" row-key="id">
      <el-table-column prop="name" label="部门名称" fixed width="240" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="sort" label="排序" width="80"></el-table-column>
      <el-table-column prop="leader" label="部门负责人"></el-table-column>
      <el-table-column prop="phone" label="负责人电话"></el-table-column>
      <el-table-column prop="status" label="状态" width="80">
        <template slot-scope="scope">
          {{ scope.row.status === '0' ? '启用' : '停用' }}
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="showRecycle">
            <el-button size="small" type="text" v-hasPermission="['system:dept:recovery']" icon="el-icon-refresh-left" @click="handleRecovery(scope.row.id)">恢复</el-button>
            <el-button size="small" type="text" v-hasPermission="['system:dept:realDelete']" icon="el-icon-delete" @click="handleRealDelete(scope.row.id)">删除</el-button>
          </div>
          <div v-else>
            <el-button size="small" type="text" v-hasPermission="['system:dept:update']" icon="el-icon-edit" @click="$refs.deptForm.update(scope.row)">修改</el-button>
            <el-button size="small" type="text" v-hasPermission="['system:dept:delete']" icon="el-icon-delete" @click="handleDelete(scope.row.id)">移到回收站</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <dept-form ref="deptForm" @closeDialog="handleClose"></dept-form>
  </ma-container>
</template>
<script>
import { getPageList, getPageListByRecycle, deletes, recoverys, realDeletes } from '@/api/system/post'
import DeptForm from './form'
export default {
  name: 'system-dept-index',
  components: {
    DeptForm
  },
  data () {
    return {
      // 是否显示回收站数据
      showRecycle: false,
      // 是否显示搜索
      showSearch: true,
      // 数据
      dataList: null,
      // 遮罩层
      loading: true,
      // 搜索
      queryParams: {
        name: undefined,
        code: undefined,
        status: undefined
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
      if (!this.showRecycle) {
        getPageList(this.queryParams).then(res => {
          this.dataList = res.data
          this.loading = false
        })
      } else {
        getPageListByRecycle(this.queryParams).then(res => {
          this.dataList = res.data
          this.loading = false
        })
      }
    },
    // form组件关闭调用方法
    handleClose (e) {
      e && this.getList()
    },
    // 切换回收站数据方法
    switchDataType () {
      this.showRecycle = !this.showRecycle
      this.getList()
    },
    // 显隐搜索
    switchShowSearch () {
      this.showSearch = !this.showSearch
    },
    // 移到回收站
    handleDelete (id) {
      this.$confirm('此操作会将数据移到回收站！', '提示', {
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
    // 恢复数据
    handleRecovery (id) {
      recoverys(id).then(res => {
        this.success(res.message)
        this.getList()
      })
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
