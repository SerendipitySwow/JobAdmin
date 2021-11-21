<template>
  <el-main>
    <el-page-header icon="el-icon-arrow-left" title="返回" :content="data.title" />
  </el-main>
</template>

<script setup>
import { onMounted, reactive, getCurrentInstance } from 'vue'
import useTabs from '@/utils/useTabs'

const { proxy } = getCurrentInstance()

let data = reactive({
  title: ''
})

onMounted(() => {
    let query = proxy.$route.query
    data.title = query.title + ' - ' + ((query.type === 'request') ? '接口请求数据' : '接口响应数据')
    useTabs.setTitle(data.title)

})
</script>