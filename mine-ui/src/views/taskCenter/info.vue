<template>
  <el-dialog v-model="dialogDescShow" title="查看协程信息">
    <el-form ref="formRef" :model="form" label-width="120px">
      <el-form-item label="协程状态:">
        <el-input v-model="form.state" placeholder="Please input"></el-input>
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
        <el-input v-model="form.executed_file_name" :prefix-icon="'el-icon-folder-opened'"></el-input>
      </el-form-item>
      <el-form-item label="协程执行的函数:">
        <el-input v-model="form.executed_function_name" :prefix-icon="'el-icon-edit'"></el-input>
      </el-form-item>
      <el-form-item label="执行的文件行数:">
        <el-input-number v-model="form.executed_function_line"  placeholder="Please input"></el-input-number>
      </el-form-item>
      <el-form-item label="定义的变量:">
        <el-input v-model="form.vars" ></el-input>
      </el-form-item>
      <el-form-item label="协程切换次数:">
        <el-input-number v-model="form.round" ></el-input-number>
      </el-form-item>
      <el-form-item label="协程运行时间:">
        <el-input-number v-model="form.elapsed"></el-input-number>
      </el-form-item>
    </el-form>
    <template #footer>
      <span>
        <el-button type="primary" @click="dialogDescShow = false">关闭</el-button>
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
        state: 'waiting',
        trace_list: [{
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/swow\/swow\/lib\/swow-library\/src\/Http\/Server.php",
          "line": 39,
          "function": "accept",
          "class": "Swow\\Socket",
          "object": {},
          "type": "->",
          "args": [{}, -1]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/src\/Console\/JobCommand.php",
          "line": 155,
          "function": "acceptConnection",
          "class": "Swow\\Http\\Server",
          "object": {},
          "type": "->",
          "args": []
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/src\/Console\/JobCommand.php",
          "line": 138,
          "function": "makeServer",
          "class": "SwowCloud\\Job\\Console\\JobCommand",
          "object": {},
          "type": "->",
          "args": ["127.0.0.1", 9762, "job_service_name"]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/hyperf\/utils\/src\/Functions.php",
          "line": 279,
          "function": "handle",
          "class": "SwowCloud\\Job\\Console\\JobCommand",
          "object": {},
          "type": "->",
          "args": []
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/src\/Console\/Command.php",
          "line": 171,
          "function": "call",
          "args": [[{}, "handle"]]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/src\/Console\/Command.php",
          "line": 174,
          "function": "SwowCloud\\Job\\Console\\{closure}",
          "class": "SwowCloud\\Job\\Console\\Command",
          "object": {},
          "type": "->",
          "args": []
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/symfony\/console\/Command\/Command.php",
          "line": 298,
          "function": "execute",
          "class": "SwowCloud\\Job\\Console\\Command",
          "object": {},
          "type": "->",
          "args": [{}, {}]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/src\/Console\/Command.php",
          "line": 64,
          "function": "run",
          "class": "Symfony\\Component\\Console\\Command\\Command",
          "object": {},
          "type": "->",
          "args": [{}, {}]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/symfony\/console\/Application.php",
          "line": 1005,
          "function": "run",
          "class": "SwowCloud\\Job\\Console\\Command",
          "object": {},
          "type": "->",
          "args": [{}, {}]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/symfony\/console\/Application.php",
          "line": 299,
          "function": "doRunCommand",
          "class": "Symfony\\Component\\Console\\Application",
          "object": {},
          "type": "->",
          "args": [{}, {}, {}]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/vendor\/symfony\/console\/Application.php",
          "line": 171,
          "function": "doRun",
          "class": "Symfony\\Component\\Console\\Application",
          "object": {},
          "type": "->",
          "args": [{}, {}]
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/bin\/job",
          "line": 28,
          "function": "run",
          "class": "Symfony\\Component\\Console\\Application",
          "object": {},
          "type": "->",
          "args": []
        }, {
          "file": "\/Users\/heping\/Serendipity-Job\/bin\/job",
          "line": 29,
          "function": "{closure}",
          "args": []
        }],
        executed_file_name: '/Users/heping/Serendipity-Job/vendor/swow/swow/lib/swow-library/src/Http/Server.php',
        executed_function_name: 'Swow\\Socket::accept',
        executed_function_line: 39,
        vars: {
          "connection": null,
          "timeout": -1
        },
        round: 3539,
        elapsed: 463025,
      },
      dialogDescShow: false
    }
  },
  methods: {
    show(info){
      console.log(info)
      this.dialogDescShow = true;
    }
  }
}
</script>
