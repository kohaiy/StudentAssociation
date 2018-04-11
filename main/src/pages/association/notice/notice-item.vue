<template>
  <div class="notice-item">
    <div class="title">
      <span class="user">[{{notice.user.username}}]</span>
      <span class="time">{{notice.createTime | formatDate}}</span>
    </div>
    <div class="content">
      {{notice.content}}
    </div>
    <div v-if="notice.images.length > 0" class="images">
      <span @click="loadLargeImage(img)" v-for="img in notice.images" :key="img" class="image">
        <span class="large fa fa-search"></span>
        <img :src="img+ '&thumb'" alt="公告图片">
      </span>
      <el-dialog :visible.sync="dialogVisible">
        <img width="100%" :src="dialogImageUrl" alt="公告图片">
      </el-dialog>
    </div>
  </div>
</template>

<script>
export default {
  name: 'notice-item',
  props: ['notice'],
  data() {
    return {
      dialogVisible: false,
      dialogImageUrl: '',
    };
  },
  methods: {
    loadLargeImage(img) {
      this.dialogImageUrl = img;
      this.dialogVisible = true;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/styles/variables";

.notice-item {
  margin-bottom: 10px;
  padding: 20px;
  box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
  border-radius: 4px;
  background-color: #fff;
  .title {
    font-size: 18px;
    margin-bottom: 5px;
    .user {
      font-weight: 700;
      color: $--color-primary;
    }
    .time {
      font-size: 14px;
      color: #999999;
    }
  }
  .content {
    margin-bottom: 10px;
    font-size: 14px;
  }
  .images {
    .image {
      display: inline-block;
      position: relative;
      height: 50px;
      width: 50px;
      border: 1px dashed transparent;
      transition: all .3s;
      cursor: pointer;
      &:hover {
        border-color: $--color-primary;
        .large {
          opacity: 1;
        }
      }
      .large {
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -8px;
        margin-top: -6px;
        color: #ffffff;
        opacity: 0;
        transition: all .3s;
      }
      img {
        height: 100%;
        width: 100%;
      }
    }
  }
}
</style>
