<template>
  <d2-container>
    asdasdasd
  </d2-container>
</template>
<script>
import { getMenuTree, getMenuTreeByRecycle } from '@/api/system/menu'
export default {
  name: 'sys-menu',
  mounted () {
    this.getData()
  },
  methods: {
    getData () {
      getMenuTree().then(res => {
        console.log(res)
      })
      getMenuTreeByRecycle()
    }
  }
}
</script>
<style lang="scss" scoped>
.page {
  background:#fff;
}
</style>
