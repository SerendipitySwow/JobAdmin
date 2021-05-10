import util from '@/libs/util.js'

export default {
  methods: {
    handleMenuSelect (index, indexPath) {
      if (/^ma-menu-empty-\d+$/.test(index) || index === undefined) {
        this.$message.warning('请添加子菜单')
      } else if (/^https:\/\/|http:\/\//.test(index)) {
        util.open(index)
      } else {
        this.$router.push({
          path: index
        })
      }
    }
  }
}
