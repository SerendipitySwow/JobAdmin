<template>
  <ma-container>
    <el-dialog
      :title="title"
      :visible.sync="resDialog"
      width="800px"
      :before-close="handleResClose">

      <span slot="footer" class="dialog-footer">
        
        <el-button
          @click="handleResClose"
          size="small"
        >
          关 闭
        </el-button>

        <el-button
          type="primary"
          @click="selectSubmit"
          :loading="loading"
          size="small"
        >
          确 定
        </el-button>

      </span>
    </el-dialog>
  </ma-container>
</template>
<script>
export default {
  props: {
    type: {
      default: 'image',
      type: String
    }
  },
  data () {
    return {
      loading: false,
      resDialog: false,
      title: '',
    }
  },
  methods: {
    show () {
      this.resDialog = true
      this.title = this.type === 'image' ? '选择图片' : '选择文件'
    },
    handleResClose () {
      this.resDialog = false
    }
  }
}
</script>