const getters = {
  userinfo: state => state.store.user.info,
  menus: state => state.store.menu.header,
  codes: state => state.store.permission.topbarRouters,
  routers: state => state.store.permission.routers,
  roles: state => state.store.permission.roles,
  quick: state => state.store.permission.quick
}
export default getters
