<template>
  <el-table
    v-loading="loading"
    :data="menuTree"
    row-key="id"
    :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
    <el-table-column prop="name" label="菜单名称" fixed width="240" :show-overflow-tooltip="true"></el-table-column>
    <el-table-column prop="icon" label="图标" align="center" width="100">
      <template slot-scope="scope">
        <ma-icon :name="scope.row.icon"/>
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
        {{ scope.row.status === '0' ? '正常' : '停用' }}
      </template>
    </el-table-column>
    <el-table-column label="操作" align="center">
      <template slot-scope="scope">
        <el-button size="mini"
          type="text"
          icon="el-icon-edit"
          @click="scope.row"
        >修改</el-button>
        <el-button
          size="mini"
          type="text"
          icon="el-icon-plus"
        >新增</el-button>
        <el-button
          size="mini"
          type="text"
          icon="el-icon-delete"
        >删除</el-button>
      </template>
    </el-table-column>
  </el-table>
</template>
<script>
import { getMenuTree } from '@/api/system/menu'
export default {
  name: 'list',
  data () {
    return {
      // 遮罩层
      loading: true,
      menuTree: []
    }
  },
  mounted () {
    this.getList()
  },
  methods: {
    getList () {
      getMenuTree().then(res => {
        this.menuTree = res.data
        this.loading = false
      })
    }
  }
}
</script>
