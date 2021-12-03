<template>
  <el-card shadow="never" class="decs">
    <h2>{{ appInfo.app_name }}</h2>
    <div class="decs-list">
      <p>最后更新时间：{{ appInfo.updated_at }}</p>
      <div class="description" v-html="appInfo.description"></div>
    </div>
  </el-card>
  <el-card shadow="never" class="card" style="margin-top: 10px;">
    <el-collapse v-model="activeName" accordion>
      <el-collapse-item title="Consistency" name="1">
        <div>
          Consistent with real life: in line with the process and logic of real
          life, and comply with languages and habits that the users are used to;
        </div>
        <div>
          Consistent within interface: all elements should be consistent, such
          as: design style, icons and texts, position of elements, etc.
        </div>
      </el-collapse-item>
    </el-collapse>
  </el-card>
</template>

<script>
export default {
  async created() {
    await this.getAppInfo()
  },
  data () {
    return {
      activeName: '1',
      appInfo: {},
    }
  },
  methods: {
    async getAppInfo() {
      let res = await this.$API.apiDoc.readApp(this.$TOOL.data.get('appId'))
      this.appInfo = res.data
    }
  }

}
</script>

<style scoped>
.decs {
  background: linear-gradient(160deg, #fff, #effbff, #dcf6ff);
  font-size: 14px;
}
.decs h2 {
  margin-bottom: 15px;
}
.decs-list p {
  line-height: 25px;
}
.decs-list .description {
  line-height: 25px;
}
</style>