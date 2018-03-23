<template>
  <div class="whisper common-container" v-loading.lock="!isLoad">
    <div class="title">
      <span>我的消息</span>
    </div>
    <div class="chat">
      <div class="list">
        <div class="list-title">
          近期消息
        </div>
        <div ref="listWrapper" class="list-content">
          <div class="wrapper">
            <router-link
              class="item"
              v-for="m in members" :key="m._id"
              :class="{ 'active': m._id === $route.params.id }"
              :to="'/message/whisper/' + m._id"
              :title="m.username">
              <span class="fa fa-user-circle"></span><span>{{m.username}}</span>
              <el-badge :value="m.unread" />
            </router-link>
          </div>
        </div>
      </div>
      <div class="dialog">
        <div class="dialog-title">{{activeUser && activeUser.username || '选择一个用户聊聊'}}</div>
        <template v-if="!activeUser">
          <div class="not-choose">
            <div class="wrapper">
              <div class="fa fa-users icon"></div>
              <div class="big">打开世界的另一扇窗</div>
              <div class="small">主动一点，世界会更大</div>
            </div>
          </div>
        </template>
        <template v-else>
          <div ref="messageWrapper" class="message-list">
            <div class="message-list-content">
              <div v-for="message in messages" :key="message._id">
                <div class="msg-time">
                  <span class="time">{{message.createTime | formatDate}}</span>
                </div>
                <div class="msg-item clearfix"
                     :class="{ 'not-me': message.sender === activeUserId }">
                  <a href="#"
                     :title="message.sender === activeUserId ?
                      activeUser.username : $store.state.user.username"
                     class="avatar">
                    {{message.sender === activeUserId ?
                    activeUser.username : $store.state.user.username}}
                  </a>
                  <div class="message">
                    <div class="message-content">
                      {{message.content}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="send-box">
            <div class="row">
              <div class="emoji">
                <el-popover
                  ref="emojiPopover"
                  placement="top"
                  width="200"
                  title="复制即可使用😂"
                  trigger="click"
                  content="😀 😂 😃 😎 😗 😑 😮 😌 😝 😒 😔 😕">
                </el-popover>
                <el-button v-popover:emojiPopover type="text">emoji</el-button>
                <el-popover
                  ref="yanPopover"
                  placement="top"
                  width="200"
                  title="复制即可使用(⌒▽⌒)"
                  trigger="click"
                  content="(⌒▽⌒) （￣▽￣） (=・ω・=) (｀・ω・´) ╮(￣▽￣)╭ ( ♥д♥) （/TДT)/">
                </el-popover>
                <el-button v-popover:yanPopover type="text">颜文字</el-button>
              </div>
            </div>
            <div class="input-box">
              <textarea
                v-model.trim="messageContent"
                @keydown.enter="sendMessage"
                placeholder="回复一下吧 ~"></textarea>
            </div>
            <div class="row right">
              <el-button @click="sendMessage" type="primary" size="small">&nbsp;发送&nbsp;</el-button>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import BScroll from 'better-scroll';
import MessageService from '../../service/MessageService';
import UserService from '../../service/UserService';

export default {
  name: 'whisper',
  mounted() {
    this.init();
  },
  created() {
    this.$nextTick(() => {
      this.listScroll = new BScroll(this.$refs.listWrapper, {
        mouseWheel: {
          speed: 20,
          invert: false,
        },
        scrollbar: {
          fade: true,
          interactive: true,
        },
      });
      // console.log(JSON.stringify(this.$refs));
      if (this.$refs.message) {
        this.messageScroll = new BScroll(this.$refs.message, {
          mouseWheel: {
            speed: 20,
            invert: false,
          },
          scrollbar: {
            fade: true,
            interactive: true,
          },
        });
      }
    });
  },
  data() {
    return {
      isLoad: false,
      members: [],
      messages: [],
      messageContent: '',
      listScroll: null,
      messageScroll: null,
    };
  },
  methods: {
    init() {
      if (this.activeUserId === this.$store.state.user._id) {
        this.$message.warning('不能给自己发送消息');
        this.$router.replace({
          path: '/message/whisper',
        });
      }
      MessageService.getMemberList()
        .then((res) => {
          this.members = res.data;
          // 判断当前是否是打开对话
          if (this.activeUserId) {
            // 判断该对话用户是否在 members 中，通过 id 去获取用户名并 push 到 members 中
            if (!this.activeUser) {
              UserService.getUserPublic(this.activeUserId)
                .then((userRes) => {
                  this.members.unshift(userRes.data);
                  setTimeout(() => {
                    this.isLoad = true;
                  }, this.$loadingDelayTime);
                })
                .catch(() => {
                  this.$router.replace({
                    path: '/message/whisper',
                  });
                  this.isLoad = true;
                });
            } else {
              MessageService.get(`whisper=${this.activeUserId}`)
                .then((res2) => {
                  this.messages = res2.data;
                  this.$nextTick(() => {
                    this.messageScroll.refresh();
                    this.messageScroll.scrollTo(0, this.messageScroll.maxScrollY);
                  });
                  setTimeout(() => {
                    this.isLoad = true;
                  }, this.$loadingDelayTime);
                });
            }
          } else {
            setTimeout(() => {
              this.isLoad = true;
            }, this.$loadingDelayTime);
          }
        });
    },
    refresh() {
      if (this.activeUserId) {
        this.isLoad = false;
        MessageService.get(`whisper=${this.activeUser._id}`)
          .then((res2) => {
            this.messages = res2.data;
            this.$nextTick(() => {
              this.messageScroll.refresh();
              this.messageScroll.scrollTo(0, this.messageScroll.maxScrollY);
            });
            setTimeout(() => {
              this.isLoad = true;
            }, this.$loadingDelayTime);
          });
      }
    },
    sendMessage() {
      if (this.messageContent) {
        MessageService.sendMessage(this.activeUserId, this.messageContent)
          .then((res) => {
            this.messages.push(res.data);
            this.messageContent = '';
            // 滚动到底部
            this.$nextTick(() => {
              this.messageScroll.refresh();
              this.messageScroll.scrollTo(0, this.messageScroll.maxScrollY);
            });
          });
      } else {
        this.$message.error('消息内容不能为空');
      }
    },
  },
  computed: {
    activeUser() {
      if (!this.$route.params.id) {
        return null;
      }
      return (this.members.filter(m => m._id === this.$route.params.id) || [])[0];
    },
    activeUserId() {
      return this.$route.params.id;
    },
  },
  watch: {
    activeUser(val) {
      if (val) {
        setTimeout(() => {
          this.messageScroll = this.messageScroll || new BScroll(this.$refs.messageWrapper, {
            mouseWheel: {
              speed: 20,
              invert: false,
            },
            scrollbar: {
              fade: true,
              interactive: true,
            },
          });
        }, 20);
      }
    },
    activeUserId(newVal, oldVal) {
      // console.log('userid change');
      if (!oldVal) {
        this.$nextTick(() => {
          this.messageScroll = new BScroll(this.$refs.messageWrapper, {
            mouseWheel: {
              speed: 20,
              invert: false,
            },
            scrollbar: {
              fade: true,
              interactive: true,
            },
          });
        });
      }
      this.refresh();
    },
  },
};
</script>

<style lang="scss" scoped>
.whisper {
  height: 100%;
  display: flex;
  flex-direction: column;
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
  .chat {
    flex: 1;
    display: flex;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    font-size: 12px;
    color: #666666;
    background-color: #fff;
    .list {
      display: flex;
      flex-direction: column;
      width: 150px;
      border-right: 1px solid #e9eaec;
      .list-title {
        padding: 0 24px;
        line-height: 35px;
        border-bottom: 1px solid #e9eaec;
      }
      .list-content {
        position: relative;
        flex: 1;
        overflow: hidden;
        .wrapper {
          position: relative;
          .item {
            display: block;
            padding: 19px 24px;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            word-break: keep-all;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all .3s;
            text-decoration: none;
            &:hover,
            &.active {
              background-color: #f4f4f4;
            }
            .fa {
              margin-right: 5px;
            }
          }
        }
      }
    }
    .dialog {
      flex: 1;
      display: flex;
      flex-direction: column;
      .dialog-title {
        padding: 0 24px;
        line-height: 35px;
        text-align: center;
        border-bottom: 1px solid #e9eaec;
      }
      .not-choose {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        .wrapper {
          text-align: center;
          .icon {
            font-size: 100px;
            color: #eeeeee;
          }
          .big {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 20px;
          }
          .small {
            color: #999999;
          }
        }
      }
      .message-list {
        position: relative;
        flex: 1;
        overflow: hidden;
        background-color: #f4f4f4;
        .message-list-content {
          .msg-time {
            padding: 16px 0;
            text-align: center;
            .time {
              line-height: 22px;
            }
          }
          .msg-item {
            padding: 0 16px 16px;
            &.not-me {
              .avatar {
                float: left;
                color: #4baffa;
                background-color: #ffffff;
              }
              .message {
                float: left;
                margin-left: 20px;
                color: #666666;
                background-color: #fff;
                &:before {
                  left: -35px;
                  border: 10px solid transparent;
                  border-left-width: 20px;
                  border-right: 20px solid #ffffff;
                }
              }
            }
            .avatar {
              float: right;
              display: block;
              width: 50px;
              height: 50px;
              line-height: 50px;
              text-align: center;
              text-decoration: none;
              overflow: hidden;
              text-overflow: ellipsis;
              color: #ffffff;
              background-color: #4baffa;
            }
            .message {
              position: relative;
              float: right;
              max-width: 400px;
              margin: 5px 20px 5px 5px;
              border-radius: 10px;
              color: #ffffff;
              background-color: rgb(128, 185, 242);
              .message-content {
                min-height: 40px;
                line-height: 40px;
                padding: 8px 16px 8px 20px;
                font-size: 14px;
                word-break: break-all;
                word-wrap: break-word;
              }
              &:before {
                content: '';
                position: absolute;
                width: 0;
                height: 0;
                top: 10px;
                right: -35px;
                border: 10px solid transparent;
                border-right-width: 20px;
                border-left: 20px solid rgb(128, 185, 242);
              }
            }
          }
        }
      }
      .send-box {
        height: 162px;
        padding: 0 16px;
        border-top: 1px solid #d8d8d8;
        border-bottom-right-radius: 4px;
        overflow: hidden;
        background-color: #f4f4f4;
        .row {
          height: 40px;
          line-height: 40px;
          font-size: 14px;
          .emoji {
            a {
              text-decoration: none;
            }
          }
        }
        .input-box {
          textarea {
            width: 100%;
            height: 60px;
            padding: 0 0 14px;
            border: none;
            font-size: 14px;
            outline: none;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: #f4f4f4;
            resize: none;
          }
        }
        .right {
          text-align: right;
        }
      }
    }
  }
}
</style>
