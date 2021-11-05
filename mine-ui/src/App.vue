<template>
	<el-config-provider :locale="$i18n.messages[$i18n.locale].el">
		<router-view></router-view>
	</el-config-provider>
</template>

<script>
	import colorTool from '@/utils/color'

	export default {
		name: 'App',
		data () {
			return {
				layout: this.$store.state.global.layout,
				layoutTags: this.$TOOL.data.get('APP_TAGS'),
				lang: this.$TOOL.data.get('APP_LANG') || this.$CONFIG.LANG,
				theme: this.$TOOL.data.get('APP_THEME') || 'default',
				colorPrimary: this.$TOOL.data.get('APP_COLOR') || this.$CONFIG.COLOR || '#409EFF'
			}
		},
		created() {
			//设置主题颜色
			const app_color = this.$TOOL.data.get('APP_COLOR') || this.$CONFIG.COLOR
			if(app_color){
				document.documentElement.style.setProperty('--el-color-primary', app_color);
				for (let i = 1; i <= 9; i++) {
					document.documentElement.style.setProperty(`--el-color-primary-light-${i}`, colorTool.lighten(app_color,i/10));
				}
				document.documentElement.style.setProperty(`--el-color-primary-darken-1`, colorTool.darken(app_color,0.1));
			}
			// 设置语言
			const app_lang = this.$TOOL.data.get("APP_LANG") || this.$CONFIG.LANG
			this.$i18n.locale = app_lang
			// 设置布局
			const app_layout = this.$TOOL.data.get("APP_LAYOUT") || this.$CONFIG.LAYOUT
			this.$store.commit("SET_layout", app_layout)
			// 是否黑夜模式
			const app_mode = this.$TOOL.data.get("APP_THEME") || 'default'
			document.body.setAttribute('data-theme', app_mode)
			// 获取配置信息
			this.$API.config.getSysConfig().then(res => {
				res.data.map(item => {
					this.$TOOL.data.set(item.key, item.value)
				})
			})
		}
	}
</script>

<style lang="scss">
	@import '@/style/style.scss';
	@import '@/style/theme/dark.scss';
</style>
