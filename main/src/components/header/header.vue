<template>
  <header class="header clearfix">
    <div class="nav-con pull-left">
      <ul>
        <li class="nav-item">
          <router-link to="/">HOME</router-link>
        </li>
        <li class="page-title">
          <span class="fa fa-clone"></span>{{$route.name}}
        </li>
      </ul>
    </div>
    <div class="nav-con pull-right">
      <ul>
        <template v-if="$store.state.user">
          <li class="nav-item">
            <a href="#"><span class="fa fa-envelope-o"></span>消息
              <el-badge :value="unreadBadge.all"/>
            </a>
            <div class="child-item messages">
              <ul>
                <li>
                  <router-link to="/message/system">
                    系统通知
                    <el-badge :value="unreadBadge.system"/>
                  </router-link>
                </li>
                <li>
                  <router-link to="/message/whisper">
                    私密消息
                    <el-badge :value="unreadBadge.whisper"/>
                  </router-link>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a href="javascript: void(0)">
              <span class="fa fa-user-o"></span>
              {{$store.state.user && $store.state.user.username}}</a>
            <div class="child-item messages">
              <ul>
                <li>
                  <router-link to="/user">
                    个人中心
                  </router-link>
                </li>
                <li>
                  <router-link to="/association">
                    我的同乡会
                  </router-link>
                </li>
                <li>
                  <a @click="logout" href="javascript: void(0)" class="text-danger">
                    注销登录
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </template>
        <template v-else>
          <li class="nav-item">
            <router-link to="/login" class="text-primary">登录</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/register">注册</router-link>
          </li>
        </template>
      </ul>
    </div>
  </header>
</template>

<script>
import UserService from '../../service/UserService';
import MessageService from '../../service/MessageService';

export default {
  name: 'v-header',
  mounted() {
    this.currentActive = this.$route.path;
    if (this.$store.state.user) {
      MessageService.get('unread=1')
        .then((res) => {
          this.unreadBadge = res.data;
        });
    }
  },
  data() {
    return {
      currentActive: '/',
      unreadBadge: {
        all: 0,
        system: 0,
        whisper: 0,
      },
    };
  },
  methods: {
    logout() {
      UserService.logout();
      this.$message.success('用户退出登录成功！');
      this.$router.replace({
        path: '/login',
        query: {
          redirect: this.$route.path,
        },
      });
    },
  },
  watch: {
    $route() {
      this.currentActive = this.$route.path;
      if (this.$store.state.user) {
        MessageService.get('unread=1')
          .then((res) => {
            this.unreadBadge = res.data;
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../assets/styles/variables";

.header {
  z-index: 1002;
  position: relative;
  min-height: 50px;
  /*overflow: hidden;*/
  border-bottom: 1px solid #dddddd;
  background-color: rgba(255, 255, 255, 1);
  .nav-con {
    &:last-child {
      margin-right: 10px;
    }
    > ul {
      margin: 0;
      padding: 0;
      list-style: none;
      > li {
        margin: 0;
        padding: 0;
        float: left;
      }
    }
    .page-title {
      height: 50px;
      line-height: 50px;
      margin-left: 20px;
      font-size: 14px;
      color: #666666;
      .fa {
        margin-right: 5px;
      }
    }
    .nav-item {
      position: relative;
      height: 50px;
      line-height: 50px;
      transition: all .3s;
      &:hover {
        background-color: #eeeeee;
        .child-item {
          opacity: 1;
          transform: scale(1, 1);
        }
      }
      a {
        display: block;
        height: 100%;
        padding: 0 15px;
        font-size: 14px;
        text-decoration: none;
        color: #333333;
      }
      &:last-child {
        .child-item {
          right: -5px;
        }
      }
      .child-item {
        position: absolute;
        top: 50px;
        width: 110px;
        overflow: hidden;
        box-shadow: rgba(0, 0, 0, 0.16) 0 2px 4px;
        border-radius: 0 0 4px 4px;
        transform-origin: top;
        transform: scale(1, 0);
        opacity: 0;
        transition: all .3s;
        background-color: #ffffff;
        ul {
          margin: 0;
          padding: 0;
          li {
            display: block;
            a {
              height: 42px;
              line-height: 42px;
              text-align: center;
              font-size: 12px;
              &:hover {
                color: $--color-primary;
                background-color: mix($--color-primary, rgba(255, 255, 255, 0), 10%);
              }
              .el-badge {
                position: absolute;
              }
            }
          }
        }
      }
      .messages {
      }
    }
  }
}

/*.el-submenu {*/
/*.el-menu {*/
/*position: relative;*/
/*right: 220px;*/
/*}*/
/*}*/
</style>
