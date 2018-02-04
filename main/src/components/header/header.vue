<template>
  <header>
    <el-menu mode="horizontal" class="container"
             :default-active="currentActive"
             :router="true">
      <el-menu-item index="/">LOGO</el-menu-item>
      <el-menu-item index="/login" class="pull-right text-primary">登录</el-menu-item>
      <el-menu-item index="/register" class="pull-right">注册</el-menu-item>
    </el-menu>
  </header>
</template>

<script>
export default {
  name: 'v-header',
  data() {
    return {
      currentActive: '/xxx',
    };
  },
};
</script>

<style lang="scss" scoped>

</style>
