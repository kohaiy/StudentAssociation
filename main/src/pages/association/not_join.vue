<template>
  <div class="not_join">
    <h1>未加入同乡会</h1>
    <template v-if="!user.school">
      <router-link to="/user">
        <el-button type="primary">请先选择您的学校</el-button>
      </router-link>
    </template>
    <template v-else>
      <ul>
        <li>
          <p>加入一个同乡会</p>
          <el-select
            v-model="association"
            no-data-text="暂无同乡会"
            placeholder="请选择">
            <el-option
              v-for="as in associations"
              :key="as._id"
              :label="as.name"
              :value="as._id">
            </el-option>
          </el-select>
        </li>
        <li>
          <p>创建一个同乡会</p>
          <div>
            <el-button @click="isShowCreateAsDialog = true" type="primary">创建同乡会</el-button>
          </div>
          <el-dialog
            title="创建同乡会"
            :visible.sync="isShowCreateAsDialog"
            width="500px">
            <el-steps :active="createStep" simple>
              <el-step title="选择地区" icon="el-icon-location-outline"></el-step>
              <el-step title="基本信息" icon="el-icon-edit"></el-step>
            </el-steps>
            <div v-if="createStep === 0" class="step-block">
              <el-cascader
                :options="provinces"
                v-model="city"
                @active-item-change="handleProvinceChange"
                :props="props"
                separator=" - "
              ></el-cascader>
            </div>
            <div v-if="createStep === 1" class="step-block">
              <el-form label-width="50px">
                <el-form-item label="学校">
                  <el-input v-model="user.school.name" :disabled="true"></el-input>
                  学校通过
                  <router-link to="/user">
                    <el-button type="text" size="small">个人中心</el-button>
                  </router-link>
                  修改
                </el-form-item>
                <el-form-item label="名称">
                  <el-input v-model="sa.name" placeholder="同乡会名称"></el-input>
                </el-form-item>
                <el-form-item label="简介">
                  <el-input v-model="sa.description" type="textarea" placeholder="同乡会简介"></el-input>
                </el-form-item>
              </el-form>
            </div>
            <div v-if="createStep === 2" class="step-block">
              <div><span>地区：</span><span>{{zone.join(' - ')}}</span></div>
              <div><span>学校：</span><span>{{user.school.name}}</span></div>
              <div><span>名称：</span><span>{{sa.name}}</span></div>
              <div><span>简介：</span><span>{{sa.description}}</span></div>
            </div>
            <div slot="footer" class="dialog-footer">
              <el-button @click="createStep--" :disabled="createStep === 0">上一步</el-button>
              <el-button type="primary" @click="nextStep" :disabled="isPassCurrentStep">
                {{createStep === 2 ? '确认创建' : '下一步'}}
              </el-button>
            </div>
          </el-dialog>
        </li>
      </ul>
    </template>
  </div>
</template>

<script>
import AssociationService from '../../service/AssociationService';
import UtilService from '../../service/UtilService';

export default {
  name: 'not_join',
  props: {
    user: {
      type: Object,
    },
  },
  mounted() {
    if (this.user.school) {
      AssociationService.getBySchoolId((this.user.school && this.user.school._id) || '')
        .then((res) => {
          this.associations = res.data;
        });
      UtilService.getProvinces()
        .then((res) => {
          this.provinces = res.data.map((p) => {
            // eslint-disable-next-line no-param-reassign
            p.cities = [];
            return p;
          });
        });
    }
  },
  data() {
    return {
      association: null,
      associations: [],
      // 创建相关
      isShowCreateAsDialog: false,
      createStep: 0,
      provinces: [],
      city: [],
      props: {
        value: '_id',
        label: 'name',
        children: 'cities',
      },
      sa: {
        name: '',
        description: '',
      },
      validate: [{ v: () => !(this.city && this.city.length === 2), m: '未选择地区' },
        { v: () => !(this.sa.name && this.sa.description), m: '同乡会名称或简介不能为空' },
      ],
      zone: [],
    };
  },
  methods: {
    handleProvinceChange(value) {
      const val = value.toString();
      UtilService.getCities(val)
        .then((res) => {
          this.provinces = this.provinces.map((p) => {
            if (p._id === val) {
              // eslint-disable-next-line no-param-reassign
              p.cities = res.data;
            }
            return p;
          });
        });
    },
    nextStep() {
      if (this.createStep === 1) {
        this.provinces.forEach((p) => {
          if (p._id === this.city[0]) {
            this.zone.push(p.name);
            p.cities.forEach((c) => {
              if (c._id === this.city[1]) {
                this.zone.push(c.name);
              }
            });
          }
        });
      }
      if (this.createStep === 2) {
        const data = {
          city: this.city[1],
          ...this.sa,
        };
        AssociationService.createAssociation(data)
          .then((res) => {
            console.log(res);
          });
      } else {
        this.createStep = this.createStep + 1;
      }
    },
  },
  computed: {
    isPassCurrentStep() {
      return this.validate[this.createStep]
        && this.validate[this.createStep].v
        && this.validate[this.createStep].v();
    },
  },
};
</script>

<style lang="scss" scoped>
.step-block {
  margin-top: 22px;
}
</style>
