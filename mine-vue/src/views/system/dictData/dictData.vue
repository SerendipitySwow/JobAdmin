<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="40%">
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="字典名称" prop="label">
        <el-input v-model="form.label" size="small" placeholder="请输入字典名称"></el-input>
      </el-form-item>
      <el-form-item label="字典值" prop="value">
        <el-input v-model="form.value" size="small" placeholder="请输入字典值"></el-input>
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
import { saveDictData, updateDictData } from '@/api/system/dictData'
export default {
  data () {
    return {
      // 显示标题
      title: '新增字典数据',
      // 显示form窗口
      showForm: false,
      // 要修改的记录
      record: null,
      // 弹窗数据
      saveType: 'create',
      // 表单数据
      form: {
        id: null,
        label: null,
        value: null,
        type_id: null,
        code: null,
        sort: 0,
        status: '0',
        remark: null
      },
      // 表单验证规则
      rules: {
        label: [{ required: true, message: '请输入字典名称', trigger: 'blur' }],
        value: [{ required: true, message: '请输入字典值', trigger: 'blur' }]
      }
    }
  },
  methods: {
    // 新增字典数据
    create (record) {
      this.showForm = true
      this.saveType = 'create'
      this.title = '新增字典类型'
      this.form.type_id = record.id
      this.form.code = record.code
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        this.form.id = null
      })
    },
    // 更新字典数据
    update (record) {
      this.saveType = 'update'
      this.record = record
      this.title = '编辑字典数据'
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
            saveDictData(this.form).then(res => {
              this.success(res.message)
              this.resetForm()
            })
          } else {
            updateDictData(this.form.id, this.form).then(res => {
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
