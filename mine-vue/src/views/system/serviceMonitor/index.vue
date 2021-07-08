<template>
  <ma-container>
    <el-row :gutter="20">
      <el-col :span="12">
        <el-card class="ma-card">
          <div slot="header" class="clearfix"><span>CPU信息</span></div>
          <div class="el-table el-table--enable-row-hover el-table--medium">
            <table cellspacing="0" style="width: 100%;">
              <tbody>
                <tr>
                  <td><div class="cell">名称</div></td>
                  <td><div class="cell" v-if="server.cpu">{{ server.cpu.name }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">核心数</div></td>
                  <td><div class="cell" v-if="server.cpu">{{ server.cpu.cores }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">缓存</div></td>
                  <td><div class="cell" v-if="server.cpu">{{ server.cpu.cache }}M</div></td>
                </tr>
                <tr>
                  <td><div class="cell">使用率</div></td>
                  <td><div class="cell" v-if="server.cpu">{{ server.cpu.usage }}%</div></td>
                </tr>
                <tr>
                  <td><div class="cell">当前空闲率</div></td>
                  <td><div class="cell" v-if="server.cpu">{{ server.cpu.free }}%</div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </el-card>
      </el-col>

      <el-col :span="12">
        <el-card class="ma-card">
          <div slot="header" class="clearfix"><span>内存信息</span></div>
          <div class="el-table el-table--enable-row-hover el-table--medium">
            <table cellspacing="0" style="width: 100%;">
              <tbody>
                <tr>
                  <td><div class="cell">总内存</div></td>
                  <td><div class="cell" v-if="server.memory">{{ server.memory.total }}G</div></td>
                </tr>
                <tr>
                  <td><div class="cell">已使用内存</div></td>
                  <td><div class="cell" v-if="server.memory">{{ server.memory.usage }}G</div></td>
                </tr>
                <tr>
                  <td><div class="cell">PHP使用内存</div></td>
                  <td><div class="cell" v-if="server.memory">{{ server.memory.php }}M</div></td>
                </tr>
                <tr>
                  <td><div class="cell">空闲内存</div></td>
                  <td><div class="cell" v-if="server.memory">{{ server.memory.free }}G</div></td>
                </tr>
                <tr>
                  <td><div class="cell">当前使用率</div></td>
                  <td><div class="cell" v-if="server.memory">{{ server.memory.rate }}%</div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </el-card>
      </el-col>
    </el-row>

    <el-row>
      <el-card class="ma-card">
        <div slot="header" class="clearfix">
            <span>PHP及环境信息</span>
        </div>
        <div class="el-table el-table--enable-row-hover el-table--medium">
            <table cellspacing="0" style="width: 100%;">
              <tbody>
                <tr>
                  <td><div class="cell">操作系统</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.os }}</div></td>
                  <td><div class="cell">PHP版本</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.php_version }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">Swoole版本</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.swoole_version }}</div></td>
                  <td><div class="cell">Hyperf版本</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.hyperf_version }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">MineAdmin版本</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.mineadmin_version }}</div></td>
                  <td><div class="cell">系统物理路径</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.project_path }}</div></td>
                </tr>
                <tr>
                  <td><div class="cell">系统启动时间</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.start_time }}</div></td>
                  <td><div class="cell">系统运行时间</div></td>
                  <td><div class="cell" v-if="server.phpenv">{{ server.phpenv.run_time }}</div></td>
                </tr>
              </tbody>
            </table>
          </div>
      </el-card>
    </el-row>

  </ma-container>
</template>
<script>
import { getServerInfo } from '@/api/system/monitor'
export default {
  name: 'system-serviceMonitor',

  data () {
    return {
      loading: [],
      server: []
    }
  },

  created () {
    this.openLoading()
    this.getService()
  },

  methods: {

    async getService () {
      await getServerInfo().then(res => {
        this.server = res.data
      })
      this.loading.close()
    },

    openLoading () {
      this.loading = this.$loading({
        lock: true,
        text: '拼命读取中',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      })
    }
  }
}
</script>
