<template>
  <el-dialog
    :title="title"
    :visible.sync="showForm"
    :before-close="handleClose"
    >
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="菜单类型">
        <el-radio-group v-model="form.type" size="small">
          <el-radio-button label="T">分类</el-radio-button>
          <el-radio-button label="C">目录</el-radio-button>
          <el-radio-button label="M">菜单</el-radio-button>
          <el-radio-button label="B">按钮</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="上级菜单">
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm">确 定</el-button>
      <el-button @click="cancel">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
export default {
  props: {
    menuTree: Array
  },
  data () {
    return {
      title: '新增菜单',
      showForm: false,
      form: {
        type: 'T'
      },
      record: null,
      rules: {
      }
    }
  },
  methods: {
    // 新增菜单
    create (record) {
      this.showForm = true
      this.title = '新增菜单'
    },
    // 更新菜单
    update (record) {
      this.title = '编辑菜单：' + record.name
      this.showForm = true
    },
    // 关闭处理方法
    handleClose () {
      this.showForm = false
      this.record = null
    },
    // 取消处理方法
    cancel () {
      this.$emit('closeDialog', false)
      this.row = this.id = null
      this.showForm = false
    },
    // 提交处理方法
    submitForm () {
      this.$emit('closeDialog', true)
      this.row = this.id = null
      this.showForm = false
    }
  }
}
</script>
