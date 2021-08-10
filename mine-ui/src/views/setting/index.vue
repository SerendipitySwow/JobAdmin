<template>
	<el-main>
		<el-card shadow="never">
			<el-tabs tab-position="top">

				<el-tab-pane label="系统设置">
					<el-form ref="form" :model="systemConfig" label-width="100px" style="margin-top: 20px;">
						<el-form-item label="系统名称">
							<el-input v-model="systemConfig.name"></el-input>
						</el-form-item>
						<el-form-item label="LogoUrl">
							<el-input v-model="systemConfig.logoUrl"></el-input>
						</el-form-item>
						<el-form-item label="登录开关">
							<el-switch v-model="systemConfig.login"></el-switch>
							<div class="el-form-item-msg" data-v-b33b3cf8="">关闭后普通用户无法登录，仅允许管理员角色登录</div>
						</el-form-item>
						<el-form-item label="密码验证规则">
							<el-input v-model="systemConfig.passwordRules"></el-input>
						</el-form-item>
						<el-form-item label="版权信息">
							<el-input type="textarea" :autosize="{minRows: 4}" v-model="systemConfig.copyright"></el-input>
						</el-form-item>
						<el-form-item>
							<el-button type="primary">保存</el-button>
						</el-form-item>
					</el-form>
				</el-tab-pane>

				<el-tab-pane label="扩展配置">
					<el-alert title="扩展配置为系统业务所有的配置，应该由系统管理员操作，如需用户配置应另起业务配置页面。" type="warning" style="margin-bottom: 15px;"></el-alert>

					<el-table :data="extendConfig" stripe>
						<el-table-column label="#" type="index" width="50"></el-table-column>
						<el-table-column label="KEY" prop="key" width="150">
							<template #default="scope">
								<el-input v-if="scope.row.isSet" v-model="scope.row.key" placeholder="请输入内容"></el-input>
								<span v-else>{{scope.row.key}}</span>
							</template>
						</el-table-column>
						<el-table-column label="VALUE" prop="value" width="350">
							<template #default="scope">
								<template v-if="scope.row.isSet">
									<el-switch v-if="typeof scope.row.value==='boolean'" v-model="scope.row.value"></el-switch>
									<el-input v-else v-model="scope.row.value" placeholder="请输入内容"></el-input>
								</template>
								<span v-else>{{scope.row.value}}</span>
							</template>
						</el-table-column>
						<el-table-column label="CATEGORY" prop="category" width="150">
							<template #default="scope">
								<el-input v-if="scope.row.isSet" v-model="scope.row.category" placeholder="请输入内容"></el-input>
								<span v-else>{{scope.row.category}}</span>
							</template>
						</el-table-column>
						<el-table-column label="TITLE" prop="title" width="350">
							<template #default="scope">
								<el-input v-if="scope.row.isSet" v-model="scope.row.title" placeholder="请输入内容"></el-input>
								<span v-else>{{scope.row.title}}</span>
							</template>
						</el-table-column>
						<el-table-column min-width="1"></el-table-column>
						<el-table-column label="操作" fixed="right" width="100">
							<template #default="scope">
								<el-button @click="table_edit(scope.row, scope.$index)" type="text" size="small">{{scope.row.isSet?'保存':"修改"}}</el-button>
								<el-button v-if="scope.row.isSet" @click="scope.row.isSet=false" type="text" size="small">取消</el-button>
								<el-popconfirm v-if="!scope.row.isSet" title="确定删除吗？" @confirm="table_del(scope.row, scope.$index)">
									<template #reference>
										<el-button type="text" size="small">删除</el-button>
									</template>
								</el-popconfirm>
							</template>
						</el-table-column>
					</el-table>
					<el-button type="primary" icon="el-icon-plus" @click="table_add" style="margin-top: 20px;"></el-button>
				</el-tab-pane>

			</el-tabs>
		</el-card>
	</el-main>
</template>

<script>
	export default {
		name: 'system',
		data() {
			return {
				systemConfig: [],
				extendConfig: [],
			}
		},

		created () {
			this.getSystemConfig()
			this.getExtendConfig()
		},

		methods: {
			
			// 系统配置组
			async getSystemConfig () {
				await this.$API.config.getSystemConfig().then(res => {
					this.systemConfig = res.data
				})
			},

			// 扩展配置组
			async getExtendConfig() {
				await this.$API.config.getExtendConfig().then(res => {
					this.extendConfig = res.data
				})
			},

			table_add(){
				var newRow = {
					key: "",
					value: "",
					title: "",
					isSet: true
				}
				this.setting.push(newRow)
			},
			table_edit(row){
				if(row.isSet){
					row.isSet = false
				}else{
					row.isSet = true
				}
			},
			table_del(row, index){
				this.setting.splice(index, 1)
			},
		}
	}
</script>

<style>
</style>
