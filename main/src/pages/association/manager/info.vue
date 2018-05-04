<template>
  <div class="info" v-loading.lock="!isLoad">
    <el-form label-width="82px">
      <el-form-item label="名称：">
        <el-input
          v-model.trim="name"
          @change="changeName"
          placeholder="同乡会名称"></el-input>
      </el-form-item>
      <el-form-item label="简介：">
        <el-input
          v-model.trim="description"
          @change="changeDescription"
          type="textarea" placeholder="同乡会简介"></el-input>
      </el-form-item>
      <el-form-item label="欢迎词：">
        <el-input
          v-model.trim="joinMsg"
          @change="changeJoinMsg"
          type="textarea" placeholder="同乡会欢迎词"></el-input>
      </el-form-item>
      <el-form-item label="公开可见：">
        <el-checkbox @change="changeOpen" v-model="open">公开</el-checkbox>
        <span class="text-danger">
          （公开时，用户可直接看到本同乡会；否则只能通过<el-button type="text" v-popover:popover>同乡会ID</el-button>查找）
        </span>
        <el-popover
          ref="popover"
          placement="top"
          width="160"
          trigger="hover"
          :content="id">
        </el-popover>
      </el-form-item>
      <el-form-item label="常用地址：">
        <el-select v-model="address" placeholder="同乡会常用地址">
          <el-option
            v-for="item in addresses"
            :key="item"
            :label="item"
            :value="item">
          </el-option>
        </el-select>
        <el-button @click="removeAddress" type="danger" circle title="删除一个地址">
          <span class="fa fa-minus"></span>
        </el-button>
        <el-button @click="addAddress" type="success" circle title="添加一个地址">
          <span class="fa fa-plus"></span>
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import AssociationService from '../../../service/AssociationService';

export default {
  name: 'info',
  mounted() {
    AssociationService.getById()
      .then((res) => {
        this.id = res.data._id;
        this.name = res.data.name;
        this.description = res.data.description;
        this.joinMsg = res.data.joinMsg;
        this.open = res.data.open;
        this.addresses = res.data.addresses;
        setTimeout(() => {
          this.isLoad = true;
        }, this.$loadingDelayTime);
      });
  },
  data() {
    return {
      isLoad: false,
      id: '',
      name: '',
      description: '',
      joinMsg: '',
      open: false,
      address: '',
      addresses: [],
    };
  },
  methods: {
    changeName() {
      AssociationService.updateInfo({ name: this.name })
        .then(() => {
          this.$message.success('更新同乡会名称成功');
        });
    },
    changeDescription() {
      AssociationService.updateInfo({ description: this.description })
        .then(() => {
          this.$message.success('更新同乡会简介成功');
        });
    },
    changeJoinMsg() {
      AssociationService.updateInfo({ joinMsg: this.joinMsg })
        .then(() => {
          this.$message.success('更新同乡会欢迎词成功');
        });
    },
    changeOpen() {
      AssociationService.updateInfo({ open: this.open })
        .then(() => {
          this.$message.success('更新同乡会是否公开成功');
        });
    },
    addAddress() {
      this.$prompt('请输入常用地址：', '添加地址', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputPattern: /^\s*.{2,50}\s*$/,
        inputErrorMessage: '地址长度为 2 - 50 字符',
      }).then(({ value = '' }) => {
        const address = value.trim();
        AssociationService.updateInfo({
          address,
        }).then(() => {
          this.addresses.unshift(address);
          this.$message.success('添加常用地址成功');
        });
      }).catch(() => null);
    },
    removeAddress() {
      if (this.address) {
        this.$confirm(`是否删除地址: ${this.address}?`, '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
        }).then(() => {
          AssociationService.updateInfo({
            '-address': this.address,
          }).then(() => {
            this.addresses.splice(this.addresses.indexOf(this.address), 1);
            this.address = '';
            this.$message.success('删除常用地址成功');
          });
        }).catch(() => null);
      } else {
        this.$message.error('请先从左侧选择一个地址');
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.info {
  .fa {
    margin-right: 0;
  }
}
</style>
