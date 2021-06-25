<template>
  <ma-container>
    <el-row :gutter="20">
      <el-col :span="12">
        <el-card class="box-card ma-card" shadow="hover">
          <div slot="header" class="clearfix">
            <span>字典类型管理</span>
          </div>
          <el-row :gutter="10" v-if="showTypeSearch">
            <el-form :inline="true" ref="queryTypeParams" :model="queryTypeParams" label-width="80px">
              <el-form-item label="类型名称" class="ma-inline-form-item" prop="name">
                <el-input size="small" v-model="queryTypeParams.name" placeholder="请输入字典类型名称"></el-input>
              </el-form-item>
              <el-form-item label="类型标识" class="ma-inline-form-item" prop="code">
                <el-input size="small" v-model="queryTypeParams.code" placeholder="请输入字典类型标识"></el-input>
              </el-form-item>
              <el-form-item class="ma-inline-form-item">
                <el-button size="small" type="primary" @click="handleTypeSearch" icon="el-icon-search">搜索</el-button>
                <el-button size="small" type="default" @click="resetTypeSearch" icon="el-icon-refresh">重置</el-button>
              </el-form-item>
            </el-form>
          </el-row>
          <el-row :gutter="10" class="mt-20">
            <el-col :span="1.5">
              <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:type:save']" @click="$refs.typeForm.create()">新增</el-button>
              <el-button size="small" icon="el-icon-delete" :disabled="typeBtnIsDisabed" v-hasPermission="['system:type:delete']" @click="handleDeletes">删除</el-button>
            </el-col>
            <table-right-toolbar recycleCode="system-user-save" @toggleData="switchDataType" @refreshTable="getTypeList" @toggleSearch="switchShowTypeSearch"></table-right-toolbar>
          </el-row>

          <el-table v-loading="typeLoading" :data="typeList" row-key="id" @selection-change="handleSelectionChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="name" label="类型名称" fixed width="150" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column prop="code" label="类型标识"></el-table-column>
            <el-table-column prop="status" label="状态" width="80" >
              <template slot-scope="scope">
                {{ scope.row.status == '0' ? '正常' : '停用' }}
              </template>
            </el-table-column>
            <el-table-column prop="remark" label="备注" width="120" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column label="操作" align="center">
              <template slot-scope="scope">
                <div v-if="showRecycle">
                  <el-button type="text" v-hasPermission="['system:type:recovery']" @click="handleRecovery(scope.row.id)">恢复</el-button>
                  <el-button type="text" v-hasPermission="['system:type:realDelete']" @click="handleRealDelete(scope.row.id)">删除</el-button>
                </div>
                <div v-else>
                  <el-button type="text" v-hasPermission="['system:type:update']" @click="$refs.userForm.update(scope.row)">修改</el-button>
                  <el-button type="text" v-hasPermission="['system:type:delete']" @click="handleDelete(scope.row.id)">移到回收站</el-button>
                </div>
              </template>
            </el-table-column>
          </el-table>
          <el-row :gutter="10" class="mt-20 text-right">
            <el-pagination
              @size-change="getTypeList"
              @current-change="getTypeList"
              layout="total, sizes, prev, pager, next, jumper"
              :page-sizes="[10, 20, 30, 50]"
              :current-page.sync="queryTypeParams.page"
              :page-size.sync="queryTypeParams.pageSize"
              :total="typePageInfo.total">
            </el-pagination>
          </el-row>
        </el-card>
      </el-col>
      <el-col :span="12">
        <el-card class="box-card ma-card" shadow="hover">
          <div slot="header" class="clearfix">
            <span>字典数据管理</span>
          </div>
          <el-row :gutter="10" v-if="showDataSearch">
            <el-form :inline="true" ref="queryDataParams" :model="queryDataParams" label-width="80px">
              <el-form-item label="字典名称" class="ma-inline-form-item" prop="label">
                <el-input size="small" v-model="queryDataParams.label" placeholder="请输入字典数据名称"></el-input>
              </el-form-item>
              <el-form-item label="字典标识" class="ma-inline-form-item" prop="code">
                <el-input size="small" v-model="queryDataParams.code" placeholder="请输入字典数据标识"></el-input>
              </el-form-item>
              <el-form-item class="ma-inline-form-item">
                <el-button size="small" type="primary" @click="handleTypeSearch" icon="el-icon-search">搜索</el-button>
                <el-button size="small" type="default" @click="resetTypeSearch" icon="el-icon-refresh">重置</el-button>
              </el-form-item>
            </el-form>
          </el-row>
          <el-row :gutter="10" class="mt-20">
            <el-col :span="1.5">
              <el-button size="small" icon="el-icon-plus" :disabled="dataList.length < 1" v-hasPermission="['system:user:save']" @click="$refs.userForm.create()">新增</el-button>
              <el-button size="small" icon="el-icon-delete" :disabled="dataBtnIsDisabed" v-hasPermission="['system:user:delete']" @click="handleDeletes">删除</el-button>
            </el-col>
            <table-right-toolbar recycleCode="system-user-save" @toggleData="switchDataType" @refreshTable="getDataList" @toggleSearch="switchShowDataSearch"></table-right-toolbar>
          </el-row>

          <el-table v-loading="dataLoading" :data="dataList" row-key="id" @selection-change="handleSelectionChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="label" label="字典名称" fixed width="150" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column prop="code" label="字典标识"></el-table-column>
            <el-table-column prop="status" label="状态" width="80" >
              <template slot-scope="scope">
                {{ scope.row.status == '0' ? '正常' : '停用' }}
              </template>
            </el-table-column>
            <el-table-column prop="remark" label="备注" width="120" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column label="操作" align="center">
              <template slot-scope="scope">
                <div v-if="showRecycle">
                  <el-button type="text" v-hasPermission="['system:type:recovery']" @click="handleRecovery(scope.row.id)">恢复</el-button>
                  <el-button type="text" v-hasPermission="['system:type:realDelete']" @click="handleRealDelete(scope.row.id)">删除</el-button>
                </div>
                <div v-else>
                  <el-button type="text" v-hasPermission="['system:type:update']" @click="$refs.userForm.update(scope.row)">修改</el-button>
                  <el-button type="text" v-hasPermission="['system:type:delete']" @click="handleDelete(scope.row.id)">移到回收站</el-button>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </ma-container>
</template>
<script>
import { getTypePageList, getTypePageListByRecycle, deletesDictType, recoverysDictType, realDeletesDictType } from '@/api/system/dictType'
import { getDataPageList, getDataPageListByRecycle, deletesDictData, recoverysDictData, realDeletesDictData } from '@/api/system/dictData'
export default {
  name: 'system-args-index',
  data () {
    return {
      // 是否显示字典类型回收站数据
      showTypeRecycle: false,
      // 是否显示字典数据回收站数据
      showDataRecycle: false,
      // 是否类型显示搜索
      showTypeSearch: true,
      // 是否数据显示搜索
      showDataSearch: true,
      // 类型数据
      typeList: [],
      // 字典数据
      dataList: [],
      // 遮罩层
      typeLoading: false,
      dataLoading: false,
      // 是否编辑
      isEdit: false,
      // 类型分页数据
      typePageInfo: { total: 0 },
      // 字典分页数据
      dataPageInfo: { total: 0 },
      // 类型按钮禁用
      typeBtnIsDisabed: true,
      // 字典按钮禁用
      dataBtnIsDisabed: true,
      // 字典类型搜索
      queryTypeParams: {
        name: undefined,
        code: undefined,
        pageSize: 10,
        page: 1
      },
      queryDataParams: {
        type_id: null,
        name: undefined,
        code: undefined,
        pageSize: 10,
        page: 1
      }
    }
  },
  created () {
    this.getTypeList()
  },
  methods: {
    // 获取类型数据
    getTypeList () {
      this.typeLoading = true
      if (!this.showTypeRecycle) {
        getTypePageList(this.queryTypeParams).then(res => {
          this.typeList = res.data.items
          this.typePageInfo = res.data.pageInfo
          this.typeLoading = false
        })
      } else {
        getTypePageListByRecycle(this.queryTypeParams).then(res => {
          this.typeList = res.data.items
          this.typePageInfo = res.data.pageInfo
          this.typeLoading = false
        })
      }
    },

    getDataList () {
      if (this.queryDataParams.type_id == null) {
        return
      }
      this.dataLoading = true
      if (!this.showDataRecycle) {
        getDataPageList(this.queryDataParams).then(res => {
          this.dataList = res.data.items
          this.dataPageInfo = res.data.pageInfo
          this.dataLoading = false
        })
      } else {
        getDataPageListByRecycle(this.queryDataParams).then(res => {
          this.dataList = res.data.items
          this.dataPageInfo = res.data.pageInfo
          this.dataLoading = false
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
    switchShowTypeSearch () {
      this.showTypeSearch = !this.showTypeSearch
    },
    // 显隐搜索
    switchShowDataSearch () {
      this.showDataSearch = !this.showDataSearch
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
    // 批量删除
    handleDeletes () {
      this.showRecycle ? this.handleRealDelete(this.ids) : this.handleDelete(this.ids)
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
