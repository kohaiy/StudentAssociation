<template>
  <div class="safe">
    <h1>安全中心</h1>
    <el-form label-width="80px">
      <el-form-item label="旧密码">
        <el-input v-model="oldPassword" type="password"></el-input>
      </el-form-item>
      <el-form-item label="新密码">
        <el-input v-model="newPassword" type="password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button @click="updatePassword" type="primary">更新密码</el-button>
      </el-form-item>
    </el-form>
    <h2>登录日志</h2>
    <ul>
      <li v-for="log in logs" :key="log">{{log | formatDate}}</li>
    </ul>
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
      }).catch((error) => {
        this.$message.error(error.message);
      });
    },
  },
};
</script>

<style scoped>

</style>
