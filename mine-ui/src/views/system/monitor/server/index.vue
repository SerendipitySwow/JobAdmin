<template>
  <div class="diy-grid-layout">
		<el-row :gutter="15">
			<el-col :md="24" :xs="24">
        <el-card shadow="hover" style="margin-bottom:15px;">
          <template #header>
            <span>CPU信息</span>
          </template>
          <el-row :gutter="15">
            <el-col :md="16" :xs="24">
              <div class="el-table el-table--enable-row-hover el-table--medium">
                <table cellspacing="0" style="width: 100%;">
                  <tbody>
                    <tr>
                      <td><div class="cell">型号</div></td>
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
                      <td><div class="cell">空闲率</div></td>
                      <td><div class="cell" v-if="server.cpu">{{ server.cpu.free }}%</div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </el-col>
            <el-col :md="8" :xs="24">
              <scEcharts height="300px" style="margin-top:-60px;" :option="cpu"></scEcharts>
            </el-col>
          </el-row>
        </el-card>
			</el-col>
		</el-row>

    <el-row :gutter="15">
			<el-col :md="24" :xs="24">
        <el-card shadow="hover" style="margin-bottom:15px;">
          <template #header>
            <span>内存信息</span>
          </template>
          <el-row :gutter="15">
            <el-col :md="16" :xs="24">
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
                      <td><div class="cell">使用率</div></td>
                      <td><div class="cell" v-if="server.memory">{{ server.memory.rate }}%</div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </el-col>
            <el-col :md="8" :xs="24">
              <el-progress type="circle" class="progress" :percentage="memoryRate" :width="220"></el-progress>
            </el-col>
          </el-row>
        </el-card>
			</el-col>
		</el-row>

    <el-row :gutter="15">
			<el-col :md="24" :xs="24">
        <el-card shadow="hover" style="margin-bottom:15px;">
          <template #header>
            <span>PHP及环境信息</span>
          </template>
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
                <tr>
                  <td><div class="cell">磁盘信息</div></td>
                  <td colspan="3">
                    <div class="cell" v-if="server.disk">
                      总空间：{{ server.disk.total }}
                      <el-divider direction="vertical"></el-divider>
                      已使用：{{ server.disk.usage }}
                      <el-divider direction="vertical"></el-divider>
                      已剩余：{{ server.disk.free }}
                      <el-divider direction="vertical"></el-divider>
                      使用率：{{ server.disk.rate }}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </el-card>
			</el-col>
		</el-row>

    <el-row :gutter="15">
			<el-col :md="24" :xs="24">
        <el-card shadow="hover">
          <template #header>
            <span>网络I/O数据</span>
          </template>
          <el-row :gutter="15">
            <el-col :md="8" :xs="24">
              <div class="el-table el-table--enable-row-hover el-table--medium">
                <table cellspacing="0" style="width: 100%;">
                  <tbody>
                    <tr>
                      <td><div class="cell">接收总大小</div></td>
                      <td><div class="cell" v-if="server.net">{{ server.net.receive_total }}M</div></td>
                    </tr>
                    <tr>
                      <td><div class="cell">当前接收包大小</div></td>
                      <td><div class="cell" v-if="server.net">{{ server.net.receive_pack }}K</div></td>
                    </tr>
                    <tr>
                      <td><div class="cell">发送总大小</div></td>
                      <td><div class="cell" v-if="server.net">{{ server.net.send_total }}M</div></td>
                    </tr>
                    <tr>
                      <td><div class="cell">当前发送包大小</div></td>
                      <td><div class="cell" v-if="server.net">{{ server.net.send_pack }}K</div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </el-col>
            <el-col :md="16" :xs="24">
              <scEcharts height="200px" :option="net"></scEcharts>
            </el-col>
          </el-row>
        </el-card>
			</el-col>
		</el-row>
	</div>
</template>
<script>
import scEcharts from '@/components/scEcharts';
export default {
  name: 'system:monitor:server',

  components: {
    scEcharts
  },

  data () {
    return {
      loading: [],
      server: [],

      cpu: {
        series: [{
          center: ['50%', '60%'],
          type: 'gauge',
          anchor: {
            show: true,
            showAbove: true,
            size: 20,
            itemStyle: {
              borderWidth: 5
            }
          },
          progress: {
            show: true
          },
          data: [{
            value: 0
          }]
        }]
			},

      memoryRate: 0,

      net: {
					grid: {
						top: '15px'
					},
					tooltip: {
						trigger: 'axis'
					},
					xAxis: {
						boundaryGap: false,
            type: 'category',
            data: (function (){
              var now = new Date();
              var res = [];
              var len = 30;
              while (len--) {
                res.unshift(now.toLocaleTimeString().replace(/^\D*/,''));
                now = new Date(now - 2000);
              }
              return res;
            })()
					},
					yAxis: {
						type: 'value'
          },
					series: [{
            name: '接收数据',
						data: [120, 200, 150, 80, 70, 110, 130],
						type: 'line',
					},
					{
            name: '发送数据',
						data: [110, 180, 120, 120, 60, 90, 110],
						type: 'line',
					}]
				}
    }
  },

  created () {
    this.openLoading()
    this.getService()
  },

  methods: {

    async getService () {
      await this.$API.monitor.getServerInfo().then(res => {
        this.server = res.data
        this.cpu.series[0].data[0].value = this.server.cpu.usage
        this.memoryRate = this.server.memory.rate
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
</style>
