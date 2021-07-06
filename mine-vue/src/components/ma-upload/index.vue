<template>
  <el-row>

    <div 
      class="uploader"
      v-if="showUploader && fileData.length == 0"
      @click="handleShowUploadDialog"
    >
      <i class="uploader-icon el-icon-plus"></i>
    </div>

    <div v-for="(item, index) in fileData" :key="index">
      <img
        class="el-upload-list__item-thumbnail"
        :src="item.url" alt=""
      >
      <span class="el-upload-list__item-actions">
        <span
          class="el-upload-list__item-preview"
          @click="handlePictureCardPreview(item)"
        >
          <i class="el-icon-zoom-in"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleDownload(item)"
        >
          <i class="el-icon-download"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleRemove(item)"
        >
          <i class="el-icon-delete"></i>
        </span>
      </span>
    </div>

    <el-button 
      icon="el-icon-finished"
      size="small"
    >
      {{ selectButtonText }}
    </el-button>

    <el-button 
      icon="el-icon-upload2"
      type="primary"
      size="small"
      @click="handleShowUploadDialog"
    >
      {{ uploadButtunText }}
    </el-button>

    <el-dialog
      :title="uploadButtunText"
      :visible.sync="uploadDialog"
      width="420px"
      :before-close="handleUploadClose">
      <el-select v-model="uploadDir" filterable placeholder="请选择上传目录" style="width: 100%" size="small">
        <el-option
          v-for="item in dirs"
          :key="item.path"
          :label="item.basename"
          :value="item.path">
        </el-option>
      </el-select>
      <el-upload
        class="mt-20"
        drag
        multiple
        ref="upload"
        :accept="allowUploadFile"
        style="width: 100%"
        action="Fake Action"
        :auto-upload="false"
        :file-list="fileList"
        :on-change="handleChange"
        :on-remove="handleRemove"
        :http-request="handleUpload"
      >
        <i class="el-icon-upload"></i>
        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
        <div class="el-upload__tip" slot="tip">只能上传{{allowUploadFile}}文件，单文件不超过2M</div>
      </el-upload>
      <span slot="footer" class="dialog-footer">
        <el-button @click="uploadDialog = false" size="small">关 闭</el-button>
        <el-button type="primary" @click="uploadSubmit" :loading="loading" size="small">上 传</el-button>
      </span>
    </el-dialog>
  </el-row>
</template>
<script>
import { getDirectory, uploadImage, uploadFile } from "@/api/system/upload"
export default {
  name: 'upload',
  props: {
    type: {
      default: 'image',
      type: String
    },
    showUploader: {
      default: true,
      type: Boolean
    }
  },
  data () {
    return {
      // 选择按钮文字
      selectButtonText: '',
      // 上传按钮文字
      uploadButtunText: '',
      // 上传modal框
      uploadDialog: false,
      loading: false,
      // 目录列表
      dirs: [],
      // 上传目录
      uploadDir: '',
      // 待上传文件列表
      fileList: [],
      // 上传后文件数据
      fileData: [],
      // 上传方法
      uploadMethod: null,
    }
  },
  created () {
    if (this.type === 'image') {
      this.selectButtonText = '选择图片'
      this.uploadButtunText = '上传图片'
      this.allowUploadFile = '.jpeg,.png,.bmp,.gif 或 svg'
      this.uploadMethod = uploadImage
    } else {
      this.selectButtonText = '选择文件'
      this.uploadButtunText = '上传文件'
      this.allowUploadFile = '.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.rar,.zip,.7z,.gz,.pdf,.wps,.md'
      this.uploadMethod = uploadFile
    }

    getDirectory().then(res => {
      this.dirs = res.data
      this.dirs.unshift({
        path: '',
        basename: '根目录',
      })
    })
    
  },
  methods: {

    handleShowUploadDialog () {
      this.uploadDialog = true
      this.uploadDir = ''
      this.fileList = []
      this.fileData = []
    },

    handleUploadClose () {
      this.uploadDialog = false
      this.fileList = []
    },

    handleUpload (data) {},

    uploadSubmit () {
      this.loading = true

      if (this.type === 'image' || this.type === 'file') {
        this.fileList.forEach(async item => {
          let dataForm = new FormData()
          dataForm.append(this.type, item.raw)
          dataForm.append('path', this.uploadDir)
          await this.uploadMethod(dataForm).then( res => {
            this.fileData.push(res.data)
          })
        })

        this.loading = false
        this.uploadDialog = false
        this.$emit('uploadData', this.fileData)
        this.success('上传成功')
      } else {
        this.error('上传类型指定错误，组件type只能是image或者file');
        this.loading = false
        return false
      }
    },

    handleChange (file, fileList) {
      this.fileList = fileList
    },

    handleRemove(file, fileList) {
      this.fileList = fileList
    }

  }
}
</script>

<style>
  .uploader {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 150px;
    height: 150px;
    background: #fbfdff;
    margin-bottom: 15px;
  }
  .uploader:hover {
    border-color: #409EFF;
  }
  .uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
  }
</style>
