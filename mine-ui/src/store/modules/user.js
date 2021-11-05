import login from '@/api/apis/login';
import tool from '@/utils/tool'
import sysRouter from '@/router/systemRouter';

export default {
    state: {
		routers: undefined
	},
    mutations: {
		SET_ROUTERS(state, routers){
            state.routers = routers
		},
    },
	actions: {
		getUserInfo({ commit }) {
			return new Promise((resolve, reject) => {
                login.getInfo().then(response => {
                if (response.data.roles && response.data.routers.length > 0) {
                    response.data.routers = filterAsyncRouter(response.data.routers)
					response.data.routers.unshift(sysRouter.dashboard)
                    let user = {
                        codes: response.data.codes,
                        roles: response.data.roles,
                        user : response.data.user
                    }
                    commit('SET_ROUTERS', response.data.routers)
                    tool.data.set('user', user)
                    resolve(response.data)
                }
                }).catch(error => {
                    reject(error)
                })
            })
		}
	}
}

//转换
function filterAsyncRouter(routerMap) {
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
