<template>
  <div class="editor" ref="dom" :style="'height: ' + props.height + 'px'"></div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import * as monaco from 'monaco-editor/esm/vs/editor/editor.api.js'
// import 'monaco-editor/esm/vs/language/json/monaco.contribution';
import 'monaco-editor/esm/vs/basic-languages/javascript/javascript.contribution'
import 'monaco-editor/esm/vs/editor/contrib/find/findController.js'

const props = defineProps({
  modelValue: {
    type: String,
    default: () => {}
  },
  height: {
    type: Number,
    default: 300
  },
  theme: {
    type: String,
    default: 'vs'
  }
})

const emit = defineEmits(['update:modelValue'])
const dom = ref()

let instance

onMounted(() => {
  const jsonModel = monaco.editor.createModel(props.modelValue, 'javascript');

  instance = monaco.editor.create(dom.value, {
    model: jsonModel,
    tabSize: 2,
    automaticLayout: true,
    scrollBeyondLastLine: false,
    language:"javascript",
    theme: props.theme
  })

  instance.onDidChangeModelContent(() => {
    const value = instance.getValue()
    emit('update:modelValue', value)
  })
})
</script>

<style scoped lang="scss">
.editor {
  border: var(--el-input-border, var(--el-border-base));
  border-radius: var(--el-input-border-radius,var(--el-border-radius-base));
  background: var(--el-input-background-color,var(--el-color-white));
}
</style>