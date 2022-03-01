<?php
// +----------------------------------------------------------------------
// | DMJ
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\index\controller;

use app\service\GoodsService;
use app\service\UserWarehouseService;
use app\service\GoodsPublishService;
use app\service\SeoService;
use app\service\ExpressService;

/**
 * 用户入库申请
 * @author   R
 * @version  0.0.1
 * @datetime 2021-07-08
 */
class Userwarehouse extends Common
{
    /**
     * 构造方法
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }
    
    /**
     * 列表
     * @author  R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     */
    public function Index()
    {
        // 总数
        $total = UserWarehouseService::UserWarehouseTotal($this->form_where);

        // 分页
        $page_params = [
            'number'    =>  $this->page_size,
            'total'     =>  $total,
            'where'     =>  $this->data_request,
            'page'      =>  $this->page,
            'url'       =>  MyUrl('index/userwarehouse/index'),
        ];
        $page = new \base\Page($page_params);

        // 获取列表
        $data_params = [
            'where'         => $this->form_where,
            'm'             => $page->GetPageStarNumber(),
            'n'             => $this->page_size,
            'order_by'      => $this->form_order_by['data'],
        ];
        $ret = UserWarehouseService::UserWarehouseList($data_params);

        // 浏览器名称
        $this->assign('home_seo_site_title', SeoService::BrowserSeoTitle('商品入库', 1));

        // 基础参数赋值
        $this->assign('params', $this->data_request);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $ret['data']);
        return $this->fetch();
    }

    /**
     * 详情
     * @author  R
     * @version 1.0.0
     * @date    2021-07-11
     * @desc    description
     */
    public function Detail()
    {
        if(!empty($this->data_request['id']))
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
            $this->assign('info', $data);
            
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
            if($ret['code'] == 0)
            {
                $this->assign('data', $data);
            }
        // 添加
            $expressName = ExpressService::ExpressName($data["express_id"]);
            $this->assign('expressName',$expressName);
        }

        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);
        return $this->fetch();
    }

    /**
     * 商品入库追加、编辑
     * @author  R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     */
    public function Add()
    {
        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);
        $this->assign('params', $this->data_request);

        // 编辑
        if (!empty($this->data_request['id']))
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
            $this->assign('info', $data);
            
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
            if($ret['code'] == 0)
            {
                $this->assign('data', $data);
            }
        // 添加
            $expressName = ExpressService::ExpressName($data["express_id"]);
            $this->assign('expressName',$expressName);
        } 
            // 发布的商品
        $where = [
            ['p.user_id', '=', $this->user['id']],
            ['g.is_shelves', '=', 1],
        ];
        $data_params = [
            'field' => 'p.*, g.title, g.images, g.is_shelves',
            'where' => $where,
        ];
        $this->assign('goods_publish_list', GoodsPublishService::GoodsPublishAll($data_params));

        return $this->fetch();  
    }

    /**
     * [Save 商品入库信息保存]
     * @author   R
     * @version  1.0.0
     * @datetime 2021-07-08
     */
    public function Save()
    {
        $params = $this->data_post;
        $user   = $this->user;
        $params['warehouse_id'] = $user['warehouse_id'];
        $params['status'] = 0;
        $params['user'] = $user;
        
        return UserWarehouseService::UserWarehouseSave($params);
    }

    /**
     * 商品规格搜索
     * @author  R
     * @version 1.0.0
     * @date    2021-07-20
     * @desc    description
     */
    public function GoodsSpecSearch()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 搜索数据
        $ret = UserWarehouseService::UserWarehouseInventoryData($this->data_request);
        if($ret['code'] == 0)
        {
            $data = [];
            foreach($ret['data']['spec'] as $v)
            {
                $v['inventory'] = '';
                $data[] = $v;
            }

            $this->assign('data', $data);
            $ret['data']['data'] = $this->fetch();
        }
        return $ret;
    }

    public function GetSkuVal(){
        $params = $this->data_post;
        return UserWarehouseService::GoodsGetSpecVal($params); 
    }
}
?>
