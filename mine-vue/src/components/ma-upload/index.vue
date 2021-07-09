<template>
  <el-row>

    <el-row>
      <el-button icon="el-icon-finished" size="small" :disabled="disabled" @click="$refs.Res.show()">
        {{ selectButtonText }}
      </el-button>

      <el-button icon="el-icon-upload2" type="primary" size="small" @click="handleShowUploadDialog" :disabled="disabled">
        {{ uploadButtunText }}
      </el-button>
    </el-row>

    <el-dialog :title="uploadButtunText" :visible.sync="uploadDialog" width="420px" :before-close="handleUploadClose">

      <el-select v-model="uploadDir" filterable placeholder="请选择上传目录" style="width: 100%" size="small">
        <el-option v-for="item in dirs" :key="item.path" :label="item.basename" :value="item.path">
        </el-option>
      </el-select>

      <el-upload class="mt-20" ref="upload" drag :multiple="multiple" :accept="allowUploadFile" style="width: 100%" action="Fake Action" :disabled="disabled" :limit="limit" :auto-upload="false" :file-list="fileList" :on-exceed="handleExceed" :on-change="handleChange" :on-remove="handleRemove" :http-request="handleUpload">

        <i class="el-icon-upload"></i>

        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
        <div class="el-upload__tip" slot="tip">只能上传{{allowUploadFile}}文件，单文件不超过2M</div>

      </el-upload>

      <span slot="footer" class="dialog-footer">

        <el-button @click="uploadDialog = false" size="small">
          关 闭
        </el-button>

        <el-button type="primary" @click="uploadSubmit" :loading="loading" :disabled="disabled" size="small">
          上 传
        </el-button>

      </span>

    </el-dialog>

    <res ref="Res" :type="type" @select="getSelect"></res>
  </el-row>
</template>
<script>
import { getDirectory, uploadImage, uploadFile } from '@/api/system/upload'
import Res from './components/res'
export default {
  name: 'upload',
  components: {
    Res
  },
  props: {
    // 组件类型， image图片  file文件上传
    type: {
      default: 'image',
      type: String
    },
    // 上传个数限制
    limit: {
      default: 5,
      type: Number
    },
    // 是否支持多选
    multiple: {
      type: Boolean,
      required: false,
      default: true
    },
    // 是否禁用
    disabled: {
      type: Boolean,
      required: false,
      default: false
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
      // loading
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
      uploadMethod: null
    }
  },
  created () {
    if (this.type === 'image') {
      this.selectButtonText = '选择图片'
      this.uploadButtunText = '上传图片'
      this.allowUploadFile = '.jpg,.jpeg,.png,.bmp,.gif 或 svg'
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
        basename: '根目录按日期存放'
      })
    })
  },
  methods: {

    handleSelectRes () {

    },

    handleShowUploadDialog () {
      this.uploadDialog = true
      this.uploadDir = ''
      this.fileList = []
    },

    handleUploadClose () {
      this.uploadDialog = false
      this.fileList = []
    },

    handleUpload (data) { },

    getSelect () {

    },

    uploadSubmit () {
      this.loading = true

      if (this.type === 'image' || this.type === 'file') {
        this.fileList.forEach(async item => {
          const dataForm = new FormData()
          dataForm.append(this.type, item.raw)
          dataForm.append('path', this.uploadDir)
          await setTimeout(async () => {
            await this.uploadMethod(dataForm).then(res => {
              this.fileData.push(res.data)
            })
          }, 1000)
        })
        this.loading = false
        this.uploadDialog = false
        this.$emit('uploadData', this.fileData)
        this.success('上传成功')
      } else {
        this.error('上传类型指定错误，组件type只能是image或者file')
        this.loading = false
        return false
      }
    },

    handleChange (file, fileList) {
      this.fileList = fileList
    },

    handleRemove (file, fileList) {
      this.fileList = fileList
    },

    // 文件超出个数限制时的钩子
    handleExceed (files, fileList) {
      if (fileList.length >= this.limit) {
        this.error(`最多只能上传 ${this.limit} 个文件`)
        return
      }

      if (files.length + fileList.length > this.limit) {
        const count = this.limit - fileList.length
        this.error(`上传数量超出限制，最多还能选择 ${count} 个文件`)
      }
    }

  }
}
</script>
