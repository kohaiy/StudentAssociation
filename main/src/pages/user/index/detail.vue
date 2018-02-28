<template>
  <div class="detail">
    <h1>detail</h1>
    <el-form label-width="80px">
      <el-form-item label="用户名">
        <el-input v-model="user.username" :disabled="true"></el-input>
      </el-form-item>
      <el-form-item label="性别">
        <el-radio-group v-model.number="user.gender">
          <el-radio-button label="0">男</el-radio-button>
          <el-radio-button label="1">女</el-radio-button>
          <el-radio-button label="-1">保密</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="地区">
        <el-select v-model="province" placeholder="省份">
          <el-option v-for="p in provinces" :key="p.pid"
                     :label="p.name" :value="p.pid"></el-option>
        </el-select>
        <el-select v-model="user.city" placeholder="城市">
          <el-option label="城市" value="city"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="注册时间">
        <span>{{user.registerTime | formatDate}}</span>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
// import UtilService from '../../../service/UtilService';
// import UserService from '../../../service/UserService';
import TestService from '../../../service/TestService';

export default {
  name: 'detail',
  mounted() {
    TestService.h();
    // UserService.getFullUser();
    // UtilService.hello();
    this.province = this.initProvince();
  },
  data() {
    return {
      provinces: [],
      province: null,
    };
  },
  methods: {
    initProvince() {
      if (!this.user.city) {
        return null;
      }
      const ps = this.provinces.filter(p => p.pid === this.user.city.pid);
      return ps && ps[0];
    },
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
};
</script>

<style scoped>

</style>
