<template>
  <div class="chartered-bus common-container" v-loading.lock="!isLoad">
    <div class="wrapper">
      <div class="actions clearfix">
        <el-button @click="addDialogVisible = true"
                   icon="fa fa-plus"
                   type="success" size="mini" class="pull-right">发布包车信息
        </el-button>
      </div>
      <div class="bus-list">
        <v-item v-for="i in 5" :key="i"/>
      </div>
    </div>
    <el-dialog
      title="发布包车信息"
      size="600px"
      :visible.sync="addDialogVisible">
      <v-add/>
    </el-dialog>
  </div>
</template>

<script>
import VItem from './charteredBus/item';
import VAdd from './charteredBus/add';

export default {
  name: 'chartered-bus',
  mounted() {
    this.isLoad = true;
  },
  data() {
    return {
      isLoad: false,
      addDialogVisible: false,
    };
  },
  components: {
    VItem,
    VAdd,
  },
};
</script>

<style lang="scss" scoped>
.chartered-bus {
  .actions {
    margin-bottom: 10px;
  }
  .wrapper {
    margin-bottom: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px 0 rgba(121, 146, 185, .54);
    border-radius: 4px;
    background-color: #fff;
  }
}
</style>
