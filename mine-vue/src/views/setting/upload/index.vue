<template>
  <ma-container>
    <el-tabs>
      <el-tab-pane label="上传配置">上传配置</el-tab-pane>
      <el-tab-pane label="本地存储">七牛云</el-tab-pane>
      <el-tab-pane label="七牛云对象存储">七牛云</el-tab-pane>
      <el-tab-pane label="阿里云OSS存储">阿里云OSS</el-tab-pane>
      <el-tab-pane label="腾讯COS存储">腾讯COS</el-tab-pane>
    </el-tabs>
  </ma-container>
</template>
<script>
export default {
  name: 'system-upload-index',
  data () {
    return {
    }
  }
}
</script>
