<template>
	<el-container>
		<el-aside width="300px" v-loading="showDicloading">
			<el-container>
				<el-header>
					<el-input placeholder="输入关键字进行过滤" v-model="dicFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree ref="dictType" class="menu" node-key="id" :data="dictTypeList" :props="dicProps" :highlight-current="true" :expand-on-click-node="false" :filter-node-method="dicFilterNode" @node-click="dicClick">
						<template #default="{node, data}">
							<span class="custom-tree-node">
								<span class="label">{{ node.label }}</span>
								<span class="code">{{ data.code }}</span>
								<span class="do" v-if="showTypeRecycle">
									<el-tooltip
										class="item"
										effect="dark"
										content="回复数据"
										placement="top"
										v-auth="'system:dictType:recovery'"
									>
										<i class="el-icon-refresh-left" @click.stop="dictTypeRecoverys(data)"></i>
									</el-tooltip>

									<el-tooltip
										class="item"
										effect="dark"
										content="物理删除"
										placement="top"
										v-auth="'system:dictType:realDelete'"
									>
										<i class="el-icon-delete" @click.stop="dictTypeDelete(node, data)"></i>
									</el-tooltip>
								</span>
								<span class="do" v-else>
									<el-tooltip
										class="item"
										effect="dark"
										content="编辑字典类型"
										placement="top"
										v-auth="'system:dictType:update'"
									>
										<i class="el-icon-edit" @click.stop="dictTypeEdit(data)"></i>
									</el-tooltip>

									<el-tooltip
										class="item"
										effect="dark"
										content="删除字典类型"
										placement="top"
										v-auth="'system:dictType:delete'"
									>
										<i class="el-icon-delete" @click.stop="dictTypeDelete(node, data)"></i>
									</el-tooltip>
								</span>
							</span>
						</template>
					</el-tree>
				</el-main>
				<el-footer style="height:60px;">
					<el-button
						icon="el-icon-plus"
						v-auth="'system:dictType:save'"
						@click="addDictType()"
						v-if="!showTypeRecycle"
					>新增</el-button>

					<el-button
						icon="el-icon-view"
						v-auth="'system:dictType:recycle'"
						@click="switchTypeData"
					>{{ getSwitchText }}</el-button>

					<el-button
						icon="el-icon-refresh"
						@click="getDictTypeList"
					>刷新</el-button>
				</el-footer>
			</el-container>
		</el-aside>
		<el-container class="is-vertical">
			<el-header>
				<div class="left-panel">
					<el-button type="primary" v-if="!showTypeRecycle" icon="el-icon-plus" @click="addInfo"></el-button>
					<el-button type="danger" plain icon="el-icon-delete" :disabled="selection.length==0" @click="batch_del"></el-button>
				</div>
			</el-header>
			<el-main class="nopadding">
				<scTable ref="table" :apiObj="dictList" row-key="id" :params="listParams" @selection-change="selectionChange" stripe :paginationLayout="'prev, pager, next'">
					<el-table-column type="selection" width="50"></el-table-column>
					<el-table-column label="" width="50">
						<template #default>
							<el-tag class="move" style="cursor: move;"><i class="el-icon-d-caret"></i></el-tag>
						</template>
					</el-table-column>
					<el-table-column label="名称" prop="name" width="150"></el-table-column>
					<el-table-column label="键值" prop="key" width="150"></el-table-column>
					<el-table-column label="是否有效" prop="yx" width="100">
						<template #default="scope">
							<el-switch
								v-if="scope.row.yx"
								v-model="scope.row.yx"
								@change="changeSwitch($event, scope.row)"
								:loading="scope.row.$switch_yx"
								active-value="1"
								inactive-value="0"
								></el-switch>
						</template>
					</el-table-column>
					<el-table-column label="操作" fixed="right" align="right" width="140">
						<template #default="scope">
							<el-button type="text" size="small" @click="table_edit(scope.row, scope.$index)">编辑</el-button>
							<el-popconfirm title="确定删除吗？" @confirm="table_del(scope.row, scope.$index)">
								<template #reference>
									<el-button type="text" size="small">删除</el-button>
								</template>
							</el-popconfirm>
						</template>
					</el-table-column>
				</scTable>
			</el-main>
		</el-container>
	</el-container>

	<dic-dialog v-if="dialog.dictType" ref="dicDialog" @success="handleDicSuccess" @closed="dialog.dictType=false"></dic-dialog>

	<list-dialog v-if="dialog.list" ref="listDialog" @success="handleListSuccess" @closed="dialog.list=false"></list-dialog>

</template>

<script>
	import dicDialog from './dic'
	import listDialog from './list'
	import Sortable from 'sortablejs'

	export default {
		name: 'system:dataDict',
		components: {
			dicDialog,
			listDialog
		},
		data() {
			return {
				dialog: {
					dic: false,
					info: false
				},
				showTypeRecycle: false,
				showDicloading: true,
				dictTypeList: [],
				dicFilterText: '',
				dicProps: {
					label: 'name'
				},
				dictList: null,
				listParams: {},
				selection: []
			}
		},
		computed: {
			getSwitchText() {
				return this.showTypeRecycle ? '显示正常数据' : '回收站'
			}
		},
		watch: {
			dicFilterText(val) {
				this.$refs.dictType.filter(val);
			}
		},
		mounted() {
			this.getDictTypeList()
			this.rowDrop()
		},
		methods: {
			//加载字典类型数据
			async getDictTypeList(){
				this.showDicloading = true
				if (!this.showTypeRecycle) {
					await this.$API.dictType.getTypeList().then(res => {
						this.dictTypeList = res.data
						this.showDicloading = false
					});
				} else {
					await this.$API.dictType.getRecycleTypeList().then(res => {
						this.dictTypeList = res.data
						this.showDicloading = false
					});
				}
				
				//获取第一个节点,设置选中 & 加载明细列表
				if(this.dictTypeList.length){
					this.$nextTick(() => {
						this.$refs.dictType.setCurrentKey(this.dictTypeList[0].id)
					})
					this.listParams = {
						code: this.dictTypeList[0].code
					}
					await this.$API.dataDict.getPageList(this.listParams).then(res => {
						this.dictList = res.data.items
					});
				}
			},
			//字典类型过滤
			dicFilterNode(value, data){
				if (!value) return true;
				return data.name.indexOf(value) !== -1;
			},
			//字典类型增加
			addDictType(){
				this.dialog.dictType = true
				this.$nextTick(() => {
					this.$refs.dicDialog.open()
				})
			},
			//编辑字典类型
			dictTypeEdit(data){
				this.dialog.dictType = true
				this.$nextTick(() => {
					var editNode = this.$refs.dictType.getNode(data.id);
					var editNodeParentId =  editNode.level==1?undefined:editNode.parent.data.id
					data.parentId = editNodeParentId
					this.$refs.dicDialog.open('edit').setData(data)
				})
			},
			// 恢复字典类型
			dictTypeRecoverys (data) {
				this.$API.dictType.recoverys(data.id).then(res => {
					if (res.success) {
						this.$message.success('数据恢复成功')
						this.getDictTypeList()
					}
				})
			},
			//字典类型点击事件
			dicClick(data){
				this.$refs.table.upData({
					code: data.code
				})
			},
			//删除字典类型
			dictTypeDelete(node, data){
				this.$confirm(`确定删除 ${data.name} 项吗？`, '提示', {
					type: 'warning'
				}).then(() => {
					this.showDicloading = true;

					if (this.showTypeRecycle) {
						this.$API.dictType.realDelete(data.id).then(() => {
							this.getDictTypeList()
						})
					} else {
						this.$API.dictType.deletes(data.id).then(() => {
							this.getDictTypeList()
						})
					}

					this.showDicloading = false;
					this.$message.success("操作成功")
				}).catch(() => {

				})
			},
			//行拖拽
			rowDrop(){
				const _this = this
				const tbody = this.$refs.table.$el.querySelector('.el-table__body-wrapper tbody')
				Sortable.create(tbody, {
					handle: ".move",
					animation: 300,
					ghostClass: "ghost",
					onEnd({ newIndex, oldIndex }) {
						const tableData = _this.$refs.table.tableData
						const currRow = tableData.splice(oldIndex, 1)[0]
						tableData.splice(newIndex, 0, currRow)
						_this.$message.success("排序成功")
					}
				})
			},
			//添加明细
			addInfo(){
				this.dialog.list = true
				this.$nextTick(() => {
					var dicCurrentKey = this.$refs.dic.getCurrentKey();
					const data = {
						dic: dicCurrentKey
					}
					this.$refs.listDialog.open().setData(data)
				})
			},
			//编辑明细
			table_edit(row){
				this.dialog.list = true
				this.$nextTick(() => {
					this.$refs.listDialog.open('edit').setData(row)
				})
			},
			//删除明细
			async table_del(row, index){
				var reqData = {id: row.id}
				var res = await this.$API.user.del.post(reqData);
				if(res.code == 200){
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
			//提交明细
			saveList(){
				this.$refs.listDialog.submit(async (formData) => {
					this.isListSaveing = true;
					var res = await this.$API.user.save.post(formData);
					this.isListSaveing = false;
					if(res.code == 200){
						//这里选择刷新整个表格 OR 插入/编辑现有表格数据
						this.listDialogVisible = false;
						this.$message.success("操作成功")
					}else{
						this.$alert(res.message, "提示", {type: 'error'})
					}
				})
			},
			//表格选择后回调事件
			selectionChange(selection){
				this.selection = selection;
			},
			//表格内开关事件
			changeSwitch(val, row){
				//1.还原数据
				row.yx = row.yx == '1'?'0':'1'
				//2.执行加载
				row.$switch_yx = true;
				//3.等待接口返回后改变值
				setTimeout(()=>{
					delete row.$switch_yx;
					row.yx = val;
					this.$message.success(`操作成功id:${row.id} val:${val}`)
				}, 500)
			},
			//本地更新数据
			handleDicSuccess(data, mode){
				if(mode=='add'){
					data.id = new Date().getTime()
					if(this.dictTypeList.length > 0){
						this.$refs.table.upData({
							code: data.code
						})
					}else{
						this.listParams = {
							code: data.code
						}
						this.dictList = this.$API.dic.info;
					}
					this.$refs.dic.append(data, data.parentId[0])
					this.$refs.dic.setCurrentKey(data.id)
				}else if(mode=='edit'){
					var editNode = this.$refs.dic.getNode(data.id);
					//判断是否移动？
					var editNodeParentId =  editNode.level==1?undefined:editNode.parent.data.id
					if(editNodeParentId != data.parentId){
						var obj = editNode.data;
						this.$refs.dic.remove(data.id)
						this.$refs.dic.append(obj, data.parentId[0])
					}
					Object.assign(editNode.data, data)
				}
			},
			//本地更新数据
			handleListSuccess(data, mode){
				if(mode=='add'){
					data.id = new Date().getTime()
					this.$refs.table.tableData.push(data)
				}else if(mode=='edit'){
					this.$refs.table.tableData.filter(item => item.id===data.id ).forEach(item => {
						Object.assign(item, data)
					})
				}
			},

			switchTypeData () {
				this.showTypeRecycle = !this.showTypeRecycle
				this.getDictTypeList()
				this.$message.success('数据已切换到' + ( this.showTypeRecycle ? '回收站数据' : '正常数据' ))
			}
		}
	}
</script>

<style scoped>
	.custom-tree-node {display: flex;flex: 1;align-items: center;justify-content: space-between;font-size: 14px;padding-right: 24px;height:100%;}
	.custom-tree-node .code {font-size: 12px;color: #999;}
	.custom-tree-node .do {display: none;}
	.custom-tree-node .do i {margin-left:5px;color: #999;padding:5px;}
	.custom-tree-node .do i:hover {color: #333;}
	.custom-tree-node:hover .code {display: none;}
	.custom-tree-node:hover .do {display: inline-block;}
</style>
