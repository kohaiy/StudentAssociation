<template>
  <div class="system common-container" v-loading.lock="!isLoad">
    <div class="title">
      <span>系统通知</span>
    </div>
    <div v-if="!isLoad" class="placeholder-container">
      <message-item/>
      <message-item/>
      <message-item/>
    </div>
    <div v-else>
      <message-item v-for="message in systemMessages" :read="message.status" :key="message._id">
        <span slot="title">{{message.title}}</span>
        <span slot="time">{{message.createTime | formatDate}}</span>
        <span slot="content">{{message.content}}</span>
      </message-item>
      <div v-if="isLoadAll">没有更多了 ~</div>
      <el-button
        v-else
        @click="loadMore"
        :loading="isLoadingMore"
        style="display: block"
        class="load-more">
        加载更多
      </el-button>
    </div>
  </div>
</template>

<script>
import MessageItem from '../../components/message/message-item';
import Scroll from '../../components/better-scroll';
import MessageService from '../../service/MessageService';

export default {
  name: 'system',
  mounted() {
    MessageService.get(`quantity=${this.quantity}`)
      .then((res) => {
        this.systemMessages = res.data;
        setTimeout(() => {
          this.isLoad = true;
        }, this.$loadingDelayTime);
      });
  },
  data() {
    return {
      isLoad: false,
      systemMessages: [],
      loadTimes: 1, // 已加载次数
      quantity: 10, // 每次加载个数
      isLoadingMore: false,
      isLoadAll: false, // 是否已经加载全部
    };
  },
  methods: {
    loadMore() {
      this.isLoadingMore = true;
      MessageService.get(`offset=${(this.quantity * this.loadTimes) + 1}&quantity=${this.quantity}`)
        .then((res) => {
          this.loadTimes = this.loadTimes + 1;
          if (res.data.length < 1) {
            this.$message.warning('已经没有更多了');
            this.isLoadAll = true;
          } else {
            this.systemMessages = this.systemMessages.concat(res.data);
            this.isLoadingMore = false;
          }
        });
    },
  },
  components: {
    MessageItem,
    Scroll,
  },
};
</script>

<style lang="scss" scoped>
.system {
  /*max-width: 720px;*/
  /*margin: auto;*/
  .title {
    height: 42px;
    line-height: 42px;
    padding-left: 16px;
    margin-bottom: 10px;
    font-size: 15px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    color: #666666;
    background-color: #fff;
  }
  .wrapper {
    height: 200px;
    overflow: hidden;
  }
}
</style>
