<template>
  <div class="manager common-container">
    <div class="item">
      <div class="title"><span class="fa fa-file-text"></span>基本信息</div>
      <div class="content">
        <v-info/>
      </div>
    </div>
    <div class="item">
      <div class="title notice-title"><span class="fa fa-calendar"></span>公告管理</div>
      <div class="content">
        <v-notice/>
      </div>
    </div>
    <div class="item">
      <div class="title"><span class="fa fa-send"></span>消息群发</div>
      <div class="content">
        <v-mass/>
      </div>
    </div>
  </div>
</template>

<script>
import VNotice from './manager/notice';
import VMass from './manager/mass';
import VInfo from './manager/info';
// import VCharteredBus from './manager/'

export default {
  name: 'manager',
  components: {
    VNotice,
    VMass,
    VInfo,
    // VCharteredBus,
  },
};
</script>

<style lang="scss" scoped>
.item {
  margin-bottom: 10px;
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
  .notice-title {
    margin-bottom: 0;
  }
}
</style>
