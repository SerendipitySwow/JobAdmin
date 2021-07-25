<template>
	<el-container>
		<el-aside width="240px" v-loading="showGrouploading">
			<el-container>
				<el-header>
					<el-input placeholder="输入关键字进行过滤" v-model="groupFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree
						ref="group"
						class="menu"
						node-key="id"
						:data="group"
						:current-node-key="''"
						:highlight-current="true"
						:expand-on-click-node="false"
						:filter-node-method="groupFilterNode"
						@node-click="groupClick"
					></el-tree>
				</el-main>
			</el-container>
		</el-aside>
		<el-container>
				<el-header>
					<div class="left-panel">

						<el-button
							icon="el-icon-plus"
							@click="add"
						>新增</el-button>

						<el-button
							type="danger"
							plain
							icon="el-icon-delete"
							:disabled="selection.length==0"
							@click="batch_del"
						>删除</el-button>

					</div>
					<div class="right-panel">
						<div class="right-panel-search">
							<el-input v-model="search.name" placeholder="搜索用户名" clearable></el-input>

							<el-tooltip class="item" effect="dark" content="搜索" placement="top">
								<el-button type="primary" icon="el-icon-search" @click="upsearch"></el-button>
							</el-tooltip>

							<el-tooltip class="item" effect="dark" content="清空条件" placement="top">
								<el-button icon="el-icon-refresh" @click="upsearch"></el-button>
							</el-tooltip>

							<el-popover placement="bottom" :width="380" trigger="hover">
								<template #reference>
									<el-button type="text">
										更多筛选<i class="el-icon-arrow-down el-icon--right"></i>
									</el-button>
								</template>
								<el-form label-width="80px">
									<el-form-item label="登录账号" prop="name">
										<el-input v-model="search.name" placeholder="用于登录系统" clearable></el-input>
									</el-form-item>
								</el-form>
							</el-popover>
						</div>
					</div>
				</el-header>
				<el-main class="nopadding">
					<scTable
						ref="table"
						:api="api"
						:column="column"
						:showRecycle="true"
						@selection-change="selectionChange"
						@switch-data="switchData"
						stripe
						remoteSort
						remoteFilter
					>
						<el-table-column type="selection" width="50"></el-table-column>

						<el-table-column label="头像" width="60">
							<template #default="scope">
								<el-avatar :src="scope.row.avatar" size="small"></el-avatar>
							</template>
						</el-table-column>
						
						<el-table-column
							label="登录账号"
							prop="username"
							width="150"
							sortable='custom'
						></el-table-column>

						<el-table-column
							label="昵称"
							prop="nickname"
							width="130"
						></el-table-column>

						<el-table-column
							label="邮箱"
							prop="email"
							width="250"
						></el-table-column>

						<el-table-column
							label="用户类型"
							prop="user_type"
							width="100"
						>
							<template #default="scope">
								{{ scope.row.user_type === '100' ? '系统用户' : '其他类型' }}
							</template>
						</el-table-column>

						<el-table-column
							label="创建时间"
							prop="created_at"
							width="150"
							sortable='custom'
						></el-table-column>

						<el-table-column label="操作" fixed="right" align="right" width="130">
							<template #default="scope">

								<el-button
									type="text"
									size="small"
									@click="table_show(scope.row, scope.$index)"
								>查看</el-button>

								<el-dropdown>

									<el-button
										type="text" size="small"
									>
										更多<i class="el-icon-arrow-down el-icon--right"></i>
									</el-button>

									<template #dropdown>
										<el-dropdown-menu>

											<el-dropdown-item
												@click="table_edit(scope.row, scope.$index)"
											>编辑</el-dropdown-item>

											<el-dropdown-item divided>
												<el-popconfirm
													title="确定删除吗？"
													@confirm="table_del(scope.row, scope.$index)"
												>
													<template #reference>
														<el-button type="text" size="small">删除</el-button>
													</template>
												</el-popconfirm>
											</el-dropdown-item>

										</el-dropdown-menu>
									</template>

								</el-dropdown>
								
							</template>
						</el-table-column>

					</scTable>
				</el-main>
		</el-container>
	</el-container>

	<save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>

</template>

<script>
	import saveDialog from './save'

	export default {
		name: 'system:user',
		components: {
			saveDialog
		},

		data() {
			return {
				dialog: {
					save: false
				},
				column: [
					{ label: '用户ID', prop: 'id', width: '150' },
					{ label: '手机', prop: 'phone', width: '120' },
					{ label: '最后登录时间', prop: 'login_time', width: '200' },
					{ label: '最后登录IP', prop: 'login_ip', width: '180' }
				],
				showGrouploading: false,
				groupFilterText: '',
				group: [],
				api: {
					list: this.$API.user.getPageList,
					recycleList: this.$API.user.getPageListByRecycle,
				},
				selection: [],
				search: {
					name: null
				}
			}
		},
		watch: {
			groupFilterText(val) {
				this.$refs.group.filter(val);
			}
		},
		mounted() {
			this.getGroup()
		},
		methods: {
			//添加
			add(){
				this.dialog.save = true
				this.$nextTick(() => {
					this.$refs.saveDialog.open()
				})
			},
			//编辑
			table_edit(row){
				this.dialog.save = true
				this.$nextTick(() => {
					this.$refs.saveDialog.open('edit').setData(row)
				})
			},
			//查看
			table_show(row){
				this.dialog.save = true
				this.$nextTick(() => {
					this.$refs.saveDialog.open('show').setData(row)
				})
			},
			//删除
			async table_del(row, index){
				var reqData = {id: row.id}
				var res = await this.$API.user.del.post(reqData);
				if(res.code == 200){
					//这里选择刷新整个表格 OR 插入/编辑现有表格数据
					this.$refs.table.tableData.splice(index, 1);
					this.$message.success("删除成功")
				}else{
					this.$alert(res.message, "提示", {type: 'error'})
				}
			},
			//批量删除
			async batch_del(){
				this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
					type: 'warning'
				}).then(() => {
					const loading = this.$loading();
					this.selection.forEach(item => {
						this.$refs.table.tableData.forEach((itemI, indexI) => {
							if (item.id === itemI.id) {
								this.$refs.table.tableData.splice(indexI, 1)
							}
						})
					})
					loading.close();
					this.$message.success("操作成功")
				}).catch(() => {

				})
			},
			//表格选择后回调事件
			selectionChange(selection){
				this.selection = selection;
			},
			//加载树数据
			async getGroup(){
				// var res = await this.$API.role.select.get();
				this.showGrouploading = false;
				// var allNode ={id: '', label: '所有'}
				// res.data.unshift(allNode);
				this.group = []
			},
			//树过滤
			groupFilterNode(value, data){
				if (!value) return true;
				return data.label.indexOf(value) !== -1;
			},
			//树点击事件
			groupClick(data){
				var params = {
					groupId: data.id
				}
				this.$refs.table.upData(params)
			},
			//搜索
			upsearch(){

			},

			// 切换数据类型回调
			switchData(type) {
				console.log(type)
			},

			//本地更新数据
			handleSuccess(data, mode){
				if(mode=='add'){
					data.id = new Date().getTime()
					this.$refs.table.tableData.unshift(data)
				}else if(mode=='edit'){
					this.$refs.table.tableData.filter(item => item.id===data.id ).forEach(item => {
						Object.assign(item, data)
					})
				}
			}
		}
	}
</script>

<style>
</style>
