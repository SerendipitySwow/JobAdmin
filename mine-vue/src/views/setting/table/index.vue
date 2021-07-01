<template>
  <ma-container>
    <el-form ref="form" :inline="true" :model="form">
      <el-card class="box-card ma-card" shadow="hover" style="margin-top:0">

        <div slot="header" class="clearfix">
          <span>基础数据</span>
        </div>

        <el-form-item label="表名称" size="small" class="ma-inline-form-item" prop="name">
          <el-input  v-model="form.name" placeholder="请输入表名称">
            <template slot="prepend">{{sysinfo.tablePrefix === '' ? '无前缀' : sysinfo.tablePrefix}}</template>
          </el-input>
        </el-form-item>

        <el-form-item label="所属模块" size="small" class="ma-inline-form-item" prop="module">
          <el-select v-model="form.module" placeholder="请选择模块">
            <el-option
              :label="item.name"
              :value="item.name"
              v-for="(item, index) in sysinfo.modulesList"
              :key="index"
              >
                <span style="float: left">{{ item.name }}</span>
                <span style="float: right; color: #8492a6; font-size: 13px">{{ item.description }}</span>
            </el-option>
          </el-select>
        </el-form-item>

        <el-button style="margin-left: 5px;" icon="el-icon-plus">创建模块</el-button>
        <el-button type="primary" style="margin-left: 20px;">提交</el-button>

      </el-card>

      <el-card class="box-card ma-card" shadow="hover">

        <div slot="header" class="clearfix">
          <span>字段</span>
        </div>

        <el-table :data="form.columns" empty-text="请添加字段...">

          <el-table-column prop="name" label="字段名称">
            <template slot-scope="scope">
              <el-input v-model="scope.row.name" size="small" placeholder="字段名称"></el-input>
            </template>
          </el-table-column>

          <el-table-column prop="type" label="字段类型">
            <template slot-scope="scope">
              <el-select v-model="scope.row.type" size="small" placeholder="字段类型">
                <!-- <el-option label="System 系统模块">System 系统模块</el-option> -->
              </el-select>
            </template>
          </el-table-column>

          <el-table-column prop="unsigned" label="Unsigned" width="100">
            <template slot-scope="scope">
              <el-checkbox v-model="scope.row.unsigned">无负号</el-checkbox>
            </template>
          </el-table-column>

          <el-table-column prop="isNull" label="NULL" width="100">
            <template slot-scope="scope">
              <el-checkbox v-model="scope.row.isNull">为空</el-checkbox>
            </template>
          </el-table-column>

          <el-table-column prop="len" label="长度">
            <template slot-scope="scope">
              <el-input-number size="small" v-model="scope.row.len" controls-position="right" :min="1" :max="9999"></el-input-number>
            </template>
          </el-table-column>

          <el-table-column prop="index" label="索引类型">
            <template slot-scope="scope">
              <el-select v-model="scope.row.index" size="small" placeholder="索引类型">
                <el-option v-for="name in indexs" :value="name" :key="name">{{name}}</el-option>
              </el-select>
            </template>
          </el-table-column>

          <el-table-column prop="default" label="默认值">
            <template slot-scope="scope">
              <el-input v-model="scope.row.default" size="small" placeholder="默认值"></el-input>
            </template>
          </el-table-column>

          <el-table-column prop="comment" label="注释">
            <template slot-scope="scope">
              <el-input v-model="scope.row.comment" size="small" placeholder="注释"></el-input>
            </template>
          </el-table-column>

          <el-table-column label="操作" align="center" width="100">
            <template slot-scope="scope">
              <el-button type="text" v-hasPermission="['system:dictType:realDelete']" @click="handleDeleteColumn(scope.row.id)">删除</el-button>
            </template>
          </el-table-column>

        </el-table>

        <el-row class="mt-20">

          <el-form-item label="ID主键" size="small" class="ma-inline-form-item" prop="pk">
            <el-input  v-model="form.pk" placeholder="请输入ID主键"></el-input>
          </el-form-item>

          <el-form-item label="表引擎" size="small" class="ma-inline-form-item" prop="engine">
            <el-select v-model="form.engine" placeholder="表引擎">
                <el-option :value="item.value" :label="item.label" v-for="(item, index) in engines" :key="index">{{item.label}}</el-option>
              </el-select>
          </el-form-item>

          <el-form-item label="表注释" size="small" class="ma-inline-form-item" prop="comment">
            <el-input  v-model="form.comment" placeholder="请输入表注释"></el-input>
          </el-form-item>

          <el-button size="small" icon="el-icon-plus" @click="handleAddColumn">增加字段</el-button>
        </el-row>

        <el-row class="mt-20">
          <el-checkbox v-model="form.autoTime">创建created_at & updated_at</el-checkbox>
          <el-checkbox v-model="form.autoTime">创建created_by & updated_by</el-checkbox>
          <el-checkbox v-model="form.autoTime">创建软删除</el-checkbox>
          <el-checkbox v-model="form.autoTime">创建Migrates迁移文件</el-checkbox>
        </el-row>

      </el-card>
    </el-form>
  </ma-container>
</template>
<script>
import { getSystemInfo } from '@/api/setting/table'
export default {
  name: 'system-table-index',
  data () {
    return {
      form: {
        name: '',
        module: '',
        columns: [],
        autoTime: true,
        pk: 'id',
        engine: '',
        comment: ''
      },
      sysinfo: {},
      engines: null,
      fields: { id: 0, name: '', type: '', unsigned: false, len: 0, isNull: false, index: '', default: '', comment: '' },
      indexs: [
        'UNIQUE', 'NORMAL', 'FULLTEXT'
      ]
    }
  },
  async created () {
    await getSystemInfo().then(res => {
      this.sysinfo = res.data
    })
    await this.getDicts('table_engine').then(res => {
      this.engines = res.data
    })
  },
  methods: {
    handleAddColumn () {
      const field = JSON.parse(JSON.stringify(this.fields))
      field.id = this.form.columns.length + 1
      this.form.columns.push(field)
    },
    handleDeleteColumn (id) {
      for (let i = 0; i < this.form.columns.length; i++) {
        if (this.form.columns[i].id === id) {
          this.form.columns.splice(i, 1)
          break
        }
      }
    }
  }
}
</script>
