<template>
  <div class="safe common-container">
    <div class="item change-password">
      <div class="title">修改密码</div>
      <el-form label-width="68px">
        <el-form-item label="旧密码：">
          <el-input v-model="oldPassword" type="password" class="short-input"></el-input>
        </el-form-item>
        <el-form-item label="新密码：">
          <el-input v-model="newPassword" type="password" class="short-input"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button @click="updatePassword" type="primary">更新密码</el-button>
        </el-form-item>
      </el-form>
    </div>
    <div class="item account-association">
      <div class="title">账号关联</div>
      <el-form label-width="82px">
        <el-form-item label="手机号码：" class="phone-numbers">
          <el-input value="13535353535" class="short-item" disabled></el-input>
          <el-button
            @click="changePhoneNumbersDialogVisible = true" type="text">更换手机号
          </el-button>
          <el-dialog
            title="更换手机号码"
            size="400px"
            :visible.sync="changePhoneNumbersDialogVisible">
            <el-input v-model.trim="phoneNumbers" placeholder="请输入手机号码"></el-input>
            <div class="body clearfix">
              <div class="phone-input pull-left">
                <el-input v-model.trim="captcha" placeholder="请输入验证码"></el-input>
              </div>
              <div class="send-button pull-right">
                <el-button @click="sendCaptcha" :disabled="!!sendCaptchaDelay">
                  {{sendCaptchaDelay ? `${sendCaptchaDelay}秒后重试` : '获取验证码'}}
                </el-button>
              </div>
            </div>
            <div slot="footer" class="dialog-footer">
              <el-button @click="changePhoneNumbersDialogVisible = false">取 消</el-button>
              <el-button type="primary"
                         @click="changePhoneNumbersDialogVisible = false">确 定
              </el-button>
            </div>
          </el-dialog>
        </el-form-item>
        <el-form-item label="邮箱地址：">
          <el-input class="short-item"></el-input>
        </el-form-item>
      </el-form>
    </div>
    <div class="item login-logs">
      <div class="title">登录日志</div>
      <ul>
        <li v-for="log in logs" :key="log">{{log | formatDate}}</li>
      </ul>
    </div>
  </div>
</template>

<script>
import UserService from '../../../service/UserService';

export default {
  name: 'safe',
  mounted() {
    UserService.getUserInfo('logs=1').then((data) => {
      this.logs = data.data.loginLogs;
    });
  },
  data() {
    return {
      newPassword: '',
      oldPassword: '',
      phoneNumbers: '',
      captcha: '',
      logs: [],
      sendCaptchaDelay: 0,
      changePhoneNumbersDialogVisible: false,
      timer: null,
    };
  },
  methods: {
    updatePassword() {
      UserService.updatePassword(this.oldPassword, this.newPassword).then(() => {
        this.$message.success('密码更新成功，请重新登录！');
        UserService.logout();
        this.$router.replace({
          path: '/login',
          query: {
            redirect: this.$router.currentRoute.path,
          },
        });
      });
    },
    sendCaptcha() {
      if (!/^1[0-9]{10}$/.test(this.phoneNumbers)) {
        this.$message.error('手机号码格式不正确');
      } else {
        this.sendCaptchaDelay = 10;
        this.timer = setInterval(() => {
          this.sendCaptchaDelay = this.sendCaptchaDelay - 1;
        }, 1000);
      }
    },
  },
  watch: {
    sendCaptchaDelay(val) {
      if (val === 0) {
        clearInterval(this.timer);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.safe {
  color: #666666;
  > .item {
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    margin-bottom: 10px;
    &:last-child {
      margin-bottom: 0;
    }
    .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 14px;
    }
  }
  .change-password {
    .short-input {
      max-width: 200px;
    }
  }
  .account-association {
    .short-item {
      max-width: 200px;
      margin-right: 10px;
    }
    .phone-numbers {
      .body {
        margin-top: 10px;
        .phone-input {
          width: 220px;
        }
      }
    }
  }
  .login-logs {
  }
}
</style>
