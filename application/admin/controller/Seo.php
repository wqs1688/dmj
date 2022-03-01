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

/**
 * seo设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Seo extends Common
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
     * [Index 配置列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
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
        // url模式
        $this->assign('seo_url_model_list', lang('seo_url_model_list'));

		// 文章标题seo方案
		$this->assign('seo_article_browser_list', lang('seo_article_browser_list'));

		// 频道标题seo方案
		$this->assign('seo_channel_browser_list', lang('seo_channel_browser_list'));

		// 配置信息
		$this->assign('data', ConfigService::ConfigList($params));
        $this->assign('lang_type', $lang_type);
		
		return $this->fetch();
	}

	/**
	 * [Save 配置数据保存]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-02T23:08:19+0800
	 */
	public function Save()
	{
		return ConfigService::ConfigSave($this->data_request);
	}
}
?>
