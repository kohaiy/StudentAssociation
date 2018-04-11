<template>
  <div class="index common-layout" v-loading.fullscreen.lock="!isLoad">
    <template v-if="isLoad && !user.association">
      <not-join
        :user="user"/>
    </template>
    <template v-else-if="isLoad">
      <aside class="common-sidebar">
        <div class="title">
          <span class="fa fa-circle-o icon"></span><span>同乡会中心</span>
        </div>
        <ul class="list">
          <li class="item">
            <span class="fa fa-home"></span>
            <router-link to="/association">基本信息</router-link>
          </li>
          <li class="item">
            <span class="fa fa-bullhorn"></span>
            <router-link to="/association/notice">公告中心</router-link>
          </li>
          <li class="item">
            <span class="fa fa-users"></span>
            <router-link to="/association/member">成员列表</router-link>
          </li>
          <li class="item">
            <span class="fa fa-cogs"></span>
            <router-link to="/association/manager">管理中心</router-link>
          </li>
        </ul>
      </aside>
      <main class="common-main-container">
        <router-view></router-view>
      </main>
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

<style lang="scss" scoped>
/*.index {*/
  /*position: absolute;*/
  /*left: 0;*/
  /*top: 0;*/
  /*bottom: 0;*/
  /*width: 100%;*/
  /*.sidebar {*/
    /*position: absolute;*/
    /*top: 0;*/
    /*left: 0;*/
    /*bottom: 0;*/
    /*width: 140px;*/
    /*overflow: auto;*/
    /*background-color: rgba(255, 255, 255, .8);*/
    /*.title {*/
      /*height: 62px;*/
      /*line-height: 62px;*/
      /*text-align: center;*/
      /*font-size: 14px;*/
      /*font-weight: 700;*/
      /*color: #333333;*/
      /*.icon {*/
        /*margin-right: 10px;*/
      /*}*/
    /*}*/
    /*.list {*/
      /*margin: 0;*/
      /*padding: 0 0 0 20px;*/
      /*list-style-type: none;*/
      /*font-size: 14px;*/
      /*font-weight: 700;*/
      /*color: #666;*/
      /*.item {*/
        /*height: 40px;*/
        /*line-height: 40px;*/
        /*.fa {*/
          /*margin-right: 10px;*/
        /*}*/
        /*a {*/
          /*text-decoration: none;*/
          /*color: #6b757b;*/
        /*}*/
      /*}*/
    /*}*/
  /*}*/
  /*.main-container {*/
    /*!*flex: 1;*!*/
    /*position: absolute;*/
    /*top: 0;*/
    /*left: 140px;*/
    /*right: 0;*/
    /*bottom: 0;*/
    /*padding: 10px;*/
    /*overflow: auto;*/
  /*}*/
/*}*/
</style>
