<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="用户名称" class="ma-inline-form-item" prop="username">
          <el-input size="small" v-model="queryParams.username" placeholder="请输入用户名称"></el-input>
        </el-form-item>
        <el-form-item label="状态" class="ma-inline-form-item" prop="status">
          <el-select size="small" v-model="queryParams.status" placeholder="用户状态">
            <el-option label="启用" value="0">启用</el-option>
            <el-option label="停用" value="1">停用</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="创建时间" class="ma-inline-form-item">
          <!-- <el-date-picker
            size="small"
            v-model="value1"
            type="daterange"
            range-separator="至"
            start-placeholder="开始日期"
            end-placeholder="结束日期">
          </el-date-picker> -->
        </el-form-item>
        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>
      </el-form>
    </template>
    <el-row :gutter="20">
      <el-col :span="4">
        <el-input placeholder="请输入部门名称" v-model="filterDept" size="small">
        </el-input>
        <el-tree class="filter-tree" :data="deptTree" :props="defaultProps" default-expand-all :expand-on-click-node="false" :filter-node-method="filterDeptNode" @node-click="handleDeptSwitch" style="margin-top: 10px" ref="tree">
        </el-tree>
      </el-col>
      <el-col :span="20">
        <el-row :gutter="10">
          <el-col :span="1.5">
            <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:user:save']" @click="$refs.userForm.create()">新增</el-button>
            <el-button size="small" icon="el-icon-delete" :disabled="btnIsDisabed" v-hasPermission="['system:user:import']" @click="handleDeletes">删除</el-button>
            <el-button size="small" icon="el-icon-upload2" v-hasPermission="['system:user:import']" @click="$refs.userForm.create()">导入</el-button>
            <el-button size="small" icon="el-icon-download" v-hasPermission="['system:user:export']" @click="$refs.userForm.create()">导出</el-button>
          </el-col>
          <table-right-toolbar recycleCode="system-user-save" @toggleData="switchDataType" @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
        </el-row>
        <el-table v-loading="loading" :data="userData" row-key="id" @selection-change="handleSelectionChange">
          <el-table-column type="selection" width="55">
          </el-table-column>
          <el-table-column prop="username" label="用户名称" fixed width="120" :show-overflow-tooltip="true"></el-table-column>
          <el-table-column prop="email" label="邮箱">
          </el-table-column>
          <el-table-column prop="user_type" label="用户类型" width="100">
            <template slot-scope="scope">
              {{ scope.row.user_type === '100' ? '系统用户' : '其他' }}
            </template>
          </el-table-column>
          <el-table-column prop="status" label="状态" width="100">
            <template slot-scope="scope">
              <el-switch v-model="scope.row.status" @change="handleStatus(scope.row)" active-value="0" inactive-value="1">
              </el-switch>
            </template>
          </el-table-column>
          <el-table-column prop="created_at" label="创建时间" width="160">
          </el-table-column>
          <el-table-column label="操作" align="center">
            <template slot-scope="scope">
              <div v-if="showRecycle">
                <el-button size="small" type="text" v-hasPermission="['system:user:recovery']" icon="el-icon-refresh-left" @click="handleRecovery(scope.row.id)">恢复</el-button>
                <el-button size="small" type="text" v-hasPermission="['system:user:realDelete']" icon="el-icon-delete" @click="handleRealDelete(scope.row.id)">删除</el-button>
              </div>
              <div v-else>
                <el-button size="small" type="text" v-hasPermission="['system:user:update']" icon="el-icon-edit" @click="$refs.userForm.update(scope.row)">修改</el-button>
                <el-button size="small" type="text" v-hasPermission="['system:user:initPassword']" icon="el-icon-key" @click="handleInitPassword(scope.row.id)">初始密码</el-button>
                <el-button size="small" type="text" v-hasPermission="['system:user:delete']" icon="el-icon-delete" @click="handleDelete(scope.row.id)">移到回收站</el-button>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <user-form ref="userForm" @closeDialog="handleClose"></user-form>
    <template slot="footer">
      <el-pagination @size-change="getList" @current-change="getList" layout="total, sizes, prev, pager, next, jumper" :page-sizes="[10, 20, 30, 50]" :current-page.sync="queryParams.page" :page-size.sync="queryParams.pageSize" :total="pageInfo.total">
      </el-pagination>
    </template>
  </ma-container>
</template>
<script>
import { getSelectTree } from '@/api/system/dept'
import { getPageList, getPageListByRecycle, recoverys, deletes, realDeletes, changeUserStatus, initPassword } from '@/api/system/user'
import userForm from './form'
export default {
  name: 'system-user-index',
  components: {
    userForm
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
      userData: [],
      // 分页数据
      pageInfo: { total: 0 },
      // 搜索
      queryParams: {
        username: undefined,
        status: undefined,
        pageSize: 10,
        page: 1
      },
      // 部门过滤
      filterDept: '',
      // 部门数据
      deptTree: [],
      // 多选
      ids: null,
      // 按钮禁用
      btnIsDisabed: true,
      defaultProps: {
        children: 'children',
        label: 'label'
      }
    }
  },
  created () {
    this.getList()
    getSelectTree().then(res => {
      this.deptTree = res.data
      this.deptTree.unshift({ id: undefined, label: '所有部门' })
    })
  },
  watch: {
    filterDept (val) {
      this.$refs.tree.filter(val)
    }
  },
  methods: {
    // 获取数据
    getList () {
      this.loading = true
      if (!this.showRecycle) {
        getPageList(this.queryParams).then(res => {
          this.userData = res.data.items
          this.pageInfo = res.data.pageInfo
          this.loading = false
        })
      } else {
        getPageListByRecycle(this.queryParams).then(res => {
          this.userData = res.data.items
          this.pageInfo = res.data.pageInfo
          this.loading = false
        })
      }
    },
    // 点击部门节点
    handleDeptSwitch (data) {
      this.queryParams.dept_id = data.id
      this.getList()
    },
    // 过滤部门节点
    filterDeptNode (value, data) {
      if (!value) return true
      return data.label.indexOf(value) !== -1
    },
    // form组件关闭调用方法
    handleClose (e) {
      e && this.getList()
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
    // 用户状态更改
    handleStatus (row) {
      const status = row.status === '0' ? '0' : '1'
      const text = row.status === '0' ? '启用' : '停用'
      this.$confirm(`确认要${text} ${row.username} 用户吗？`, '提示', {
        type: 'warning',
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(() => {
        changeUserStatus({ id: row.id, status }).then(res => {
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
    // 批量删除
    handleDeletes () {
      this.handleDelete(this.ids)
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
    // 初始化用户密码
    handleInitPassword (id) {
      this.$confirm('确定要将用户密码设置为：123456', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        initUserPassword(id).then(res => {
          this.success(res.message)
        })
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
