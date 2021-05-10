<template>
  <ma-container>
    asdasdasd
  </ma-container>
</template>
<script>
import { getMenuTree } from '@/api/system/menu'
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
    }
  }
}
</script>
<style lang="scss" scoped>
.page {
  background:#fff;
}
</style>
