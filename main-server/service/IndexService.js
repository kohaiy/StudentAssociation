const BaseService = require('./BaseService');
const Province = require('../model/province');
const City = require('../model/city');
const School = require('../model/school');

class IndexService extends BaseService {
    static async initSchools() {
        const provinces = require('../data/provinces').provinces;
        const cities = require('../data/cities').cities;
        const schools = require('../data/shools').schools;
        // 遍历所有省份
        provinces.map(async (province) => {
            let pro = new Province({
                pid: province.pid,
                name: province.name,
            });
            pro = await pro.save();
            // 过滤出当前省份下的所有城市
            let filteredCities = cities.filter((c) => {
                return c.pid === province.pid;
            });
            // 遍历所有城市
            filteredCities.map(async (c) => {
                let cit = new City({
                    pid: pro,
                    cid: c.cid,
                    name: c.name,
                });
                cit = await cit.save();
                // 过滤出当前城市下的所有学校
                let filteredSchools = schools.filter((s) => {
                    return s.cid === c.cid;
                });
                filteredSchools.map(async (s) => {
                    let sch = new School({
                        cid: cit,
                        sid: s.sid,
                        name: s.name,
                    });
                    await sch.save();
                });
            });
        });
    }
}

module.exports = IndexService;