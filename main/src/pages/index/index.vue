<template>
  <div class="index">
    <div class="navbar">
      <div class="navbar-wrapper">
      </div>
    </div>
    <div class="container-wrapper clearfix">
      <div class="panel main-container">
        虚位以待！！！
      </div>
      <div class="panel user-panel">
        <div class="no-login">
          <div class="login-btn">
            <router-link to="/login">
              <el-button type="primary">马上登录</el-button>
            </router-link>
          </div>
          <div class="register-btn">
            <div>还没有账号？</div>
            <div>
              <router-link to="/register">
                <el-button type="text">注册</el-button>
              </router-link>
              一个
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'index',
  data() {
    return {
      num: 0,
      carouselImages: [
        '/static/images/carousel1.jpeg',
        '/static/images/carousel2.jpeg',
        '/static/images/carousel3.jpg',
      ],
    };
  },
};
</script>

<style lang="scss" scoped>
.index {
  .navbar {
    position: relative;
    top: -50px;
    height: 150px;
    margin-bottom: -50px;
    .navbar-wrapper {
      height: 100%;
      background: url(navbar.png) no-repeat center 0;
      background-size: auto 150px;
    }
  }
  .container-wrapper {
    max-width: 720px;
    height: 100px;
    margin: 10px auto;
    display: flex;
    > .panel {
      margin-bottom: 10px;
      padding: 20px;
      box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
      border-radius: 4px;
      background-color: #fff;
    }
    .main-container {
      flex: 1;
      height: 100px;
      margin-right: 10px;
    }
    .user-panel {
      width: 150px;
      height: 180px;
      text-align: center;
      .no-login {
        .login-btn {
          margin: 30px;
        }
      }
    }
  }
}
</style>
