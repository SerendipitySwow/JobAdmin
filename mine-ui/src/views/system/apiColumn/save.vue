<template>
  <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
    <el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px">
      
        <el-form-item label="字段名称" prop="name">
            <el-input v-model="form.name" clearable placeholder="请输入字段名称" />
        </el-form-item>

        <el-form-item label="数据类型" prop="data_type">
            <el-input v-model="form.data_type" type="textarea" :rows="3" clearable placeholder="请输入数据类型" />
        </el-form-item>

        <el-form-item label="是否必填" prop="is_required">
            <el-radio-group v-model="form.is_required">
                <el-radio label="0">是</el-radio>
                <el-radio label="1">否</el-radio>
            </el-radio-group>
        </el-form-item>

        <el-form-item label="默认值" prop="default_value">
            <el-input v-model="form.default_value" clearable placeholder="请输入默认值" />
        </el-form-item>

        <el-form-item label="状态" prop="status">
            <el-select v-model="form.status" style="width:100%" clearable placeholder="请选择状态">
                <el-option
                    v-for="(item, index) in data_status_data"
                    :key="index" :label="item.label"
                    :value="item.value"
                >{{item.label}}</el-option>
            </el-select>
        </el-form-item>

        <el-form-item label="字段说明" prop="description">
            <el-input v-model="form.description" clearable placeholder="请输入字段说明" />
        </el-form-item>

        <el-form-item label="备注" prop="remark">
            <el-input v-model="form.remark" clearable placeholder="请输入备注" />
        </el-form-item>

    </el-form>
    <template #footer>
      <el-button @click="visible=false" >取 消</el-button>
      <el-button type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
    </template>
  </el-dialog>
</template>

<script>
  import editor from '@/components/scEditor'

  export default {
    emits: ['success', 'closed'],
    components: {
      editor
    },
    data() {
      return {
        mode: "add",
        titleMap: {
          add: '新增接口字段',
          edit: '编辑接口字段'
        },
        form: {
          
           id: '',
           api_id: '',
           name: '',
           data_type: '',
           is_required: '',
           default_value: '',
           status: '',
           description: '',
           remark: '',
        },
        rules: {
          
           api_id: [{required: true, message: '接口主键必填', trigger: 'blur' }],
           name: [{required: true, message: '字段名称必填', trigger: 'blur' }],
           type: [{required: true, message: '字段类型', trigger: 'blur' }],
           data_type: [{required: true, message: '数据类型必填', trigger: 'blur' }],
           is_required: [{required: true, message: '是否必填必填', trigger: 'blur' }],
        },
        visible: false,
        isSaveing: false,
        
        data_status_data: [],
      }
    },
    async created() {
        await this.getDictData();
    },
    methods: {
      //显示
      open(mode='add'){
        this.mode = mode;
        this.visible = true;
        return this;
      },
      //表单提交方法
      submit(){
        this.$refs.dialogForm.validate(async (valid) => {
          if (valid) {
            this.isSaveing = true;
            let res = null
            if (this.mode == 'add') {
              res = await this.$API.systemApiColumn.save(this.form)
            } else {
              res = await this.$API.systemApiColumn.update(this.form.id, this.form)
            }
            this.isSaveing = false;
            if(res.success){
              this.$emit('success', this.form, this.mode)
              this.visible = false;
              this.$message.success(res.message)
            }else{
              this.$alert(res.message, "提示", {type: 'error'})
            }
          }
        })
      },

      //表单注入数据
      setData(data){
        
          this.form.id = data.id;
          this.form.api_id = data.api_id;
          this.form.name = data.name;
          this.form.data_type = data.data_type;
          this.form.is_required = data.is_required;
          this.form.default_value = data.default_value;
          this.form.status = data.status;
          this.form.description = data.description;
          this.form.remark = data.remark;
      },

      // 获取字典数据
      getDictData() {
        
          this.getDict('data_status').then(res => {
              this.data_status_data = res.data
          })
      }
    }
  }
</script>
