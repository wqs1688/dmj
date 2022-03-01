<?php
// +----------------------------------------------------------------------
// | Admin 入库管理
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\facade\Hook;
use app\service\WarehouseGoodsService;
use app\service\WarehouseService;
use app\service\GoodsService;
use app\service\UserWarehouseService;
use app\service\ExpressService;

/**
 * 商品入库管理
 * @author  R
 * @version 1.0.0
 * @date    2021-07-22
 * @desc    description
 */
class Inbound extends Common
{
    /**
     * 构造方法
     * @author  R
     * @version 1.0.0
     * @date    2020-07-22
     * @desc    description
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 登录校验
        $this->IsLogin();

        // 权限校验
        $this->IsPower();
    }

    /**
     * 列表
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     */
    public function Index()
    {
        $admin = $this->admin;//var_dump($this->form_where);
        $where = $this->form_where;
        if($admin['role_id'] != 1){
            $where[] =['u.warehouse_id','in',[$admin['warehouse_id']]];
        }
        $this->form_where = $where;
        // 总数
        //array_push($this->form_where ,$where);
        //var_dump($this->form_where);
        $total = UserWarehouseService::UserWarehouseTotal($this->form_where);

        // 分页
        $page_params = [
            'number'    =>  $this->page_size,
            'total'     =>  $total,
            'where'     =>  $this->data_request,
            'page'      =>  $this->page,
            'url'       =>  MyUrl('admin/inbound/index'),
        ];
        $page = new \base\Page($page_params);

        // 获取数据列表
        $data_params = [
            'where'         => $this->form_where,
            'm'             => $page->GetPageStarNumber(),
            'n'             => $this->page_size,
            'order_by'      => $this->form_order_by['data'],
        ];
        $ret = UserWarehouseService::UserWarehouseList($data_params);
        // 有效仓库列表
        $data_params = [
            'field'     => 'id,name',
            'where'     => [
                'is_enable'         => 1,
                'is_delete_time'    => 0,
            ],
        ];
        $warehouse = WarehouseService::WarehouseList($data_params);
        $this->assign('warehouse_list', $warehouse['data']);

        // 商品分类
        $this->assign('goods_category_list', GoodsService::GoodsCategoryAll());

        // 基础参数赋值
        $this->assign('params', $this->data_request);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $ret['data']);
        return $this->fetch();
    }

    /**
     * 详情
     * @author   R
     * @version  1.0.0
     * @date     2020-08-05
     */
    public function Detail()
    {
        if (!empty($params = $this->data_request['id']))
        {
            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => [['w.id', '=', intval($this->data_request['id'])]],
                'is_handle'     => 0,
            ];
            $ret = UserWarehouseService::UserWarehouseList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            // 箱子外包装信息
            $boxs = UserWarehouseService::UserWarehouseBox($data["put_id"]);
            $data['boxs'] = $boxs['data'];
            foreach($data["boxs"] as $val){
                //箱子内物品信息
                $details = UserWarehouseService::UserWarehouseBoxDetail($val["box_id"]);
                foreach($details['data'] as $key => $value){
                    $param["goods_id"]= $value['good_id'];
                    $speclist = UserWarehouseService::GoodsGetSpecVal($param);
                    $details['data'][$key]["speclist"] = $speclist["data"];
                }
                $data["details"][$val["box_id"]] = $details['data'];
            }
            $this->assign('info', $data);
         
        }

        $expressName = ExpressService::ExpressName($data["express_id"]);
        $this->assign('expressName', $expressName);
        // 入库状态
        $status = lang('common_warehouse_status_list');
        
        $this->assign('status', $status);

        return $this->fetch();
    }

    /**
     * 编辑页面
     * @author  R
     * @version 1.0.0
     * @date    2021-08-04
     * @desc    description
     */
    public function CheckInfo()
    {
        // 参数
        if (!empty($params = $this->data_request['id']))
        {
            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => [['w.id', '=', intval($this->data_request['id'])]],
                'is_handle'     => 0,
            ];
            $ret = UserWarehouseService::UserWarehouseList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            // 箱子外包装信息
            $boxs = UserWarehouseService::UserWarehouseBox($data["put_id"]);
            $data['boxs'] = $boxs['data'];
            foreach($data["boxs"] as $val){
                //箱子内物品信息
                $details = UserWarehouseService::UserWarehouseBoxDetail($val["box_id"]);
                foreach($details['data'] as $key => $value){
                    $param["goods_id"]= $value['good_id'];
                    $speclist = UserWarehouseService::GoodsGetSpecVal($param);
                    $details['data'][$key]["speclist"] = $speclist["data"];
                }
                $data["details"][$val["box_id"]] = $details['data'];
            }
            $this->assign('info', $data);
         
        }

        // 快递列表
        $expresslist = ExpressService::ExpressList();
        $this->assign('expresslist',$expresslist);
        // 入库状态
        $status = lang('common_warehouse_status_list');
        $this->assign('status', $status);

        return $this->fetch();
    }
    
    /**
     * 入库
     * @author  H
     * @version 1.0.0
     * @date    2021-11-23
     * @desc    description
     */
    public function Warehouse()
    {
        if (!empty($params = $this->data_request['id']))
        {
            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => [['w.id', '=', intval($this->data_request['id'])]],
                'is_handle'     => 0,
            ];
            $ret = UserWarehouseService::UserWarehouseList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            // 箱子外包装信息
            $boxs = UserWarehouseService::UserWarehouseBox($data["put_id"]);
            $data['boxs'] = $boxs['data'];
            foreach($data["boxs"] as $val){
                //箱子内物品信息
                $details = UserWarehouseService::UserWarehouseBoxDetail($val["box_id"]);
                foreach($details['data'] as $key => $value){
                    $param["goods_id"]= $value['good_id'];
                    $speclist = UserWarehouseService::GoodsGetSpecVal($param);
                    $details['data'][$key]["speclist"] = $speclist["data"];
                }
                $data["details"][$val["box_id"]] = $details['data'];
            }
            $this->assign('info', $data);
         
        }

        return $this->fetch();
    }

    /**
     * 编辑
     * @author  R
     * @version 1.0.0
     * @date    2021-08-05
     * @desc    description
     */
    public function CheckSave()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = $this->data_request;
        $params['warehouse_id'] = 2;
        $params['admin'] = $this->admin;

        return UserWarehouseService::UserWarehouseCheck($params);
    }

    /**
     * 删除
     * @author  R
     * @version 1.0.0
     * @date    2021-08-05
     * @desc    description
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = $this->data_request;
        $params['admin'] = $this->admin;
        return UserWarehouseService::UserWarehouseDelete($params);
    }
    
    /**
     * 在库保存
     * @author  R
     * @version 1.0.0
     * @date    2021-11-23
     * @desc    description
     */
    public function WarehouseSave()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        $admin = $this->admin;
        // 开始处理
        $params = $this->data_request;
        $params['warehouse_id'] = $admin['warehouse_id'];
        $params['admin'] = $admin;

        return WarehouseGoodsService::GoodInventorySave($params);
    }

}
?>
