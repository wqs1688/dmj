<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2099 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://opensource.org/licenses/mit-license.php )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\index\controller;

use think\facade\Hook;
use app\service\SystemBaseService;
use app\service\GoodsService;
use app\service\UserService;
use app\service\UserAddressService;
use app\service\PaymentService;
use app\service\BuyService;
use app\service\SeoService;

/**
 * 购买
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Buy extends Common
{
    /**
     * 构造方法
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-11-30
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }
    
    /**
     * [Index 首页]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-02-22T16:50:32+0800
     */
    public function Index()
    {
        if($this->data_post)
        {
            session('buy_post_data', $this->data_post);
            return redirect(MyUrl('index/buy/index'));
        } else {
            // 站点类型，是否开启了展示型
            if(SystemBaseService::SiteTypeValue() == 1)
            {
                $this->assign('msg', '展示型不允许提交订单');
                return $this->fetch('public/tips_error');
            }

            // 获取下单信息
            $data = session('buy_post_data');
            if(empty($data))
            {
                $this->assign('msg', '商品信息为空');
                return $this->fetch('public/tips_error');
            }

            // 参数
            $params = array_merge($this->data_request, $data);
            $params['user'] = $this->user;
            $buy_ret = BuyService::BuyTypeGoodsList($params);

            // 商品校验
            if(isset($buy_ret['code']) && $buy_ret['code'] == 0)
            {
                // 基础信息
                $buy_base = $buy_ret['data']['base'];
                $buy_goods = $buy_ret['data']['goods'];

                // 判断用户积分是否充足
                $params['user']['integral_empty'] = false;
                if($params['user']['integral'] < $buy_base['actual_price'])
                {
                    $params['user']['integral_empty'] = true;
                }

                // 用户地址
                //$address = UserAddressService::UserAddressList(['user'=>$this->user]);
                //$this->assign('user_address_list', $address['data']);

                // 支付方式
                $this->assign('payment_list', PaymentService::BuyPaymentList(['is_enable'=>1, 'is_open_user'=>1]));

                // 公共销售模式
                $this->assign('common_site_type', $buy_base['common_site_type']);

                // 地址选中处理
                // 防止选中id不存在地址列表中
                // 如果默认没有则表示不存在地址列表中
                if(isset($params['address_id']) && empty($buy_base['address']))
                {
                    unset($params['address_id']);
                }

                // 加载百度地图api
                $this->assign('is_load_baidu_map_api', 1);

                // 钩子
                $this->PluginsHook($buy_ret['data'], $params);

                // 浏览器名称
                $this->assign('home_seo_site_title', SeoService::BrowserSeoTitle('订单确认', 1));

                // 页面数据
                $this->assign('base', $buy_base);
                $this->assign('buy_goods', $buy_goods);
                $this->assign('params', $params);
                return $this->fetch();
            } else {
                $this->assign('msg', isset($ret['msg']) ? $ret['msg'] : '参数错误');
                return $this->fetch('public/tips_error');
            }
        }
    }

    /**
     * 钩子处理
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-08-13
     * @desc    description
     * @param   [array]           $data     [确认数据]
     * @param   [array]           $params   [输入参数]
     */
    private function PluginsHook($data = [], $params = [])
    {
        $hook_arr = [
            // 订单确认页面顶部钩子
            'plugins_view_buy_top',

            // 订单确认页面内部顶部钩子
            'plugins_view_buy_inside_top',

            // 订单确认页面地址底部钩子
            'plugins_view_buy_address_bottom',

            // 订单确认页面支付方式底部钩子
            'plugins_view_buy_payment_bottom',

            // 订单确认页面分组商品底部钩子
            'plugins_view_buy_group_goods_bottom',

            // 订单确认页面用户留言底部钩子
            'plugins_view_buy_user_note_bottom',

            // 订单确认页面订单确认信息顶部钩子
            'plugins_view_buy_base_confirm_top',

            // 订单确认页面提交订单表单内部钩子
            'plugins_view_buy_form_inside',

            // 订单确认页面内部底部钩子
            'plugins_view_buy_inside_bottom',

            // 订单确认页面底部钩子
            'plugins_view_buy_bottom',
        ];
        foreach($hook_arr as $hook_name)
        {
            $this->assign($hook_name.'_data', Hook::listen($hook_name,
                [
                    'hook_name'     => $hook_name,
                    'is_backend'    => false,
                    'data'          => $data,
                    'params'        => $params,
                ]));
        }
    }

    /**
     * 订单添加
     * @author   R
     * @version 1.0.0
     * @date    2021-12-16
     * @desc    description
     */
    public function Add()
    {
        if(input('post.'))
        {
            $params = $this->data_post;
            $params['user'] = $this->user;
            $params['addr_file'] = $_FILES;
 
            if($params['site_model'] == 5)
            {
                // 存入仓库处理
                return self::SaveToWarehouse($params);
            } else {
                if (! empty($params['address']))
                {
                    // 处理收件人信息
                    $ret = UserAddressService::UserAddressSave($params);
                    if($ret['code'] != 0)
                    {
                        return $ret;
                    } elseif(isset($ret['data']['addr_id'])) {
                        $params['address_id'] = $ret['data']['addr_id'];
                    }
                }
                
                // 处理订单
                return BuyService::OrderInsert($params);
            }
        } else {
            $this->assign('msg', '非法访问');
            return $this->fetch('public/tips_error');
        }
    }

    /**
     * 商品存入仓库
     */
    public static function SaveToWarehouse($params=[])
    {
        // TODO...
        return 'TODO...';
    }
}
?>
