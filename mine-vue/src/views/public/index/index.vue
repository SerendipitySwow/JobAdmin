<template>
  <d2-container class="page">
    <div class="ma-public-container">
      <div class="ma-menu-card" v-for="item in menuData" :key="item.title" :name="item.title">
        <el-divider content-position="left">
          <i :class="`fa fa-${item.icon}`" class="ma-c-icon"/><span class="ma-c-title">{{item.title}}</span>
        </el-divider>
        <div v-if="!item.children">暂无操作菜单</div>
        <div v-else>
          <el-row :gutter="12">
            <el-col :span="4" class="ma-public-col" v-for="child in item.children" :key="child.title">
              <el-card shadow="hover" class="ma-public-card" @click.native="goto(child.path)">
                  <i :class="`fa fa-${child.icon}`" class="ma-c-icon"/>
                  <span class="ma-c-title">{{child.title}}</span>
              </el-card>
            </el-col>
          </el-row>
        </div>
      </div>
    </div>
  </d2-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  name: 'public-index',
  data () {
    return {
      menuData: []
    }
  },
  computed: {
    ...mapState('store/menu', [
      'aside'
    ])
  },
  watch: {
    aside: {
      handler (menu) {
        this.setData(menu)
      },
      immediate: true
    }
  },
  methods: {
    setData (menu) {
      if (menu.length < 1) {
        this.menuData = []
      } else {
        for (let i = 1; i < menu.length; i++) {
          this.menuData.push(menu[i])
        }
      }
    },
    goto (path) {
      this.$router.push({ path })
    }
  }
}
</script>
<style lang="scss" scoped>
.page {
  .ma-public-container {
    padding: 15px;
    background: #fff;
  }
  .ma-c-title, .ma-c-icon {
    font-size: 14px;
    color: $color-text-normal;
  }
  .ma-c-icon {
    padding-right: 5px;
  }
  .ma-public-col {
    margin-bottom: 10px;
    cursor: pointer;
    .ma-public-card {
      background: #fefefe;
    }
  }
}
</style>
