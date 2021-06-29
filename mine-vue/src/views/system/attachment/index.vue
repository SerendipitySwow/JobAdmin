<template>
  <ma-container>
    <template slot="header" v-if="showSearch">
      <el-form :inline="true" ref="queryParams" :model="queryParams" label-width="80px">
        <el-form-item label="原文件名" class="ma-inline-form-item" prop="origin_name">
          <el-input size="small" v-model="queryParams.origin_name" placeholder="请输入原文件名"></el-input>
        </el-form-item>
        <el-form-item label="存储模式" class="ma-inline-form-item" prop="storage_mode">
          <el-select size="small" v-model="queryParams.storage_mode" placeholder="请选择存储模式">
            <el-option :label="item.label" :value="item.value" v-for="(item, index) in storageMode" :key="index">{{item.label}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="创建时间" class="ma-inline-form-item">
          <el-date-picker size="small" type="daterange" v-model="dateRange" range-separator="至" format="yyyy-MM-dd" value-format="yyyy-MM-dd" @change="handleDateChange" start-placeholder="开始日期" end-placeholder="结束日期">
          </el-date-picker>
        </el-form-item>
        <el-form-item class="ma-inline-form-item">
          <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
          <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
        </el-form-item>
      </el-form>
    </template>
    <el-row :gutter="20">
      <el-col :span="1.5">
        <el-button size="small" icon="el-icon-delete" :disabled="btnIsDisabed" v-hasPermission="['system:attachment:import']" @click="handleDeletes">删除</el-button>
      </el-col>
      <table-right-toolbar recycleCode="system-attachment-recycle" @toggleData="switchDataType" @refreshTable="getList" @toggleSearch="switchShowSearch"></table-right-toolbar>
    </el-row>
    <el-table v-loading="loading" :data="dataList" row-key="id" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55">
          </el-table-column>
      <el-table-column prop="origin_name" label="原文件名" fixed width="160" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="object_name" label="新文件名" width="160" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="mime_type" label="资源类型" width="160" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="storage_path" label="存储目录" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="suffix" label="扩展名" width="80" ></el-table-column>
      <el-table-column prop="size_byte" label="字节数" width="100" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="size_info" label="文件大小" ></el-table-column>
      <el-table-column prop="created_at" label="创建时间" width="160" ></el-table-column>
      <el-table-column label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="showRecycle">
            <el-button type="text" v-hasPermission="['system:attachment:recovery']" @click="handleRecovery(scope.row.id)">恢复</el-button>
            <el-button type="text" v-hasPermission="['system:attachment:realDelete']" @click="handleRealDelete(scope.row.id)">删除</el-button>
          </div>
          <div v-else>
            <el-button type="text" @click="review(scope.row)">预览</el-button>
            <el-button type="text" v-hasPermission="['system:attachment:delete']" @click="handleDelete(scope.row.id)">移到回收站</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <template slot="footer">
      <el-pagination @size-change="getList" @current-change="getList" layout="total, sizes, prev, pager, next, jumper" :page-sizes="[10, 20, 30, 50]" :current-page.sync="queryParams.page" :page-size.sync="queryParams.pageSize" :total="pageInfo.total">
      </el-pagination>
    </template>
    <el-dialog
      title="图片预览"
      :visible.sync="dialogVisible"
      width="50%"
      :before-close="handleReviewClose">
      <el-image :src="record.url" lazy></el-image>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog>
  </ma-container>
</template>
<script>
import { getPageList, getPageListByRecycle, deletes, recoverys, realDeletes } from '@/api/system/attachment'
export default {
  name: 'system-attachment-index',
  data () {
    return {
      // 是否显示回收站数据
      showRecycle: false,
      // 是否显示搜索
      showSearch: true,
      // 数据
      dataList: [],
      // 遮罩层
      loading: true,
      // 选择时间范围
      dateRange: null,
      // modal
      dialogVisible: false,
      // 存储模式
      storageMode: [
        {label: '本地存储', value: 1},
        {label: '阿里云OSS存储', value: 2},
        {label: '七牛云存储', value: 3},
        {label: '腾讯COS存储', value: 4},
      ],
      // 分页数据
      pageInfo: { total: 0 },
      // 按钮禁用
      btnIsDisabed: true,
      // 搜索
      queryParams: {
        storage_mode: undefined,
        origin_name: undefined,
        maxDate: undefined,
        minDate: undefined,
        pageSize: 10,
        page: 1
      },
      // 当前记录
      record: { url: ''},
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
    // 预览图片
    review (row) {
      this.record = row
      if (!/png|jpeg|jpg|png|bmp/.test(row.mime_type)) {
        this.error('非图片，无法预览');
        return false
      } else {
        this.dialogVisible = true
      }
    },
    handleReviewClose () {
      this.dialogVisible = false
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
    // 选择时间事件
    handleDateChange (values) {
      if (values !== null) {
        this.queryParams.minDate = values[0]
        this.queryParams.maxDate = values[1]
      }
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
      this.dateRange = null
      this.queryParams.minDate = this.queryParams.maxDate = undefined
      this.handleSearch()
    }
  }
}
</script>
