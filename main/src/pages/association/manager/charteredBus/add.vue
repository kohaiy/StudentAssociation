<template>
  <div class="add clearfix">
    <el-form label-width="100px">
      <el-form-item label="包车标题：">
        <el-input v-model.trim="form.title"
                  placeholder="包车标题" class="short-input"></el-input>
      </el-form-item>
      <el-form-item label="人数上限：">
        <el-input-number v-model="form.limit"
                         :min="1"></el-input-number>
      </el-form-item>
      <el-form-item label="车票单价：">
        <el-input
          v-model.number="form.price"
          placeholder="车票单价"
          class="short-input">
          <template slot="prepend">￥</template>
        </el-input>
      </el-form-item>
      <el-form-item label="发车时间：">
        <el-date-picker
          v-model="form.departureTime"
          type="datetime"
          placeholder="选择发车时间"></el-date-picker>
      </el-form-item>
      <el-form-item label="报名时间：">
        <el-date-picker
          v-model="form.checkInTime"
          type="datetimerange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="上车地点：">
        <el-autocomplete
          v-model.trim="startPlace"
          :fetch-suggestions="startPlaceSearch"
          placeholder="上车地点"
          class="short-input"
        ></el-autocomplete>
        <el-button @click="addStartPlace" icon="el-icon-plus" circle></el-button>
        <div class="tags">
          <el-tag
            v-for="(place, index) in form.startPlaces"
            :key="place"
            @close="startPlaceTagClose(index)"
            type="primary"
            class="el-tag"
            closable>
            {{place}}
          </el-tag>
        </div>
      </el-form-item>
      <el-form-item label="下车地点：">
        <el-autocomplete
          @keyup.enter.native="addEndPlace"
          @select="handleEndSelect"
          v-model.trim="endPlace"
          :fetch-suggestions="endPlaceSearch"
          placeholder="下车地点"
          class="short-input"
        ></el-autocomplete>
        <el-button @click="addEndPlace" icon="el-icon-plus" circle></el-button>
        <div class="tags">
          <el-tag
            v-for="(place, index) in form.endPlaces"
            :key="place"
            @close="endPlaceTagClose(index)"
            type="success"
            class="el-tag"
            closable>
            {{place}}
          </el-tag>
        </div>
      </el-form-item>
      <el-form-item label="描述信息：">
        <el-input v-model.trim="form.description"
                  type="textarea" placeholder="填写此次包车额外说明"></el-input>
      </el-form-item>
    </el-form>
    <div class="dialog-footer pull-right">
      <el-button @click="close">取 消</el-button>
      <el-button type="primary" @click="publish">
        {{mode === 'update' ? '确认更改' : '确认发布'}}
      </el-button>
    </div>
  </div>
</template>

<script>
import AssociationService from '../../../../service/AssociationService';
import CharteredService from '../../../../service/CharteredService';

export default {
  name: '',
  mounted() {
    this.form = this.chartered || {
      title: '',
      description: '',
      limit: 0,
      price: 0,
      startPlaces: [],
      endPlaces: [],
      departureTime: Date.now(),
      checkInTime: [],
    };
    AssociationService.getById()
      .then((res) => {
        this.startPlaces = res.data.addresses.map(a => ({ value: a }));
        this.endPlaces = this.startPlaces;
      });
  },
  props: {
    chartered: {
      type: Object,
      default: null,
    },
    mode: {
      type: String,
      default: 'create',
    },
  },
  data() {
    return {
      form: {
        title: '',
        description: '',
        limit: 0,
        price: 0,
        startPlaces: [],
        endPlaces: [],
        departureTime: null,
        checkInTime: null,
      },
      startPlace: '',
      startPlaces: [],
      endPlace: '',
      endPlaces: [],
    };
  },
  methods: {
    // 确认发布
    publish() {
      if (this.mode === 'create') {
        CharteredService.create(this.form)
          .then(() => {
            this.$message.success('添加包车信息成功');
            this.$emit('success');
            this.close();
          })
          .catch((err) => {
            this.$message.error(err.message);
          });
      } else if (this.mode === 'update') {
        CharteredService.update(this.form)
          .then(() => {
            this.$message.success('更新包车信息成功');
            this.$emit('success');
            this.close();
          })
          .catch((err) => {
            this.$message.error(err.message);
          });
      }
    },
    handleStartSelect(item) {
      // this.form.startPlaces.push(item.value);
      // this.addStartPlace();
      console.log('hahha');
      const val = item.value;
      console.log(this.form.startPlaces);
      if (val.length > 1 && val.length < 21) {
        if (this.form.startPlaces.indexOf(val) < 0) {
          this.form.startPlaces.push(val);
        }
        // else {
        //   this.$message.error('已经有相同的地址存在了');
        // }
        this.startPlace = '';
        // } else {
        //   this.$message.error('长度必须为 2 - 20 个字符');
      }
    },
    handleEndSelect() {
      // this.form.endPlaces.push(item.value);
    },
    addStartPlace() {
      console.log('add');
      if (this.startPlace.length > 1 && this.startPlace.length < 21) {
        if (this.form.startPlaces.indexOf(this.startPlace) < 0) {
          this.form.startPlaces.push(this.startPlace);
        } else {
          this.$message.error('已经有相同的地址存在了');
        }
        this.startPlace = '';
      } else {
        this.$message.error('长度必须为 2 - 20 个字符');
      }
    },
    startPlaceTagClose(i) {
      this.form.startPlaces.splice(i, 1);
    },
    startPlaceSearch(queryString, cb) {
      const startPlaces = this.startPlaces;
      const results = queryString ?
        startPlaces.filter(s => s.value.indexOf(queryString) >= 0) : startPlaces;
      cb(results);
    },
    addEndPlace() {
      if (this.endPlace.length > 1 && this.endPlace.length < 21) {
        if (this.form.endPlaces.indexOf(this.endPlace) < 0) {
          this.form.endPlaces.push(this.endPlace);
        } else {
          this.$message.error('已经有相同的地址存在了');
        }
        this.endPlace = '';
      } else {
        this.$message.error('长度必须为 2 - 20 个字符');
      }
    },
    endPlaceTagClose(i) {
      this.form.endPlaces.splice(i, 1);
    },
    endPlaceSearch(queryString, cb) {
      const endPlaces = this.endPlaces;
      const results = queryString ?
        endPlaces.filter(s => s.value.indexOf(queryString) >= 0) : endPlaces;
      cb(results);
    },
    close() {
      this.$emit('close');
    },
  },
  watch: {
    chartered(val) {
      this.form = val || {
        title: '',
        description: '',
        limit: 0,
        price: 0,
        startPlaces: [],
        endPlaces: [],
        departureTime: Date.now(),
        checkInTime: [],
      };
    },
  },
  computed: {
    // chartered() {
    //   return this.form || {
    //     title: '',
    //     description: '',
    //     limit: 0,
    //     price: 0,
    //     startPlaces: [],
    //     endPlaces: [],
    //     departureTime: null,
    //     checkInTime: null,
    //   };
    // },
  },
};
</script>

<style lang="scss" scoped>
.short-input {
  max-width: 200px;
}

.tags {
  margin-top: 10px;
  .el-tag {
    margin: 0 10px 10px 0;
  }
}

</style>
