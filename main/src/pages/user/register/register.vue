<template>
  <div class="register-page">
    <div class="register-wrapper">
      <div class="title">用户注册中心</div>
      <el-form ref="registerForm" :model="registerForm" label-width="82px">
        <el-form-item label="用户名：">
          <el-input v-model="registerForm.username"></el-input>
        </el-form-item>
        <el-form-item label="密码：">
          <el-input type="password" v-model="registerForm.password"></el-input>
        </el-form-item>
        <el-form-item label="确认密码：">
          <el-input @keyup.enter.native="doRegister"
                    type="password" v-model="registerForm.password2"></el-input>
        </el-form-item>
        <el-form-item label="验证码：">
          <div id="registerCaptcha">
            <span v-if="!captchaReady">正在加载验证码......</span>
          </div>
        </el-form-item>
        <el-form-item class="clearfix">
          已有账号？
          <router-link to="/login">
            <el-button type="text" to="/login">登录</el-button>
          </router-link>
          <el-button @click="doRegister" type="primary" class="pull-right">注册</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import UserService from '../../../service/UserService';
import '../../../assets/script/geetest';
import api from '../../../api';

export default {
  name: 'register',
  mounted() {
    api.get('/geetest', { t: Date.now() })
      .then((res) => {
        const data = res.data;
        window.initGeetest({
          gt: data.gt,
          challenge: data.challenge,
          offline: !data.success, // 表示用户后台检测极验服务器是否宕机
          new_captcha: data.new_captcha, // 用于宕机时表示是新验证码的宕机
          product: 'popup', // 产品形式，包括：float，popup
          width: '100%',
        }, this.handler);
      });
  },
  data() {
    return {
      registerForm: {
        username: '',
        password: '',
        password2: '',
      },
      captchaReady: false,
      captchaObj: null,
    };
  },
  methods: {
    doRegister() {
      const result = this.captchaObj.getValidate();
      if (!result) {
        this.$message.error('请完成验证');
      } else {
        api.post('/geetest', result)
          .then((res) => {
            if (res.status === 0) {
              UserService.register(this.registerForm.username, this.registerForm.password)
                .then(() => {
                  this.$message.success('注册成功！');
                  this.$router.replace({
                    path: '/login',
                  });
                })
                .catch((data) => {
                  this.$error(data.message);
                  this.captchaObj.reset();
                });
            } else {
              this.$message.error('验证失败，请重试');
              this.captchaObj.reset();
            }
          });
      }
    },
    handler(captchaObj) {
      captchaObj.appendTo('#registerCaptcha');
      captchaObj.onReady(() => {
        this.captchaReady = true;
      });
      captchaObj.onSuccess(() => {
        this.doRegister();
      });
      this.captchaObj = captchaObj;
    },
  },
};
</script>

<style lang="scss" scoped>
.register-page {
  max-width: 480px;
  margin: 10px auto;
  .register-wrapper {
    padding: 20px 50px 10px 40px;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 20px;
    }
  }
}
</style>
