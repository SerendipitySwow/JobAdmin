<template>
  <el-drawer
    v-model="drawer"
    :with-header="false"
    size="40%"
  >
    <el-main
      v-loading="loading"
      element-loading-background="rgba(255, 255, 255, 0.5)"
      element-loading-text="数据加载中..."
      style="height:100%;"
    >
      <el-tabs v-model="activeName">
        <el-tab-pane label="选择分组绑定" name="group">
          <el-checkbox-group v-model="apiGroupData">

          </el-checkbox-group>
        </el-tab-pane>
        <el-tab-pane label="选择接口绑定" name="api">

        </el-tab-pane>
      </el-tabs>
    </el-main>
  </el-drawer>
</template>

<script>
export default {
  emits: ['success'],
  data() {
    return {
      drawer: false,
      loading: true,
      activeName: 'group',
      apiGroupData: [],
      apiData: [],
      queryParams: {
        getApiList: true
      }
    };
  },
  methods: {
    async open() {
      this.drawer = true
      this.loading = true
      await this.getApiGroupData()
    },

    getApiGroupData() {
      this.$API.apiGroup.getSelectList(this.queryParams).then(res => {
        this.apiGroupData = res.data
        this.loading = false
        console.log(this.apiGroupData)
      })
    },
  }
};
</script>
