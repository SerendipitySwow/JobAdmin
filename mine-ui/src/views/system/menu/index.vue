<template>
	<el-container>
		<el-aside width="283px">
			<el-container>
				<el-header>
					<el-input placeholder="输入关键字进行过滤" v-model="menuFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree
						ref="menu"
						class="menu"
						node-key="name"
						:data="menuList"
						:props="menuProps"
						draggable
						highlight-current
                        :expand-on-click-node="false"
 
                        :filter-node-method="menuFilterNode"
                        @node-click="menuClick"
                    >

						<template #default="{node, data}">
							<span class="custom-tree-node">
								<span class="label">{{ node.label }}</span>
								<span class="do">
									<i class="el-icon-plus" @click.stop="add(node, data)"></i>
									<i class="el-icon-delete" @click.stop="add(node, data)"></i>
								</span>
							</span>
						</template>

					</el-tree>
				</el-main>
				<el-footer style="height:51px;">
					<el-button size="mini" icon="el-icon-plus" v-auth="'system:menu:save'" @click="add()">新增</el-button>
					<el-button size="mini" plain icon="el-icon-view" @click="delMenu">回收站</el-button>
					<el-button size="mini" plain icon="el-icon-refresh" @click="delMenu">刷新</el-button>
				</el-footer>
			</el-container>
		</el-aside>
		<el-container>
			<el-main class="nopadding" style="padding:20px;">
				<save ref="save" :menu="menuList"></save>
			</el-main>
		</el-container>
	</el-container>
</template>

<script>
	let newMenuIndex = 1;
	import save from './save'

	export default {
		name: "menu:index",
		components: {
			save
		},
		data(){
			return {
				menuList: [],
				menuProps: {
					label: (data)=>{
						return data.name
					}
				},
				menuFilterText: '',
				showRecycle: false,
				queryParams: {
					name: undefined,
				}
			}
		},
		watch: {
			menuFilterText(val){
				this.$refs.menu.filter(val);
			}
		},
		mounted() {
			this.getMenu();
		},
		methods: {
			//加载树数据
			async getMenu(){
				if (! this.showRecycle) {
					await this.$API.menu.getList(this.queryParams).then(res => {
						this.menuList = res.data;
					})
				} else {
					await this.$API.menu.getRecycle(this.queryParams).then(res => {
						this.menuList = res.data;
					})
				}
			},
			//树点击
			menuClick(data, node){
				let pid = node.level==1?undefined:node.parent.data.id;
				this.$refs.save.setData(data, pid)
			},
			//树过滤
			menuFilterNode(value, data){
				if (!value) return true;
				let targetText = data.name;
				return targetText.indexOf(value) !== -1;
			},

			//增加
			add(node){
				let newMenuName = "未命名" + newMenuIndex++;
				let newMenuData = {
					name: newMenuName,
					path: "",
					component: "",
                    type: 'M'
				}
				if(node){
					this.$refs.menu.append(newMenuData, node)
					let lastNode = node.childNodes[node.childNodes.length-1]
					this.$refs.menu.setCurrentKey(lastNode.data.name)
					let pid = node.data.id;
					this.$refs.save.setData(newMenuData, pid)
				}else{
					this.$refs.menu.append(newMenuData)
					let newNode = this.menuList[this.menuList.length-1]
					this.$refs.menu.setCurrentKey(newNode.name)
					this.$refs.save.setData(newMenuData)
				}

			},

			//删除菜单
			delMenu(){
				let CheckedNodes = this.$refs.menu.getCheckedNodes()
				if(CheckedNodes.length == 0){
					this.$message.warning("请选择需要删除的项")
					return false;
				}
				CheckedNodes.forEach(item => {
                    console.log(item)
					// this.$refs.menu.remove(item)
				})
			}
		}
	}
</script>

<style scoped>
	.custom-tree-node {display: flex;flex: 1;align-items: center;justify-content: space-between;font-size: 14px;padding-right: 24px;height:100%;}
	.custom-tree-node .label {display: flex;align-items: center;;height: 100%;}
	.custom-tree-node .label .el-tag {margin-left: 5px;}
	.custom-tree-node .do {display: none;}
	.custom-tree-node .do i {margin-left:5px;color: #999;padding:5px;}
	.custom-tree-node .do i:hover {color: #333;}

	.custom-tree-node:hover .do {display: inline-block;}
</style>
