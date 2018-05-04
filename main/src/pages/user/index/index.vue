<template>
  <div class="index common-layout">
    <input id="sidebarCheckbox" type="checkbox">
    <aside class="common-sidebar">
      <div class="title">
        <span class="fa fa-user icon"></span><span>用户中心</span>
      </div>
      <ul class="list">
        <li class="item">
          <span class="fa fa-address-card"></span>
          <router-link to="/user">我的信息</router-link>
        </li>
        <li class="item">
          <span class="fa fa-key"></span>
          <router-link to="/user/safe">安全中心</router-link>
        </li>
      </ul>
    </aside>
    <main class="common-main-container">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'index',
};
</script>

<style lang="scss" scoped>
/*.index {*/
  /*!*display: flex;*!*/
  /*!*flex-direction: row;*!*/
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
