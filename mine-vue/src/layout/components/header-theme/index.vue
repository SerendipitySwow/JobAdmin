<template>
  <div>
    <el-tooltip
      effect="dark"
      content="主题"
      placement="bottom">
      <el-button
        class="ma-ml-0 ma-mr btn-text can-hover"
        type="text"
        @click="dialogVisible = true">
        <ma-icon
          name="diamond"
          style="font-size: 16px"/>
      </el-button>
    </el-tooltip>
    <el-dialog
      title="主题"
      width="600px"
      :visible.sync="dialogVisible"
      :append-to-body="true">
      <ma-theme-list style="margin-top: -25px;"/>
    </el-dialog>
  </div>
</template>

<script>
import themeList from './components/ma-theme-list'
export default {
  components: {
    'ma-theme-list': themeList
  },
  data () {
    return {
      dialogVisible: false
    }
  }
}
</script>
