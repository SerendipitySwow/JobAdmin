<template>
  <el-drawer
    v-model="drawer"
    :with-header="false"
    size="40%"
  >
    <el-main>
      <el-tabs v-model="activeName">
        <el-tab-pane label="选择分组绑定" name="group">User</el-tab-pane>
        <el-tab-pane label="选择接口绑定" name="api">Config</el-tab-pane>
      </el-tabs>
    </el-main>
  </el-drawer>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      activeName: 'group',
    };
  },
  methods: {
    open() {
      this.drawer = true
    }
  }
};
</script>
