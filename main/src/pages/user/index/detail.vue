<template>
  <div class="detail">
    <h1>detail</h1>
    <el-form label-width="80px">
      <el-form-item label="用户名">
        <el-input v-model="user.username" :disabled="true"></el-input>
      </el-form-item>
      <el-form-item label="性别">
        <el-radio-group v-model.number="user.gender">
          <el-radio-button label="0">男</el-radio-button>
          <el-radio-button label="1">女</el-radio-button>
          <el-radio-button label="-1">保密</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="注册时间">
        <span>{{user.userTime.register | formatDate}}</span>
      </el-form-item>
      <el-form-item label="上次登录">
        <span>{{user.userTime.lastLogin | formatDate}}</span>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'detail',
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
};
</script>

<style scoped>

</style>
