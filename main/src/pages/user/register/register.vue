<template>
  <div class="register-page">
    <div class="register-wrapper">
      <div class="title">用户注册中心</div>
      <el-form ref="registerForm" :model="registerForm" label-width="70px">
        <el-form-item label="用户名">
          <el-input v-model="registerForm.username"></el-input>
        </el-form-item>
        <el-form-item label="密码">
          <el-input type="password" v-model="registerForm.password"></el-input>
        </el-form-item>
        <el-form-item label="确认密码">
          <el-input @keyup.enter.native="doRegister"
                    type="password" v-model="registerForm.password2"></el-input>
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

export default {
  name: 'register',
  data() {
    return {
      registerForm: {
        username: '',
        password: '',
        password2: '',
      },
    };
  },
  methods: {
    doRegister() {
      UserService.register(this.registerForm.username, this.registerForm.password)
        .then(() => {
          this.$message.success('注册成功！');
        })
        .catch((error) => {
          this.$error(error.message);
        });
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
