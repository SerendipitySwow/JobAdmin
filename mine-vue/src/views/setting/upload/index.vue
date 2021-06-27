<template>
  <ma-container>
    <el-form ref="form" :model="form" label-width="120px">
      <el-divider content-position="center"><span class="font-bold">七牛云存储</span></el-divider>
      <el-form-item label="空间名称" prop="form.qiniu_bucket">
        <el-input v-model="form.qiniu_bucket" size="small" clearable placeholder="请输入七牛云存储Bucket（空间名称）"></el-input>
        <div class="tips">七牛云存储Bucket名称，请设置为：公开空间</div>
      </el-form-item>
      <el-form-item label="访问密钥" prop="form.qiniu_accesskey">
        <el-input v-model="form.qiniu_accesskey" size="small" clearable placeholder="请输入七牛云存储AccessKey（访问密钥）"></el-input>
        <div class="tips">可以在 [ 七牛云 > 个人中心 ] 设置并获取到 AccessKey</div>
      </el-form-item>
      <el-form-item label="安全密钥" prop="form.qiniu_secretkey">
        <el-input v-model="form.qiniu_secretkey" size="small" clearable placeholder="请输入七牛云存储SecretKey（安全密钥）"></el-input>
        <div class="tips">可以在 [ 七牛云 > 个人中心 ] 设置并获取到 SecretKey</div>
      </el-form-item>
      <el-form-item label="访问域名" prop="form.qiniu_domain">
        <el-input v-model="form.qiniu_domain" size="small" clearable placeholder="请输入七牛云存储访问域名"></el-input>
        <div class="tips">七牛云存储访问域名，如：static.mineadmin.com</div>
      </el-form-item>


      <el-divider content-position="center"><span class="font-bold">阿里云OSS存储</span></el-divider>
      <el-form-item label="访问域名" prop="form.oss_endpoint">
        <el-select v-model="form.oss_endpoint" size="small" clearable="" style="width:100%" placeholder="请选择阿里云OSS的EndPoint（访问域名及数据中心）">
          <el-option
            v-for="(item, index) in oss_endpoint"
            :key="index" :label="item.label + ' - （' + item.value + '）'"
            :value="item.value"
          >{{item.label}} - （{{item.value}}）</el-option>
        </el-select>
        <div class="tips">阿里云OSS的Region表示OSS的数据中心所在的地域，Endpoint表示OSS对外服务的访问域名</div>
      </el-form-item>
      <el-form-item label="空间名称" prop="form.oss_bucket">
        <el-input v-model="form.oss_bucket" size="small" clearable placeholder="请输入阿里云OSS存储Bucket（空间名称）"></el-input>
        <div class="tips">阿里云OSS存储Bucket名称</div>
      </el-form-item>
      <el-form-item label="空间名称" prop="form.oss_domain">
        <el-input v-model="form.oss_domain" size="small" clearable placeholder="请输入阿里云OSS存储外部访问域名"></el-input>
        <div class="tips">阿里云OSS存储外部访问域名，如：static.mineadmin.com</div>
      </el-form-item>
      <el-form-item label="访问密钥" prop="form.oss_accessId">
        <el-input v-model="form.oss_accessId" size="small" clearable placeholder="请输入阿里云OSS存储AccessId（访问密钥）"></el-input>
        <div class="tips">可以在 [ 阿里云 > 个人中心 ] 设置并获取到 AccessId</div>
      </el-form-item>
      <el-form-item label="安全密钥" prop="form.oss_accessSecret">
        <el-input v-model="form.oss_accessSecret" size="small" clearable placeholder="请输入阿里云OSS存储AccessSecret（安全密钥）"></el-input>
        <div class="tips">可以在 [ 阿里云 > 个人中心 ] 设置并获取到 AccessSecret</div>
      </el-form-item>

      <el-divider content-position="center"><span class="font-bold">腾讯云COS</span></el-divider>
      <el-form-item label="访问域名" prop="form.cos_region">
        <el-input v-model="form.cos_region" size="small" clearable placeholder="请输入腾讯云COS存储区域"></el-input>
        <div class="tips">腾讯云COS存储空间所在区域，需要严格对应储存所在区域才能上传文件</div>
      </el-form-item>
      <el-form-item label="空间名称" prop="form.cos_bucket">
        <el-input v-model="form.cos_bucket" size="small" clearable placeholder="请输入腾讯云COS存储Bucket（空间名称）"></el-input>
        <div class="tips">腾讯云COS存储Bucket名称</div>
      </el-form-item>
      <el-form-item label="访问域名" prop="form.cos_domain">
        <el-input v-model="form.cos_domain" size="small" clearable placeholder="请输入腾讯云COS存储外部访问域名"></el-input>
        <div class="tips">腾讯云COS存储外部访问域名，如：static.mineadmin.com</div>
      </el-form-item>
      <el-form-item label="应用ID" prop="form.cos_appId">
        <el-input v-model="form.cos_appId" size="small" clearable placeholder="请输入腾讯云COS存储appId（应用ID）"></el-input>
        <div class="tips">可以在 [ 腾讯云 > 个人中心 ] 设置并获取到 appId</div>
      </el-form-item>
      <el-form-item label="访问密钥" prop="form.cos_secretId">
        <el-input v-model="form.cos_secretId" size="small" clearable placeholder="请输入腾讯云COS存储secretId（访问密钥）"></el-input>
        <div class="tips">可以在 [ 腾讯云 > 个人中心 ] 设置并获取到 secretId</div>
      </el-form-item>
      <el-form-item label="安全密钥" prop="form.cos_secretKey">
        <el-input v-model="form.cos_secretKey" size="small" clearable placeholder="请输入腾讯云COS存储secretKey（安全密钥）"></el-input>
        <div class="tips">可以在 [ 腾讯云 > 个人中心 ] 设置并获取到 secretKey</div>
      </el-form-item>
    </el-form>
  </ma-container>
</template>
<script>
export default {
  name: 'system-upload-index',
  data () {
    return {
      form: {
        qiniu_bucket: '',
        qiniu_accesskey: '',
        qiniu_secretkey: '',
        qiniu_domain: '',

        oss_bucket: '',
        oss_domain: '',
        oss_endpoint: '',
        oss_accessId: '',
        oss_accessSecret: '',

        cos_region: '',
        cos_bucket: '',
        cos_domain: '',
        cos_appId: '',
        cos_secretId: '',
        cos_secretKey: ''
      },
      oss_endpoint: [],
    }
  },
  created () {
    this.getDicts('oss_endpoint').then(res => {
      this.oss_endpoint = res.data
      console.log(this.oss_endpoint)
    })
  },
  methods: {

  }
}
</script>
