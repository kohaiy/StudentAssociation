<template>
  <div class="notice common-container">
    <div v-if="!notices.length" class="item">
      暂无公告。
    </div>
    <v-notice-item
      v-for="notice in notices" :key="notice._id"
      :notice="notice"
    />
  </div>
</template>

<script>
import VNoticeItem from './notice/notice-item';
import NoticeService from '../../service/NoticeService';

export default {
  name: 'notice',
  mounted() {
    NoticeService.getNotices()
      .then((res) => {
        this.notices = res.data;
      });
  },
  data() {
    return {
      notices: [],
    };
  },
  components: {
    VNoticeItem,
  },
};
</script>

<style lang="scss" scoped>
.notice {
  .item {
    margin-bottom: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
  }
}
</style>
