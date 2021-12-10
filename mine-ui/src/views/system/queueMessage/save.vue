<template>
  <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
    <el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px">
      
        <el-form-item label="内容类型" prop="content_type">
            <el-input v-model="form.content_type" clearable placeholder="请输入内容类型" />
        </el-form-item>

        <el-form-item label="消息内容" prop="content">
            <el-input v-model="form.content" clearable placeholder="请输入消息内容" />
        </el-form-item>

        <el-form-item label="接收人" prop="receive_by">
            <el-input v-model="form.receive_by" clearable placeholder="请输入接收人" />
        </el-form-item>

        <el-form-item label="发送人" prop="send_by">
            <el-input v-model="form.send_by" clearable placeholder="请输入发送人" />
        </el-form-item>

        <el-form-item label="发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败" prop="send_status">
            <el-select v-model="form.send_status" style="width:100%" clearable placeholder="请选择发送状态 0:待发送 1:发送中 2:发送成功 3:发送失败">
                <el-option
                    v-for="(item, index) in message_send_status_data"
                    :key="index" :label="item.label"
                    :value="item.value"
                >{{item.label}}</el-option>
            </el-select>
        </el-form-item>

        <el-form-item label="查看状态 0:未读 1: 已读" prop="read_status">
            <el-select v-model="form.read_status" style="width:100%" clearable placeholder="请选择查看状态 0:未读 1: 已读">
                <el-option
                    v-for="(item, index) in message_read_status_data"
                    :key="index" :label="item.label"
                    :value="item.value"
                >{{item.label}}</el-option>
            </el-select>
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
          add: '新增消息',
          edit: '编辑消息'
        },
        form: {
          
           id: '',
           content_id: '',
           content_type: '',
           content: '',
           receive_by: '',
           send_by: '',
           send_status: '',
           read_status: '',
        },
        rules: {
          
        },
        visible: false,
        isSaveing: false,
        
        message_send_status_data: [],
        message_read_status_data: [],
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
              res = await this.$API.systemQueueMessage.save(this.form)
            } else {
              res = await this.$API.systemQueueMessage.update(this.form.id, this.form)
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
          this.form.content_id = data.content_id;
          this.form.content_type = data.content_type;
          this.form.content = data.content;
          this.form.receive_by = data.receive_by;
          this.form.send_by = data.send_by;
          this.form.send_status = data.send_status;
          this.form.read_status = data.read_status;
      },

      // 获取字典数据
      getDictData() {
        
          this.getDict('message_send_status').then(res => {
              this.message_send_status_data = res.data
          })
          this.getDict('message_read_status').then(res => {
              this.message_read_status_data = res.data
          })
      },

      

      

      
    }
  }
</script>
