<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="800px">
    <el-form ref="form" :model="form" :rules="rules" label-width="90px">
      <el-row>
        <el-col :span="12">
          <el-form-item label="用户名称" prop="username">
            <el-input v-model="form.username" size="small" placeholder="请输入用户名称"></el-input>
          </el-form-item>
          <el-form-item label="用户密码" prop="password" v-if="saveType === 'create'">
            <el-input v-model="form.password" size="small" placeholder="请输入用户密码" show-password></el-input>
          </el-form-item>
          <el-form-item label="角色" prop="role_ids">
            <el-select v-model="form.role_ids" size="small" style="width:100%" multiple placeholder="请选择用户角色">
              <el-option v-for="item in roleData" :key="item.id" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="岗位" prop="post_ids">
            <el-select v-model="form.post_ids" size="small" style="width:100%" multiple placeholder="请选择用户岗位">
              <el-option v-for="item in postData" :key="item.id" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="所属部门" prop="dept_id">
            <el-cascader v-model="form.dept_id" size="small" clearable style="width:100%" :options="deptTree" :props="{ checkStrictly: true }"></el-cascader>
          </el-form-item>
          <el-form-item label="邮箱" prop="email">
            <el-input v-model="form.email" size="small" placeholder="请输入邮箱"></el-input>
          </el-form-item>
          <el-form-item label="状态" prop="status">
            <el-radio-group v-model="form.status">
              <el-radio label="0">启用</el-radio>
              <el-radio label="1">停用</el-radio>
            </el-radio-group>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item label="备注" prop="remark">
        <el-input type="textarea" size="small" :rows="3" placeholder="用户备注信息" v-model="form.remark">
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
import { getSelectTree } from '@/api/system/dept'
import { getRoleList } from '@/api/system/role'
import { getPostList } from '@/api/system/post'
import { save, update } from '@/api/system/user'
export default {
  data () {
    return {
      // 显示标题
      title: '新增用户',
      // 显示form窗口
      showForm: false,
      // 用户选择器数据
      deptTree: [],
      // 岗位列表
      postData: [],
      // 角色列表
      roleData: [],
      // 要修改的记录
      record: null,
      // 弹窗类型
      saveType: 'create',
      // 表单数据
      form: {
        id: null,
        username: '',
        password: '123456',
        dept_id: null,
        role_ids: '',
        post_ids: '',
        email: '',
        status: '0',
        remark: ''
      },
      // 表单验证规则
      rules: {
        username: [{ required: true, message: '请输入用户名称', trigger: 'blur' }],
        password: [{ required: true, message: '请输入用户密码', trigger: 'blur' }],
        role_ids: [{ required: true, message: '请选择角色', trigger: 'blur' }]
      }
    }
  },
  // 创建生命周期
  mounted () {
    this.initData()
  },
  methods: {
    // 新增用户
    create () {
      this.showForm = true
      this.saveType = 'create'
      this.title = '新增用户'

      this.$nextTick(() => {
        this.$refs.form.resetFields()
        this.form.id = null
        this.form.password = '123456'
      })
    },
    // 更新用户
    update (record) {
      this.saveType = 'update'
      this.title = '编辑用户'
      this.showForm = true
      this.$nextTick(() => {
        this.$refs.form.resetFields()
        // 填充form数据
        this.setFormData(record)
      })
    },
    initData () {
      getSelectTree().then(res => {
        this.deptTree = res.data
      })
      getRoleList().then(res => {
        this.roleData = res.data
        console.log(this.roleData)
      })
      getPostList().then(res => {
        this.postData = res.data
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
