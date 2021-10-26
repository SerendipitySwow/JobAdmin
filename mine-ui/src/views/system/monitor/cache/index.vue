<template>
  <div
    class="diy-grid-layout"
  >
    <el-row :gutter="15">
      <el-col :md="24" :xs="24">
        <el-card shadow="hover">
          <template #header>
            <span>Redis信息</span>
          </template>
          <div class="table">
            <table cellspacing="0" style="width: 100%;">
              <tbody>
                <tr>
                  <td><div class="cell">Redis版本</div></td>
                  <td><div class="cell">{{ server.version }}</div></td>
                  <td><div class="cell">客户端连接数</div></td>
                  <td><div class="cell">{{ server.clients }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">使用内存</div></td>
                  <td><div class="cell">{{ server.use_money }}</div></td>
                  <td><div class="cell">使用CPU</div></td>
                  <td><div class="cell">{{ new Number(server.use_cpu).toFixed(2) }}%</div></td>
                </tr>
                <tr>
                  <td><div class="cell">端口</div></td>
                  <td><div class="cell">{{ server.port }}</div></td>
                  <td><div class="cell">进程数</div></td>
                  <td><div class="cell">{{ server.forks_num }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">已过期key</div></td>
                  <td><div class="cell">{{ server.expired_keys }}</div></td>
                  <td><div class="cell">MineAdmin 使用key</div></td>
                  <td><div class="cell">{{ server.sys_total_keys }}</div></td>
                </tr>
              </tbody>
            </table>

            
          </div>
        </el-card>

        <el-card shadow="hover">
          <template #header>
            <span>其他信息</span>
          </template>
          <div class="table">
            <el-row :gutter="15">
              <el-col :span="12">
                <table cellspacing="0" style="width: 100%;">
                  <thead>
                    <tr>
                      <td><div class="cell"></div></td>
                      <td width="80%"><div class="cell">缓存名称</div></td>
                      <td><div class="cell" width="15%" style="text-align:center">操作</div></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(key, index) in keys" :key="index">
                      <td><div class="cell">{{ index + 1 }}</div></td>
                      <td><div class="cell">{{ key }}</div></td>
                      <td><div class="cell" width="15%" style="text-align:center">
                        <el-button><i class="el-icon-delete" /></el-button>
                      </div></td>
                    </tr>
                  </tbody>
                </table>
              </el-col>

              <el-col :span="12">
                asd
              </el-col>
            </el-row>
          </div>
        </el-card>
      </el-col>
    </el-row>
	</div>
</template>
<script>
import scEcharts from '@/components/scEcharts';
export default {
  name: 'system:cache',

  components: {
    scEcharts
  },

  data () {
    return {
      server: {},
      keys: [],
    }
  },

  async mounted () {
    await this.getService()
  },

  methods: {
    async getService () {
      await this.$API.monitor.getCacheInfo().then(res => {
        this.server = res.data.server
        console.log(this.server)
        this.keys   = res.data.keys
      })
    }
  }
}
</script>

<style scoped>
.diy-grid-layout {
  padding: 15px;
}
.progress {
  left: 50%;
  margin-left: -120px;
}
:deep(.el-progress__text span) {
  font-size: 32px;
}
.table tr {
  font-size: 14px;
  color: #606266;

}
.table td {
  box-sizing:border-box;
  text-overflow:ellipsis;
  text-align:left;
  vertical-align:middle;
  position:relative;
  border-bottom: 1px solid #ebeef5;
  padding: 10px 0;
}
</style>
