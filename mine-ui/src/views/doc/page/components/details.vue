<template>
  <el-drawer
    v-model="drawer"
    :with-header="false"
    size="40%"
  >
    <el-main>
      <el-tabs v-model="activeName">
        <el-tab-pane label="参数列表" name="params">参数列表</el-tab-pane>
        <el-tab-pane label="模拟请求" name="request">模拟请求</el-tab-pane>
      </el-tabs>
    </el-main>
  </el-drawer>
</template>

<script>
export default {
  data () {
    return {
      drawer: false,
      appData: {},
      activeName: 'params',
    }
  },

  methods: {
    open (data) {
      this.appData = data
      this.drawer = true
    }
  }
}
</script>