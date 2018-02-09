<template>
  <div class="index">
    <el-row>
      <el-col :span="4">
        <el-menu
          :router="true"
          default-active="/user">
          <el-menu-item index="/user">我的信息</el-menu-item>
          <el-menu-item index="/user/safe">安全中心</el-menu-item>
        </el-menu>
      </el-col>
      <el-col :span="20">
        <router-view></router-view>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'index',
};
</script>

<style scoped>

</style>
