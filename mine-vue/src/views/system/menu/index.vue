<template>
  <ma-container style="padding-top:0">
    <template slot="header">Header</template>
    <el-row :gutter="10">
      <el-col :span="1">
        <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:menu:save']" @click="$refs.menuForm.create()">新增菜单</el-button>
      </el-col>
      <table-right-toolbar @toggleData="switchDataType" recycleCode="system-menu-save" @refreshTable="getList"></table-right-toolbar>
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
            <el-button size="small" type="text" v-hasPermission="['system:menu:recovery']" icon="el-icon-refresh-left" @click="handleRecovery(scope.row)">恢复</el-button>
            <el-button size="small" type="text" v-hasPermission="['system:menu:realDelete']" icon="el-icon-delete" @click="handleRealDelete(scope.row.id)">删除</el-button>
          </div>
          <div v-else>
            <el-button size="small" type="text" v-hasPermission="['system:menu:update']" icon="el-icon-edit" @click="$refs.menuForm.update(scope.row)">修改</el-button>
            <el-button size="small" type="text" v-hasPermission="['system:menu:delete']" icon="el-icon-delete" @click="handleDelete(scope.row.id)">移到回收站</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <menu-form ref="menuForm" :menuTree="menuTree" @closeDialog="handleClose"></menu-form>
  </ma-container>
</template>
<script>
import { getMenuTree, getRecycle, deletes } from '@/api/system/menu'
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
      // 遮罩层
      loading: true,
      // 数据
      menuTree: []
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
        getMenuTree().then(res => {
          this.menuTree = res.data
          this.loading = false
        })
      } else {
        getRecycle().then(res => {
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
    // 移到回收站
    handleDelete (id) {
      this.$confirm('此操作会将数据移到回收站！', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        deletes(id).then(res => {
          this.$message({ type: 'success', message: res.message })
        })
      })
    },
    // 真实删除数据
    handleRealDelete (id) {

    }
  }
}
</script>
