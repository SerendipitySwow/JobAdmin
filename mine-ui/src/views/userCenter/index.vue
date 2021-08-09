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
						<div class="user-info-bottom">
							<h2>个人签名</h2>
							<el-space wrap>
								{{ userInfo.user.signed == null ? '这家伙很懒，什么都没有留下。' : userInfo.user.signed }}
							</el-space>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :lg="16">
				<el-card shadow="never">
					<el-tabs tab-position="top">
						<el-tab-pane label="基本资料">
							<el-form ref="formUser" :model="formUser" label-width="80px" style="width: 600px; margin-top:20px;">

								<el-form-item label="账号">
									<el-input v-model="formUser.username" disabled></el-input>
									<div class="el-form-item-msg">账号信息用于登录，系统不允许修改</div>
								</el-form-item>

								<el-form-item label="昵称">
									<el-input v-model="formUser.nickname"></el-input>
								</el-form-item>

								<el-form-item label="手机">
									<el-input v-model="formUser.phone"></el-input>
								</el-form-item>

								<el-form-item label="邮箱">
									<el-input v-model="formUser.email"></el-input>
								</el-form-item>

								<el-form-item label="个性签名">
									<el-input
										v-model="formUser.signed"
										type="textarea"
										:rows="3"
										maxlength="255"
										show-word-limit
									/>
								</el-form-item>

								<el-form-item>
									<el-button type="primary" @click="updateInfo" :loading="infoLoading">保存</el-button>
								</el-form-item>

							</el-form>
						</el-tab-pane>
						<el-tab-pane label="修改密码">
							<el-form ref="formPassword" :rules="passwordRule" :model="formPassword" label-width="80px" style="width: 600px;margin-top:20px;">

								<el-form-item label="旧密码">
									<el-input v-model="formPassword.oldPassword" type="password" clearable show-password></el-input>
								</el-form-item>

								<el-form-item label="新密码">
									<el-input v-model="formPassword.newPassword"></el-input>
								</el-form-item>

								<el-form-item label="确认密码">
									<el-input v-model="formPassword.newPassword_confirmation "></el-input>
								</el-form-item>

								<el-form-item>
									<el-button type="primary" @click="modifyPassword" :loading="passwordLoading">保存</el-button>
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

				infoLoading: false,
				passwordLoading: false,
				avatarLoading: false,

				formUser: {
					id: '',
					avatar: '',
					username: '',
					nickname: '',
					signed: '',
					phone: '',
					email: ''
				},

				formPassword: {
					'oldPassword': '',
					'newPassword': '',
					'newPassword_confirmation ' : '',
				},

				passwordRule: {
					oldPassword: [{ required: true, message: '请输入旧密码', trigger: 'blur' }],
					newPassword: [{ required: true, message: '请输入新密码', trigger: 'blur' }],
					newPassword_confirmation: [{ required: true, message: '请输入确认密码', trigger: 'blur' }]
				},

				userInfo: null,
			}
		},

		created () {
			this.userInfo = this.$TOOL.data.get('user')
			this.formUser = this.userInfo.user
		},

		methods: {
			
			// 更新用户资料
			updateInfo() {
				this.$refs.formUser.validate( async (valid) => {
					if (valid) {
						this.formUser.avatar = undefined
						this.infoLoading = true
						let res = await this.$API.user.updateInfo(this.formUser)
						this.infoLoading = false
						if ( res.success ) {
							this.$TOOL.data.set('user', this.userInfo)
							this.$message.success(res.message)
            }else{
              this.$alert(res.message, "提示", { type: 'error' })
            }
					}
				})
			},

			// 修改密码
			modifyPassword() {
				this.$refs.formPassword.validate( async (valid) => {
					if (valid) {
						this.passwordLoading = true
						let res = await this.$API.user.modifyPassword(this.formPassword)
						this.passwordLoading = false
						if (res.success) {
							this.$message.success(res.message)
            }else{
              this.$alert(res.message, "提示", { type: 'error' })
            }
					}
				})
			}

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
