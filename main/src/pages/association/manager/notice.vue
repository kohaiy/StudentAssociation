<template>
  <div class="notice">
    <el-table
      :data="noticeData"
      empty-text="暂无公告"
      max-height="300"
      style="width: 100%">
      <el-table-column
        type="index"
        width="50">
      </el-table-column>
      <el-table-column
        class-name="word-not-break-line"
        width="150"
        label="内容">
        <template slot-scope="scope">
          <span :title="scope.row.content">{{scope.row.content}}</span>
        </template>
      </el-table-column>
      <el-table-column
        prop="user.username"
        label="发布者">
      </el-table-column>
      <el-table-column
        label="发布时间"
        width="150">
        <template slot-scope="scope">
          {{scope.row.createTime | formatDate}}
        </template>
      </el-table-column>
      <el-table-column
        fixed="right"
        width="50"
        align="center"
        label="显示">
        <template slot-scope="scope">
          <el-switch
            @change="noticeStatusChange(scope.row)"
            v-model="scope.row.status">
          </el-switch>
        </template>
      </el-table-column>
      <el-table-column
        fixed="right"
        width="100"
        align="center"
        label="操作">
        <template slot-scope="scope">
          <el-button
            @click="removeNotice(scope.row._id)"
            icon="fa fa-trash"
            size="mini"
            type="danger">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <div class="action clearfix">
      <el-button @click="dialogVisible = true"
                 type="success" size="small" icon="fa fa-plus" class="pull-right">发布公告
      </el-button>
      <el-dialog
        title="发布公告"
        :visible.sync="dialogVisible">
        <el-input v-model.trim="noticeContent" type="textarea" placeholder="公告内容"></el-input>
        <el-upload
          action="http://localhost:3000/upload"
          :limit="5"
          :before-upload="beforeImageUpload"
          :on-change="uploadChange"
          list-type="picture">
          <el-button type="text" icon="fa fa-picture-o">图片</el-button>
          最多可上传 5 张图片。
        </el-upload>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="submitNotice">确 定</el-button>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import NoticeService from '../../../service/NoticeService';

export default {
  mounted() {
    NoticeService.getNotices('all=1')
      .then((res) => {
        this.noticeData = res.data;
      });
  },
  data() {
    return {
      noticeData: [],
      noticeContent: '',
      imageList: [],
      dialogVisible: false,
    };
  },
  methods: {
    removeNotice(_id) {
      this.$confirm('此操作将永久删除该公告, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(() => {
        NoticeService.deleteNotice(_id)
          .then(() => {
            this.noticeData = this.noticeData.filter(notice => notice._id !== _id);
            this.$message({
              type: 'success',
              message: '删除成功!',
            });
          });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除',
        });
      });
    },
    submitNotice() {
      if (this.noticeContent) {
        const images = this.imageList.map(img => img.response.data.split('&')[0]);
        NoticeService.createNotice(this.noticeContent, images)
          .then((res) => {
            this.noticeData.unshift(res.data);
            this.dialogVisible = false;
            this.noticeContent = '';
          });
      } else {
        this.$message.error('公告内容不能为空。');
      }
    },
    noticeStatusChange(notice) {
      NoticeService.updateNotice(notice._id, `status=${notice.status ? '1' : ''}`)
        .catch(() => {
          notice.status = !notice.status;
        });
    },
    uploadChange(file, fileList) {
      this.imageList = fileList;
    },
    beforeImageUpload(file) {
      const allowTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
      const isAllowType = allowTypes.indexOf(file.type) > -1;
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isAllowType) {
        this.$message.error('上传图片只能是 JPG/PNG/GIF/ICO 格式!');
      }
      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 2MB!');
      }
      return isAllowType && isLt2M;
    },
  },
};
</script>

<style lang="scss" scoped>
.notice {
  .action {
    margin-top: 10px;
  }
}
</style>
