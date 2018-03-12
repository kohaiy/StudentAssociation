<template>
  <header>
    <el-menu mode="horizontal" class="container"
             :default-active="currentActive"
             :router="true">
      <el-menu-item index="/">LOGO</el-menu-item>
      <el-menu-item index="/login" class="pull-right text-primary">登录</el-menu-item>
      <el-menu-item index="/register" class="pull-right">注册</el-menu-item>
      <el-submenu index="/xxx" class="pull-right">
        <template slot="title">用户名</template>
        <el-menu-item index="/user">个人中心</el-menu-item>
        <el-menu-item index="/association">我的同乡会</el-menu-item>
        <el-menu-item index="/message">我的消息</el-menu-item>
        <el-menu-item @click="logout" :index="$route.path" class="text-danger">注销</el-menu-item>
      </el-submenu>
    </el-menu>
  </header>
</template>

<script>
import UserService from '../../service/UserService';

export default {
  name: 'v-header',
  mounted() {
    this.currentActive = this.$route.path;
  },
  data() {
    return {
      currentActive: '/',
    };
  },
  methods: {
    logout() {
      UserService.logout();
      this.$message.success('用户退出登录成功！');
      this.$router.replace({
        path: '/login',
        query: {
          redirect: this.$route.path,
        },
      });
    },
  },
  watch: {
    $route() {
      this.currentActive = this.$route.path;
    },
  },
};
</script>

<style lang="scss" scoped>

</style>
