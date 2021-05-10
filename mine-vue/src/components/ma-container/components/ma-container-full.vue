<template>
  <div class="ma-container-full">
    <div v-if="$slots.header" class="ma-container-full__header" ref="header">
      <slot name="header"/>
    </div>
    <div class="ma-container-full__body" ref="body">
      <slot/>
    </div>
    <div v-if="$slots.footer" class="ma-container-full__footer" ref="footer">
      <slot name="footer"/>
    </div>
  </div>
</template>

<script>
import scroll from './mixins/normal'
export default {
  name: 'ma-container-full',
  mixins: [
    scroll
  ],
  mounted () {
    // 增加滚动事件监听
    this.addScrollListener()
  },
  beforeDestroy () {
    // 移除滚动事件监听
    this.removeScrollListener()
  }
}
</script>
