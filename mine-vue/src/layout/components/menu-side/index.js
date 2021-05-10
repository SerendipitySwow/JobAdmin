import { mapState } from 'vuex'
import menuMixin from '../mixin/menu'
import { createMenu } from '../libs/util.menu'

export default {
  name: 'ma-layout-header-aside-menu-side',
  mixins: [
    menuMixin
  ],
  render (h) {
    return <div class="ma-layout-header-aside-menu-side">
      <ma-scrollbar>
        <el-menu
          collapse={ this.asideCollapse }
          collapseTransition={ this.asideTransition }
          uniqueOpened={ true }
          defaultActive={ this.$route.fullPath }
          ref="menu"
          onSelect={ this.handleMenuSelect }>
          { this.aside.map(menu => createMenu.call(this, h, menu)) }
        </el-menu>
        {
          this.aside.length === 0 && !this.asideCollapse
            ? <div class="ma-layout-header-aside-menu-empty" flex="dir:top main:center cross:center">
              <ma-icon name="inbox"/>
              <span>还未设置菜单</span>
            </div>
            : null
        }
      </ma-scrollbar>
    </div>
  },
  computed: {
    ...mapState('store/menu', [
      'aside',
      'asideCollapse',
      'asideTransition'
    ])
  }
}
