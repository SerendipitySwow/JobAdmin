<template>
	<el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
		<el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px">

			<el-form-item label="字段名称" prop="name">
				<el-input v-model="form.name" clearable placeholder="请输入字段名称" />
			</el-form-item>

			<el-form-item label="字段类型 0 请求 1 返回" prop="type">
				<el-radio-group v-model="form.type">
					<el-radio label="0">是</el-radio>
					<el-radio label="1">否</el-radio>
				</el-radio-group>
			</el-form-item>

			<el-form-item label="数据类型" prop="data_type">
				<el-select v-model="form.data_type" style="width:100%" clearable placeholder="请选择数据类型">
				</el-select>
			</el-form-item>

			<el-form-item label="是否必填 0 非必填 1 必填" prop="is_required">
				<el-input v-model="form.is_required" clearable placeholder="请输入是否必填 0 非必填 1 必填" />
			</el-form-item>

			<el-form-item label="默认值" prop="default_value">
				<el-input v-model="form.default_value" clearable placeholder="请输入默认值" />
			</el-form-item>

			<el-form-item label="状态 (0正常 1停用)" prop="status">
				<el-select v-model="form.status" style="width:100%" clearable placeholder="请选择状态 (0正常 1停用)">
					<el-option
						v-for="(item, index) in data_status_data"
						:key="index" :label="item.label"
						:value="item.value"
					>{{item.label}}</el-option>
				</el-select>
			</el-form-item>

			<el-form-item label="字段说明" prop="description">
				<el-input v-model="form.description" clearable placeholder="请输入字段说明" />
			</el-form-item>

			<el-form-item label="备注" prop="remark">
				<el-input v-model="form.remark" clearable placeholder="请输入备注" />
			</el-form-item>

		</el-form>
		<template #footer>
			<el-button @click="visible=false" >取 消</el-button>
			<el-button type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
		</template>
	</el-dialog>
</template>

<script setup>
import editor from '@/components/scEditor'
import { defineComponent } from "vue"

defineComponent({
	editor
})
</script>

<style scoped>

</style>
