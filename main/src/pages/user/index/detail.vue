<template>
  <div class="detail" v-loading.fullscreen.lock="!isLoad">
    <div v-show="isLoad">
      <el-form label-width="80px">
        <el-form-item label="用户名">
          <el-input v-model="user.username" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item label="昵称">
          <el-input @blur="changeNickname"
                    @keyup.enter.native="changeNickname"
                    v-model="user.nickname"></el-input>
        </el-form-item>
        <el-form-item label="姓名">
          <el-input @blur="changeRealName"
                    @keyup.enter.native="changeRealName"
                    v-model="user.realName"></el-input>
        </el-form-item>
        <el-form-item label="性别">
          <el-radio-group @change="changeGender" v-model.number="user.gender">
            <el-radio-button label="0">男</el-radio-button>
            <el-radio-button label="1">女</el-radio-button>
            <el-radio-button label="-1">保密</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="地区">
          <el-select v-model="province" placeholder="省份">
            <el-option v-for="p in provinces" :key="p._id"
                       :label="p.name" :value="p._id"></el-option>
          </el-select>
          <el-select @change="changeCity" v-model="city" placeholder="城市">
            <el-option v-for="c in cities" :key="c._id"
                       :label="c.name" :value="c._id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="学校">
          <el-button @click="isShowSchoolDialog = true">
            {{user.school && user.school.name || '选择学校'}}
          </el-button>
        </el-form-item>
        <el-form-item label="同乡会">
          <router-link to="/association">
            <el-button>
              {{user.association && user.association.name || '加入同乡会'}}
            </el-button>
          </router-link>
        </el-form-item>
        <el-form-item label="注册时间">
          <span>{{user.registerTime | formatDate}}</span>
        </el-form-item>
      </el-form>
      <!--选择学校对话框-->
      <el-dialog
        title="选择学校"
        :visible.sync="isShowSchoolDialog">
        <el-form>
          <el-form-item label="省份">
            <el-select v-model="sProvince" placeholder="省份">
              <el-option v-for="p in provinces" :key="p._id"
                         :label="p.name" :value="p._id"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="城市">
            <el-select v-model="sCity" placeholder="城市">
              <el-option v-for="c in sCities" :key="c._id"
                         :label="c.name" :value="c._id"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="学校">
            <el-select v-model="sSchool" placeholder="城市">
              <el-option v-for="s in sSchools" :key="s._id"
                         :label="s.name" :value="s._id"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="isShowSchoolDialog = false">取 消</el-button>
          <el-button type="primary" @click="changeSchool">确 定</el-button>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import UtilService from '../../../service/UtilService';
import UserService from '../../../service/UserService';
// import TestService from '../../../service/TestService';

export default {
  name: 'detail',
  mounted() {
    UserService.getUserInfo('city=1&school=1&association=1').then((res) => {
      this.user = res.data;
      return UtilService.getProvinces();
    }).then((res) => {
      this.provinces = res.data;
      this.province = this.initProvince()._id;
      this.city = this.user.city && this.user.city._id;
      setTimeout(() => {
        this.isLoad = true;
      }, this.$loadingDelayTime);
    });
  },
  data() {
    return {
      isLoad: false,
      user: {
        username: '',
        nickname: '',
        realName: '',
        gender: -1,
      },
      provinces: [],
      cities: [],
      province: null,
      city: null,
      // 学校选择 对话框
      isShowSchoolDialog: false,
      sProvince: null,
      sCity: null,
      sSchool: null,
      sCities: [],
      sSchools: [],
    };
  },
  methods: {
    initProvince() {
      if (!this.user.city) {
        return {};
      }
      const ps = this.provinces.filter(p => p._id === this.user.city.pid) || [];
      return ps[0];
    },
    changeCity() {
      UserService.updateInfo({ city: this.city })
        .then(() => this.$message.success('更新成功！'))
        .catch(error => this.$message.error(error));
    },
    changeGender() {
      UserService.updateInfo({ gender: this.user.gender })
        .then(() => this.$message.success('更新成功！'))
        .catch(error => this.$message.error(error));
    },
    changeNickname() {
      UserService.updateInfo({ nickname: this.user.nickname })
        .then(() => this.$message.success('更新成功！'))
        .catch(error => this.$message.error(error));
    },
    changeRealName() {
      UserService.updateInfo({ realName: this.user.realName })
        .then(() => this.$message.success('更新成功！'))
        .catch(error => this.$message.error(error));
    },
    changeSchool() {
      UserService.updateInfo({ school: this.sSchool })
        .then(() => {
          this.$message.success('更新成功！');
          this.isShowSchoolDialog = false;
          this.user.school = (this.sSchools.filter(s => s._id === this.sSchool) || [])[0];
        })
        .catch(error => this.$message.error(error));
    },
  },
  computed: {},
  watch: {
    province(pid) {
      UtilService.getCities(pid).then((res) => {
        this.cities = res.data;
      });
    },
    sProvince(pid) {
      this.sSchools = [];
      UtilService.getCities(pid).then((res) => {
        this.sCities = res.data;
        this.sCity = null;
      });
    },
    sCity(cid) {
      if (!cid) {
        this.sSchool = null;
        return;
      }
      UtilService.getSchools(cid).then((res) => {
        this.sSchools = res.data;
        this.sSchool = null;
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.detail {
  padding: 20px;
}
</style>
