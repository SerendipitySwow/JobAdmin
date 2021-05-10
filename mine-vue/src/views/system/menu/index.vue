<template>
  <ma-container style="padding-top:0">
    <template slot="header">Header</template>
    <el-table
      v-loading="loading"
      :data="menuTree"
      row-key="id"
      default-expand-all
      :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
      <el-table-column prop="name" label="菜单名称" :show-overflow-tooltip="true" width="160"></el-table-column>
      <el-table-column prop="icon" label="图标" align="center" width="100">
        <template slot-scope="scope">
          <ma-icon :name="scope.icon"/>
        </template>
      </el-table-column>
      <el-table-column prop="route" label="路由" width="180"></el-table-column>
      <el-table-column
        prop="code"
        label="菜单代码">
      </el-table-column>
    </el-table>
  </ma-container>
</template>
<script>
import { getMenuTree } from '@/api/system/menu'
export default {
  name: 'sys-menu',
  data () {
    return {
      // 遮罩层
      loading: true,
      menuTree: []
    }
  },
  mounted () {
    this.getData()
  },
  methods: {
    getData () {
      getMenuTree().then(res => {
        this.menuTree = res.data
        this.loading = false
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.page {
  background:#fff;
}
</style>
