<template>
  <el-dialog v-model="dialogDescShow">
    <el-form ref="formRef" :model="form" label-width="120px">
      <el-form-item label="协程状态:">
        <el-input v-model="form.state" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="协程函数调用栈:">
        <json-viewer
            :value="form.trace_list"
            :expand-depth=5
            copyable
            boxed
            sort></json-viewer>
      </el-form-item>
      <el-form-item label="协程执行的文件:">
        <el-input v-model="form.executed_file_name" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="协程执行的函数:">
        <el-input v-model="form.executed_function_name" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="执行的文件行数:">
        <el-input v-model="form.executed_function_line" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="定义的变量:">
        <el-input v-model="form.vars" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="协程切换次数:">
        <el-input v-model="form.round" type="textarea" disabled placeholder="Please input"></el-input>
      </el-form-item>
      <el-form-item label="协程运行时间:">
        <el-input v-model="form.elapsed" type="textarea" disabled placeholder="Please input"></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
      <span>
        <el-button type="primary"  @click="dialogDescShow = false" >关闭</el-button>
      </span>
    </template>

  </el-dialog>
</template>
<script>

import JsonViewer from 'vue-json-viewer'
import 'vue-json-viewer/style.css'

export default {
  components: {
    JsonViewer
  },
  emits: ["success"],
  data(){
    return {
      form: {
        state: '111111111',
        trace_list:  {
          total: 25,
          limit: 10,
          skip: 0,
          links: {
            previous: undefined,
            next: function(){
            },
          },
          data: [{
            id: '5968fcad629fa84ab65a5247',
            firstname: 'Ada',
            lastname: 'Lovelace',
            awards: null,
            known: ['mathematics', 'computing'],
            position: {
              lat: 44.563836,
              lng: 6.495139
            },
            description: `Augusta Ada King, Countess of Lovelace (née Byron; 10 December 1815 – 27 November 1852) was an English mathematician and writer,
            chiefly known for her work on Charles Babbage's proposed mechanical general-purpose computer,
            the Analytical Engine. She was the first to recognise that the machine had applications beyond pure calculation,
            and published the first algorithm intended to be carried out by such a machine.
            As a result, she is sometimes regarded as the first to recognise the full potential of a "computing machine" and the first computer programmer.`,
            bornAt: '1815-12-10T00:00:00.000Z',
            diedAt: '1852-11-27T00:00:00.000Z'
          }, {
            id: '5968fcad629fa84ab65a5246',
            firstname: 'Grace',
            lastname: 'Hopper',
            awards: ['Defense Distinguished Service Medal', 'Legion of Merit', 'Meritorious Service Medal', 'American Campaign Medal', 'World War II Victory Medal', 'National Defense Service Medal', 'Armed Forces Reserve Medal', 'Naval Reserve Medal', 'Presidential Medal of Freedom'],
            known: null,
            position: {
              lat: 43.614624,
              lng: 3.879995
            },
            description: `Grace Brewster Murray Hopper (née Murray; December 9, 1906 – January 1, 1992)
            was an American computer scientist and United States Navy rear admiral.
            One of the first programmers of the Harvard Mark I computer,
            she was a pioneer of computer programming who invented one of the first compiler related tools.
            She popularized the idea of machine-independent programming languages, which led to the development of COBOL,
            an early high-level programming language still in use today.`,
            bornAt: '1815-12-10T00:00:00.000Z',
            diedAt: '1852-11-27T00:00:00.000Z'
          }]
        },
        executed_file_name: '',
        executed_function_name: '',
        executed_function_line: false,
        vars: [],
        round: '',
        elapsed: '',
      },
      dialogDescShow: false
    }
  },
  methods: {
    show(){
      this.dialogDescShow = true;
    }
  }
}
</script>
