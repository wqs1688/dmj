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
 * 邮箱设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Email extends Common
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
		// 配置信息
		$this->assign('data', ConfigService::ConfigList($params));
        $this->assign('lang_type', $lang_type);
		$type = input('type', 'email');

		// 静态数据
		$this->assign('common_is_text_list', lang('common_is_text_list'));

		// 导航
		$this->assign('nav_type', $type);
		if($type == 'email')
		{
			return $this->fetch('index');
		} else {
			return $this->fetch('message');
		}
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
		return ConfigService::ConfigSave($_POST);
	}

	/**
	 * [EmailTest 邮件测试]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-10T15:30:10+0800
	 */
	public function EmailTest()
	{
		// 验证码公共基础参数
		$verify_param = array(
				'expire_time' => MyC('common_verify_expire_time'),
				'interval_time'	=>	MyC('common_verify_interval_time'),
			);

		$obj = new \base\Email($verify_param);
		$email_param = array(
				'email'		=>	isset($this->data_request['email']) ? $this->data_request['email'] : '',
				'content'	=>	'邮件配置-发送测试内容',
				'title'		=>	MyC('home_site_name').' - '.'测试',
			);
		// 发送
		if($obj->SendHtml($email_param))
		{
			return DataReturn('发送成功');
		}
		return DataReturn('发送失败'.'['.$obj->error.']', -100);
	}
}
?>
