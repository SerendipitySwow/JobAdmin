<template>
  <el-dialog
    :title="title"
    :visible.sync="showForm"
    :before-close="handleClose"
    width="35%"
    >
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="菜单类型" prop="type">
        <el-radio-group v-model="form.type" size="small">
          <el-radio-button label="T" name="type">分类</el-radio-button>
          <el-radio-button label="C" name="type">目录</el-radio-button>
          <el-radio-button label="M" name="type">菜单</el-radio-button>
          <el-radio-button label="B" name="type">按钮</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="上级菜单" prop="parent_id">
        <el-cascader v-model="form.parent_id" size="small" clearable style="width:100%" :options="selectTree" :props="{ checkStrictly: true }" ></el-cascader>
      </el-form-item>
      <el-row>
        <el-col :span="12">
          <el-form-item label="菜单名称" prop="name">
            <el-input v-model="form.name" size="small" placeholder="请输入菜单名称"></el-input>
          </el-form-item>
          <el-form-item label="图标" prop="icon" v-if="form.type !== 'B'">
            <ma-icon-select v-model="form.icon" size="small" :user-input="true"/>
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
import { getSelectTree, save } from '@/api/system/menu'
export default {
  props: {
    menuTree: Array
  },
  data () {
    return {
      title: '新增菜单',
      showForm: false,
      selectTree: [],
      record: null,
      saveType: 'create',
      form: {
        type: 'T',
        parent_id: null,
        name: null,
        code: '',
        route: '',
        component: '',
        status: '0',
        sort: 0,
        is_out: '1',
        is_hidden: '1',
        is_quick: '1',
        is_cache: '0'
      },
      rules: {
        name: [{ required: true, message: '请输入菜单名称', trigger: 'blur' }],
        code: [{ required: true, message: '请输入菜单代码', trigger: 'blur' }],
        route: [{ required: true, message: '请输入路由', trigger: 'blur' }],
        component: [{ required: true, message: '请输入组件路径', trigger: 'blur' }]
      }
    }
  },
  created () {
    getSelectTree().then(res => {
      this.selectTree = res.data
    })
  },
  methods: {
    // 新增菜单
    create (record) {
      console.log(record)
      this.showForm = true
      this.saveType = 'create'
      this.title = '新增菜单'
    },
    // 更新菜单
    update (record) {
      this.saveType = 'update'
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
      this.showForm = false
      this.record = null
    },
    // 提交处理方法
    submitForm () {
      this.$refs.form.validate(valid => {
        if (valid) {
          if (this.saveType === 'create') {
            save(this.form).then(res => {
              this.resetForm()
            })
          } else {
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
    }
  }
}
</script>
<style scoped>
/deep/ .el-form-item__content .el-input-group {
  vertical-align:middle;
}
</style>
