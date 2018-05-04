<template>
  <div class="add">
    <el-form label-width="100px">
      <el-form-item label="包车标题：">
        <el-input v-model.trim="form.title"></el-input>
      </el-form-item>
      <el-form-item label="报名时间：">
        <el-date-picker
          v-model="form.signTime"
          type="datetimerange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期">
        </el-date-picker>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: '',
  data() {
    return {
      form: {
        title: '',
        maxSeat: 0,
        startPlace: '',
        endPlace: '',
        startTime: Date.now(),
        stopTime: Date.now(),
        signTime: [new Date(), new Date()],
      },
    };
  },
};
</script>

<style scoped>

</style>
