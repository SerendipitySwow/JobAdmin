<template>
  <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
    <el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px">
      
        <el-form-item label="UUID" prop="uuid">
            <el-input v-model="form.uuid" clearable placeholder="请输入UUID" />
        </el-form-item>

        <el-form-item label="交换机名称" prop="exchange_name">
            <el-input v-model="form.exchange_name" clearable placeholder="请输入交换机名称" />
        </el-form-item>

        <el-form-item label="路由名称" prop="routing_key_name">
            <el-input v-model="form.routing_key_name" clearable placeholder="请输入路由名称" />
        </el-form-item>

        <el-form-item label="队列名称" prop="queue_name">
            <el-input v-model="form.queue_name" clearable placeholder="请输入队列名称" />
        </el-form-item>

        <el-form-item label="队列内容" prop="queue_content">
            <el-input v-model="form.queue_content" clearable placeholder="请输入队列内容" />
        </el-form-item>

        <el-form-item label="队列内容" prop="log_content">
            <el-input v-model="form.log_content" clearable placeholder="请输入队列内容" />
        </el-form-item>

        <el-form-item label="生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复" prop="produce_status">
            <el-input v-model="form.produce_status" clearable placeholder="请输入生产状态 0:未生产 1:生产中 2:生产成功 3:生产失败 4:生产重复" />
        </el-form-item>

        <el-form-item label="消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复" prop="consume_status">
            <el-input v-model="form.consume_status" clearable placeholder="请输入消费状态 0:未消费 1:消费中 2:消费成功 3:消费失败 4:消费重复" />
        </el-form-item>

        <el-form-item label="延迟时间（秒）" prop="delay_time">
            <el-input v-model="form.delay_time" clearable placeholder="请输入延迟时间（秒）" />
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
          add: '新增队列监控',
          edit: '编辑队列监控'
        },
        form: {
          
           id: '',
           uuid: '',
           exchange_name: '',
           routing_key_name: '',
           queue_name: '',
           queue_content: '',
           log_content: '',
           produce_status: '',
           consume_status: '',
           delay_time: '',
        },
        rules: {
          
        },
        visible: false,
        isSaveing: false,
        
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
              res = await this.$API.systemQueue.save(this.form)
            } else {
              res = await this.$API.systemQueue.update(this.form.id, this.form)
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
          this.form.uuid = data.uuid;
          this.form.exchange_name = data.exchange_name;
          this.form.routing_key_name = data.routing_key_name;
          this.form.queue_name = data.queue_name;
          this.form.queue_content = data.queue_content;
          this.form.log_content = data.log_content;
          this.form.produce_status = data.produce_status;
          this.form.consume_status = data.consume_status;
          this.form.delay_time = data.delay_time;
      },

      // 获取字典数据
      getDictData() {
        
      },

      

      

      
    }
  }
</script>
