<template>
  <footer>
    <div class="bg-primary text-center footer-copyright">
      网站首页 | 版权所有@柯灰 | 用户反馈 | 关于我们
    </div>
  </footer>
</template>

<script>
export default {
  name: 'v-footer',
};
</script>

<style lang="scss" scoped>
footer {
  height: 50px;
  overflow: hidden;
  .footer-copyright {
    line-height: 50px;
    font-size: 14px;
  }
}
</style>
