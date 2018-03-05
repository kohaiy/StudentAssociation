<template>
  <div class="panel panel-default message-item">
    <div class="panel-body">
      <div class="message-heading">
        <span class="title"><slot name="title">消息标题</slot></span>
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
};
</script>

<style lang="scss" scoped>
@import "./../../assets/styles/_variables";

.message-item {
  margin-bottom: 10px;
  .message-heading {
    .title {
      font-weight: bold;
      color: $--color-primary;
    }
    .time {
      font-size: smaller;
    }
  }
}
</style>
