import {createRouter, createWebHashHistory} from 'vue-router';
import config from "@/config"
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import tool from '@/utils/tool';
import store from '@/store/index'
import sysRouter from './systemRouter';
import {beforeEach, afterEach} from './scrollBehavior';

//系统路由
const routes = sysRouter.systemRouter

const whiteList = ['login', 'test']
const defaultRoutePath = '/dashboard'

//系统特殊路由
const routes_404 = {
	path: "/:pathMatch(.*)*",
	hidden: true,
	component: () => import(/* webpackChunkName: "404" */ '@/layout/other/404'),
}

const router = createRouter({
	history: createWebHashHistory(),	// createWebHistory 暂时不可用，多层次路由地址有bug。
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

		//整页路由处理
		if(to.meta.fullpage){
			to.matched = [to.matched[to.matched.length-1]]
		}

		if (tool.data.get('lockScreen') && to.name !== 'lockScreen') {
			next({ name: 'lockScreen' })
		} else if (! tool.data.get('lockScreen') && to.name === 'lockScreen' ) {
			next({ path: defaultRoutePath })
		} else if (to.name === 'login'){
			next({ path: defaultRoutePath })
		} else if (! store.state.user.routers) {
			await store.dispatch('getUserInfo').then( res => {
				if (res.routers.length !== 0) {
					let routers = res.routers
					const apiRouter = filterAsyncRouter(routers)
					apiRouter.unshift(sysRouter.dashboard)
					res.routers = apiRouter
					tool.data.set('user', res)
					flatAsyncRoutes(apiRouter).forEach(item => {
						router.addRoute("layout", item)
					})
					router.addRoute(routes_404)
					if (to.matched.length == 0) {
						router.push(to.fullPath)
					}
				}
			}).catch(() => {
				next({ name: 'login', query: { redirect: to.fullPath } })
				store.commit('SET_ROUTERS', undefined)
				tool.data.clear()
			})
			beforeEach(to, from)
			next()
		} else {
			beforeEach(to, from)
			next()
		}
	} else {
		if (whiteList.includes(to.name)) {
			beforeEach(to, from)
			next()
		} else {
			next({ name: 'login', query: { redirect: to.fullPath } })
		}
	}
});

router.afterEach((to, from) => {
	afterEach(to, from)
	NProgress.done()
});

router.onError((error) => {
	NProgress.done();
	const pattern = /Loading chunk (\d)+ failed/g;
	const isChunkLoadFailed = error.message.match(pattern);
	const targetPath = router.history.pending.fullPath;
	if (isChunkLoadFailed) {
		router.replace(targetPath);
	}
});


//转换
function filterAsyncRouter(routerMap, activePath = null) {
	const accessedRouters = []
	routerMap.forEach(item => {
		if (item.meta.type == 'B') {
			return
		}
		item.meta = item.meta?item.meta:{};
		//处理外部链接特殊路由
		if(item.meta.type == 'I'){
			item.meta.url = item.path
			item.path = `/i/${item.name}`
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
		return () => import(/* webpackChunkName: "[request]" */ `@/views/${component}`)
	}else{
		return () => import(`@/layout/other/empty`)
	}

}

//路由扁平化
function flatAsyncRoutes(routes, breadcrumb=[]) {
	let res = []
	routes.forEach(route => {
		const tmp = {...route}
        if (tmp.children) {
            let childrenBreadcrumb = [...breadcrumb]
            childrenBreadcrumb.push(route)
            let tmpRoute = { ...route }
            tmpRoute.meta.breadcrumb = childrenBreadcrumb
            delete tmpRoute.children
            res.push(tmpRoute)
            let childrenRoutes = flatAsyncRoutes(tmp.children, childrenBreadcrumb)
            childrenRoutes.map(item => {
                res.push(item)
            })
        } else {
            let tmpBreadcrumb = [...breadcrumb]
            tmpBreadcrumb.push(tmp)
            tmp.meta.breadcrumb = tmpBreadcrumb
            res.push(tmp)
        }
    })
    return res
}

export default router
