<template>
  <div class="manager common-container">
    <div class="wrapper">
      <div class="actions">
        <el-button @click="$router.go(-1)"
                   icon="fa fa-sign-out" size="mini">返回
        </el-button>
      </div>
      <div class="detail-info">
        <el-form>
          <el-form-item label="包车标题：">{{chartered.title}}</el-form-item>
          <el-form-item label="发布人员：">{{chartered.user && chartered.user.username}}</el-form-item>
          <el-form-item label="发车时间：">{{chartered.departureTime | formatDate}}</el-form-item>
          <el-form-item label="车票单价：">{{chartered.price}}</el-form-item>
          <el-form-item label="人数上限：">{{chartered.limit}}</el-form-item>
          <el-form-item label="报名时间：">
            {{chartered.checkInTime &&
            chartered.checkInTime.map(t => moment(t).format('YYYY-MM-DD HH:mm:ss')).join('~')}}
          </el-form-item>
          <el-form-item label="描述信息：">{{chartered.description}}</el-form-item>
        </el-form>
      </div>
    </div>
    <div class="wrapper">
      <!--操作栏-->
      <div class="actions clearfix">
        <el-button @click="appendTicketsToBus" size="mini">
          批量添加到...
        </el-button>
        <el-badge :value="buses.length" :hidden="!buses.length">
          <el-button @click="busDialogVisible = true" size="mini">车辆信息</el-button>
        </el-badge>
        <el-button
          @click="exportTickets"
          icon="fa fa-download" size="mini" class="pull-right">导出 Excel
        </el-button>
      </div>
      <!--车辆列表-->
      <el-dialog
        title="车辆列表"
        :visible.sync="busDialogVisible"
        size="400px">
        <div class="bus-list">
          <el-card v-for="bus in buses" :key="bus.title" shadow="hover" class="bus-card">
            <div class="clearfix">
              <span>{{bus.title}}</span>
              <el-button @click="removeBus(bus)"
                         type="text" class="detail pull-right">移除
              </el-button>
              <el-button @click="rename(bus)"
                         type="text" class="detail pull-right">重命名
              </el-button>
              <el-button @click="displayBusDetail(bus)"
                         type="text" class="detail pull-right">详情
              </el-button>
            </div>
          </el-card>
          <el-button @click="addBus" type="primary" class="add-btn">添加车辆</el-button>
        </div>
      </el-dialog>
      <!--车辆详情-->
      <el-dialog
        title="车辆详情"
        :visible.sync="busDetailDialogVisible">
        <el-select v-model="currentBus.startPlace"
                   placeholder="上车地点">
          <el-option
            v-for="p in chartered.startPlaces"
            :key="p"
            :label="p"
            :value="p">
          </el-option>
        </el-select>
        <el-select v-model="currentBus.endPlace"
                   placeholder="下车地点">
          <el-option
            v-for="p in chartered.endPlaces"
            :key="p"
            :label="p"
            :value="p">
          </el-option>
        </el-select>
        <el-button
          @click="publishBus"
          icon="fa fa-save" type="success">确认发布车辆
        </el-button>
        <el-table
          @selection-change="handleSelectionChange"
          :data="currentBus.tickets">
          <el-table-column
            type="index"></el-table-column>
          <el-table-column
            label="用户">
            <template slot-scope="scope">
              {{scope.row.user.username}}
            </template>
          </el-table-column>
          <el-table-column
            label="上车地点"
            prop="startPlace">
            <template slot-scope="scope">
              {{scope.row.startPlace}}
            </template>
          </el-table-column>
          <el-table-column
            label="下车地点"
            prop="endPlace">
            <template slot-scope="scope">
              {{scope.row.endPlace}}
            </template>
          </el-table-column>
          <el-table-column
            label="操作">
            <template slot-scope="scope">
              <el-button
                @click="removeTicketFromBus(scope.row)"
                icon="el-icon-delete" type="danger" size="mini">移除
              </el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-dialog>
      <!--添加到车辆-->
      <el-dialog
        title="添加到车辆"
        size="400px"
        :visible.sync="addToBusDialogVisible">
        <div class="bus-list">
          <el-card v-for="bus in buses"
                   :key="bus.title" shadow="hover" class="bus-card">
            <div class="clearfix">
              <span>{{bus.title}}</span>
              <el-button @click="doAppendTicketsToBus(bus)"
                         type="text" class="detail pull-right">选择
              </el-button>
            </div>
          </el-card>
          <el-button @click="addBus" type="primary" class="add-btn">添加车辆</el-button>
        </div>
      </el-dialog>
      <!--订票列表-->
      <div class="tickets">
        <el-table
          @selection-change="handleSelectionChange"
          :data="tickets">
          <el-table-column
            type="selection"
            width="55">
          </el-table-column>
          <el-table-column
            type="index"></el-table-column>
          <el-table-column
            label="用户">
            <template slot-scope="scope">
              {{scope.row.user.username}}
            </template>
          </el-table-column>
          <el-table-column
            label="上车地点"
            prop="startPlace"
            :filters="startPlaceFilters"
            :filter-method="filterStartPlace">
            <template slot-scope="scope">
              {{scope.row.startPlace}}
            </template>
          </el-table-column>
          <el-table-column
            label="下车地点"
            prop="endPlace"
            :filters="endPlaceFilters"
            :filter-method="filterEndPlace">
            <template slot-scope="scope">
              {{scope.row.endPlace}}
            </template>
          </el-table-column>
          <el-table-column
            prop="createTime"
            :formatter="formatDate"
            label="报名时间"
            sortable>
          </el-table-column>
        </el-table>
      </div>
    </div>
  </div>
</template>

<script>
import XLSX from 'xlsx';
import FileSaver from 'file-saver';
import CharteredService from '../../../../../service/CharteredService';
import TicketService from '../../../../../service/TicketService';
import BusService from '../../../../../service/BusService';

export default {
  name: '',
  mounted() {
    this.loadChartered();
  },
  data() {
    return {
      // 当前包车信息
      chartered: {},
      // 包车订票信息
      tickets: [],
      // 选中订票信息
      selectTickets: [],
      // 车辆信息
      buses: [{
        title: '默认车辆',
        tickets: [],
        startPlace: '',
        endPlace: '',
      }],
      currentBus: {},
      busDialogVisible: false,
      busDetailDialogVisible: false,
      addToBusDialogVisible: false,
      ai: 1,
    };
  },
  methods: {
    publishBus() {
      const bus = this.currentBus;
      if (!bus.startPlace) {
        this.$message.error('上车地点不能为空');
      } else if (!bus.endPlace) {
        this.$message.error('下车地点不能为空');
      } else if (bus.tickets.length < 1) {
        this.$message.error('当前车辆中没有订票信息');
      } else {
        BusService.create(bus)
          .then((res) => {
            console.log(res);
          });
      }
    },
    loadChartered() {
      CharteredService.getById(this.$route.params.id)
        .then((res) => {
          if (res.data) {
            this.chartered = res.data;
            this.loadTickets();
          } else {
            this.$message.error('参数错误');
            this.$router.replace('/association/bus-center');
          }
        })
        .catch((err) => {
          this.$message.error(err && err.message);
          this.$router.replace('/association/bus-center');
        });
    },
    loadTickets() {
      TicketService.get(`chartered=${this.chartered._id}`)
        .then((res) => {
          this.tickets = res.data;
        });
    },
    appendTicketsToBus() {
      if (this.selectTickets.length > 0) {
        this.addToBusDialogVisible = true;
      } else {
        this.$message.error('当前未选中任何订票信息');
      }
    },
    doAppendTicketsToBus(bus) {
      bus.tickets = bus.tickets.concat(this.selectTickets);
      // 过滤掉已经添加到车辆中的订票信息
      this.selectTickets.forEach((t) => {
        this.tickets = this.tickets.filter(t1 => t !== t1);
      });
      this.addToBusDialogVisible = false;
      this.$message.success(`成功添加到[${bus.title}]`);
    },
    removeTicketFromBus(ticket) {
      this.currentBus.tickets.splice(this.currentBus.tickets.indexOf(ticket), 1);
      this.tickets.push(ticket);
    },
    displayBusDetail(bus) {
      this.currentBus = bus;
      this.busDetailDialogVisible = true;
    },
    addBus() {
      this.$prompt('请输入包车标题', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputPattern: /.+/,
        inputErrorMessage: '不能为空',
      }).then(({ value }) => {
        if (this.buses.filter(b => b.title === value).length > 0) {
          this.$message.error('标题已经重复了');
        } else {
          this.buses.unshift({
            title: value,
            tickets: [],
            startPlace: '',
            endPlace: '',
          });
        }
      }).catch(() => {
      });
    },
    removeBus(bus) {
      this.buses.splice(this.buses.indexOf(bus), 1);
      this.tickets = this.tickets.concat(bus.tickets);
    },
    rename(bus) {
      this.$prompt('请输入包车标题', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputPattern: /.+/,
        inputValue: bus.title,
        inputErrorMessage: '不能为空',
      }).then(({ value }) => {
        if (this.buses.filter(b => b.title === value).length > 0) {
          this.$message.error('标题已经重复了');
        } else {
          bus.title = value;
        }
      }).catch(() => {
      });
    },
    exportTickets() {
      const workbook = XLSX.utils.book_new();
      const data = this.tickets.map((t) => {
        const res = {
          用户: t.user.username,
          上车地点: t.startPlace,
          下车地点: t.endPlace,
          手机号码: t.phone,
          登记时间: this.moment(t.createTime).format('YYYY年MM月DD日 HH:mm:ss'),
        };
        return res;
      });
      const worksheet = XLSX.utils.json_to_sheet(data);
      XLSX.utils.book_append_sheet(workbook, worksheet, '订票列表');
      const workbookOut = XLSX.write(workbook, { bookType: 'xlsx', bookSST: true, type: 'array' });
      try {
        FileSaver.saveAs(new Blob([workbookOut], { type: 'application/octet-stream' }),
          `${this.chartered.title}-订票列表-${this.moment().format('YYYYMMDDHHmmss')}.xlsx`,
        );
      } catch (e) {
        console.log(e);
        this.$message.error('导出订票列表失败，请稍后重试');
      }
    },
    filterStartPlace(value, row) {
      return row.startPlace === value;
    },
    filterEndPlace(value, row) {
      return row.endPlace === value;
    },
    formatDate(row) {
      return this.moment(row.createTime).format('YYYY-MM-DD HH:mm:ss');
    },
    handleSelectionChange(rows) {
      this.selectTickets = rows;
    },
  },
  computed: {
    startPlaceFilters() {
      if (!this.chartered.startPlaces) {
        return [];
      }
      return this.chartered.startPlaces.map(p => ({ text: p, value: p }));
    },
    endPlaceFilters() {
      if (!this.chartered.endPlaces) {
        return [];
      }
      return this.chartered.endPlaces.map(p => ({ text: p, value: p }));
    },
  },
};
</script>

<style lang="scss" scoped>
.manager {
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

.bus-list {
  .add-btn {
    width: 100%;
    margin-top: 5px;
  }
  .bus-card {
    margin-bottom: 10px;
    &:hover {
      .detail {
        opacity: 1;
      }
    }
    .detail {
      opacity: 0;
      margin-left: 5px;
      padding: 3px 0;
      transition: opacity .3s;
    }
  }
}
</style>
