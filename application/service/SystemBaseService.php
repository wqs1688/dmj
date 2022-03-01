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
namespace app\service;

use think\Db;
use think\facade\Hook;
use app\service\ResourcesService;
use app\service\QuickNavService;
use app\service\PluginsService;
use app\service\ConfigService;

/**
 * 系统基础公共信息服务层
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-09-12
 * @desc    description
 */
class SystemBaseService
{
    // 商品优惠使用记录key
    public static $plugins_goods_discount_record_key = 'plugins_use_goods_discount_record_';

    /**
     * 公共配置信息
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-09-12
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function Common($params = [])
    {
        // 配置信息
        $config = [
            // 基础
            'common_site_type'                  => self::SiteTypeValue(),
            'common_shop_notice'                => MyC('common_shop_notice', null, true),

            // 协议、注册协议、隐私协议
            'agreement_userregister_url'        => MyUrl('index/agreement/index', ['document'=>'userregister', 'is_content'=>1]),
            'agreement_userprivacy_url'         => MyUrl('index/agreement/index', ['document'=>'userprivacy', 'is_content'=>1]),

            // 手机端相关配置
            'common_app_is_enable_search'       => (int) MyC('common_app_is_enable_search', 1),
            'common_app_is_enable_answer'       => (int) MyC('common_app_is_enable_answer', 1),
            'common_app_is_header_nav_fixed'    => (int) MyC('common_app_is_header_nav_fixed', 0),
            'common_app_is_online_service'      => (int) MyC('common_app_is_online_service', 0),
            'common_app_customer_service_tel'   => MyC('common_app_customer_service_tel', null, true),

            // 扩展项-留言、问答
            'common_is_login_answer'                => (int) MyC('common_is_login_answer', 0, true),

            // 扩展项-订单
            'common_order_close_limit_time'         => (int) MyC('common_order_close_limit_time', 30, true),
            'common_order_success_limit_time'       => (int) MyC('common_order_success_limit_time', 21600, true),
            'common_pay_log_order_close_limit_time' => (int) MyC('common_pay_log_order_close_limit_time', 30, true),

            // 扩展项-CDN
            'common_cdn_attachment_host'        => MyC('common_cdn_attachment_host', null, true),
            'common_cdn_public_host'            => MyC('common_cdn_public_host', null, true),

            // 验证码
            'common_verify_expire_time'         => (int) MyC('common_verify_expire_time', 600, true),
            'common_verify_interval_time'       => (int) MyC('common_verify_interval_time', 60, true),
            'common_img_verify_state'           => (int) MyC('common_img_verify_state', 0, true),

            // 密码找回
            'home_site_user_forgetpwd_ad_images'=> self::SiteAdConfigImagesMgerge('home_site_user_forgetpwd'),

            // 用户登录
            'home_user_login_type'              => MyC('home_user_login_type', [], true),
            'home_user_login_img_verify_state'  => (int) MyC('home_user_login_img_verify_state', 0, true),
            'home_site_user_login_ad_images'    => self::SiteAdConfigImagesMgerge('home_site_user_login'),

            // 注册
            'home_user_reg_type'                    => MyC('home_user_reg_type', [], true),
            'home_user_register_img_verify_state'   => (int) MyC('home_user_register_img_verify_state', 0, true),
            'common_register_is_enable_audit'       => (int) MyC('common_register_is_enable_audit', 0, true),
            'home_is_enable_userregister_agreement' => (int) MyC('home_is_enable_userregister_agreement', 0, true),
            'home_site_user_register_bg_images'     => ResourcesService::AttachmentPathViewHandle(MyC('home_site_user_register_bg_images')),

            // 用户帐号绑定
            'common_user_is_onekey_bind_mobile'     => (int) MyC('common_user_is_onekey_bind_mobile', 0),
            'common_user_is_mandatory_bind_mobile'  => (int) MyC('common_user_is_mandatory_bind_mobile', 0),

            // 站点信息
            'home_site_name'                    => MyC('home_site_name', null, true),
            'home_site_logo'                    => ResourcesService::AttachmentPathViewHandle(MyC('home_site_logo')),
            'home_site_logo_wap'                => ResourcesService::AttachmentPathViewHandle(MyC('home_site_logo_wap')),
            'home_site_desktop_icon'            => ResourcesService::AttachmentPathViewHandle(MyC('home_site_desktop_icon')),
            'home_site_state'                   => (int) MyC('home_site_state', 0, true),
            'home_site_close_reason'            => MyC('home_site_close_reason', null, true),

            // 备案信息
            'home_site_icp'                     => MyC('home_site_icp', null, true),
            'home_site_security_record_name'    => MyC('home_site_security_record_name', null, true),
            'home_site_security_record_url'     => MyC('home_site_security_record_url', null, true),

            // css/js版本值
            'home_static_cache_version'         => MyC('home_static_cache_version', null, true),

            // 底部代码
            'home_footer_info'                  => MyC('home_footer_info', null, true),

            // 首页设置参数
            'home_index_banner_left_status'     => (int) MyC('home_index_banner_left_status', 1),
            'home_index_banner_right_status'    => (int) MyC('home_index_banner_right_status', 1),

            // 搜索相关
            'home_search_limit_number'          => (int) MyC('home_search_limit_number', 20, true),
            'home_search_is_brand'              => (int) MyC('home_search_is_brand', 1),
            'home_search_is_category'           => (int) MyC('home_search_is_category', 1),
            'home_search_is_price'              => (int) MyC('home_search_is_price', 1),
            'home_search_is_params'             => (int) MyC('home_search_is_params', 1),
            'home_search_is_spec'               => (int) MyC('home_search_is_spec', 1),

            // 站点设置-扩展-基础
            'home_index_friendship_link_status' => (int) MyC('home_index_friendship_link_status', 0, true),
            'home_header_top_is_home'           => (int) MyC('home_header_top_is_home', 1),

            // 站点设置-扩展-快捷导航
            'home_navigation_main_quick_status' => (int) MyC('home_navigation_main_quick_status', 0),
            'home_navigation_main_quick_name'   => MyC('home_navigation_main_quick_name', '百宝箱', true),

            // 站点设置-扩展-用户地址
            'home_user_address_map_status'      => (int) MyC('home_user_address_map_status', 0),
            'home_user_address_idcard_status'   => (int) MyC('home_user_address_idcard_status', 0),
            'home_extraction_address_position'  => (int) MyC('home_extraction_address_position', 0),

            // 订单相关
            'home_is_enable_order_bulk_pay'     => (int) MyC('home_is_enable_order_bulk_pay', 0),
            'common_order_is_booking'           => (int) MyC('common_order_is_booking'),

            // 用户中心相关
            'common_user_center_notice'         => MyC('common_user_center_notice', null, true),
            'common_app_is_head_vice_nav'       => (int) MyC('common_app_is_head_vice_nav', 0),

            // 商品分类相关
            'category_show_level'               => MyC('common_show_goods_category_level', 3, true),

            // 商品相关
            'common_app_is_use_mobile_detail'   => (int) MyC('common_app_is_use_mobile_detail'),
            'common_app_is_good_thing'          => (int) MyC('common_app_is_good_thing'),
            'common_app_is_poster_share'        => (int) MyC('common_app_is_poster_share'),
            'common_is_goods_detail_show_photo' => (int) MyC('common_is_goods_detail_show_photo', 0, true),
            'common_is_exhibition_mode_btn_text'=> MyC('common_is_exhibition_mode_btn_text', '立即咨询', true),

            // 百度地图密钥
            'common_baidu_map_ak'               => MyC('common_baidu_map_ak', null, true),

            // 商店信息
            'common_customer_store_tel'         => MyC('common_customer_store_tel', null, true),
            'common_customer_store_email'       => MyC('common_customer_store_email', null, true),
            'common_customer_store_address'     => MyC('common_customer_store_address', null, true),
            'common_customer_store_qrcode'      => ResourcesService::AttachmentPathViewHandle(MyC('common_customer_store_qrcode')),

            // SEO信息
            'home_seo_site_title'               => MyC('home_seo_site_title', null, true),
            'home_seo_site_keywords'            => MyC('home_seo_site_keywords', null, true),
            'home_seo_site_description'         => MyC('home_seo_site_description', null, true),
            
        ];

        // 支付宝小程序在线客服
        if(APPLICATION_CLIENT_TYPE == 'alipay')
        {
            $config['common_app_mini_alipay_tnt_inst_id'] = MyC('common_app_mini_alipay_tnt_inst_id', null, true);
            $config['common_app_mini_alipay_scene'] = MyC('common_app_mini_alipay_scene', null, true);
        }

        // 数据集合
        $data = [
            // 全局状态值(1接口执行成功,用于前端校验接口请求完成状态,以后再加入其它状态)
            'status'            => 1,

            // 配置信息
            'config'            => $config,

            // 货币符号
            'currency_symbol'   => ResourcesService::CurrencyDataSymbol(),

            // 快捷入口信息
            'quick_nav'         => QuickNavService::QuickNav(),

            // 插件配置信息
            'plugins_base'      => PluginsService::PluginsBaseList(),
        ];

        // 公共配置信息钩子
        $hook_name = 'plugins_service_base_commin';
        Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'data'          => &$data,
            'params'        => $params,
        ]);

        return DataReturn('success', 0, $data);
    }

    /**
     * 站点相关多张广告图片配置信息合并
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-05-08
     * @desc    description
     * @param   [string]            $type   [类型]
     * @param   [int]               $count  [数量、默认3]
     */
    public static function SiteAdConfigImagesMgerge($type, $count = 3)
    {
        $data = [];
        $key = $type.'_ad';
        for($i=1; $i<=$count; $i++)
        {
            $img = ResourcesService::AttachmentPathViewHandle(MyC($key.$i.'_images'));
            if(!empty($img))
            {
                $data[] = [
                    'images'    => $img,
                    'url'       => MyC($key.$i.'_url', null, true),
                    'bg_color'  => MyC($key.$i.'_bg_color', null, true),
                ];
            }
        }
        return $data;
    }

    /**
     * 数据返回处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-01-06
     * @desc    description
     * @param   [array]           $data [返回数据]
     */
    public static function DataReturn($data = [])
    {
        // 当前操作名称, 兼容插件模块名称
        $module_name = strtolower(request()->module());
        $controller_name = strtolower(request()->controller());
        $action_name = strtolower(request()->action());

        // 钩子
        $hook_name = 'plugins_service_base_data_return_'.$module_name.'_'.$controller_name.'_'.$action_name;
        Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'data'          => &$data,
            'params'        => input(),
        ]);

        return DataReturn('success', 0, $data);
    }

    /**
     * 站点类型
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-04
     * @desc    description
     */
    public static function SiteTypeValue()
    {
        // 当前站点类型、默认销售型（0销售型, 1展示型, 2自提点, 3虚拟销售, 4销售+自提）
        $value = (int) MyC('common_site_type', 0, true);

        // 钩子
        $hook_name = 'plugins_service_base_site_type_value';
        Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'value'         => &$value,
        ]);

        return $value;
    }

    /**
     * 是否使用商品优化记录
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-09
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     * @param   [string]       $plugins  [插件名称]
     */
    public static function IsGoodsDiscountRecord($goods_id, $plugins)
    {
        // 获取记录
        $data = self::GetGoodsDiscountRecord($goods_id);

        // 当前插件是否存在优惠记录
        return in_array($plugins, $data);
    }

    /**
     * 商品优化记录
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-09
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     * @param   [string]       $plugins  [插件名称]
     * @param   [int]          $is_use [是否使用（0否, 1是）]
     */
    public static function GoodsDiscountRecord($goods_id, $plugins, $is_use = 0)
    {
        // 记录key
        $key = self::$plugins_goods_discount_record_key.$goods_id;

        // 获取记录
        $data = self::GetGoodsDiscountRecord($goods_id);

        // 是否存在
        $index = array_search($plugins, $data);

        // 是否使用优惠
        if($is_use == 1)
        {
            // 存储记录
            if($index === false)
            {
                $data[] = $plugins;
            }
            session($key, $data);
        } else {
            if($index !== false)
            {
                unset($data[$index]);
                sort($data);
            }
        }

        session($key, empty($data) ? null : $data);
        return true;
    }

    /**
     * 获取使用商品优化记录
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-09
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     */
    public static function GetGoodsDiscountRecord($goods_id)
    {
        $res = session(self::$plugins_goods_discount_record_key.$goods_id);
        return empty($res) ? [] : $res;
    }

    /**
     * 商品是否支持折扣
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-08
     * @desc    description
     * @param   [array]          $params     [输入参数]
     * @param   [string]         $plugins    [插件名称]
     */
    public static function IsGoodsDiscount($params = [], $plugins = '')
    {
        // 默认支持
        $status = true;

        // 是否关闭商品优惠重叠
        // 采用钩子进行处理
        if(MyC('is_close_goods_discount_overlap', 0) == 1 && !empty($params) && !empty($params['hook_name']))
        {
            switch($params['hook_name'])
            {
                // 商品处理结束
                case 'plugins_service_goods_handle_end' :
                    if(!empty($params['goods']) && !empty($params['goods']['id']))
                    {
                        $old = Db::name('Goods')->field('price,min_price,max_price')->find($params['goods']['id']);
                        if(!empty($old))
                        {
                            // 展示销售价格
                            if($status && isset($params['goods']['price']))
                            {
                                $temp = explode('-', $params['goods']['price']);
                                $temp_old = explode('-', $old['price']);
                                if($temp[count($temp)-1] < $temp_old[count($temp_old)-1])
                                {
                                    $status = false;
                                }
                            }

                            // 最低价
                            if($status && isset($params['goods']['min_price']))
                            {
                                if($params['goods']['min_price'] < $old['min_price'])
                                {
                                    $status = false;
                                }
                            }

                            // 最高价
                            if($status && isset($params['goods']['max_price']))
                            {
                                if($params['goods']['max_price'] < $old['max_price'])
                                {
                                    $status = false;
                                }
                            }
                        }
                    }
                    break;

                // 获取规格详情
                case 'plugins_service_goods_spec_base' :
                    if(!empty($params['data']) && !empty($params['data']['spec_base']) && !empty($params['data']['spec_base']['id']) && !empty($params['data']['spec_base']['goods_id']) && isset($params['data']['spec_base']['price']))
                    {
                        $price_old = Db::name('GoodsSpecBase')->where(['id'=>$params['data']['spec_base']['id']])->value('price');
                        if($status && $params['data']['spec_base']['price'] < $price_old)
                        {
                            $status = false;
                        }
                    }
                    break;
            }
        }

        // 返回状态、默认支持
        return $status;
    }

    /**
     * 协议数据
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-04-25
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function AgreementData($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'document',
                'error_msg'         => '协议文档类型有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 获取内容
        return ConfigService::ConfigContentRow('common_agreement_'.$params['document']);
    }
}
?>