<template>
  <d2-container type="ghost">
    <d2-module-index-banner slot="header" v-bind="banner"/>
  </d2-container>
</template>

<script>
export default {
  data () {
    return {
      banner: {
        title: 'PLUGIN',
        subTitle: 'D2Admin 集成了许多实用插件'
      }
    }
  }
}
</script>
