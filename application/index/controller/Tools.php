<?php
namespace app\index\controller;

use app\index\model\City as CityM;
use app\index\model\Province as ProvinceM;
use app\index\model\School as SchoolM;

class Tools extends BaseController
{

    public function get()
    {
        if (request()->param('a') !== null) {
            switch (request()->param('a')) {
                case 'province':
                    $provinceM = new ProvinceM;
                    $list      = $provinceM->order('pname asc')->select();
                    return json($list);
                    break;
                case 'city':
                    $cityM = new CityM;
                    $list  = $cityM->getCityListByPid(request()->param('pid'));
                    if ($list === false) {
                        return json(['code' => 1, 'result' => $cityM->error]);
                    }
                    return json(['code' => 0, 'result' => $list]);
                    break;
                case 'school':
                    $schoolM = new SchoolM;
                    $list    = $schoolM->getSchoolListByCid(request()->param('cid'));
                    if ($list === false) {
                        return json(['code' => 1, 'result' => $schoolM->error]);
                    }
                    return json(['code' => 0, 'result' => $list]);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
