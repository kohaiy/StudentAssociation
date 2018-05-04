<template>
  <div class="mass" v-loading.lock="!isLoad">
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
</template>

<script>
import MessageService from '../../../service/MessageService';

export default {
  name: 'mass',
  data() {
    return {
      isLoad: true,
      message: '',
    };
  },
  methods: {
    massMessage() {
      this.isLoad = false;
      MessageService.massMessage(this.message)
        .then(() => {
          this.$message.success('发送成功！');
          this.message = '';
          this.isLoad = true;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.mass {
  .message-length {
    margin-right: 10px;
    color: #666666;
  }
}
</style>
