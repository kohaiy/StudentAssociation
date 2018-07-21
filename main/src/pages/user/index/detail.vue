<template>
  <div class="detail common-container" v-loading.fullscreen.lock="!isLoad">
    <div class="detail-list" v-show="isLoad">
      <el-form label-width="82px">
        <el-form-item label="头像：">
          <el-upload
            class="avatar-uploader"
            :action="apiPath + '/upload'"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <div v-if="user.avatar"
                 :style="'background-image:url(' + user.avatar + ')'"
                 class="avatar"></div>
            <i v-else class="el-icon-plus
             avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <el-form-item class="short-item" label="用户名：">
          <el-input v-model="user.username" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item class="short-item" label="昵称：">
          <el-input @change="updateInfo('nickname')"
                    v-model="user.nickname"></el-input>
        </el-form-item>
        <el-form-item class="short-item" label="姓名：">
          <el-input @change="updateInfo('realName')"
                    v-model="user.realName"></el-input>
        </el-form-item>
        <el-form-item label="性别：">
          <el-radio-group @change="updateInfo('gender')" v-model.number="user.gender">
            <el-radio-button label="0">男</el-radio-button>
            <el-radio-button label="1">女</el-radio-button>
            <el-radio-button label="-1">保密</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item class="medium-item1" label="邮箱地址：">
          <el-autocomplete
            class="medium-item"
            v-model.trim="user.email"
            :fetch-suggestions="autoAddEmailFix"
            placeholder="电子邮箱地址"
            :trigger-on-focus="false"
            @select="updateInfo('email')"
          ></el-autocomplete>
          <el-checkbox
            @change="updateInfo('openEmail')"
            v-model="user.openEmail">公开
          </el-checkbox>
        </el-form-item>
        <el-form-item class="medium-item1" label="手机号码：">
          <el-input class="medium-item"
                    @change="updateInfo('phoneNumber')"
                    v-model.trim="user.phoneNumber"></el-input>
          <!--<el-button @click="changePhoneNumbersDialogVisible = true">更换</el-button>-->
          <el-dialog
            title="更换手机号码"
            :visible.sync="changePhoneNumbersDialogVisible">
            <el-row>
              <el-col :span="12">
                <el-input placeholder="手机号码"></el-input>
              </el-col>
              <el-col :span="12">
                <el-button>发送验证码</el-button>
              </el-col>
            </el-row>
            <div slot="footer" class="dialog-footer">
              <el-button @click="dialogVisible = false">取 消</el-button>
              <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
            </div>
          </el-dialog>
          <el-checkbox
            @change="updateInfo('openPhoneNumber')"
            v-model="user.openPhoneNumber">公开
          </el-checkbox>
        </el-form-item>
        <el-form-item label="地区：">
          <el-select v-model="province" placeholder="省份">
            <el-option v-for="p in provinces" :key="p._id"
                       :label="p.name" :value="p._id"></el-option>
          </el-select>
          <el-select @change="changeCity" v-model="city" placeholder="城市">
            <el-option v-for="c in cities" :key="c._id"
                       :label="c.name" :value="c._id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="学校：">
          <el-button @click="isShowSchoolDialog = true">
            {{user.school && user.school.name || '选择学校'}}
          </el-button>
        </el-form-item>
        <el-form-item label="同乡会：">
          <router-link to="/association">
            <el-button>
              {{user.association && user.association.name || '加入同乡会'}}
            </el-button>
          </router-link>
        </el-form-item>
        <el-form-item label="注册时间：">
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
        email: '',
        phoneNumber: '',
        gender: -1,
        avatar: '',
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
      commonEmailFix: [
        '@qq.com',
        '@163.com',
        '@163.net',
        '@gmail.com',
        '@yahoo.com',
        '@msn.com',
        '@hotmail.com',
        '@aol.com',
        '@ask.com',
        '@live.com',
        '@0355.net',
        '@263.net',
        '@3721.net',
        '@yeah.net',
        '@googlemail.com',
        '@mail.com',
      ],
      changePhoneNumbersDialogVisible: false,
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
    updateInfo(field) {
      UserService.updateInfo({ [field]: this.user[field] })
        .then(() => this.$message.success('更新信息成功'))
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
    handleAvatarSuccess(res) {
      if (res.status === 0) {
        this.user.avatar = res.data;
        this.$message.success('上传成功');
        UserService.updateInfo({ avatar: this.user.avatar })
          .then(() => this.$message.success('更新成功！'))
          .catch(error => this.$message.error(error));
      } else {
        this.$message.error('图片上传失败，请重试');
      }
    },
    beforeAvatarUpload(file) {
      const allowTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
      const isAllowType = allowTypes.indexOf(file.type) > -1;
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isAllowType) {
        this.$message.error('上传头像图片只能是 JPG/PNG/GIF/ICO 格式!');
      }
      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!');
      }
      return isAllowType && isLt2M;
    },
    autoAddEmailFix(prefix, cb) {
      if (prefix && prefix.indexOf('@') < 0) {
        const results = this.commonEmailFix.map(fix => ({
          value: prefix + fix,
        }));
        cb(results);
      } else {
        cb([]);
      }
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
    }
    ,
  }
  ,
}
;
</script>

<style lang="scss" scoped>
.detail {
  min-width: 300px;
  overflow: auto;
  .detail-list {
    padding: 40px 20px 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    .short-item {
      max-width: 250px;
    }
    .medium-item {
      width: 200px;
    }
  }
  .avatar-uploader {
    width: 100px;
    height: 100px;
    line-height: 100px;
    text-align: center;
    border: 1px dashed #8c939d;
    border-radius: 6px;
    overflow: hidden;
    font-size: 28px;
    color: #8c939d;
    cursor: pointer;
    &:hover {
      border-color: #409EFF;
    }
    .avatar {
      height: 100px;
      width: 100px;
      background: #8c939d center;
      background-size: cover;
    }
    .avatar-uploader-icon {
      line-height: 100px;
    }
  }
}
</style>
