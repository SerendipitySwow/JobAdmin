/**
 * @description 创建侧边栏菜单
 * @param {Function} h createElement
 * @param {Object} menu 菜单项
 */
export function elMenuItem (h, menu) {
  let icon = null
  if (menu.icon) icon = <i class={ `fa fa-${menu.icon}` }/>
  else if (menu.iconSvg) icon = <d2-icon-svg name={ menu.iconSvg }/>
  else icon = <i class="fa fa-file-o"/>
  return <el-menu-item
    key={ menu.path }
    index={ menu.path }>
    { icon }
    <span slot="title">{ menu.title || '未命名菜单' }</span>
  </el-menu-item>
}

/**
 * @description 在组件中调用此方法渲染菜单项目
 * @param {Function} h createElement
 * @param {Object} menu 菜单项
 */
export function createMenu (h, menu) {
  return elMenuItem.call(this, h, menu)
}
