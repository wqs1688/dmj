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
namespace app\admin\controller;

use app\service\ConfigService;
use app\service\ResourcesService;

/**
 * 协议管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Agreement extends Common
{
    /**
     * 构造方法
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
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
     * 配置列表
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-05-16
     * @desc    description
     */
    public function Index()
    {
        $admin = $this->admin;
        $params[] = '';
        $lang_type = '';
        if($admin['lang_type'] == 2){
            $params['field'] = 'only_tag,fname as name,fdescribe as `describe`,value,error_tips';
            $lang_type = '&lang=pt-br';
        }
        // 配置信息
        $this->assign('data', ConfigService::ConfigList($params));
        $this->assign('lang_type', $lang_type);

        // 编辑器文件存放地址
        $this->assign('editor_path_type', ResourcesService::EditorPathTypeValue('agreement'));

        // 导航数据
        $nav_data = [
            [
                'name'  => '用户注册协议',
                'type'  => 'register',
            ],
            [
                'name'  => '用户隐私政策',
                'type'  => 'privacy',
            ]
        ];
        $this->assign('nav_data', $nav_data);

        // 导航/视图
        $nav_type = input('nav_type', 'register');
        $this->assign('nav_type', $nav_type);
        return $this->fetch($nav_type);
    }

    /**
     * 配置数据保存
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-05-16
     * @desc    description
     */
    public function Save()
    {
        return ConfigService::ConfigSave($_POST);
    }
}
?>
