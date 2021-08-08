<template>
	<el-main>
		<el-row :gutter="15">
			<el-col :lg="8">
				<el-card shadow="never">
					<div class="user-info">
						<div class="user-info-top">
							<el-avatar :size="160" :src="userInfo.user.avatar"></el-avatar>
							<h2>{{ userInfo.user.nickname||'-' }}</h2>
							<el-button type="primary" round icon="el-icon-collection-tag" size="medium">{{ userInfo.user.username }}</el-button>
						</div>
						<div class="user-info-main">
							<ul>
								<li><label><i class="el-icon-user"></i></label><span>{{ userInfo.user.email }}</span></li>
								<li><label><i class="el-icon-present"></i></label><span> {{ userInfo.user.user_type == '100' ? '系统用户' : '其他类型' }}</span></li>
								<li><label><i class="el-icon-mobile"></i></label><span>{{ userInfo.user.phone }}</span></li>
								<li><label><i class="el-icon-coin"></i></label><span>{{ userInfo.roles[0] }}</span></li>
							</ul>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :lg="16">
				<el-card shadow="never">
					<el-tabs tab-position="top">
						<el-tab-pane label="基本资料">
							<el-form ref="form" :model="form" label-width="80px" style="width: 460px;margin-top:20px;">
								<el-form-item label="账号">
									<el-input v-model="form.user" disabled></el-input>
									<div class="el-form-item-msg">账号信息用于登录，系统不允许修改</div>
								</el-form-item>
								<el-form-item label="姓名">
									<el-input v-model="form.name"></el-input>
								</el-form-item>
								<el-form-item label="性别">
									<el-select v-model="form.sex" placeholder="请选择">
										<el-option label="保密" value="0"></el-option>
										<el-option label="男" value="1"></el-option>
										<el-option label="女" value="2"></el-option>
									</el-select>
								</el-form-item>
								<el-form-item label="个性签名">
									<el-input v-model="form.about" type="textarea"></el-input>
								</el-form-item>
								<el-form-item>
									<el-button type="primary">保存</el-button>
								</el-form-item>
							</el-form>
						</el-tab-pane>
						<el-tab-pane label="修改密码">
							<el-form ref="form" :model="form" label-width="120px" style="width: 460px;margin-top:20px;">
								<el-form-item label="布局">
									<el-select v-model="config.theme" placeholder="请选择">
										<el-option label="常规" value="0"></el-option>
										<el-option label="分栏" value="1"></el-option>
									</el-select>
								</el-form-item>
								<el-form-item label="控制台自由布局">
									<el-switch v-model="config.diy"></el-switch>
								</el-form-item>
								<el-form-item label="多标签">
									<el-switch v-model="config.tags"></el-switch>
								</el-form-item>
								<el-form-item label="系统通知">
									<el-switch v-model="config.msg"></el-switch>
								</el-form-item>
								<el-form-item>
									<el-button type="primary">保存</el-button>
								</el-form-item>
							</el-form>
						</el-tab-pane>
					</el-tabs>
				</el-card>
			</el-col>
		</el-row>
	</el-main>
</template>

<script>
	export default {
		name: 'userCenter',
		data() {
			return {
				activities: [
					{
						operate: '更改了',
						mod: '系统配置',
						describe: 'systemName 为 SCUI',
						type: 'edit',
						timestamp: '刚刚'
					},
					{
						operate: '删除了',
						mod: '用户',
						describe: 'USER',
						type: 'del',
						timestamp: '5分钟前'
					},
					{
						operate: '禁用了',
						mod: '用户',
						describe: 'USER',
						type: 'del',
						timestamp: '5分钟前'
					},
					{
						operate: '创建了',
						mod: '用户',
						describe: 'USER',
						type: 'add',
						timestamp: '5分钟前'
					},
					{
						operate: '审核了',
						mod: '用户',
						describe: 'lolowan 为 通过',
						type: 'add',
						timestamp: '10分钟前'
					},
					{
						operate: '登录',
						mod: '',
						describe: '成功',
						type: 'do',
						timestamp: '1小时前'
					},
				],
				form: {
					user: "81883387@qq.com",
					name: "Sakuya",
					sex: "1",
					about: "正所谓富贵险中求"
				},
				userInfo: null,
				config: {
					theme: '1',
					diy: true,
					tags: true,
					msg: true
				}
			}
		},
		created () {
			this.userInfo = this.$TOOL.data.get('user')
		}
	}
</script>

<style scoped>
	.el-card {margin-bottom:15px;}
	.activity-item {font-size: 13px;color: #999;display: flex;align-items: center;}
	.activity-item label {color: #333;margin-right:10px;}
	.activity-item .el-avatar {margin-right:10px;}
	.activity-item .el-tag {margin-right:10px;}
</style>
