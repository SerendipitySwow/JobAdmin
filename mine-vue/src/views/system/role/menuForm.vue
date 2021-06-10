<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="40%">
    <el-form ref="form" :model="form" label-width="80px">
      <el-form-item label="角色名称">
        <el-input v-model="form.name" size="small" :disabled="true" placeholder="请输入角色名称"></el-input>
      </el-form-item>
      <el-form-item label="角色权限" prop="menu_ids">
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm" size="small">确 定</el-button>
      <el-button @click="cancel" size="small">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { update } from '@/api/system/role'
export default {
  data () {
    return {
      // 显示标题
      title: '菜单权限',
      // 显示form窗口
      showForm: false,
      // 角色选择器数据
      selectTree: [],
      // 要修改的记录
      record: null,
      // 表单数据
      form: {
        id: null,
        name: null,
        menu_ids: null
      }
    }
  },
  methods: {
    // 载入数据
    load (record) {
      this.showForm = true
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        this.setFormData(record)
      })
    },
    // 关闭处理方法
    handleClose () {
      this.showForm = false
      this.record = null
    },
    // 取消处理方法
    cancel () {
      this.showForm = false
      this.record = null
    },
    // 提交处理方法
    submitForm () {
      this.$refs.form.validate(valid => {
        if (valid) {
          update(this.form.id, this.form).then(res => {
            this.success(res.message)
            this.resetForm()
          })
        } else {
          return false
        }
      })
    },
    // 重置表单
    resetForm () {
      this.$emit('closeDialog', true)
      this.showForm = false
      this.$refs.form.resetFields()
    },
    // 填充form数据
    setFormData (record) {
      for (const item in this.form) {
        if (typeof record[item] !== 'undefined') {
          this.form[item] = record[item]
        }
      }
    }
  }
}
</script>
