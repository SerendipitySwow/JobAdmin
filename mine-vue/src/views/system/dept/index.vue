<template>
  <ma-container>
    <template slot="header" v-if="showSearch">

      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">

        <el-form-item label="部门名称" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入部门名称"></el-input>
        </el-form-item>

        <el-form-item label="状态" class="ma-inline-form-item" prop="status">
          <el-select size="small" v-model="queryParams.status" placeholder="部门状态">
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

        <el-button
          size="small"
          icon="el-icon-plus"
          v-hasPermission="['system:dept:save']"
          @click="$refs.deptForm.create()"
        >新增</el-button>

      </el-col>

      <table-right-toolbar
       recycleCode="system:dept:recycle"
       @toggleData="switchDataType"
       @refreshTable="getList"
       @toggleSearch="switchShowSearch"
      ></table-right-toolbar>

    </el-row>

    <el-table
      v-loading="loading"
      :data="deptTree"
      row-key="id"
      :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
    >

      <el-table-column prop="name" label="部门名称" fixed width="240" :show-overflow-tooltip="true">
      </el-table-column>

      <el-table-column prop="sort" label="排序">
      </el-table-column>

      <el-table-column prop="leader" label="部门负责人">
      </el-table-column>

      <el-table-column prop="phone" label="负责人电话">
      </el-table-column>

      <el-table-column prop="status" label="状态">
        <template slot-scope="scope">
          {{ scope.row.status === '0' ? '启用' : '停用' }}
        </template>
      </el-table-column>

      <el-table-column label="操作" align="center">
        <template slot-scope="scope">

          <div v-if="showRecycle">

            <el-button
              type="text"
              v-hasPermission="['system:dept:recovery']"
              @click="handleRecovery(scope.row.id)"
            >恢复</el-button>

            <el-button
              type="text"
              v-hasPermission="['system:dept:realDelete']"
              @click="handleRealDelete(scope.row.id)"
            >删除</el-button>

          </div>

          <div v-else>

            <el-button
              type="text"
              v-hasPermission="['system:dept:update']"
              @click="$refs.deptForm.update(scope.row)"
            >修改</el-button>

            <el-button
              type="text"
              v-hasPermission="['system:dept:delete']"
              @click="handleDelete(scope.row.id)"
            >移到回收站</el-button>

          </div>
        </template>

      </el-table-column>

    </el-table>

    <dept-form ref="deptForm" @closeDialog="handleClose"></dept-form>

  </ma-container>
</template>
<script>

import { getDeptTree, getRecycle, deletes, recoverys, realDeletes } from '@/api/system/dept'
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
      // 遮罩层
      loading: true,
      // 数据
      deptTree: [],
      // 搜索
      queryParams: {
        name: undefined,
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
        getDeptTree(this.queryParams).then(res => {
          this.deptTree = res.data
          this.loading = false
        })
      } else {
        getRecycle(this.queryParams).then(res => {
          this.deptTree = res.data
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
