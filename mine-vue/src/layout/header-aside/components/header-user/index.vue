<template>
  <el-dropdown size="small" class="d2-mr">
    <span class="btn-text">{{info.name ? `你好 ${info.name}` : '未登录'}}</span>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item @click.native="logOff">
        <d2-icon name="power-off" class="d2-mr-5"/>
        注销
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
