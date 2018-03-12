<template>
  <div class="index" v-loading.fullscreen.lock="!isLoad">
    <template v-if="isLoad && !user.association">
      <not-join
        :user="user"/>
    </template>
    <template v-else-if="isLoad">
      <el-row>
        <el-col :span="4">
          <el-menu
            :router="true"
            default-active="/user">
            <el-menu-item index="/association">首页</el-menu-item>
            <el-menu-item index="/association/member">成员</el-menu-item>
          </el-menu>
        </el-col>
        <el-col :span="20">
          <router-view></router-view>
          <pre>{{user}}</pre>
        </el-col>
      </el-row>
    </template>
  </div>
</template>

<script>
import UserService from '../../service/UserService';
import NotJoin from './not_join';

export default {
  components: { NotJoin },
  name: 'index',
  mounted() {
    UserService.getUserInfo('association=1&school=1').then((res) => {
      this.user = res.data;
      setTimeout(() => {
        this.isLoad = true;
      }, this.$loadingDelayTime);
    });
  },
  data() {
    return {
      user: null,
      isLoad: false,
    };
  },
}
;
</script>

<style scoped>

</style>
