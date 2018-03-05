<template>
  <div class="system">
    系统通知
    <message-item v-for="i in 10" :key="i">
      <span slot="title">{{i}}. 与伊藤健太郎、新垣樽助、高橋広樹、梶裕貴、諏訪部順一相遇</span>
      <span slot="time">2018年1月4日 13:41:36</span>
      <span slot="content">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        Adipisci perferendis, repellendus! Adipisci alias dolores
        doloribus ea et fugiat itaque odio quibusdam quidem
        voluptatum. Aliquid consequatur eos quis sed sequi tempora?
      </span>
    </message-item>
  </div>
</template>

<script>
import MessageItem from '../../components/message/message-item';

export default {
  name: 'system',
  components: {
    MessageItem,
  },
};
</script>

<style scoped>

</style>
