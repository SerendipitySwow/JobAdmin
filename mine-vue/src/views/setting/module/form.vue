<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="40%">
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="模块名称" prop="name">
        <el-input v-model="form.name" size="small" placeholder="请输入模块名称（英文名称）"></el-input>
      </el-form-item>
      <el-form-item label="模块标签" prop="label">
        <el-input v-model="form.label" size="small" placeholder="请输入模块标签（中文名称）"></el-input>
      </el-form-item>
      <el-form-item label="版本号" prop="version">
        <el-input v-model="form.version" size="small" placeholder="请输入版本号"></el-input>
      </el-form-item>
      <el-form-item label="描述" prop="description">
        <el-input v-model="form.description" type="textarea" :rows="3" size="small" placeholder="请输入模块功能描述"></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm" size="small">确 定</el-button>
      <el-button @click="cancel" size="small">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { save } from '@/api/setting/module'
export default {
  data () {
    return {
      // 显示标题
      title: '创建新模块',
      // 显示form窗口
      showForm: false,
      // 弹窗类型
      // 表单数据
      form: {
        name: null,
        label: null,
        version: null,
        description: null
      },
      // 表单验证规则
      rules: {
        name: [{ required: true, pattern: /^[A-Za-z]{2,}$/g, message: '名称必须是2位以上的英文', trigger: 'blur' }],
        label: [{ required: true, message: '模块标签必填', trigger: 'blur' }],
        version: [{ required: true, pattern: /^[0-9\.]{3,}$/g, message: '版本号必须包含数字和小数点', trigger: 'blur' }],
        description: [{ required: true, message: '模块功能描述必填', trigger: 'blur' }],
      }
    }
  },
  methods: {
    // 创建新模块
    create () {
      this.showForm = true
      this.$nextTick(() => {
        this.$refs.form.resetFields()
      })
    },
    // 关闭处理方法
    handleClose () {
      this.showForm = false
    },
    // 取消处理方法
    cancel () {
      this.showForm = false
    },
    // 提交处理方法
    submitForm () {
      this.$refs.form.validate(valid => {
        if (valid) {
          // 提交数据
          save(this.form).then(res => {
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
    }
  }
}
</script>
