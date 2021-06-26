<template>
  <ma-container>
    <el-row :gutter="20">
      <el-col :span="12">
        <el-card class="box-card ma-card" shadow="hover">
          <div slot="header" class="clearfix">
            <span>字典类型管理</span>
          </div>
          <!-- 字典类型搜索start -->
          <el-row :gutter="10" v-if="showTypeSearch" class="mb-20">
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
          <!-- 字典类型搜索end -->
          <!-- 字典类型工具栏start -->
          <el-row :gutter="10">
            <el-col :span="1.5">
              <el-button size="small" icon="el-icon-plus" v-hasPermission="['system:dictType:save']" @click="$refs.typeForm.create()">新增</el-button>
              <el-button size="small" icon="el-icon-delete" :disabled="typeBtnIsDisabed" v-hasPermission="['system:dictType:delete']" @click="handleDeletes('type')">删除</el-button>
            </el-col>
            <table-right-toolbar recycleCode="system-dictType-save" @toggleData="switchTypeList" @refreshTable="getTypeList" @toggleSearch="switchShowTypeSearch"></table-right-toolbar>
          </el-row>
          <!-- 字典类型工具栏end -->
          <!-- 字典类型表格start -->
          <el-table
            v-loading="typeLoading"
            :data="typeList"
            @row-click="handleClickRow"
            row-key="id"
            @selection-change="handleSelectionTypeChange"
            :highlight-current-row="true"
          >
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
                <div v-if="showTypeRecycle">
                  <el-button type="text" v-hasPermission="['system:dictType:recovery']" @click="handleRecovery(scope.row.id, 'type')">恢复</el-button>
                  <el-button type="text" v-hasPermission="['system:dictType:realDelete']" @click="handleRealDelete(scope.row.id, 'type')">删除</el-button>
                </div>
                <div v-else>
                  <el-button type="text" v-hasPermission="['system:dictType:update']" @click="$refs.typeForm.update(scope.row)">修改</el-button>
                  <el-button type="text" v-hasPermission="['system:dictType:delete']" @click="handleDelete(scope.row.id, 'type')">移到回收站</el-button>
                </div>
              </template>
            </el-table-column>
          </el-table>
          <!-- 字典类型表格end -->
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
          <!-- 字典数据搜索start -->
          <el-row :gutter="10" v-if="showDataSearch" class="mb-20">
            <el-form :inline="true" ref="queryDataParams" :model="queryDataParams" label-width="80px">
              <el-form-item label="字典名称" class="ma-inline-form-item" prop="label">
                <el-input size="small" v-model="queryDataParams.label" placeholder="请输入字典名称"></el-input>
              </el-form-item>
              <el-form-item label="字典值" class="ma-inline-form-item" prop="value">
                <el-input size="small" v-model="queryDataParams.value" placeholder="请输入字典值"></el-input>
              </el-form-item>
              <el-form-item class="ma-inline-form-item">
                <el-button size="small" type="primary" @click="handleDataSearch" icon="el-icon-search">搜索</el-button>
                <el-button size="small" type="default" @click="resetDataSearch" icon="el-icon-refresh">重置</el-button>
              </el-form-item>
            </el-form>
          </el-row>
          <!-- 字典数据搜索end -->
          <!-- 字典数据工具栏start -->
          <el-row :gutter="10">
            <el-col :span="1.5">
              <el-button size="small" icon="el-icon-plus" :disabled="record === null" v-hasPermission="['system:dictData:save']" @click="$refs.dataForm.create(record)">新增</el-button>
              <el-button size="small" icon="el-icon-delete" :disabled="dataBtnIsDisabed" v-hasPermission="['system:dictData:delete']" @click="handleDeletes('data')">删除</el-button>
            </el-col>
            <table-right-toolbar recycleCode="system-dictData-save" @toggleData="switchDataList" @refreshTable="getDataList" @toggleSearch="switchShowDataSearch"></table-right-toolbar>
          </el-row>
          <!-- 字典数据工具栏end -->
          <!-- 字典数据表格start -->
          <el-table v-loading="dataLoading" :data="dataList" row-key="id" @selection-change="handleSelectionDataChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="label" label="字典名称" fixed width="150" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column prop="value" label="字典值" ></el-table-column>
            <el-table-column prop="status" label="状态" width="80" >
              <template slot-scope="scope">
                {{ scope.row.status == '0' ? '正常' : '停用' }}
              </template>
            </el-table-column>
            <el-table-column prop="remark" label="备注" width="120" :show-overflow-tooltip="true"></el-table-column>
            <el-table-column label="操作" align="center">
              <template slot-scope="scope">
                <div v-if="showDataRecycle">
                  <el-button type="text" v-hasPermission="['system:dictData:recovery']" @click="handleRecovery(scope.row.id, 'data')">恢复</el-button>
                  <el-button type="text" v-hasPermission="['system:dictData:realDelete']" @click="handleRealDelete(scope.row.id, 'data')">删除</el-button>
                </div>
                <div v-else>
                  <el-button type="text" v-hasPermission="['system:dictData:update']" @click="$refs.dataForm.update(scope.row)">修改</el-button>
                  <el-button type="text" v-hasPermission="['system:dictData:delete']" @click="handleDelete(scope.row.id, 'data')">移到回收站</el-button>
                </div>
              </template>
            </el-table-column>
          </el-table>
          <!-- 字典数据表格end -->
          <el-row :gutter="10" class="mt-20 text-right">
            <el-pagination
              @size-change="getDataList"
              @current-change="getDataList"
              layout="total, sizes, prev, pager, next, jumper"
              :page-sizes="[10, 20, 30, 50]"
              :current-page.sync="queryDataParams.page"
              :page-size.sync="queryDataParams.pageSize"
              :total="dataPageInfo.total">
            </el-pagination>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
    <dict-type-form ref="typeForm" @closeDialog="handleTypeClose"></dict-type-form>
    <dict-data-form ref="dataForm" @closeDialog="handleDataClose"></dict-data-form>
  </ma-container>
</template>
<script>
import { getTypePageList, getTypePageListByRecycle, deletesDictType, recoverysDictType, realDeletesDictType } from '@/api/system/dictType'
import { getDataPageList, getDataPageListByRecycle, deletesDictData, recoverysDictData, realDeletesDictData } from '@/api/system/dictData'
import dictTypeForm from './dictType'
import dictDataForm from './dictData'
export default {
  name: 'system-dict-index',
  components: {
    dictTypeForm,
    dictDataForm
  },
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
      // ids 列表
      typeIds: [],
      dataIds: [],
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
        label: undefined,
        value: undefined,
        pageSize: 10,
        page: 1
      },
      record: null
    }
  },
  created () {
    this.getTypeList()
    this.getDicts('mysql_type').then(res => {
      console.log(res)
    })
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
    // 行点击事件
    handleClickRow (row, column, event) {
      this.record = row
      this.queryDataParams.type_id = row.id
      this.getDataList()
    },
    // form组件关闭调用方法
    handleTypeClose (e) {
      e && this.getTypeList()
    },
    // form组件关闭调用方法
    handleDataClose (e) {
      e && this.getDataList()
    },
    // 切换回收站数据方法
    switchTypeList () {
      this.showTypeRecycle = !this.showTypeRecycle
      this.getTypeList()
    },
    switchDataList () {
      this.showDataRecycle = !this.showDataRecycle
      this.getDataList()
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
    handleDelete (id, action) {
      this.$confirm('此操作会将数据移到回收站！', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        if (action === 'type') {
          deletesDictType(id).then(res => {
            this.success(res.message)
            this.getTypeList()
            this.getDataList()
          })
        } else {
          deletesDictData(id).then(res => {
            this.success(res.message)
            this.getDataList()
          })
        }
      })
    },
    // 真实删除数据
    handleRealDelete (id, action) {
      this.$confirm('此操作会将数据物理删除', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        if (action === 'type') {
          realDeletesDictType(id).then(res => {
            this.success(res.message)
            this.getTypeList()
            this.getDataList()
          })
        } else {
          realDeletesDictData(id).then(res => {
            this.success(res.message)
            this.getDataList()
          })
        }
      })
    },
    // 多选
    handleSelectionTypeChange (items) {
      if (items.length > 0) {
        const ids = []
        items.forEach(item => {
          ids.push(item.id)
          this.typeBtnIsDisabed = false
          this.typeIds = ids.join(',')
        })
      } else {
        this.typeBtnIsDisabed = true
        this.typeIds = null
      }
    },
    handleSelectionDataChange (items) {
      if (items.length > 0) {
        const ids = []
        items.forEach(item => {
          ids.push(item.id)
          this.dataBtnIsDisabed = false
          this.dataIds = ids.join(',')
        })
      } else {
        this.dataBtnIsDisabed = true
        this.dataIds = null
      }
    },
    // 批量删除
    handleDeletes (action) {
      if (action === 'type') {
        this.showTypeRecycle ? this.handleRealDelete(this.typeIds, 'type') : this.handleDelete(this.typeIds, 'type')
      } else {
        this.showDataRecycle ? this.handleRealDelete(this.dataIds, 'data') : this.handleDelete(this.dataIds, 'data')
      }
    },
    // 恢复数据
    handleRecovery (id, action) {
      if (action === 'type') {
        recoverysDictType(id).then(res => {
          this.success(res.message)
          this.getTypeList()
        })
      } else {
        recoverysDictData(id).then(res => {
          this.success(res.message)
          this.getDataList()
        })
      }
    },
    // 搜索
    handleTypeSearch () {
      this.getTypeList()
    },
    handleDataSearch () {
      this.getDataList()
    },
    // 重置搜索
    resetTypeSearch () {
      this.$refs.queryTypeParams.resetFields()
      this.handleTypeSearch()
    },
    resetDataSearch () {
      this.$refs.queryDataParams.resetFields()
      this.handleDataSearch()
    }
  }
}
</script>
