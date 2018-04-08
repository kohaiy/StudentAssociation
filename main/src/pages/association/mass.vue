<template>
  <div class="mass common-container">
    <div class="wrapper">
      <div class="title">群发消息</div>
      <el-form>
        <el-form-item>
          <el-input v-model.trim="message"
                    type="textarea" :maxlength="100"
                    autosize placeholder="消息内容"></el-input>
        </el-form-item>
        <el-form-item class="clearfix">
          <el-button @click="massMessage" :disabled="!message.length"
                     type="primary" class="pull-right">群发
          </el-button>
          <span class="text-danger">只有同乡会会长和管理员可以群发消息。</span>
          <span class="pull-right message-length">({{message.length}}/100)</span>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import MessageService from '../../service/MessageService';

export default {
  name: 'mass',
  data() {
    return {
      message: '',
    };
  },
  methods: {
    massMessage() {
      MessageService.massMessage(this.message)
        .then(() => {
          this.$message.success('发送成功！');
          this.message = '';
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.mass {
  .wrapper {
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 18px;
    }
    .message-length {
      margin-right: 10px;
      color: #666666;
    }
  }
}
</style>
