import {createRouter, createWebHashHistory} from 'vue-router';
import { ElNotification } from 'element-plus';
import config from "@/config"
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import tool from '@/utils/tool';
import store from '@/store/index'
import systemRouter from './systemRouter';

//系统路由
const routes = systemRouter

const whiteList = ['login', 'test']
const defaultRoutePath = '/dashboard'

//系统特殊路由
const routes_404 = {
	path: "/:pathMatch(.*)*",
	hidden: true,
	component: () => import('@/views/other/404'),
}

const router = createRouter({
	history: createWebHashHistory(),
	routes: routes
})

//设置标题
document.title = config.APP_NAME

router.beforeEach(async (to, from, next) => {
	
	NProgress.start()

	//动态标题
	document.title = `${to.meta.title} - ${config.APP_NAME}`

	let token = tool.data.get('token');

	if (token && token !== 'undefined') {
		if(to.name === 'login'){
			next({ path: defaultRoutePath })
		} else if (! store.state.user.routers) {
			await store.dispatch('getUserInfo').then( res => {
				if (res.routers.length !== 0) {
					let routers = res.routers;
					const apiRouter = filterAsyncRouter(routers);
					tool.data.set('user', res)
					apiRouter.forEach(item => {
						router.addRoute("layout", item)
					})
					router.addRoute(routes_404)
					if (to.matched.length == 0) {
						router.push(to.fullPath);
					}
				}
			}).catch(() => {
				tool.data.set('user', null)
				store.commit('SET_ROUTERS', undefined)
				next({ name: 'login', query: { redirect: to.fullPath } })
			})
			next()
		} else {
			next()
		}
	} else {
		if (whiteList.includes(to.name)) {
			next()
		} else {
			next({ name: 'login', query: { redirect: to.fullPath } })
		}
	}
});

router.afterEach(() => {
	NProgress.done()
});

router.onError((error) => {
	NProgress.done();
	ElNotification.error({
		title: '路由错误',
		message: error.message
	});
});


//转换
function filterAsyncRouter(routerMap) {
	const accessedRouters = []
	routerMap.forEach(item => {
		if (item.meta.type == 'B') {
			return;
		}
		item.meta = item.meta?item.meta:{};
		//处理外部链接特殊路由
		if(item.meta.type=='iframe'){
			item.meta.url = item.path;
			item.path = `/i/${item.name}`;
		}
		//MAP转路由对象
		const route = {
			path: item.path,
			name: item.name,
			meta: item.meta,
			redirect: item.redirect,
			children: item.children ? filterAsyncRouter(item.children) : null,
			component: loadComponent(item.component)
		}
		accessedRouters.push(route)
	})
	return accessedRouters
}

function loadComponent(component){
	if(component){
		return () => import(`@/views/${component}`)
	}else{
		return () => import(`@/views/other/empty`)
	}

}


export default router
