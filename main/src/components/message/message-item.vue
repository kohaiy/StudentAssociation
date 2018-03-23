<template>
  <div class="message-item">
    <div class="panel-body">
      <div class="message-heading">
        <span class="title" :class="{ 'read': read }"><slot name="title">消息标题</slot></span>
        <span class="time"><slot name="time">1970年1月1日 00:00:00</slot></span>
      </div>
      <div class="message-content">
        <slot name="content">消息内容</slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'message-item',
  props: {
    read: {
      type: Boolean,
      default: true,
    },
  },
};
</script>

<style lang="scss" scoped>
@import "./../../assets/styles/_variables";

.message-item {
  .panel-body {
    padding: 24px 16px;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px 0 rgba(121,146,185,.54);
    border-radius: 4px;
    line-height: 24px;
    background-color: #fff;
    .message-heading {
      .title {
        font-size: 12px;
        font-weight: bold;
        color: $--color-primary;
      }
      .read {
        color: #666666;
      }
      .time {
        font-size: 12px;
        color: #999999;
      }
    }
    .message-content {
      padding-left: 8px;
      font-size: 12px;
      word-break: break-all;
      color: #666666;
    }
  }
}
</style>
