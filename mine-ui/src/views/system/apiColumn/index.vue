<template>
	<sc-page-header
			:title="data.title"
			icon="el-icon-connection"
	>
		<el-button @click="data.proxy.$router.push('api')">返回接口管理</el-button>
	</sc-page-header>
	<el-container>
		<el-header>
			<div class="left-panel">

				<el-button
					icon="el-icon-plus"
					v-auth="['system:SystemApiColumn:save']"
					type="primary"
					@click="add"
				>新增</el-button>

				<el-button
					type="danger"
					plain
					icon="el-icon-delete"
					v-auth="['system:SystemApiColumn:delete']"
					:disabled="data.selection.length==0"
					@click="batchDel"
				>删除</el-button>

			</div>
			<div class="right-panel">
				<div class="right-panel-search">

					<el-input v-model="data.queryParams.name" placeholder="字段名称" clearable></el-input>

					<el-tooltip class="item" effect="dark" content="搜索" placement="top">
						<el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
					</el-tooltip>

					<el-tooltip class="item" effect="dark" content="清空条件" placement="top">
						<el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
					</el-tooltip>

					<el-popover placement="bottom-end" :width="450" trigger="click" >
						<template #reference>
							<el-button type="text" @click="povpoerShow = ! povpoerShow">
								更多筛选<i class="el-icon-arrow-down el-icon--right"></i>
							</el-button>
						</template>
						<el-form label-width="80px">

							<el-form-item label="是否必填" prop="is_required">
								<el-input v-model="data.queryParams.is_required" placeholder="是否必填" clearable></el-input>
							</el-form-item>

							<el-form-item label="状态" prop="status">

								<el-select v-model="data.queryParams.status" style="width:100%" clearable placeholder="状态">
									<el-option
										v-for="(item, index) in data_status_data"
										:key="index"
										:label="item.label"
										:value="item.value"
									>{{item.label}}</el-option>
								</el-select>
							</el-form-item>

						</el-form>
					</el-popover>
				</div>
			</div>
		</el-header>
		<el-main class="nopadding">
			<maTable
				ref="table"
				:api="api"
				:column="column"
				:showRecycle="true"
				row-key="id"
				:hidePagination="false"
				@selection-change="selectionChange"
				@switch-data="switchData"
				stripe
				remoteSort
			>
				<el-table-column type="selection" width="50"></el-table-column>


				<el-table-column
					label="字段名称"
					prop="name"
				/>
				<el-table-column
					label="数据类型"
					prop="data_type"
				/>
				<el-table-column
					label="是否必填"
					prop="is_required"
				/>
				<el-table-column
					label="默认值"
					prop="default_value"
				/>
				<el-table-column
					label="状态"
					prop="status"
				/>
				<el-table-column
					label="字段说明"
					prop="description"
				/>

				<!-- 正常数据操作按钮 -->
				<el-table-column label="操作" fixed="right" align="right" width="130" v-if="!isRecycle">
					<template #default="scope">

						<el-button
							type="text"
							size="small"
							@click="tableEdit(scope.row, scope.$index)"
							v-auth="['system:SystemApiColumn:update']"
						>编辑</el-button>

						<el-button
							type="text"
							size="small"
							@click="deletes(scope.row.id)"
							v-auth="['system:SystemApiColumn:delete']"
						>删除</el-button>

					</template>
				</el-table-column>

				<!-- 回收站操作按钮 -->
				<el-table-column label="操作" fixed="right" align="right" width="130" v-else>
					<template #default="scope">

						<el-button
							type="text"
							size="small"
							v-auth="['system:SystemApiColumn:recovery']"
							@click="recovery(scope.row.id)"
						>恢复</el-button>

						<el-button
							type="text"
							size="small"
							v-auth="['system:SystemApiColumn:realDelete']"
							@click="deletes(scope.row.id)"
						>删除</el-button>

					</template>
				</el-table-column>

			</maTable>
		</el-main>
	</el-container>

<!--	<save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>-->
</template>

<script setup>
import { onMounted, reactive, getCurrentInstance } from 'vue'
import useTabs from '@/utils/useTabs'

const { proxy } = getCurrentInstance()
const _this = getCurrentInstance().appContext.config.globalProperties

let data = reactive({
	proxy,
  title : '',
	apiId : null,
	selection: [],
	queryParams: { name: undefined, status: undefined, is_required: undefined },
	statusData: [],
})

onMounted(async () => {
	let query = proxy.$route.query
	if (query.title && query.apiId) {
		data.title = query.title + ' - ' + ((query.type === 'request') ? '接口请求数据' : '接口响应数据')
		data.apiId = query.apiId
		useTabs.setTitle(data.title)
	} else {
		_this.$message.error('请从正确来路访问页面，标签页已关闭')
		useTabs.close()
	}

	await getDictData()
})

// 获取字典数据
let getDictData = () => {
	console.log('123123')
	_this.getDict('data_status').then(res => {
		data.statusData = res.data
	})
}
</script>
