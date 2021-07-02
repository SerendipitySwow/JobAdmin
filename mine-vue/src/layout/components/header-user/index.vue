<template>
  <el-dropdown size="small" class="ma-mr">
    <div class="btn-text"><el-avatar size="small"> S </el-avatar><div class="username">{{info.name}}</div></div>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item @click.native="logOff" icon="el-icon-user">个人信息
      </el-dropdown-item>
      <el-dropdown-item @click.native="logOff" icon="el-icon-delete">清除缓存
      </el-dropdown-item>
      <el-dropdown-item @click.native="logOff" icon="el-icon-refresh-right">重启后台
      </el-dropdown-item>
      <el-dropdown-item divided @click.native="logOff" icon="el-icon-lock">后台锁屏
      </el-dropdown-item>
      <el-dropdown-item @click.native="logOff" icon="el-icon-switch-button">注销账户
      </el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  computed: {
    ...mapState('store/user', [
      'info'
    ])
  },
  methods: {
    ...mapActions('store/account', [
      'logout'
    ]),
    ...mapActions('store/user', [
      'cancellation'
    ]),
    /**
     * @description 登出
     */
    logOff () {
      this.logout({
        confirm: true
      }).then(e => {
        e && this.cancellation()
      })
    }
  }
}
</script>
<style scoped>
.btn-text {
  position: relative;
  padding: 0 10px !important;
}
.btn-text .username {
  display: inline-block;
  position: relative;
  left: 7px;
  top: -9px;
}
</style>
