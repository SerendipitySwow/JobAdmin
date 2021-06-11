<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="40%">
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="角色名称" prop="name">
        <el-input v-model="form.name" size="small" placeholder="请输入角色名称"></el-input>
      </el-form-item>
      <el-form-item label="代码" prop="code">
        <el-input v-model="form.code" size="small" :disabled="form.code === 'superAdmin'" placeholder="请输入角色代码"></el-input>
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" size="small" :min="0" :max="999" label="排序"></el-input-number>
      </el-form-item>
      <el-form-item label="状态" prop="status" v-if="form.type !== 'B'">
        <el-radio-group v-model="form.status">
          <el-radio label="0">启用</el-radio>
          <el-radio label="1">停用</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="备注" prop="remark">
        <el-input type="textarea" size="small" :rows="3" placeholder="备注信息" v-model="form.remark">
        </el-input>
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm" size="small">确 定</el-button>
      <el-button @click="cancel" size="small">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { save, update } from '@/api/system/role'
export default {
  data () {
    return {
      // 显示标题
      title: '新增角色',
      // 显示form窗口
      showForm: false,
      // 要修改的记录
      record: null,
      // 弹窗类型
      saveType: 'create',
      // 表单数据
      form: {
        id: null,
        name: null,
        code: null,
        status: '0',
        sort: 0,
        remark: null
      },
      // 表单验证规则
      rules: {
        name: [{ required: true, message: '请输入角色名称', trigger: 'blur' }],
        code: [{ required: true, message: '请输入角色代码', trigger: 'blur' }]
      }
    }
  },
  methods: {
    // 新增角色
    create () {
      this.showForm = true
      this.saveType = 'create'
      this.title = '新增角色'
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        this.form.id = null
      })
    },
    // 更新角色
    update (record) {
      this.saveType = 'update'
      this.record = record
      this.title = '编辑角色'
      this.showForm = true
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        // 填充form数据
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
          if (this.saveType === 'create') {
            // 新增数据
            save(this.form).then(res => {
              this.success(res.message)
              this.resetForm()
            })
          } else {
            update(this.form.id, this.form).then(res => {
              this.success(res.message)
              this.resetForm()
            })
          }
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
