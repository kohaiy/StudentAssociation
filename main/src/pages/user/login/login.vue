<template>
  <div class="login-page">
    <div class="login-wrapper">
      <div class="title">用户登录中心</div>
      <el-form ref="loginForm" :model="loginForm" label-width="68px">
        <el-form-item label="用户名：">
          <el-input v-model="loginForm.username"></el-input>
        </el-form-item>
        <el-form-item label="密码：">
          <el-input type="password" v-model="loginForm.password"
                    @keyup.enter.native="doLogin"></el-input>
        </el-form-item>
        <el-form-item label="验证码：">
          <div id="loginCaptcha">
            <span v-if="!captchaReady">正在加载验证码......</span>
          </div>
        </el-form-item>
        <!--<el-form-item class="clearfix">-->
        <!--<el-checkbox v-model="loginForm.isRemember">记住密码</el-checkbox>-->
        <!--<el-button type="text" class="pull-right">忘记密码？</el-button>-->
        <!--</el-form-item>-->
        <el-form-item class="clearfix">
          还没有账号？
          <router-link to="/register">
            <el-button type="text">注册</el-button>
          </router-link>
          <el-button @click="doLogin" type="primary" class="pull-right">登录</el-button>
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
  name: 'login',
  mounted() {
    this.checkUserStatus();
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
      loginForm: {
        username: 'kohai',
        password: '123123',
        isRemember: true,
      },
      captchaReady: false,
      captchaObj: null,
    };
  },
  methods: {
    doLogin() {
      // 本地状态下，无网络补救方法
      if (!this.captchaObj && window.location.origin.indexOf('localhost') > -1) {
        UserService.login(this.loginForm.username, this.loginForm.password)
          .then(() => {
            this.$message.success('登录成功！');
            this.checkUserStatus();
          })
          .catch((data) => {
            this.$error(data.message);
          });
        return;
      }
      const result = this.captchaObj.getValidate();
      if (!result) {
        this.$message.error('请完成验证');
      } else {
        api.post('/geetest', result)
          .then((res) => {
            if (res.status === 0) {
              UserService.login(this.loginForm.username, this.loginForm.password)
                .then(() => {
                  this.$message.success('登录成功！');
                  this.checkUserStatus();
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
    checkUserStatus() {
      UserService.getUser()
        .then(() => {
          this.$router.replace({
            path: this.$route.query.redirect || '/',
          });
        });
    },
    handler(captchaObj) {
      captchaObj.appendTo('#loginCaptcha');
      captchaObj.onReady(() => {
        this.captchaReady = true;
      });
      captchaObj.onSuccess(() => {
        this.doLogin();
      });
      this.captchaObj = captchaObj;
    },
  },
  components: {},
};
</script>

<style lang="scss" scoped>
.login-page {
  max-width: 480px;
  margin: 10px auto;
  .login-wrapper {
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
