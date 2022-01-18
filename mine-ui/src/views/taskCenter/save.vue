<template>
  <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
    <el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px">

        <el-form-item label="任务状态" prop="status">
            <el-input v-model="form.status" clearable placeholder="请输入任务状态 0:待处理 1:处理中 2:已处理 3:已取消 4:处理失败" />
        </el-form-item>

        <el-form-item label="重试间隔(秒)" prop="step">
            <el-input v-model="form.step" clearable placeholder="请输入重试间隔(秒)" />
        </el-form-item>

        <el-form-item label="执行时间" prop="runtime">
            <el-input v-model="form.runtime" clearable placeholder="请输入执行时间" />
        </el-form-item>

        <el-form-item label="任务内容" prop="content">
            <el-input v-model="form.content" clearable placeholder="请输入任务内容" />
        </el-form-item>

        <el-form-item label="任务执行时间" prop="timeout">
            <el-input v-model="form.timeout" clearable placeholder="请输入任务执行时间" />
        </el-form-item>

        <el-form-item label="任务名称" prop="name">
            <el-input v-model="form.name" clearable placeholder="请输入任务名称" />
        </el-form-item>


        <el-form-item label="错误信息" prop="memo">
            <el-input v-model="form.memo" clearable placeholder="请输入当任务执行出现错误时,记录错误信息" />
        </el-form-item>


        <el-form-item label="重试次数" prop="retry_times">
            <el-input v-model="form.retry_times" clearable placeholder="请输入重试次数" />
        </el-form-item>

        <el-form-item label="consul运行服务的ID" prop="consul_service_id">
            <el-input v-model="form.consul_service_id" clearable placeholder="请输入consul运行服务的ID" />
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
          add: '新增任务列表',
          edit: '编辑任务列表'
        },
        treeList: [],
        form: {

           id: '',
           is_deleted: '',
           status: '',
           app_key: '',
           task_no: '',
           step: '',
           runtime: '',
           content: '',
           created_at: '',
           timeout: '',
           name: '',
           coroutine_id: '',
           memo: '',
           result: '',
           retry_times: '',
           consul_service_id: '',
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
              res = await this.$API.missionTask.save(this.form)
            } else {
              res = await this.$API.missionTask.update(this.form.id, this.form)
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
          this.form.is_deleted = data.is_deleted;
          this.form.status = data.status;
          this.form.app_key = data.app_key;
          this.form.task_no = data.task_no;
          this.form.step = data.step;
          this.form.runtime = data.runtime;
          this.form.content = data.content;
          this.form.created_at = data.created_at;
          this.form.timeout = data.timeout;
          this.form.name = data.name;
          this.form.coroutine_id = data.coroutine_id;
          this.form.memo = data.memo;
          this.form.result = data.result;
          this.form.retry_times = data.retry_times;
          this.form.consul_service_id = data.consul_service_id;
      },

      // 获取字典数据
      getDictData() {

      },






    }
  }
</script>
