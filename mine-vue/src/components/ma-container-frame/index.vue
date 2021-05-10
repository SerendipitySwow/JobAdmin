<template>
  <ma-container v-bind="$attrs">
    <iframe
      class="ma-container-frame"
      :src="src"
      frameborder="0"/>
  </ma-container>
</template>

<script>
export default {
  name: 'ma-container-frame',
  props: {
    src: {
      type: String,
      required: false,
      default: 'https://d2.pub/zh/doc/ma-admin'
    }
  }
}
</script>

<style lang="scss" scoped>
.ma-container-frame {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 100%;
  width: 100%;
}
</style>
