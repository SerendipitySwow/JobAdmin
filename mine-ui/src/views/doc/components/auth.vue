<template>
  <el-container class="container">
    <el-row class="row">
      <el-col :span="24">
        <div class="title">
          <img src="img/logo.svg" width="56" /> Api Document
        </div>

        <el-form ref="form" :model="form" label-width="80px" :rules="rules" label-position="top" class="form">
          <el-form-item label="APP ID" prop="app_id">
            <el-input v-model="form.app_id"></el-input>
          </el-form-item>
          <el-form-item label="APP SECRET" prop="app_secret">
            <el-input v-model="form.app_secret"></el-input>
          </el-form-item>

          <el-button type="primary" size="large" style="width: 100%; margin-top: 5px;" @click="login" :loading="loading">{{ $t('apiDoc.loginBtn') }}</el-button>
        </el-form>
      </el-col>
    </el-row>
  </el-container>
</template>

<script>
export default {
  created () {
    this.checkAuth()
  },
  data () {
    return {
      loading: false,
      form: {
        app_id: '',
        app_secret: '',
      },
      rules: {
        app_id: [
          {required: true, message: this.$t('apiDoc.appIdError'), trigger: 'blur'}
        ],
        app_secret: [
          {required: true, message: this.$t('apiDoc.appSecretError'), trigger: 'blur'}
        ]
      },
    }
  },

  methods: {
    checkAuth() {
      if (this.$TOOL.data.get('apiAuth')) {
        window.location.reload()
      }
    },

    login() {
      this.$refs.form.validate( _ => {
        if (_) {
          this.$TOOL.data.set('appId', this.form.app_id)
          this.$TOOL.data.set('apiAuth', true)
          this.checkAuth()
        } else {
          return;
        }
      })
    }
  }
}
</script>

<style scoped lang="scss">
.row {
  width: 380px;
  background: linear-gradient(160deg, #fff, #effbff, #dcf6ff);
  margin:0 auto; height: 355px; border-radius: 8px;
  top: 50%; margin-top: -200px;
  padding: 10px;
  box-shadow: 0 0 5px #888;

  .title {
    text-align: center; font-size: 28px; color: #002c36; margin-top: 5px;
    img {
      top: 11px; position: relative; margin-right: 6px;
    }
  }

  .form {
    padding: 30px 20px;
  }
}
</style>