<template>
  <transition name="fade-transverse">
    <div v-if="show" class="ma-module-index-menu">
      <ma-module-index-menu-group
        v-for="(item, index) in menu.children"
        :key="index"
        :menu="item"/>
    </div>
  </transition>
</template>

<script>
import maModuleIndexMenuGroup from './components/group'
export default {
  components: {
    maModuleIndexMenuGroup
  },
  props: {
    menu: {
      default: () => ({
        children: []
      })
    }
  },
  data () {
    return {
      show: false
    }
  },
  mounted () {
    setTimeout(() => {
      this.show = true
    }, 300)
  }
}
</script>

<style lang="scss">
.ma-module-index-menu {
  @extend %unable-select;
  margin-top: 20px;
}
</style>
