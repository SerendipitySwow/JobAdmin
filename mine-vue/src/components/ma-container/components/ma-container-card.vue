<template>
  <div class="ma-container-card">
    <div v-if="$slots.header" class="ma-container-card__header" ref="header">
      <slot name="header"/>
    </div>
    <div class="ma-container-card__body" ref="body">
      <div class="ma-container-card__body-card">
        <slot/>
      </div>
    </div>
    <div v-if="$slots.footer" class="ma-container-card__footer" ref="footer">
      <slot name="footer"/>
    </div>
  </div>
</template>

<script>
import scroll from './mixins/normal'
export default {
  name: 'ma-container-card',
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
