<template>
  <div id="app">
    <div class="header-wrapper">
      <v-header/>
    </div>
    <div class="main-wrapper">
      <router-view></router-view>
    </div>
    <div class="footer-wrapper">
      <v-footer/>
    </div>
    <v-background/>
  </div>
</template>

<script>
import VHeader from './components/header/header';
import VFooter from './components/footer/footer';
import VBackground from './components/background/background';

export default {
  name: 'App',
  data() {
    return {
      radio: '1',
      radio3: '',
    };
  },
  methods: {
    click() {
      this.$message.warning('success');
    },
  },
  components: {
    VHeader,
    VFooter,
    VBackground,
  },
};
</script>

<style lang="scss" scoped>
* {
  box-sizing: border-box;
}

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: rgba(164, 192, 230, .5);
  .header-wrapper {
  }
  .main-wrapper {
    flex: 1;
    position: relative;
  }
  .footer-wrapper {
  }
}
</style>
