<template>
  <ma-container style="padding-top:0">
    <template slot="header">Header</template>
    <el-tabs v-model="activeName">
      <el-tab-pane label="菜单管理" name="menu">
        <menu-List></menu-list>
      </el-tab-pane>
      <el-tab-pane label="回收站" name="recycle">
        <recycle-List></recycle-list>
      </el-tab-pane>
    </el-tabs>
  </ma-container>
</template>
<script>
import MenuList from './list'
import RecycleList from './recycle'
export default {
  name: 'system-menu-index',
  components: {
    MenuList,
    RecycleList
  },
  data () {
    return {
      activeName: 'menu'
    }
  }
}
</script>
