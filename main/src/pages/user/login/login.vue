<template>
  <div class="login-page">
    <div class="login-wrapper">
      <div class="title">用户登录中心</div>
      <el-form ref="loginForm" :model="loginForm" label-width="60px">
        <el-form-item label="用户名">
          <el-input v-model="loginForm.username"></el-input>
        </el-form-item>
        <el-form-item label="密码">
          <el-input type="password" v-model="loginForm.password"
                    @keyup.enter.native="doLogin"></el-input>
        </el-form-item>
        <el-form-item class="clearfix">
          <el-checkbox v-model="loginForm.isRemember">记住密码</el-checkbox>
          <el-button type="text" class="pull-right">忘记密码？</el-button>
        </el-form-item>
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

export default {
  name: 'login',
  mounted() {
    this.checkUserStatus();
  },
  data() {
    return {
      loginForm: {
        username: 'kohai',
        password: '123123',
        isRemember: true,
      },
    };
  },
  methods: {
    doLogin() {
      UserService.login(this.loginForm.username, this.loginForm.password)
        .then(() => {
          this.$message.success('登录成功！');
          this.checkUserStatus();
        })
        .catch((data) => {
          console.log(data);
          this.$error(data.message);
        });
    },
    checkUserStatus() {
      UserService.getUser()
        .then(() => {
          this.$router.replace({
            path: this.$route.query.redirect || '/',
          });
        });
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
