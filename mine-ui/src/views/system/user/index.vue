<template>
	<el-container>
		<el-aside width="220px" v-loading="showDeptloading">
			<el-container>
				<el-header>
					<el-input placeholder="输入关键字进行过滤" v-model="deptFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree
						ref="dept"
						class="menu"
						node-key="id"
						:data="dept"
						:current-node-key="''"
						:highlight-current="true"
						:expand-on-click-node="false"
						:filter-node-method="deptFilterNode"
						@node-click="deptClick"
					></el-tree>
				</el-main>
			</el-container>
		</el-aside>
		<el-container>
				<el-header>
					<div class="left-panel">

						<el-button
							icon="el-icon-plus"
							v-auth="['system:user:save']"
							@click="add"
						>新增</el-button>

						<el-button
							type="danger"
							plain
							icon="el-icon-delete"
							v-auth="['system:user:delete']"
							:disabled="selection.length==0"
							@click="batch_del"
						>删除</el-button>

					</div>
					<div class="right-panel">
						<div class="right-panel-search">
							<el-input v-model="queryParams.name" placeholder="搜索用户名" clearable></el-input>

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
									<el-form-item label="状态" class="ma-inline-form-item" prop="status">
										<el-select size="small" v-model="queryParams.status" placeholder="用户状态">
											<el-option label="启用" value="0">启用</el-option>
											<el-option label="停用" value="1">停用</el-option>
										</el-select>
									</el-form-item>

									<el-form-item label="创建时间" class="ma-inline-form-item">
										<el-date-picker
											size="small"
											v-model="dateRange"
											type="daterange"
											range-separator="至"
											@change="handleDateChange"
											start-placeholder="开始日期"
											end-placeholder="结束日期"
										></el-date-picker>
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
						@selection-change="selectionChange"
						@switch-data="switchData"
						stripe
						remoteSort
						remoteFilter
					>
						<el-table-column type="selection" width="50"></el-table-column>

						<el-table-column label="头像" width="80">
							<template #default="scope">
								<el-avatar :src="scope.row.avatar" size="small"></el-avatar>
							</template>
						</el-table-column>
						
						<el-table-column
							label="登录账号"
							prop="username"
							sortable='custom'
						></el-table-column>

						<el-table-column
							label="昵称"
							prop="nickname"
						></el-table-column>

						<el-table-column
							label="邮箱"
							prop="email"
							width="220"
						></el-table-column>

						<!-- <el-table-column
							label="状态"
							prop="status"
							width="100"
						>
							<template #default="scope">
								<el-switch
									v-model="scope.row.status"
									@change="handleStatus($event, scope.row)"
									active-value="0"
									inactive-value="1"
								></el-switch>
							</template>
						</el-table-column> -->

						<el-table-column
							label="用户类型"
							prop="user_type"
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

											<el-dropdown-item 
												@click="table_edit(scope.row, scope.$index)"
											>设置首页</el-dropdown-item>

											<el-dropdown-item 
												@click="table_edit(scope.row, scope.$index)"
											>初始化密码</el-dropdown-item>

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

					</maTable>
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
					{ label: '用户ID', prop: 'id', width: '150', hide: true },
					{ label: '手机', prop: 'phone', width: '120', hide: true  },
					{ label: '最后登录时间', prop: 'login_time', width: '200', hide: true  },
					{ label: '最后登录IP', prop: 'login_ip', width: '180', hide: true  }
				],
				povpoerShow: false,
				dateRange:'',
				showDeptloading: false,
				deptFilterText: '',
				dept: [],
				api: {
					list: this.$API.user.getPageList,
					recycleList: this.$API.user.getPageListByRecycle,
				},
				selection: [],
				queryParams: {
					username: undefined,
					dept_id: undefined,
					maxDate: undefined,
        			minDate: undefined,
					status: undefined
				},
			}
		},
		watch: {
			deptFilterText(val) {
				this.$refs.dept.filter(val);
			}
		},
		mounted() {
			this.getDept()
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
			async getDept(){
				await this.$API.dept.tree().then(res => {
					res.data.unshift({id: undefined, label: '所有'})
					this.dept = res.data
					this.showDeptloading = false
				})
			},
			//树过滤
			deptFilterNode(value, data){
				if (!value) return true;
				return data.label.indexOf(value) !== -1;
			},
			//树点击事件
			deptClick(data){
				this.queryParams.dept_id = data.id
				this.$refs.table.upData(this.queryParams)
			},

			// 选择时间事件
			handleDateChange (values) {
				if (values !== null) {
					this.queryParams.minDate = values[0]
					this.queryParams.maxDate = values[1]
				}
			},

			//搜索
			handlerSearch(){

			},

			// 切换数据类型回调
			switchData(type) {
				console.log(type)
			},

			// 用户状态更改
			handleStatus (val, row) {
				console.log(val)
				const status = row.status === '0' ? '0' : '1'
				const text = row.status === '0' ? '启用' : '停用'
				this.$confirm(`确认要${text} ${row.username} 用户吗？`, '提示', {
					type: 'warning',
					confirmButtonText: '确定',
					cancelButtonText: '取消'
				}).then(() => {
					this.$API.user.changeStatus({ id: row.id, status }).then(() => {
						this.$message.success(text + '成功')
					})
				}).catch(() => {
					row.status = row.status === '0' ? '1' : '0'
				})
			},

			resetSearch() {

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
