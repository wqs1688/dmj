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

use app\service\ThemeService;
use app\service\ConfigService;
use app\service\StoreService;

/**
 * 主题管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Theme extends Common
{
    private $view_type;

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

		// 小导航
		$this->view_type = input('view_type', 'index');
	}

	/**
     * 列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 导航参数
		$this->assign('view_type', $this->view_type);

        // 应用商店
        $this->assign('store_theme_url', StoreService::StoreThemeUrl());

        // 是否默认首页
		if($this->view_type == 'index')
		{
            // 默认主题
            $this->assign('theme', ThemeService::DefaultTheme());

            // 获取主题列表
            $data = ThemeService::ThemeList();
            $this->assign('data_list', $data);

            // 插件更新信息
            $upgrade = ThemeService::ThemeUpgradeInfo($data);
            $this->assign('upgrade_info', $upgrade['data']);
		}
        return $this->fetch($this->view_type);
	}

	/**
	 * 模板切换保存
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  1.0.0
	 * @datetime 2018-12-19T00:58:47+0800
	 */
	public function Save()
	{
        $params['common_default_theme'] = empty($this->data_request['theme']) ? 'default' : $this->data_request['theme'];
		$ret = ConfigService::ConfigSave($params);
        if($ret['code'] == 0)
        {
            $ret['msg'] = '切换成功';
        }
        return $ret;
	}

	/**
	 * [Delete 删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-09T21:13:47+0800
	 */
	public function Delete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始处理
		return ThemeService::ThemeDelete($this->data_request);
	}

	/**
	 * [Upload 模板上传安装]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-05-10T16:27:09+0800
	 */
	public function Upload()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始处理
		return ThemeService::ThemeUpload($this->data_request);
	}

	/**
     * 主题打包下载
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-03-22
     * @desc    description
     */
    public function Download()
    {
        // 开始处理
        $ret = ThemeService::ThemeDownload($this->data_request);
        if(isset($ret['code']) && $ret['code'] != 0)
        {
            $this->assign('msg', $ret['msg']);
            return $this->fetch('public/tips_error');
        } else {
            return $ret;
        }
    }
}
?>