<template>
  <el-row>
    <draggable
      v-model="imageList"
      v-bind="{scroll: true, animation: 400}"
      class="el-upload-list el-upload-list--picture-card"
      tag="ul"
      :disabled="disabled"
      @start="isDrag = true"
      @end="isDrag = false"
    >
      <li
        v-for="(item, index) in value"
        :key="index"
        class="el-upload-list__item"
        :style="`width:120px; height:120px;`"
      >
        <div class="thumbnail" :style="`width:120px; height:120px;`">
          <el-image :src="item.url" fit="fill"/>
        </div>

        <span v-show="!isDrag" :class="{ 'el-upload-list__item-actions': true }">
            <span class="el-upload-list__item-delete">
              <i class="el-icon-zoom-in" @click="preview(index)"/>
            </span>

            <span class="el-upload-list__item-delete">
              <i class="el-icon-delete" @click="remove(index)"/>
            </span>
          </span>
      </li>
    </draggable>

    <slot name="upload"/>

  </el-row>
</template>

<script>
export default {
  components: {
    draggable: () => import('vuedraggable')
  },
  props: {
    // 外部v-model值
    value: {
      type: Array,
      default: () => []
    },
    disabled: {
      default: false
    }
  },
  data () {
    return {
      isDrag: false
    }
  },
  computed: {
    imageList: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  },
  methods: {
    preview (index) {
      this.$preview(this.imageList, index)
    },
    remove (index) {
      this.imageList.splice(index, 1)
    }
  }
}
</script>

<style scoped>
.thumbnail {
  display: inline-flex;
  flex-flow: column;
}
</style>
