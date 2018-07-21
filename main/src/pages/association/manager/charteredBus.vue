<template>
  <div class="chartered-bus common-container" v-loading.lock="!isLoad">
    <div class="wrapper">
      <div class="actions clearfix">
        <span class="fa fa-bullhorn"></span>包车信息
        <el-button v-if="$store.state.isManager" @click="addDialogVisible = true"
                   icon="fa fa-plus"
                   type="success" size="mini" class="pull-right">发布包车信息
        </el-button>
      </div>
      <div class="bus-list">
        <v-item
          v-for="chartered in chartereds"
          @check-in="checkInChartered(chartered)"
          @edit="clickChartered(chartered)"
          @remove="removeChartered(chartered)"
          @click="$router.push({path: '/association/bus-manager/' + chartered._id})"
          :chartered="chartered"
          :key="chartered._id"/>
        <el-dialog
          title="包车详情"
          size="600px"
          :visible.sync="detailVisible">
          <v-add
            @close="detailVisible = false"
            @success="loadChartereds"
            :chartered="updateChartered" mode="update"/>
        </el-dialog>
      </div>
    </div>
    <div class="wrapper">
      <div class="title no-padding-bottom"><span class="fa fa-ticket"></span>我的订票</div>
      <v-my-ticket/>
    </div>
    <el-dialog
      title="发布包车信息"
      size="600px"
      :visible.sync="addDialogVisible">
      <v-add
        @close="closeAddDialog"
        @success="loadChartereds"
      />
    </el-dialog>
    <el-dialog
      title="包车报名"
      size="600px"
      :visible.sync="checkInDialogVisible">
      <v-check-in
        :chartered="currentChartered"/>
    </el-dialog>
  </div>
</template>

<script>
import CharteredService from '../../../service/CharteredService';
import VItem from './charteredBus/item';
import VAdd from './charteredBus/add';
import VCheckIn from './charteredBus/check-in';
import VMyTicket from './charteredBus/my-ticket';

export default {
  name: 'chartered-bus',
  mounted() {
    this.loadChartereds();
  },
  data() {
    return {
      isLoad: false,
      currentChartered: {},
      chartereds: [],
      detailVisible: false,
      addDialogVisible: false,
      checkInDialogVisible: false,
    };
  },
  methods: {
    checkInChartered(chartered) {
      this.currentChartered = chartered;
      this.checkInDialogVisible = true;
    },
    clickChartered(chartered) {
      this.currentChartered = chartered;
      this.detailVisible = true;
    },
    removeChartered() {
      this.$message.success('删除？');
    },
    loadChartereds() {
      this.isLoad = false;
      CharteredService.getAll()
        .then((res) => {
          this.chartereds = res.data;
          this.isLoad = true;
        });
    },
    closeAddDialog() {
      console.log('--------------');
      this.addDialogVisible = false;
    },
  },
  computed: {
    updateChartered() {
      return { ...this.currentChartered };
    },
  },
  components: {
    VItem,
    VAdd,
    VCheckIn,
    VMyTicket,
  },
};
</script>

<style lang="scss" scoped>
.chartered-bus {
  .actions {
    margin-bottom: 10px;
    font-size: 14px;
  }
  .wrapper {
    margin-bottom: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
    > .title {
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 1px solid #eeeeee;
      font-size: 14px;
    }
    > .no-padding-bottom {
      margin-bottom: 0;
    }
  }
}
</style>
