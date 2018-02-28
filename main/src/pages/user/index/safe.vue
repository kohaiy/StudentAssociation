<template>
  <div class="safe">
    <h1>安全中心</h1>
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
    UserService.getFullUser().then((data) => {
      this.logs = data.data.loginLogs;
    });
  },
  data() {
    return {
      logs: [],
    };
  },
};
</script>

<style scoped>

</style>
