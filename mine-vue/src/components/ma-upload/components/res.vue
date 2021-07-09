<template>
  <ma-container>
    <el-dialog
      :title="title"
      :visible.sync="resDialog"
      width="753px"
      :before-close="handleResClose">

      <!-- 按钮组 及 搜索 -->
      <el-row>

        <el-col :span="10">
          <el-button-group>

            <el-tooltip 
              class="item"
              effect="dark"
              :content="'选择当前页所有' + (type == 'image' ? '图片' : '文件')"
              placement="top"
            >
              <el-button size="small" icon="el-icon-check">全选</el-button>
            </el-tooltip>

            <el-tooltip 
              class="item"
              effect="dark"
              :content="'反选当前页所有' + (type == 'image' ? '图片' : '文件')"
              placement="top"
            >  
              <el-button size="small" icon="el-icon-close">反选</el-button>
            </el-tooltip>

            <el-tooltip 
              class="item"
              effect="dark"
              :content="'取消所有选中的' + (type == 'image' ? '图片' : '文件')"
              placement="top"
            >  
              <el-button size="small" icon="el-icon-error">取消</el-button>
            </el-tooltip>

          </el-button-group>
        </el-col>

        <el-col :span="14">

          <el-input 
            :placeholder="'输入' + (type == 'image' ? '图片' : '文件') + '名称筛选'"
            size="small"
            v-model="queryParams.name"
          >
            <el-button slot="append" icon="el-icon-search"></el-button>
          </el-input>

        </el-col>

      </el-row>

      <el-row>
        <el-breadcrumb separator-class="el-icon-arrow-right" class="breadcrumb">
<!-- @click="loadPath(item.path)" -->
          <el-breadcrumb-item v-for="(item, index) in breadcrumb" :key="index">
            <a @click="openFolder(item.path, 'out')" >{{ item.name }}</a>
          </el-breadcrumb-item>

        </el-breadcrumb>
      </el-row>

      <el-row class="mt-20 file-list" v-if="dataList.length > 0">

        <div class="file-list">

          <div class="list" v-for="(item, index) in dataList" :key="index">

            <div 
              class="icon"
              @click="openFolder(item.basename, 'in')"
              v-if="item.type === 'dir'"
            >
              <ma-icon name="folder"></ma-icon>
            </div>

            <div 
              class="file"
              @click="select(item.name)"
              v-if="item.type === 'file'"
            >
              <el-image
                class="image"
                v-if="item.url && item.url !== ''"
                :src="item.url"
                fit="contain"></el-image>
            </div>

            <el-tooltip placement="bottom">

              <div slot="content">
                <span v-if="item.type === 'dir'">文件夹 <br /></span>
                名称：{{ item.basename }} <br />
                日期：{{ dayjs(item.timestamp * 1000).format('YYYY-M-D HH:mm:ss') }}
              </div>

              <div class="name">{{item.basename}}</div>

            </el-tooltip>
          </div>

        </div>

      </el-row>
      
      <el-empty v-else :description="'暂无' + (type == 'image' ? '图片' : '文件')">
        <el-button icon="el-icon-refresh" size="small" type="primary" @click="getList()">刷新</el-button>
      </el-empty>

      <span slot="footer" class="dialog-footer">
        
        <el-pagination
          class="ma-fl"
          @size-change="getList"
          @current-change="getList"
          layout="total, sizes, prev, pager, next"
          :page-sizes="[30, 60]"
          :current-page.sync="queryParams.page"
          :page-size.sync="queryParams.pageSize"
          :total="pageInfo.total"
        ></el-pagination>

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
import { getAllFiles } from '@/api/system/upload'
import dayjs from 'dayjs'
export default {
  props: {
    type: {
      default: 'image',
      type: String
    }
  },
  data () {
    return {
      // 日期时间插件
      dayjs,
      // loading
      loading: false,
      // 选择框显示
      resDialog: false,
      // 显示标题
      title: '',
      // 面包屑
      breadcrumb: [{ name: '根目录', path: '/' }],
      // 数据列表
      dataList: [],
      // 分页数据
      pageInfo: {},
      // 搜索参数
      queryParams: {
        name: undefined,
        page: 1,
        pageSize: 30
      }
    }
  },
  methods: {

    show () {
      this.resDialog = true
      this.title = this.type === 'image' ? '选择图片' : '选择文件'
      this.getList()
    },

    getList () {
      getAllFiles(this.queryParams).then(res => {
        this.dataList = res.data.items
        this.pageInfo = res.data.pageInfo
      })
    },

    handleResClose () {
      this.resDialog = false
    },

    openFolder (folder, type) {
      this.queryParams.path = folder
      if (type === 'in') {
        const parent = this.breadcrumb[this.breadcrumb.length - 1];
        this.breadcrumb.push({ name: folder, path: parent.path + '/' + folder})
      }
      if (type == 'out') {
        if (folder == '/' && this.breadcrumb.length > 1) {
          this.breadcrumb.pop()
        }
      }
      this.getList()
    },

    selectSubmit () {

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
  margin-top: 10px;
}
.file-list {
  display: inline-flex;
  flex-wrap: wrap;
  flex-direction:row;
}
.file-list .list {
  width: 105px;
  height: 120px;
  border: 1px solid #EBEEF5;
  margin-right: 14px;
  margin-bottom: 14px;
  display: flex;
  flex-direction: column;
  border-radius: 2px;
  cursor: pointer;
}
.file-list .list:hover {
  background: #f5f5f5;
}
.file-list .list:nth-child(6) {
    margin-right: 0; 
}
.list .icon {
  height: 70px;
  margin-right: 1px;
  color: rgb(255, 214, 89);
  background: #f5f5f5;
  font-size: 56px;
  text-align: center;
  padding: 12px 0;
}
.list .file {
  height: 94px;
  overflow: hidden;
}
.list .file .image {
  width: 100%;
  height: 94px;
}
.list .name {
  text-align: center;
  line-height: 27px;
  height: 27px;
  width: 90%;
  font-size: 12px; 
  margin:0 auto;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
