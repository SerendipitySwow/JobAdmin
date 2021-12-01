<template>
  <el-container>
    <el-header>
      <div class="logo">
        <img src="img/logo.svg" width="54" /> <span class="title">API Document</span>
        <span class="sys_name">MineAdmin</span>
      </div>
      <el-menu default-active="1" mode="horizontal">
        <el-menu-item index="1">接口列表</el-menu-item>
        <el-menu-item index="2">签名算法</el-menu-item>
        <el-submenu index="3">
          <el-menu-item index="3-1">
            <el-icon><el-icon-refresh /></el-icon>切换应用
          </el-menu-item>
          <el-menu-item index="3-2" @click="$router.push('/')">
            <el-icon><ma-icon-mineadmin /></el-icon>返回后台
          </el-menu-item>
        </el-submenu>
      </el-menu>
    </el-header>

    <el-main>
      <router-view />
    </el-main>

    <el-footer class="footer">
      MineAdmin {{ $CONFIG.APP_VER }} Copyright © 2021-2022 mineadmin.com All Rights Reserved.
    </el-footer>
  </el-container>
</template>

<style scoped lang="scss">
.logo {
  img {
    position: relative;
    top: 6px;
    margin-right: 10px;
  }
  .title {
    font-size: 28px; margin-right: 5px;
  }
  .sys_name {
    color: #fff; background: rgb(220,38,38);
    padding: 0 4px; border-radius: 2px; font-family: inherit;
  }
}
.footer {
  text-align: center; line-height: 32px;
}
</style>