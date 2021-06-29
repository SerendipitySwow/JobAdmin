<template>
  <ma-container>
    <el-form ref="form" :inline="true" :model="form">
      <el-card class="box-card ma-card" shadow="hover" style="margin-top:0">
        <div slot="header" class="clearfix">
          <span>基础数据</span>
        </div>
        <el-form-item label="表名称" size="small" class="ma-inline-form-item" prop="name">
          <el-input  v-model="form.name" placeholder="请输入表名称">
            <template slot="prepend">{{tablePrefix}}</template>
          </el-input>
        </el-form-item>
        <el-form-item label="所属模块" size="small" class="ma-inline-form-item" prop="module">
          <el-select v-model="module" placeholder="请选择模块">
            <!-- <el-option label="System 系统模块">System 系统模块</el-option> -->
          </el-select>
          <el-button style="margin-left: 5px;" icon="el-icon-plus">创建模块</el-button>
          <el-button type="primary" style="margin-left: 20px;">提交</el-button>
        </el-form-item>
      </el-card>
      <el-card class="box-card ma-card" shadow="hover">
        <div slot="header" class="clearfix">
          <span>字段</span>
        </div>
        <el-table :data="form.columns" tooltip-effect="dark">
            <el-table-column prop="name" label="字段名称" width="150">
              <template slot-scope="scope">
                <el-input v-model="scope.row.name" size="mini" placeholder="字段名称"></el-input>
              </template>
            </el-table-column>
            <el-table-column prop="type" label="字段类型" width="150">
              <template slot-scope="scope">
                <el-select v-model="scope.row.type" size="mini" placeholder="字段类型">
                  <!-- <el-option label="System 系统模块">System 系统模块</el-option> -->
                </el-select>
              </template>
            </el-table-column>
            <el-table-column prop="unsigned" label="Unsigned" width="130">
              <template slot-scope="scope">
                <el-checkbox v-model="scope.row.unsigned">无负号</el-checkbox>
              </template>
            </el-table-column>
            <el-table-column prop="isNull" label="NULL" width="120">
              <template slot-scope="scope">
                <el-checkbox v-model="scope.row.isNull">为空</el-checkbox>
              </template>
            </el-table-column>
            <el-table-column prop="len" label="长度" width="140">
              <template slot-scope="scope">
                <el-input-number size="mini" style="width:110px" v-model="scope.row.len" controls-position="right" :min="1" :max="9999"></el-input-number>
              </template>
            </el-table-column>
            <el-table-column prop="index" label="索引类型" width="140">
              <template slot-scope="scope">
                <el-select v-model="scope.row.index" size="mini" placeholder="索引类型">
                  <!-- <el-option label="System 系统模块">System 系统模块</el-option> -->
                </el-select>
              </template>
            </el-table-column>
            <el-table-column prop="default" label="默认值" width="140">
              <template slot-scope="scope">
                <el-input v-model="scope.row.default" size="mini" placeholder="默认值"></el-input>
              </template>
            </el-table-column>
            <el-table-column prop="comment" label="注释" width="160">
              <template slot-scope="scope">
                <el-input v-model="scope.row.comment" size="mini" placeholder="注释"></el-input>
              </template>
            </el-table-column>
            <el-table-column label="操作" align="center">
              <template slot-scope="scope">
                <el-button type="text" v-hasPermission="['system:dictType:realDelete']" @click="handleRealDelete(scope.row.id, 'type')">删除</el-button>
              </template>
            </el-table-column>
          </el-table>
          <el-row class="mt-20">
            <el-form-item label="ID主键" size="mini" class="ma-inline-form-item" prop="pk">
              <el-input  v-model="form.pk" placeholder="请输入ID主键"></el-input>
            </el-form-item>
            <el-form-item label="表引擎" size="mini" class="ma-inline-form-item" prop="engine">
              <el-select v-model="form.engine" placeholder="表引擎">
                  <!-- <el-option label="System 系统模块">System 系统模块</el-option> -->
                </el-select>
            </el-form-item>
            <el-form-item label="表注释" size="mini" class="ma-inline-form-item" prop="comment">
              <el-input  v-model="form.comment" placeholder="请输入表注释"></el-input>
            </el-form-item>
            <el-button size="mini" icon="el-icon-plus">增加字段</el-button>
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
export default {
  name: 'system-table-index',
  data () {
    return {
      tablePrefix: '无前缀',
      form: {
        name: '',
        module: '',
        columns: [{id: 0, name: '', type: '', unsigned: false, len: 0, isNull: false, index: '', default: '', comment: ''}],
        autoTime: true,
        pk: 'id',
        engine: '',
        comment: '',
      },
    }
  }
}
</script>