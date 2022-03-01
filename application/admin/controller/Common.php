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

use think\facade\Hook;
use think\Controller;
use app\module\FormHandleModule;
use app\service\AdminService;
use app\service\AdminPowerService;
use app\service\ConfigService;
use app\service\ResourcesService;
use app\service\StoreService;

/**
 * 管理员公共控制器
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Common extends Controller
{
	// 管理员
	protected $admin;

	// 左边权限菜单
	protected $left_menu;

    // 当前操作名称
    protected $module_name;
    protected $controller_name;
    protected $action_name;

    // 输入参数 post|get|request
    protected $data_post;
    protected $data_get;
    protected $data_request;

    // 分页信息
    protected $page;
    protected $page_size;

    // 动态表格
    protected $form_table;
    protected $form_where;
    protected $form_params;
    protected $form_md5_key;
    protected $form_user_fields;
    protected $form_order_by;
    protected $form_error;

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
//var_dump($_SERVER['REQUEST_URI']);
        // 输入参数
        $this->data_post = input('post.');
        $this->data_get = input('get.');
        $this->data_request = input();

		// 系统初始化
        $this->SystemInit();

		// 管理员信息
		$this->admin = AdminService::LoginInfo();
		// 权限菜单
		AdminPowerService::PowerMenuInit();
		$this->left_menu = AdminPowerService::MenuData();

		// 视图初始化
		$this->ViewInit();

        // 动态表格初始化
        $this->FormTableInit();

        // 公共钩子初始化
        $this->CommonPluginsInit();
	}

    /**
     * 公共钩子初始化
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-07
     * @desc    description
     */
    private function CommonPluginsInit()
    {
        // css钩子
        $this->assign('plugins_admin_css_data', Hook::listen('plugins_admin_css', ['hook_name'=>'plugins_admin_css', 'is_backend'=>true]));

        // js钩子
        $this->assign('plugins_admin_js_data', Hook::listen('plugins_admin_js', ['hook_name'=>'plugins_admin_js', 'is_backend'=>true]));
        
        // 公共header内钩子
        $this->assign('plugins_admin_common_header_data', Hook::listen('plugins_admin_common_header', ['hook_name'=>'plugins_admin_common_header', 'is_backend'=>true, 'admin'=>$this->admin]));

        // 公共页面底部钩子
        $this->assign('plugins_admin_common_page_bottom_data', Hook::listen('plugins_admin_common_page_bottom', ['hook_name'=>'plugins_admin_common_page_bottom', 'is_backend'=>true, 'admin'=>$this->admin]));

        // 公共顶部钩子
        $this->assign('plugins_admin_view_common_top_data', Hook::listen('plugins_admin_view_common_top', ['hook_name'=>'plugins_admin_view_common_top', 'is_backend'=>true, 'admin'=>$this->admin]));

        // 公共底部钩子
        $this->assign('plugins_admin_view_common_bottom_data', Hook::listen('plugins_admin_view_common_bottom', ['hook_name'=>'plugins_admin_view_common_bottom', 'is_backend'=>true, 'admin'=>$this->admin]));

        // 公共表格钩子名称动态处理
        $current = 'plugins_view_admin_'.$this->controller_name;

        // 是否插件默认下
        if($this->controller_name == 'plugins')
        {
            if(!empty($this->data_request['pluginsname']))
            {
                $current .= '_'.trim($this->data_request['pluginsname']);
            }
        }

        // 内容外部顶部
        $this->assign('hook_name_content_top', $current.'_content_top');
        // 内容外部底部
        $this->assign('hook_name_content_bottom', $current.'_content_bottom');
        // 内容内部顶部
        $this->assign('hook_name_content_inside_top', $current.'_content_inside_top');
        // 内容内部底部
        $this->assign('hook_name_content_inside_bottom', $current.'_content_inside_bottom');
        // 表格列表顶部操作
        $this->assign('hook_name_form_top_operate', $current.'_top_operate');
        // 表格列表底部操作
        $this->assign('hook_name_form_bottom_operate', $current.'_bottom_operate');
        // 表格列表后面操作栏
        $this->assign('hook_name_form_list_operate', $current.'_list_operate');

        // 公共详情页面钩子名称动态处理
        // 内容外部顶部
        $this->assign('hook_name_detail_top', $current.'_detail_top');
        // 内容外部底部
        $this->assign('hook_name_detail_bottom', $current.'_detail_bottom');
        // 内容内部顶部
        $this->assign('hook_name_detail_inside_top', $current.'_detail_inside_top');
        // 内容内部底部
        $this->assign('hook_name_detail_inside_bottom', $current.'_detail_inside_bottom');
         
        $admin = $this->admin;
        $lang_type = '&lang=zh-cn';
        if($admin['lang_type'] == 2){
            $lang_type = '&lang=pt-br';
        }
        $this->assign('lang_type',$lang_type);
    }

	/**
     * 系统初始化
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-07
     * @desc    description
     */
    private function SystemInit()
    {
    	// 配置信息初始化
        ConfigService::ConfigInit();

        // url模式,后端采用兼容模式
        \think\facade\Url::root(__MY_ROOT_PUBLIC__.CurrentScriptName().'?s=');
    }

	/**
	 * [IsLogin 登录校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:42:35+0800
	 */
	protected function IsLogin()
	{
		if($this->admin === null)
		{
			if(IS_AJAX)
			{
				exit(json_encode(DataReturn('登录失效，请重新登录', -400)));
			} else {
				die('<script type="text/javascript">if(self.frameElement && self.frameElement.tagName == "IFRAME"){parent.location.reload();}else{window.location.href="'.MyUrl('admin/admin/logininfo').'";}</script>');
			}
		}
	}

	/**
	 * [ViewInit 视图初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:30:06+0800
	 */
	public function ViewInit()
	{
		// 主题
        $default_theme = 'default';
        $this->assign('default_theme', $default_theme);

        $langues = AdminService::getLanguesList();
        $this->assign('langues',$langues);

        // 当前操作名称
        $this->module_name = strtolower(request()->module());
        $this->controller_name = strtolower(request()->controller());
        $this->action_name = strtolower(request()->action());

        // 当前操作名称
        $this->assign('module_name', $this->module_name);
        $this->assign('controller_name', $this->controller_name);
        $this->assign('action_name', $this->action_name);

        // 管理员
        $this->assign('admin', $this->admin);

        // 权限菜单
        $this->assign('left_menu', $this->left_menu);

        // 分页信息
        $this->page = max(1, isset($this->data_request['page']) ? intval($this->data_request['page']) : 1);
        $this->page_size = MyC('common_page_size', 10, true);
        $this->assign('page', $this->page);
        $this->assign('page_size', $this->page_size);

        // 货币符号
        $this->assign('currency_symbol', ResourcesService::CurrencyDataSymbol());

		// 控制器静态文件状态css,js
        $module_css = $this->module_name.DS.$default_theme.DS.'css'.DS.$this->controller_name;
        $module_css .= file_exists(ROOT_PATH.'static'.DS.$module_css.'.'.$this->action_name.'.css') ? '.'.$this->action_name.'.css' : '.css';
        $this->assign('module_css', file_exists(ROOT_PATH.'static'.DS.$module_css) ? $module_css : '');

        $module_js = $this->module_name.DS.$default_theme.DS.'js'.DS.$this->controller_name;
        $module_js .= file_exists(ROOT_PATH.'static'.DS.$module_js.'.'.$this->action_name.'.js') ? '.'.$this->action_name.'.js' : '.js';
        $this->assign('module_js', file_exists(ROOT_PATH.'static'.DS.$module_js) ? $module_js : '');

        // 价格正则
        $this->assign('default_price_regex', lang('common_regex_price'));

		// 附件host地址
        $this->assign('attachment_host', config('shopxo.attachment_host'));

        // css/js引入host地址
        $this->assign('public_host', config('shopxo.public_host'));

        // 当前url地址
        $this->assign('my_url', __MY_URL__);

        // 项目public目录URL地址
        $this->assign('my_public_url', __MY_PUBLIC_URL__);

        // 当前http类型
        $this->assign('my_http', __MY_HTTP__);

        // 开发模式
        $this->assign('shopxo_is_develop', config('shopxo.is_develop'));

        // 默认不加载百度地图api
        $this->assign('is_load_baidu_map_api', 0);

        // 站点名称
        $this->assign('admin_theme_site_name', MyC('admin_theme_site_name', 'DamaiJia', true));

        // 站点商店信息
        $site_store_info = StoreService::SiteStoreInfo();
        if(empty($site_store_info))
        {
            $res = StoreService::SiteStoreAccountsBindHandle();
            if(!empty($res) && isset($res['code']) && $res['code'] == 0)
            {
                $site_store_info = StoreService::SiteStoreInfo();
            }
        }
        $this->assign('site_store_info', $site_store_info);

        // 系统基础信息
        $is_system_show_base = 0;//(empty($site_store_info) || empty($site_store_info['vip']) || !isset($site_store_info['vip']['status']) || $site_store_info['vip']['status'] == 0 || ($site_store_info['vip']['status'] == 1 && (AdminIsPower('index', 'storeaccountsbind') || AdminIsPower('index', 'inspectupgrade')))) ? 1 : 0;
        $this->assign('is_system_show_base', $is_system_show_base);
	}

    /**
     * 动态表格初始化
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-02
     * @desc    description
     */
    public function FormTableInit()
    {
        // 获取表格模型
        $module = FormModulePath($this->data_request);
        if(!empty($module))
        {
            // 调用表格处理
            $params = $this->data_request;
            $params['system_admin'] = $this->admin;
            $ret = (new FormHandleModule())->Run($module['module'], $module['action'], $params);
            if($ret['code'] == 0)
            {
                $this->form_table = $ret['data']['table'];
                $this->form_where = $ret['data']['where'];
                $this->form_params = $ret['data']['params'];
                $this->form_md5_key = $ret['data']['md5_key'];
                $this->form_user_fields = $ret['data']['user_fields'];
                $this->form_order_by = $ret['data']['order_by'];

                $this->assign('form_table', $this->form_table);
                $this->assign('form_params', $this->form_params);
                $this->assign('form_md5_key', $this->form_md5_key);
                $this->assign('form_user_fields', $this->form_user_fields);
                $this->assign('form_order_by', $this->form_order_by);
            } else {
                $this->form_error = $ret['msg'];
                $this->assign('form_error', $this->form_error);
            }
        }
    }

	/**
	 * [IsPower 是否有权限]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-20T19:18:29+0800
	 */
	protected function IsPower()
	{
		// 不需要校验权限的方法
		$unwanted_power = ['getnodeson'];
        if(!AdminIsPower(null, null, $unwanted_power))
        {
            if(IS_AJAX)
            {
                exit(json_encode(DataReturn('无权限', -1000)));
            } else {
                return $this->error('无权限');
            }
        }
	}

    /**
     * [_empty 空方法操作]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-02-25T15:47:50+0800
     * @param    [string]      $name [方法名称]
     */
    public function _empty($name)
    {
        if(IS_AJAX)
        {
            exit(json_encode(DataReturn($name.' 非法访问', -1000)));
        } else {
            $this->assign('msg', $name.' 非法访问');
            return $this->fetch('public/tips_error');
        }
    }
}
?>
