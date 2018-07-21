<template>
  <div class="check-in clearfix">
    <el-form label-width="82px">
      <el-form-item label="包车标题：">{{chartered.title}}</el-form-item>
      <el-form-item label="发布人员：">{{chartered.user.username}}</el-form-item>
      <el-form-item label="发车时间：">{{chartered.departureTime | formatDate}}</el-form-item>
      <el-form-item label="车票单价：">{{chartered.price}}</el-form-item>
      <el-form-item label="人数上限：">{{chartered.limit}}</el-form-item>
      <el-form-item label="报名时间：">
        {{chartered.checkInTime.map(t => moment(t).format('YYYY-MM-DD HH:mm:ss')).join('~')}}
      </el-form-item>
      <el-form-item label="描述信息：">{{chartered.description}}</el-form-item>
      <el-form-item label="联系电话：">
        <el-input v-model.trim="phone"
                  placeholder="手机号码"></el-input>
      </el-form-item>
      <el-form-item label="上车地点：">
        <el-select v-model="startPlace" placeholder="请选择上车地点">
          <el-option
            v-for="item in chartered.startPlaces"
            :key="item"
            :label="item"
            :value="item">
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="下车地点：">
        <el-select v-model="endPlace" placeholder="请选择下车地点">
          <el-option
            v-for="item in chartered.endPlaces"
            :key="item"
            :label="item"
            :value="item">
          </el-option>
        </el-select>
      </el-form-item>
    </el-form>
    <div class="dialog-footer pull-right">
      <el-button>取 消</el-button>
      <el-button @click="doCheckIn" type="primary">
        确认报名
      </el-button>
    </div>
  </div>
</template>

<script>
import TicketService from '../../../../service/TicketService';

export default {
  name: '',
  props: {
    chartered: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      phone: this.$store.state.user.phoneNumber,
      startPlace: '',
      endPlace: '',
    };
  },
  methods: {
    doCheckIn() {
      TicketService.create({
        cid: this.chartered._id,
        phone: this.phone,
        startPlace: this.startPlace,
        endPlace: this.endPlace,
      }).then((res) => {
        console.log(res);
        this.$message.success('订票成功');
      }).catch((err) => {
        this.$message.error(err.message);
      });
    },
  },
};
</script>

<style scoped>

</style>
