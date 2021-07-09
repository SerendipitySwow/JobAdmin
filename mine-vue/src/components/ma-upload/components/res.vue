<template>
  <ma-container>
    <el-dialog
      :title="title"
      :visible.sync="resDialog"
      width="750px"
      :before-close="handleResClose">

      <el-row>
        <el-breadcrumb separator-class="el-icon-arrow-right" class="breadcrumb">

          <el-breadcrumb-item v-for="(item, index) in breadcrumb" :key="index">
            <a @click="loadPath(item.path)">{{ item.name }}</a>
          </el-breadcrumb-item>

        </el-breadcrumb>
      </el-row>

      <!-- 按钮组 及 搜索 -->
      <el-row>

        <el-col :span="10">
          <el-button-group>
            <el-button size="small" icon="el-icon-check">全选</el-button>
            <el-button size="small" icon="el-icon-close">反选</el-button>
            <el-button size="small" icon="el-icon-error">取消</el-button>
          </el-button-group>
        </el-col>

        <el-col :span="14">
          <el-input :placeholder="'输入' + (type == 'image' ? '图片' : '文件') + '名称筛选'" size="small" v-model="input3">
            <el-button slot="append" icon="el-icon-search"></el-button>
          </el-input>
        </el-col>

      </el-row>

      <el-row class="mt-20 file-list">

        <div class="file-list" v-if="dataList > 0">

        </div>

        <el-empty :description="'暂无' + (type == 'image' ? '图片' : '文件')" v-else>
          <el-button icon="el-icon-refresh" size="small" type="primary" plain>刷新</el-button>
        </el-empty>

      </el-row>

      <span slot="footer" class="dialog-footer">

        <el-button
          @click="handleResClose"
          size="small"
        >
          关 闭
        </el-button>

        <el-button
          type="primary"
          @click="selectSubmit"
          :loading="loading"
          size="small"
        >
          确 定
        </el-button>

      </span>
    </el-dialog>
  </ma-container>
</template>
<script>
export default {
  props: {
    type: {
      default: 'image',
      type: String
    }
  },
  data () {
    return {
      // loading
      loading: false,
      // 选择框显示
      resDialog: false,
      // 显示标题
      title: '',
      // 面包屑
      breadcrumb: [{ name: '根目录', path: '/' }, { name: '20210709', path: '/20210709' }],
      // 数据列表
      dataList: []
    }
  },
  methods: {
    show () {
      this.resDialog = true
      this.title = this.type === 'image' ? '选择图片' : '选择文件'
    },
    handleResClose () {
      this.resDialog = false
    }
  }
}
</script>

<style scoped>
/deep/ .el-dialog__body {
  padding: 10px 20px !important;
}
.breadcrumb {
  border: 1px solid #EBEEF5;
  padding: 10px;
  border-radius: 2px;
  margin-bottom: 10px;
}
.file-list {

}
</style>
