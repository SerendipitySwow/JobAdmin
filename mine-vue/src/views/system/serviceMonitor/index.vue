<template>
  <ma-container>
    <el-row :gutter="20">
      <el-col :span="12">
        <el-card class="ma-card">
          <div slot="header" class="clearfix">
              <span>CPU使用率</span>
          </div>
          <el-table :data="cpuinfo">

            <el-table-column prop="name" label="类型"  width="180"></el-table-column>
            <el-table-column prop="value" label="说明"></el-table-column>

          </el-table>
        </el-card>
      </el-col>

      <el-col :span="12">
        <el-card class="ma-card">
          <div slot="header" class="clearfix">
              <span>内存使用率</span>
          </div>
          <el-table :data="meminfo">

            <el-table-column prop="name" label="类型"  width="180"></el-table-column>
            <el-table-column prop="value" label="说明"></el-table-column>

          </el-table>
        </el-card>
      </el-col>
    </el-row>

    <el-row>
      <el-card class="ma-card">
        <div slot="header" class="clearfix">
            <span>PHP信息</span>
        </div>
        <el-table :data="meminfo">

          <el-table-column prop="name" label="类型"  width="180"></el-table-column>
          <el-table-column prop="value" label="说明"></el-table-column>

        </el-table>
      </el-card>
    </el-row>
    
    <el-row>
      <el-card class="ma-card">
        <div slot="header" class="clearfix">
            <span>服务器信息</span>
        </div>
        <el-table :data="meminfo">

          <el-table-column prop="name" label="类型"  width="180"></el-table-column>
          <el-table-column prop="value" label="说明"></el-table-column>

        </el-table>
      </el-card>
    </el-row>

    <el-row>
      <el-card class="ma-card">
        <div slot="header" class="clearfix">
            <span>磁盘信息</span>
        </div>
        <el-table :data="meminfo">

          <el-table-column prop="name" label="类型"  width="180"></el-table-column>
          <el-table-column prop="value" label="说明"></el-table-column>

        </el-table>
      </el-card>
    </el-row>
  </ma-container>
</template>
<script>
import { getServerInfo } from '@/api/system/serviceMonitor'
export default {
  name: 'system-serviceMonitor',

  data () {
    return {
      loading: [],
      cpuinfo: [],
      meminfo: [],
      projectMemory: '',
    }
  },

  created () {
    this.openLoading()
    this.getService()
  },

  methods: {

    async getService () {
      await getServerInfo().then(res => {
        let cpuinfo = res.data.cpuinfo
        this.cpuinfo.push({ name: 'CPU名称', value: cpuinfo.cpuName })
        this.cpuinfo.push({ name: 'CPU核心数', value: cpuinfo.cpuCores })
        for (let i = 0; i < cpuinfo.cpuUsage.length; i++) {
          let n = i + 1
          this.cpuinfo.push({ name: `CPU-${n} 使用率`, value: `${cpuinfo.cpuUsage[i]}%` })
        }

        let meminfo = res.data.meminfo
        this.projectMemory = meminfo.memProject

        this.meminfo.push({ name: '总内存', value: meminfo.memTotal })
        this.meminfo.push({ name: '空闲内存', value: meminfo.memFree })
        this.meminfo.push({ name: '已用内存', value: meminfo.memUsage })
        this.meminfo.push({ name: '系统占用内存', value: meminfo.memProject })
        this.meminfo.push({ name: '内存使用率', value: meminfo.memRate })

        
      })
      this.loading.close()
    },

    openLoading() {
      this.loading = this.$loading({
        lock: true,
        text: "拼命读取中",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)"
      });
    }
  }
}
</script>