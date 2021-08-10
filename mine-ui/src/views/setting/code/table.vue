<template>
  <el-dialog
    title="装载数据表"
    :visible="dialogVisible"
    width="50%"
    :before-close="handleDialogClose"
  >
    <el-form
      :inline="true"
      ref="queryParams"
      :model="queryParams"
      label-width="40px"
    >
      <el-form-item label="表名" class="ma-inline-form-item" prop="name">
        <el-input size="small" v-model="queryParams.name" placeholder="请输入表名"></el-input>
      </el-form-item>

      <el-form-item class="ma-inline-form-item">
        <el-button size="small" type="primary" @click="handleSearch" icon="el-icon-search">搜索</el-button>
        <el-button size="small" type="default" @click="resetSearch" icon="el-icon-refresh">重置</el-button>
      </el-form-item>

    </el-form>

    <maTable
      ref="table"
      :api="api"
      rowKey="name"
      :column="column"
      @selection-change="selectionChange"
      stripe
      remoteSort
      remoteFilter
    >
      <el-table-column type="selection" width="50"></el-table-column>
      
      <el-table-column
        label="表名称"
        prop="name"
        width="180"
        :show-overflow-tooltip="true"
      ></el-table-column>

      <el-table-column
        label="表引擎"
        prop="engine"
      ></el-table-column>

      <el-table-column
        label="总行数"
        prop="rows"
      ></el-table-column>

      <el-table-column
        label="碎片大小"
        prop="data_free"
      >
        <template #default="scope">
          {{formatData(scope.row.data_free)}}
        </template>
      </el-table-column>

      <el-table-column
        label="数据大小"
        prop="data_length"
      >
        <template #default="scope">
          {{ formatData(scope.row.data_length) }}
        </template>
      </el-table-column>

      <el-table-column
        label="索引大小"
        prop="index_length"
      >
        <template #default="scope">
          {{formatData(scope.row.index_length)}}
        </template>
      </el-table-column>

      <el-table-column
        label="字符集"
        prop="collation"
        width="180"
        :show-overflow-tooltip="true"
      ></el-table-column>

      <el-table-column
        label="创建时间"
        prop="created_at"
        width="160"
      >
        <template #default="scope">
          {{scope.row.create_time.substr(0, 10)}}
        </template>
      </el-table-column>

      <el-table-column
        prop="comment"
        label="表注释"
        :show-overflow-tooltip="true"
      ></el-table-column>

      <el-table-column label="操作" fixed="right" align="right">
        <template #default="scope">

          <el-button
          type="text"
          v-auth="['system:dataMaintain:detailed']"
          @click="handleDetail(scope.row.name)"
        >查看</el-button>
          
        </template>
      </el-table-column>

    </maTable>

    <template #footer class="dialog-footer">
      <el-button @click="handleDialogClose" size="small">关 闭</el-button>
      <el-button type="primary" @click="loadTable" size="small">确 定</el-button>
    </template>
  </el-dialog>
</template>
<script>
export default {

  data () {
    return {
      api: { list: this.$API.dataMaintain.getPageList },
      // 搜索
      queryParams: {
        name: undefined
      },
      // modal
      dialogVisible: false,
      // 选择的表名
      names: []
    }
  },

  methods: {

    // 显示表分页
    show () {
      this.dialogVisible = true
      this.names = []
    },

    // 装载数据表
    loadTable () {
      this.$API.generate.loadTable({ names: this.names }).then(res => {
        if (res.success) {
          this.handleDialogClose()
          this.$emit('confirm')
        } 
      })
    },

    // 表字段modal关闭
    handleDialogClose () {
      this.dialogVisible = false
    },

    // 多选
    handleSelectionChange (items) {
      if (items.length > 0) {
        this.names = items.map(item => {
          return { name: item.name, comment: item.comment }
        })
      } else {
        this.names = []
      }
    },

    // 搜索
    handleSearch () {
      this.$refs.table.upDate(this.queryParams)
    },

    // 重置搜索
    resetSearch () {
      this.$refs.queryParams.resetFields()
      this.handleSearch()
    }
  }
}
</script>
