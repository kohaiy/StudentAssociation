<template>
  <div class="item" @click.stop="$emit('click')">
    <div class="icon">
      <span v-if="chartered.status" class="fa fa-check-circle text-success"></span>
      <span v-else class="fa fa-minus-circle text-danger"></span></div>
    <div class="detail">
      <div class="title word-not-break-line">{{chartered.title}}</div>
      <div class="wrapper">
        <div class="user" title="创建者">
          <span class="fa fa-user-o"></span>{{chartered.user.username}}
        </div>
        <div class="max-seat" title="人数上限"><span class="fa fa-male"></span>{{chartered.limit}}</div>
      </div>
    </div>
    <div class="time">
      <div class="wrapper"
           :title="'报名截止时间：' + moment(chartered.checkInTime[1]).format('YYYY-MM-DD HH:mm:ss')">
        {{moment(chartered.checkInTime[1]).fromNow()}}
      </div>
      <div class="actions">
        <el-button @click.stop="$emit('check-in')" icon="fa fa-user-plus" size="mini">报名</el-button>
        <template v-if="$store.state.isManager">
          <el-button @click.stop="$emit('edit')" icon="fa fa-edit" size="mini">编辑</el-button>
          <el-button @click.stop="$emit('remove')"
                     icon="fa fa-trash" type="danger" size="mini">删除
          </el-button>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'item',
  props: {
    chartered: {
      type: Object,
    },
    // title: {
    //   type: String,
    //   default: '这是本次包车信息的标题标题标题题题',
    // },
    // user: {
    //   type: String,
    //   default: '创建者',
    // },
    // // 最大座位数
    // maxSeat: {
    //   type: Number,
    //   default: 50,
    // },
    // // 开始报名时间
    // startTime: {
    //   type: Number,
    //   default: Date.now(),
    // },
    // // 结束报名时间
    // stopTime: {
    //   type: Number,
    //   default: Date.now(),
    // },
    // // 状态
    // status: {
    //   type: Boolean,
    //   default: true,
    // },
    // // 创建时间
    // createTime: {
    //   type: Number,
    //   default: Date.now(),
    // },
  },
  methods: {
    clickItem(e) {
      this.$emit('click');
      e.stopPopuer();
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../../assets/styles/variables";

$-color-border: #ddd;
.item {
  display: flex;
  padding: 5px;
  border-bottom: 1px solid $-color-border;
  transition: background-color .3s;
  cursor: pointer;
  &:first-child {
    border-top: 1px solid $-color-border;
  }
  &:hover {
    background-color: rgba(0, 0, 0, .1);
  }
  * {
    user-select: none;
  }
  .icon {
    height: 50px;
    line-height: 50px;
    margin: 0 10px;
    .fa {
      line-height: 50px;
      font-size: 25px;
      color: $--color-success;
    }
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
