<template>
  <el-dialog
    title="预览代码"
    :visible.sync="dialogVisible"
    width="80%"
    :before-close="handleDialogClose"
  >
    <el-tabs v-model="activeName">

      <el-tab-pane
        v-for="(item, index) in previewCode"
        :key="index"
        :label="item.tab_name"
        :name="item.name"
      >

        <ma-highlight :code="item.code" :lang="item.lang" />

      </el-tab-pane>

    </el-tabs>
  </el-dialog>
</template>
<script>
import { preview } from '@/api/setting/generate'
export default {

  data () {
    return {
      // modal
      dialogVisible: false,
      // 激活tab
      activeName: 'controller',
      // 要预览的代码
      previewCode: []
    }
  },

  methods: {

    // 显示modal
    async show (id) {
      this.activeName = 'controller'
      await preview({ id }).then(res => {
        if (res.success) {
          this.previewCode = res.data
          this.dialogVisible = true
        }
      })
    },

    // 表字段modal关闭
    handleDialogClose () {
      this.dialogVisible = false
    },
  }
}
</script>