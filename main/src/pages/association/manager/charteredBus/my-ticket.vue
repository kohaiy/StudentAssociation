<template>
  <div class="">
    <el-table
      :data="tickets">
      <el-table-column
        label="包车内容">
        <template slot-scope="scope">
          <span>{{ scope.row.chartered.title }}</span>
        </template>
      </el-table-column>
      <el-table-column
        label="登记手机"
        prop="phone"></el-table-column>
      <el-table-column
        label="上车地点"
        prop="startPlace"></el-table-column>
      <el-table-column
        label="下车地点"
        prop="endPlace"></el-table-column>
      <el-table-column
        label="操作">
        <template slot-scope="scope">
          <template v-if="!scope.row.bus">
            <el-button icon="fa fa-edit" type="text" size="mini">编辑</el-button>
            <el-button
              @click="cancelTicket(scope.row._id)"
              icon="fa fa-chain-broken" type="text" size="mini">退票
            </el-button>
          </template>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import TicketService from '../../../../service/TicketService';

export default {
  name: '',
  mounted() {
    this.loadTickets();
  },
  data() {
    return {
      tickets: [],
    };
  },
  methods: {
    loadTickets() {
      TicketService.get('me=1')
        .then((res) => {
          this.tickets = res.data;
        });
    },
    cancelTicket(id) {
      this.$confirm('确定要取消该订票信息吗?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(() => {
        TicketService.delete(id)
          .then(() => {
            this.$message.success('退票成功');
            this.loadTickets();
          });
      }).catch(() => {
      });
    },
  },
};
</script>

<style scoped>

</style>
