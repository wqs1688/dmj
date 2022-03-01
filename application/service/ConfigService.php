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

/**
 * 配置服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ConfigService
{
    // 富文本,不实例化的字段
    public static $rich_text_list = [
            'home_footer_info',
            'common_email_currency_template',
            'home_email_user_reg',
            'home_email_user_forget_pwd',
            'home_email_user_email_binding',
            'home_site_close_reason',
            'common_agreement_userregister',
            'common_agreement_userprivacy',
            'common_self_extraction_address',
            'home_index_floor_top_right_keywords',
            'home_index_floor_manual_mode_goods',
            'home_index_floor_left_top_category',
            'admin_email_login_template',
            'home_email_login_template',
            'home_site_security_record_url',
        ];

    // 附件字段列表
    public static $attachment_field_list = [
        'home_site_logo',
        'home_site_logo_wap',
        'home_site_desktop_icon',
        'common_customer_store_qrcode',
        'home_site_user_register_bg_images',
        'home_site_user_login_ad1_images',
        'home_site_user_login_ad2_images',
        'home_site_user_login_ad3_images',
        'home_site_user_forgetpwd_ad1_images',
        'home_site_user_forgetpwd_ad2_images',
        'home_site_user_forgetpwd_ad3_images',
    ];

    // 字符串转数组字段列表, 默认使用英文逗号处理 [ , ]
    public static $string_to_array_field_list = [
        'common_images_verify_rules',
        'home_user_login_type',
        'home_user_reg_type',
        'admin_login_type',
        'home_search_params_type',
    ];

    // 需要文件缓存的key
    public static $file_cache_keys = [
        // 伪静态后缀
        'home_seo_url_html_suffix',

        // 前端默认主题
        'common_default_theme',

        // 时区
        'common_timezone',

        // 是否开启redis缓存
        'common_data_is_use_cache',
        'common_cache_data_redis_host',
        'common_cache_data_redis_port',
        'common_cache_data_redis_password',
        'common_cache_data_redis_expire',
        'common_cache_data_redis_prefix',

        // session是否开启redis缓存
        'common_session_is_use_cache',
        'common_cache_session_redis_host',
        'common_cache_session_redis_port',
        'common_cache_session_redis_password',
        'common_cache_session_redis_expire',
        'common_cache_session_redis_prefix',

        // cdn地址
        'common_cdn_attachment_host',
        'common_cdn_public_host',

        // 编辑器配置信息
        'home_max_limit_image',
        'home_max_limit_video',
        'home_max_limit_file',
    ];

    /**
     * 配置列表，唯一标记作为key
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-07
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function ConfigList($params = [])
    {
        $field = isset($params['field']) ? $params['field'] : 'only_tag,name,describe,value,error_tips';
        $data = Db::name('Config')->column($field);
        if(!empty($data))
        {
            foreach($data as $k=>&$v)
            {
                // 字符串转数组
                foreach(self::$string_to_array_field_list as $fv)
                {
                    if($k == $fv)
                    {
                        $v['value'] = (!isset($v['value']) || $v['value'] == '') ? [] : explode(',', $v['value']);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 配置数据保存
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-01-02T23:08:19+0800
     * @param   [array]          $params [输入参数]
     */
    public static function ConfigSave($params = [])
    {
        // 参数校验
        if(empty($params))
        {
            return DataReturn('参数不能为空', -1);
        }

        // 当前参数中不存在则移除
        $data_fields = self::$attachment_field_list;
        foreach($data_fields as $key=>$field)
        {
            if(!isset($params[$field]))
            {
                unset($data_fields[$key]);
            }
        }

        // 获取附件
        $attachment = ResourcesService::AttachmentParams($params, $data_fields);
        foreach($attachment['data'] as $k=>$v)
        {
            $params[$k] = $v;
        }

        // 处理百度地图 ak, 空则默认变量
        if(array_key_exists('common_baidu_map_ak', $params))
        {
            $map_ak_old = MyC('common_baidu_map_ak', '{{common_baidu_map_ak}}', true);
        }

        // 循环保存数据
        $success = 0;

        // 开始更新数据
        foreach($params as $k=>$v)
        {
            if(in_array($k, self::$rich_text_list))
            {
                $v = ResourcesService::ContentStaticReplace($v, 'add');
            } else {
                $v = htmlentities($v);
            }
            if(Db::name('Config')->where(['only_tag'=>$k])->update(['value'=>$v, 'upd_time'=>time()]))
            {
                $success++;

                // 单条配置缓存删除
                cache($k, null);
            }
        }
        if($success > 0)
        {
            // 删除所有配置的缓存数据
            cache(config('shopxo.cache_common_my_config_key'), null);

            // 所有配置信息更新
            self::ConfigInit(1);

            // 是否需要更新路由规则
            $ret = self::RouteSeparatorHandle($params);
            if($ret['code'] != 0)
            {
                return $ret;
            }

            // 处理百度地图 ak
            if(array_key_exists('common_baidu_map_ak', $params) && isset($map_ak_old))
            {
                $file_all = [
                    ROOT.'public/static/common/lib/ueditor/dialogs/map/map.html',
                    ROOT.'public/static/common/lib/ueditor/dialogs/map/show.html',
                ];
                foreach($file_all as $f)
                {
                    // 是否有权限
                    if(!is_writable($f))
                    {
                        return DataReturn('编辑器文件没有权限['.$f.']', -1);
                    }

                    // 替换
                    $search = ['ak={{common_baidu_map_ak}}', 'ak='.$map_ak_old];
                    $replace = 'ak='.MyC('common_baidu_map_ak', '{{common_baidu_map_ak}}', true);
                    $status = file_put_contents($f, str_replace($search, $replace, file_get_contents($f)));
                    if($status === false)
                    {
                        return DataReturn('百度地图密钥配置失败', -5);
                    }
                }
            }

            return DataReturn('编辑成功'.'['.$success.']');
        }
        return DataReturn('编辑失败', -100);
    }

    /**
     * 系统配置信息初始化
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-01-03T21:36:55+0800
     * @param    [int] $status [是否更新数据,0否,1是]
     */
    public static function ConfigInit($status = 0)
    {
        $key = config('shopxo.cache_common_my_config_key');
        $data = cache($key);
        if(empty($data) || $status == 1)
        {
            // 所有配置
            $data = Db::name('Config')->column('value', 'only_tag');

            // 数据处理
            // 字符串转数组
            foreach(self::$string_to_array_field_list as $fv)
            {
                if(isset($data[$fv]))
                {
                    $data[$fv] = ($data[$fv] == '') ? [] : explode(',', $data[$fv]);
                }
            }

            // 数据处理
            foreach($data as $k=>&$v)
            {
                // 富文本字段处理
                if(in_array($k, self::$rich_text_list))
                {
                    $v = ResourcesService::ContentStaticReplace($v, 'get');
                }

                // 公共内置数据缓存
                cache($k, $v);

                // 数据文件缓存
                if(in_array($k, self::$file_cache_keys))
                {
                    MyFileConfig($k, $v);
                }
            }

            // 所有配置缓存集合
            cache($key, $data);
        }
    }

    /**
     * 路由规则处理
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-01-02T23:08:19+0800
     * @param   [array]          $params [输入参数]
     */
    public static function RouteSeparatorHandle($params = [])
    {
        if(isset($params['home_seo_url_model']))
        {
            $route_file = ROOT.'route'.DS.'route.config';
            $route_file_php = ROOT.'route'.DS.'route.php';

            // 文件目录
            if(!is_writable(ROOT.'route'))
            {
                return DataReturn('路由目录没有操作权限'.'[./route]', -11);
            }

            // 路配置文件权限
            if(file_exists($route_file_php) && !is_writable($route_file_php))
            {
                return DataReturn('路由配置文件没有操作权限'.'[./route/route.php]', -11);
            }

            // pathinfo+短地址模式
            if($params['home_seo_url_model'] == 2)
            {
                
                if(!file_exists($route_file))
                {
                    return DataReturn('路由规则文件不存在'.'[./route/route.config]', -14);
                }

                // 开始生成规则文件
                if(file_put_contents($route_file_php, file_get_contents($route_file)) === false)
                {
                    return DataReturn('路由规则文件生成失败', -10);
                }

            // 兼容模式+pathinfo模式
            } else {
                if(file_exists($route_file_php) && @unlink($route_file_php) === false)
                {
                    return DataReturn('路由规则处理失败', -10);
                }
            }
            return DataReturn('处理成功', 0);
        }
        return DataReturn('无需处理', 0);
    }

    /**
     * 根据唯一标记获取条配置内容
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-05-16
     * @desc    description
     * @param   [string]           $key [唯一标记]
     */
    public static function ConfigContentRow($key)
    {
        // 缓存key,单条新增前缀，与公共配置区分开
        $data = cache('config_content_row_'.$key);

        // 获取内容
        if(empty($data))
        {
            $data = Db::name('Config')->where(['only_tag'=>$key])->field('name,value,type,upd_time')->find();
            if(!empty($data))
            {
                // 富文本处理
                if(in_array($key, self::$rich_text_list))
                {
                    $data['value'] = ResourcesService::ContentStaticReplace($data['value'], 'get');
                }
                $data['upd_time_time'] = empty($data['upd_time']) ? null : date('Y-m-d H:i:s', $data['upd_time']);
            }
            cache($key, $data);
        }
        
        return DataReturn('操作成功', 0, $data);
    }

    /**
     * 站点自提模式 - 自提地址列表
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-11-13
     * @desc    description
     * @param   [string]          $value  [自提的配置数据]
     * @param   [array]           $params [输入参数]
     */
    public static function SiteTypeExtractionAddressList($value = null, $params = [])
    {
        // 未指定内容则从缓存读取
        if(empty($value))
        {
            $value = MyC('common_self_extraction_address');
        }

        // 数据处理
        $data = [];
        if(!empty($value) && is_string($value))
        {
            $temp_data = json_decode($value, true);
            if(!empty($temp_data) && is_array($temp_data))
            {
                $data = $temp_data;
            }
        }
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                if(array_key_exists('logo', $v))
                {
                    $v['logo'] = ResourcesService::AttachmentPathViewHandle($v['logo']);
                }
            }
        }

        // 自提点地址列表数据钩子
        $hook_name = 'plugins_service_site_extraction_address_list';
        Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'data'          => &$data,
        ]);

        // 数据距离处理
        if(!empty($data) && is_array($data) && !empty($params) && !empty($params['lng']) && !empty($params['lat']))
        {
            $unit = 'km';
            foreach($data as &$v)
            {
                if(!empty($v) && is_array($v))
                {
                    // 计算距离
                    $v['distance_value'] = \base\GeoTransUtil::GetDistance($v['lng'], $v['lat'], $params['lng'], $params['lat'], 2);
                    $v['distance_unit'] = $unit;
                }
            }

            // 根据距离排序
            if(count($data) > 1)
            {
                $data = ArrayQuickSort($data, 'distance_value');
            }
        }

        return DataReturn('操作成功', 0, $data);
    }

    /**
     * 站点虚拟模式 - 虚拟销售信息
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-11-19
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function SiteFictitiousConfig($params = [])
    {
        // 标题
        $title = MyC('common_site_fictitious_return_title', '密钥信息', true);

        // 提示信息
        $tips =  MyC('common_site_fictitious_return_tips', null, true);

        $result = [
            'title'     => $title,
            'tips'      => str_replace("\n", '<br />', $tips),
        ];
        return DataReturn('操作成功', 0, $result);
    }
}
?>
