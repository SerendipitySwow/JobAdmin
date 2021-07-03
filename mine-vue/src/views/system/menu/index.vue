<template>
  <ma-container style="padding-top:0">
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="菜单名称" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入菜单名称"></el-input>
        </el-form-item>
        <el-form-item label="状态" class="ma-inline-form-item" prop="status">
          <el-select size="small" v-model="queryParams.status" placeholder="菜单状态">
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
        <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:menu:save']" @click="$refs.menuForm.create()">新增</el-button>
      </el-col>
      <table-right-toolbar recycleCode="system:menu:recycle" @toggleData="switchDataType" @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="menuTree" row-key="id" :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
      <el-table-column prop="name" label="菜单名称" fixed width="240" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="icon" label="图标" align="center" width="100">
        <template slot-scope="scope">
          <ma-icon :name="scope.row.icon" />
        </template>
      </el-table-column>
      <el-table-column prop="sort" label="排序" width="80"></el-table-column>
      <el-table-column prop="code" label="菜单代码"></el-table-column>
      <el-table-column prop="component" label="组件路径">
        <template slot-scope="scope">
          {{ scope.row.component ? scope.row.component : '-' }}
        </template>
      </el-table-column>
      <el-table-column prop="type" label="类型">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.type === 'T'">分类</el-tag>
          <el-tag type="danger" v-if="scope.row.type === 'C'">目录</el-tag>
          <el-tag type="warning" v-if="scope.row.type === 'M'">菜单</el-tag>
          <el-tag type="success" v-if="scope.row.type === 'B'">按钮</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="status" label="状态" width="80">
        <template slot-scope="scope">
          {{ scope.row.status === '0' ? '启用' : '停用' }}
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="showRecycle">
            <el-button type="text" v-hasPermission="['system:menu:recovery']" @click="handleRecovery(scope.row.id)">恢复</el-button>
            <el-button type="text" v-hasPermission="['system:menu:realDelete']" @click="handleRealDelete(scope.row.id)">删除</el-button>
          </div>
          <div v-else>
            <el-button type="text" v-hasPermission="['system:menu:update']" @click="$refs.menuForm.update(scope.row)">修改</el-button>
            <el-button type="text" v-hasPermission="['system:menu:delete']" @click="handleDelete(scope.row.id)">移到回收站</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <menu-form ref="menuForm" @closeDialog="handleClose"></menu-form>
  </ma-container>
</template>
<script>
import { getMenuTree, getRecycle, deletes, recoverys, realDeletes } from '@/api/system/menu'
import MenuForm from './form'
export default {
  name: 'system-menu-index',
  components: {
    MenuForm
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
      menuTree: [],
      // 搜索
      queryParams: {
        dept_id: undefined,
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
        getMenuTree(this.queryParams).then(res => {
          this.menuTree = res.data
          this.loading = false
        })
      } else {
        getRecycle(this.queryParams).then(res => {
          this.menuTree = res.data
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
