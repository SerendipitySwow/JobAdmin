<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="50%">
    <el-form ref="form" :model="form" :rules="rules" label-width="110px">
      <el-form-item label="菜单类型" prop="type">
        <el-radio-group v-model="form.type" size="small">
          <el-radio-button label="T" name="type">分类</el-radio-button>
          <el-radio-button label="C" name="type">目录</el-radio-button>
          <el-radio-button label="M" name="type">菜单</el-radio-button>
          <el-radio-button label="B" name="type">按钮</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="上级菜单" prop="parent_id">
        <el-cascader v-model="form.parent_id" size="small" clearable style="width:100%" :options="selectTree" :props="{ checkStrictly: true }"></el-cascader>
      </el-form-item>
      <el-row>
        <el-col :span="12">
          <el-form-item label="菜单名称" prop="name">
            <el-input v-model="form.name" size="small" placeholder="请输入菜单名称"></el-input>
          </el-form-item>
          <el-form-item label="图标" prop="icon" v-if="form.type !== 'B'">
            <ma-icon-select v-model="form.icon" size="small" :user-input="true" />
          </el-form-item>
          <el-form-item label="排序" prop="sort">
            <el-input-number v-model="form.sort" size="small" :min="0" :max="999" label="排序"></el-input-number>
          </el-form-item>
          <el-form-item label="是否外链" prop="is_out" v-if="form.type !== 'B' && form.type !== 'T' && form.type !== 'C'">
            <el-radio-group v-model="form.is_out">
              <el-radio label="0">是</el-radio>
              <el-radio label="1">否</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="状态" prop="status" v-if="form.type !== 'B'">
            <el-radio-group v-model="form.status">
              <el-radio label="0">启用</el-radio>
              <el-radio label="1">停用</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="生成按钮菜单" prop="restful" v-if="form.type === 'M' && saveType === 'create'">
            <el-radio-group v-model="form.restful" style="margin-right: 10px;">
              <el-radio label="0">生成</el-radio>
              <el-radio label="1">不生成</el-radio>
            </el-radio-group>
            <el-tooltip class="item" effect="dark" content="生成RESTful路由按钮菜单，即：save、update、delete、read 以及回收站相关按钮菜单" placement="top">
              <ma-icon name="question-circle" />
            </el-tooltip>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="菜单代码" prop="code">
            <el-input v-model="form.code" size="small" placeholder="请输入菜单代码"></el-input>
          </el-form-item>
          <el-form-item label="路由" prop="route" v-if="form.type !== 'B'">
            <el-input v-model="form.route" size="small" placeholder="请输入路由"></el-input>
          </el-form-item>
          <el-form-item label="组件路径" prop="component" v-if="form.type !== 'B' && form.type !== 'T' && form.type !== 'C'">
            <el-input v-model="form.component" size="small" placeholder="请输入组件路径"></el-input>
          </el-form-item>
          <el-form-item label="隐藏" prop="is_hidden" v-if="form.type !== 'B'">
            <el-radio-group v-model="form.is_hidden">
              <el-radio label="0">是</el-radio>
              <el-radio label="1">否</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="快捷菜单" v-if="form.type === 'M'" prop="is_quick">
            <el-radio-group v-model="form.is_quick">
              <el-radio label="0">是</el-radio>
              <el-radio label="1">否</el-radio>
            </el-radio-group>
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm" size="small">确 定</el-button>
      <el-button @click="cancel" size="small">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { getSelectTree, save, update } from '@/api/system/menu'
export default {
  data () {
    return {
      // 显示标题
      title: '新增菜单',
      // 显示form窗口
      showForm: false,
      // 菜单选择器数据
      selectTree: [],
      // 要修改的记录
      record: null,
      // 弹窗类型
      saveType: 'create',
      // 表单数据
      form: {
        id: null,
        type: 'T',
        parent_id: null,
        name: null,
        code: '',
        route: '',
        icon: '',
        component: '',
        status: '0',
        sort: 0,
        is_out: '1',
        is_hidden: '1',
        is_quick: '1',
        is_cache: '0',
        restful: '0'
      },
      // 表单验证规则
      rules: {
        name: [{ required: true, message: '请输入菜单名称', trigger: 'blur' }],
        code: [{ required: true, message: '请输入菜单代码', trigger: 'blur' }],
        route: [{ required: true, message: '请输入路由', trigger: 'blur' }],
        component: [{ required: true, message: '请输入组件路径', trigger: 'blur' }]
      }
    }
  },
  // 创建生命周期
  created () {
    getSelectTree().then(res => {
      this.selectTree = res.data
    })
  },
  methods: {
    // 新增菜单
    create () {
      this.showForm = true
      this.saveType = 'create'
      this.title = '新增菜单'
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        this.form.id = null
      })
    },
    // 更新菜单
    update (record) {
      this.saveType = 'update'
      this.record = record
      this.title = '编辑菜单：' + record.name
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
            // 更新数据
            if (this.form.parent_id !== null && typeof this.form.parent_id !== 'number') {
              const id = this.form.parent_id.pop()
              if (id === this.record.id) {
                this.error('上级菜单不能选择本菜单')
                this.form.parent_id.push(id)
                return false
              } else {
                this.form.parent_id.push(id)
              }
            } else if (typeof this.form.parent_id === 'number') {
              const id = this.form.parent_id
              this.form.parent_id = []
              this.form.parent_id.push(id)
            }
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
<style scoped>
/deep/ .el-form-item__content .el-input-group {
  vertical-align: middle;
}
</style>
