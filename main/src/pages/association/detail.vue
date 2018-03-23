<template>
  <div class="detail common-container" v-loading.fullscreen.lock="!isLoad">
    <div v-if="isLoad">
      <h3>{{association.name}}（地区：{{association.city.name}}）</h3>
      <el-form size="small" label-width="100px">
        <el-form-item label="学校：">
          <span>{{association.school.name}}</span>
        </el-form-item>
        <el-form-item label="名称：">
          <span>{{association.name}}</span>
          <el-input v-model="association.name">
          </el-input>
        </el-form-item>
        <el-form-item label="简介：">
          <span>{{association.description}}</span>
          <el-input autosize type="textarea" v-model="association.description"></el-input>
        </el-form-item>
        <el-form-item label="会长：">
          <span>{{association.chairman.username}}（{{association.chairman.nickname}}）</span>
        </el-form-item>
        <el-form-item label="管理员：">
          <span v-if="!association.managers.length">暂无</span>
          <ul v-else>
            <li v-for="manager in association.managers" :key="manager._id">
              {{manager.username}}（{{manager.nickname}}）
            </li>
          </ul>
        </el-form-item>
        <el-form-item label="创建时间：">
          <span>{{association.createTime | formatDate}}</span>
        </el-form-item>
        <el-form-item>
          <el-button @click="quitAssociation" type="danger">退出同乡会</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import UserService from '../../service/UserService';
import AssociationService from '../../service/AssociationService';

export default {
  name: 'detail',
  mounted() {
    // UserService.getUser().then((res) => {
    AssociationService.getById('city=1&chairman=1&school=1&managers=1')
      .then((res2) => {
        this.association = res2.data;
        console.log(this.association);
        this.isLoad = true;
      });
    // });
  },
  data() {
    return {
      isLoad: false,
      association: null,
    };
  },
  methods: {
    quitAssociation() {
      this.$confirm('您确定要退出同乡会？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(() => {
        UserService.quitAssociation()
          .then(() => {
            this.$message({
              type: 'success',
              message: '退出成功!',
            });
            this.$router.go(0);
          });
      }).catch(() => null);
    },
  },
};
</script>

<style scoped>

</style>
