<template>
  <div class="safe common-container">
    <div class="change-password">
      <div class="title">修改密码</div>
      <el-form inline>
        <div class="label">旧密码：</div>
        <el-form-item class="input">
          <el-input v-model="oldPassword" type="password"></el-input>
        </el-form-item>
        <div class="label">新密码：</div>
        <el-form-item class="input">
          <el-input v-model="newPassword" type="password"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button @click="updatePassword" type="primary">更新密码</el-button>
        </el-form-item>
      </el-form>
    </div>
    <div class="login-logs">
      <div class="title">登录日志</div>
      <ul>
        <li v-for="log in logs" :key="log">{{log | formatDate}}</li>
      </ul>
    </div>
  </div>
</template>

<script>
import UserService from '../../../service/UserService';

export default {
  name: 'safe',
  mounted() {
    UserService.getUserInfo('logs=1').then((data) => {
      this.logs = data.data.loginLogs;
    });
  },
  data() {
    return {
      newPassword: '',
      oldPassword: '',
      logs: [],
    };
  },
  methods: {
    updatePassword() {
      UserService.updatePassword(this.oldPassword, this.newPassword).then(() => {
        this.$message.success('密码更新成功，请重新登录！');
        UserService.logout();
        this.$router.replace({
          path: '/login',
          query: {
            redirect: this.$router.currentRoute.path,
          },
        });
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.safe {
  color: #666666;
  .change-password {
    padding: 20px;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 14px;
    }
  }
  .login-logs {
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 14px;
    }
  }
}
</style>
