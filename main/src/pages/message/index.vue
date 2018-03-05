<template>
  <div class="index">
    <aside class="sidebar">
      <ul>
        <li>
          <router-link to="/message/system">系统通知</router-link>
        </li>
        <li>
          <router-link to="/message/whisper">我的信息</router-link>
        </li>
      </ul>
    </aside>
    <main class="main-container">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'index',
};
</script>

<style lang="scss" scoped>
.index {
  display: flex;
  flex-direction: row;
  .sidebar {
    width: 150px;
  }
  .main-container {
    flex: 1;
  }
}
</style>
