<template>
  <el-button icon="el-icon-finished" @click="showSelectPanel = true" >选择用户</el-button>

  <sc-dialog
    v-model="showSelectPanel"
    title="选择用户"
    width="800px"
  >
    asdasd
  </sc-dialog>

</template>

<script>
export default {
  props: {
    'modelValue': {
      type: Array
    }
  },
  data() {
    return {
      showSelectPanel: false
    }
  }
}
</script>