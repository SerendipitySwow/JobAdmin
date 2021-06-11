<template>
  <el-dialog :title="title" :visible.sync="showForm" :before-close="handleClose" width="40%">
    <el-form ref="form" :model="form" label-width="80px">
      <el-form-item label="角色名称">
        <el-input v-model="form.name" size="small" :disabled="true" placeholder="请输入角色名称"></el-input>
      </el-form-item>
      <el-form-item label="权限边界">
        <el-select v-model="form.data_scope" size="small" placeholder="请选择权限边界" @change="handleChangeScope">
          <el-option
            v-for="item in scopes"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option>
        </el-select>
      </el-form-item>
      <el-form-item v-if="form.data_scope === '1'" label="数据权限" prop="menu_ids">
        <el-checkbox @change="handleTreeExpand($event)">展开/折叠</el-checkbox>
        <el-checkbox @change="handleTreeAll($event)">全选/全不选</el-checkbox>
        <el-tree
          class="ma-tree-border"
          ref="tree"
          :data="dataList"
          show-checkbox
          node-key="id"
          empty-text="加载数据中..."
          :props="defaultProps">
        </el-tree>
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button type="primary" @click="submitForm" size="small">确 定</el-button>
      <el-button @click="cancel" size="small">取 消</el-button>
    </div>
  </el-dialog>
</template>
<script>
import { update, getDeptByRole } from '@/api/system/role'
import { getSelectTree } from '@/api/system/dept'
export default {
  data () {
    return {
      // 显示标题
      title: '数据权限',
      // 显示form窗口
      showForm: false,
      // 要修改的记录
      record: null,
      // 部门列表
      dataList: null,
      // 表单数据
      form: {
        id: null,
        name: null,
        data_scope: '0',
        dept_ids: null
      },
      // ele 树props
      defaultProps: {
        children: 'children',
        label: 'label'
      },
      // 0：全部数据权限 1：自定数据权限 2：本部门数据权限 3：本部门及以下数据权限 4：本人数据权限
      scopes: [
        { value: '0', label: '全部数据权限' },
        { value: '1', label: '自定义数据权限' },
        { value: '2', label: '本部门数据权限' },
        { value: '3', label: '本部门及以下数据权限' },
        { value: '4', label: '本人数据权限' }
      ]
    }
  },
  methods: {
    // 载入数据
    async load (record) {
      this.showForm = true
      await this.getTreeList()
      this.$nextTick(() => {
        this.getDeptByRoleId(record.id)
        this.$refs.form.resetFields()
        this.setFormData(record)
      })
    },
    // 获取菜单数据
    getTreeList () {
      getSelectTree().then(res => {
        this.dataList = res.data
      })
    },
    // 获取该角色拥有的部门ID
    getDeptByRoleId (id) {
      getDeptByRole(id).then(res => {
        if (res.data[0] && res.data[0].depts) {
          res.data[0].depts.forEach(item => {
            this.$refs.tree.setChecked(item.id, true, false)
          })
        }
      })
    },
    // 更改权限边界
    handleChangeScope (value) {
      if (value !== '1' && this.$refs.tree !== undefined) {
        this.$refs.tree.setCheckedKeys([])
      }
    },
    // 树（展开/折叠）
    handleTreeExpand (value) {
      this.dataList.forEach(item => {
        this.$refs.tree.store.nodesMap[item.id].expanded = value
      })
    },
    // 树（全选/全不选）
    handleTreeAll (value) {
      this.$refs.tree.setCheckedNodes(value ? this.dataList : [])
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
    // 获取所选节点
    getTreeSelectNodes () {
      // 目前被选中的菜单节点
      const selectKeys = this.$refs.tree.getCheckedKeys()
      // 半选中的菜单节点
      const halfSelectKeys = this.$refs.tree.getHalfCheckedKeys()
      selectKeys.unshift.apply(selectKeys, halfSelectKeys)
      return selectKeys
    },
    // 提交处理方法
    submitForm () {
      this.$refs.form.validate(valid => {
        if (valid) {
          if (this.form.data_scope === '1') {
            this.form.dept_ids = this.getTreeSelectNodes()
          }
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
