<template>
  <div class="item">
    <div class="icon"><span class="fa fa-calendar"></span></div>
    <div class="detail">
      <div class="title word-not-break-line">{{title}}</div>
      <div class="wrapper">
        <div class="user" title="创建者"><span class="fa fa-user-o"></span>{{user}}</div>
        <div class="max-seat" title="最大座位数"><span class="fa fa-male"></span>{{maxSeat}}</div>
      </div>
    </div>
    <div class="time">
      <el-popover
        ref="popover"
        placement="bottom"
        width="180"
        trigger="hover">
        <div class="start-time">{{startTime | formatDate('Y年M月DD日 HH:mm:ss')}}</div>
        <div class="stop-time">~ {{stopTime | formatDate('Y年M月DD日 HH:mm:ss')}}</div>
      </el-popover>
      <el-button type="text" v-popover:popover>报名时间</el-button>
      <!--<div class="wrapper" title="报名时间">-->
      <!--</div>-->
    </div>
  </div>
</template>

<script>
export default {
  name: 'item',
  props: {
    title: {
      type: String,
      default: '这是本次包车信息的标题标题标题题题',
    },
    user: {
      type: String,
      default: '创建者',
    },
    // 最大座位数
    maxSeat: {
      type: Number,
      default: 50,
    },
    // 开始报名时间
    startTime: {
      type: Number,
      default: Date.now(),
    },
    // 结束报名时间
    stopTime: {
      type: Number,
      default: Date.now(),
    },
    // 状态
    status: {
      type: Boolean,
      default: true,
    },
    // 创建时间
    createTime: {
      type: Number,
      default: Date.now(),
    },
  },
};
</script>

<style lang="scss" scoped>
.item {
  display: flex;
  padding: 5px;
  transition: background-color .3s;
  &:hover {
    background-color: rgba(0, 0, 0, .1);
  }
  .icon {
    height: 50px;
    line-height: 50px;
    margin: 0 10px;
    font-size: 20px;
    color: #0f0;
    /*background-color: #0f0;*/
  }
  .detail {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 5px 10px;
    overflow: hidden;
    /*background-color: #e4e4e4;*/
    .title {
    }
    .wrapper {
      display: flex;
      margin-top: 5px;
      font-size: 14px;
      color: #666666;
      .user {
        margin-right: 10px;
      }
      .max-seat {

      }
    }

  }
  .time {
    .wrapper {
      font-size: 12px;
      color: #666666;
    }
    .start-time {

    }
  }
}
</style>
