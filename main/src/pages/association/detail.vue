<template>
  <div class="detail" v-loading.fullscreen.lock="!isLoad">
    <div v-if="isLoad">
      <h3>{{association.name}} - {{association.city.name}}</h3>
      <div>
        <span>学校：</span>
        <span>{{association.school.name}}</span>
      </div>
      <div>
        <span>简介：</span>
        <span>{{association.description}}</span>
      </div>
      <div>
        <span>会长：</span>
        <span>{{association.chairman.username}}（{{association.chairman.nickname}}）</span>
      </div>
      <div>
        <span>管理员：</span>
        <ul>
          <li v-for="manager in association.managers" :key="manager._id">
            {{manager.username}}（{{manager.nickname}}）
          </li>
        </ul>
      </div>
      <div>
        <span>创建时间：</span>
        <span>{{association.createTime | formatDate}}</span>
      </div>
    </div>
  </div>
</template>

<script>
// import UserService from '../../service/UserService';
import AssociationService from '../../service/AssociationService';

export default {
  name: 'detail',
  mounted() {
    AssociationService.getById(this.$store.state.user.association, 'city=1&chairman=1&school=1&managers=1')
      .then((res) => {
        this.association = res.data;
        this.isLoad = true;
      });
  },
  data() {
    return {
      isLoad: false,
      association: null,
    };
  },
};
</script>

<style scoped>

</style>
