<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="角色名称" class="ma-inline-form-item" prop="name">
          <el-input size="small" v-model="queryParams.name" placeholder="请输入角色名称"></el-input>
        </el-form-item>
        <el-form-item label="角色代码" class="ma-inline-form-item" prop="code">
          <el-input size="small" v-model="queryParams.code" placeholder="请输入角色代码"></el-input>
        </el-form-item>
        <el-form-item label="状态" class="ma-inline-form-item" prop="status">
          <el-select size="small" v-model="queryParams.status" placeholder="角色状态">
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
    <el-row :gutter="20">
      <el-col :span="1.5">
        <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:role:save']" @click="$refs.roleForm.create()">新增</el-button>
        <el-button size="small" icon="el-icon-delete" :disabled="btnIsDisabed" v-hasPermission="['system:role:import']" @click="handleDeletes">删除</el-button>
      </el-col>
      <table-right-toolbar recycleCode="system-role-recycle" @toggleData="switchDataType" @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="dataList" row-key="id" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55">
          </el-table-column>
      <el-table-column prop="name" label="角色名称" fixed width="200" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="code" label="角色代码"></el-table-column>
      <el-table-column prop="sort" label="排序" ></el-table-column>
      <el-table-column prop="status" label="状态">
        <template slot-scope="scope">
          <el-switch v-model="scope.row.status" @change="handleStatus(scope.row)" active-value="0" inactive-value="1">
          </el-switch>
        </template>
      </el-table-column>
      <el-table-column prop="created_at" label="创建时间" ></el-table-column>
      <el-table-column label="操作" align="center" width="280">
        <template slot-scope="scope">
          <div v-if="showRecycle">
            <el-button type="text" v-hasPermission="['system:role:recovery']" @click="handleRecovery(scope.row.id)">恢复</el-button>
            <el-button type="text" v-hasPermission="['system:role:realDelete']" @click="handleRealDelete(scope.row.id)">删除</el-button>
          </div>
          <div v-else>
            <el-button type="text" v-hasPermission="['system:role:update']" @click="$refs.roleForm.update(scope.row)">修改</el-button>
            <el-button type="text" v-hasPermission="['system:role:menuPermi']" @click="$refs.dataForm.update(scope.row)">菜单权限</el-button>
            <el-button type="text" v-hasPermission="['system:role:dataPermi']" @click="$refs.dataForm.update(scope.row)">数据权限</el-button>
            <el-button type="text" v-hasPermission="['system:role:delete']" @click="handleDelete(scope.row.id)">移到回收站</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <role-form ref="roleForm" @closeDialog="handleClose"></role-form>
    <template slot="footer">
      <el-pagination @size-change="getList" @current-change="getList" layout="total, sizes, prev, pager, next, jumper" :page-sizes="[10, 20, 30, 50]" :current-page.sync="queryParams.page" :page-size.sync="queryParams.pageSize" :total="pageInfo.total">
      </el-pagination>
    </template>
  </ma-container>
</template>
<script>
import { getPageList, getPageListByRecycle, deletes, recoverys, realDeletes, changeRoleStatus } from '@/api/system/role'
import RoleForm from './form'
export default {
  name: 'system-role-index',
  components: {
    RoleForm
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
      // 分页数据
      pageInfo: { total: 0 },
      // 按钮禁用
      btnIsDisabed: true,
      // 搜索
      queryParams: {
        name: undefined,
        code: undefined,
        status: undefined,
        pageSize: 10,
        page: 1
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
          this.dataList = res.data.items
          this.pageInfo = res.data.pageInfo
          this.loading = false
        })
      } else {
        getPageListByRecycle(this.queryParams).then(res => {
          this.dataList = res.data.items
          this.pageInfo = res.data.pageInfo
          this.loading = false
        })
      }
    },
    // form组件关闭调用方法
    handleClose (e) {
      e && this.getList()
    },
    // 角色状态更改
    handleStatus (row) {
      const status = row.status === '0' ? '0' : '1'
      const text = row.status === '0' ? '启用' : '停用'
      this.$confirm(`确认要${text} ${row.name} 角色吗？`, '提示', {
        type: 'warning',
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(() => {
        changeRoleStatus({ id: row.id, status }).then(res => {
          this.success(text + '成功')
        })
      }).catch(() => {
        row.status = row.status === '0' ? '1' : '0'
      })
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
    // 批量删除
    handleDeletes () {
      this.showRecycle ? this.handleRealDelete(this.ids) : this.handleDelete(this.ids)
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
