<template>
  <el-main>
    <el-page-header icon="el-icon-arrow-left" title="返回" :content="data.title" />
  </el-main>
</template>

<script setup>
import { onMounted, reactive, getCurrentInstance } from 'vue'
import useTabs from '@/utils/useTabs'

const { proxy } = getCurrentInstance()
const _this = getCurrentInstance().appContext.config.globalProperties

let data = reactive({
  title: '',
	apiId: null
})

onMounted(() => {
	let query = proxy.$route.query
	if (query.title && query.apiId) {
		data.title = query.title + ' - ' + ((query.type === 'request') ? '接口请求数据' : '接口响应数据')
		data.apiId = query.apiId
		useTabs.setTitle(data.title)
	} else {
		_this.$message.error('请从正确来路访问页面，标签页已关闭')
		useTabs.close()
	}
})
</script>
