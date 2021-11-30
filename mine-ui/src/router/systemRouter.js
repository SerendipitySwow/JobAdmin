import config from "@/config"

//系统路由
const routes = {
	systemRouter: [{
			name: "layout",
			path: "/",
			component: () => import(/* webpackChunkName: "layout" */ '@/layout'),
			redirect: config.DASHBOARD_URL,
			children: []
		},
		{
			path: "/login",
			name: 'login',
			component: () => import(/* webpackChunkName: "login" */ '@/views/userCenter/login'),
			meta: {
				title: "登录"
			}
		},
		{
			path: "/lockScreen",
			name: 'lockScreen',
			component: () => import(/* webpackChunkName: "lockScreen" */ '@/views/userCenter/lockScreen'),
			meta: {
				title: "锁屏"
			}
		},
		{
			path: '/doc',
			name: 'Doc',
			component: () => import(/* webpackChunkName: "Doc" */ '@/views/doc/index'),
			meta: {
				title: "接口文档"
			}
		}
	],
	dashboard: {
		name: "home",
		path: "/home",
		component: () => import(`@/layout/other/empty`),
		meta: {
			title: "首页",
			icon: "el-icon-home-filled"
		},
		children: [
			{
				name: "dashboard",
				path: "/dashboard",
				meta: {
					title: "控制台",
					icon: "el-icon-monitor",
					affix: true
				},
				component: () => import(/* webpackChunkName: "dashboard" */ '@/views/home'),
			},{
				name: "userCenter",
				path: "/usercenter",
				meta: {
					title: "个人信息",
					icon: "el-icon-user"
				},
				component: () => import(/* webpackChunkName: "usercenter" */ '@/views/userCenter'),
			},{
				name: "system",
				path: "/system",
				meta: {
					title: "系统配置",
					icon: "el-icon-setting",
				},
				component: () => import(/* webpackChunkName: "system" */ '@/views/setting/index'),
			},{
				name: "demo",
				path: "/demo",
				meta: {
					title: "组件演示",
					icon: "sc-icon-vue",
				},
				component: () => import(/* webpackChunkName: "demo" */ '@/views/demo/index'),
			}
		]
	}
}

export default routes;


