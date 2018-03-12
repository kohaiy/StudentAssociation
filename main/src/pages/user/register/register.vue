<template>
  <div class="register-page">
    <el-row>
      <el-col
        :xs="{ span: 22, offset: 1 }"
        :sm="{ span: 12, offset: 6 }"
        :md="{ span: 8, offset: 8 }"
        :lg="{ span: 6, offset: 9 }"
      >
        <h2 class="title">用户注册中心</h2>
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
      </el-col>
    </el-row>
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
  .title {
    margin-bottom: 20px;
    padding-bottom: 10px;
  }
}
</style>
