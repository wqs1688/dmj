<?php
// +----------------------------------------------------------------------
// | DMJ
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\index\controller;

use app\service\GoodsService;
use app\service\BrandService;
use app\service\RegionService;
use app\service\GoodsPublishService;
use app\service\SeoService;

/**
 * 用户商品发布
 * @author   R
 * @version  0.0.1
 * @datetime 2021-07-08
 */
class UserGoodsPublish extends Common
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
        $total = GoodsPublishService::GoodsPublishTotal($this->form_where);

        // 分页
        $page_params = [
            'number'    =>  $this->page_size,
            'total'     =>  $total,
            'where'     =>  $this->data_request,
            'page'      =>  $this->page,
            'url'       =>  MyUrl('index/usergoodspublish/index'),
        ];
        $page = new \base\Page($page_params);

        // 获取列表
        $data_params = [
            'where'         => $this->form_where,
            'm'             => $page->GetPageStarNumber(),
            'n'             => $this->page_size,
            'order_by'      => $this->form_order_by['data'],
        ];
        $ret = GoodsPublishService::GoodsPublishList($data_params);

        // 浏览器名称
        $this->assign('home_seo_site_title', SeoService::BrowserSeoTitle('商品发布', 1));

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
            // 条件
            $where = [
                ['p.id', '=', intval($this->data_request['id'])],
            ];

            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => $where,
            ];
            $ret = GoodsPublishService::GoodsPublishList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            $this->assign('data', $data);
        }
        
        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);
        return $this->fetch();
    }

    /**
     * 商品发布追加、编辑
     * @author  R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     */
    public function Add()
    {
        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);

        // 编辑
        if(!empty($this->data_request['id']))
        {
            $data_params = [
                'm'                 => 0,
                'n'                 => 1,
                'where'             => [['p.id', '=', intval($this->data_request['id'])]],
                'field'             => 'p.id as pid, g.*',
            ];
            $ret = GoodsPublishService::GoodsPublishList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'];

            // 获取商品编辑规格
            $specifications = GoodsService::GoodsEditSpecifications($data[0]['id']);
            $this->assign('specifications', $specifications);

            // 获取商品详情
            $goods_params = [
                'm'                 => 0,
                'n'                 => 1,
                'where'             => [['is_delete_time', '=', 0],['id', '=', intval($data[0]['id'])]],
                'is_photo'          => 1,
                'is_content_app'    => 1,
                'is_category'       => 1,
            ];
            $data = GoodsService::GoodsDataHandle($data, $goods_params);
            $this->assign('data', $data['data'][0]);
        }
        $user = $this->user;
        $user_id= $user["id"];
        $this->assign('userId',sprintf("%04s",$user_id));

        // 商品分类
        $this->assign('goods_category_list', GoodsService::GoodsCategoryAll());

        return $this->fetch();
    }

    /**
     * [Save 发布商品保存]
     * @author   R
     * @version  1.0.0
     * @datetime 2021-07-08
     */
    public function Save()
    {
        $params = $this->data_post;
        $params['user']         = $this->user;
        $params['is_shelves']   = 2;

        return GoodsPublishService::GoodsPublishSave($params);
    }

    /**
     * 商品分销信息
     * @author  R
     * @version 1.0.0
     * @date    2021-08-10
     * @desc    description
     */
    public function distributeInfo()
    {
        // 参数
        $params = $this->data_request;

        // 数据
        $data = [];
        if(!empty($params['goods_id']))
        {
            $ret = GoodsPublishService::GoodsInventoryData($params);
            $data = empty($ret['data']) ? [] : $ret['data'];
            $data['inventory_sum'] = 0;//array_sum(array_column($data['spec'], 'inventory'));
        }

        // 数据
        $this->assign('data', $data);
        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);

        return $this->fetch();
    }

    /**
     * 商品分销
     * @author  R
     * @version 1.0.0
     * @date    2021-08-10
     * @desc    description
     */
    public function distributeSave()
    {
        // 开始处理
        $params = $this->data_request;
        return GoodsPublishService::GoodsInventorySave($params);
    }

    /**
     * 商品收藏取消
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-13
     * @desc    description
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        $params = $this->data_post;
        $params['user'] = $this->user;
        return GoodsFavorService::GoodsFavorDelete($params);
    }

    public function Checksku(){
        $params = $this->data_post;
        return GoodsPublishService::GoodsSkuCheck($params);
    }

    public function Checktitle(){
        $params = $this->data_post;
        return GoodsPublishService::GoodsTitleCheck($params);
    }
}
?>
