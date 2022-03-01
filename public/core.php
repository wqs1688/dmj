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

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.6.0','<'))  die('PHP版本最低 5.6.0');

// 系统版本
define('APPLICATION_VERSION', 'v2.0.3');

// 定义系统目录分隔符
define('DS', '/');

// HTTP类型
define('__MY_HTTP__', (
    (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') 
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
    || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && (strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off' || $_SERVER['HTTP_FRONT_END_HTTPS'] == 'https')) 
    || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) 
    || (!empty($_SERVER['HTTP_FROM_HTTPS']) && $_SERVER['HTTP_FROM_HTTPS'] !== 'off') 
    || (!empty($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https') 
    || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
) ? 'https' : 'http');

// 根目录
$my_root = empty($_SERVER['SCRIPT_NAME']) ? '' : substr($_SERVER['SCRIPT_NAME'], 1, strrpos($_SERVER['SCRIPT_NAME'], '/'));
define('__MY_ROOT__', defined('IS_ROOT_ACCESS') ? $my_root : str_replace('public'.DS, '', $my_root));
define('__MY_ROOT_PUBLIC__', defined('IS_ROOT_ACCESS') ? DS.$my_root.'public'.DS : DS.$my_root);

// 当前服务器ip
define('__MY_ADDR__', empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR']);

// 项目HOST
define('__MY_HOST__', empty($_SERVER['HTTP_HOST']) ? '' : $_SERVER['HTTP_HOST']);

// 项目URL地址
define('__MY_URL__',  empty($_SERVER['HTTP_HOST']) ? '' : __MY_HTTP__.'://'.__MY_HOST__.DS.$my_root);

// 项目public目录URL地址
define('__MY_PUBLIC_URL__',  empty($_SERVER['HTTP_HOST']) ? '' : __MY_HTTP__.'://'.__MY_HOST__.__MY_ROOT_PUBLIC__);

// 当前页面url地址
$request_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
if(!empty($request_url) && !empty($my_root))
{
    // 去除多余的子目录路径
    $request_url = str_replace($my_root, '', $request_url);
}
define('__MY_VIEW_URL__', substr(__MY_URL__, 0, -1).$request_url);

// 系统根目录,强制转换win反斜杠
define('ROOT_PATH', str_replace('\\', DS, dirname(__FILE__)).DS);

// 系统根目录 去除public
define('ROOT', substr(ROOT_PATH, 0, -7));

// 定义应用目录
define('APP_PATH', ROOT.'application'.DS);

// 请求应用 [web, app] 默认web(ios|android|小程序 均为app)
define('APPLICATION', empty($_REQUEST['application']) ? 'web' : trim($_REQUEST['application']));

// 请求客户端 [pc, h5, ios, android, alipay, weixin, baidu, toutiao, qq] 默认pc(目前系统为自适应,h5需自行校验)
define('APPLICATION_CLIENT_TYPE', empty($_REQUEST['application_client_type']) ? 'pc' : trim($_REQUEST['application_client_type']));

// 是否get
define('IS_GET', isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET');

// 是否post
define('IS_POST', isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST');

// 是否ajax
define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) || isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'ajax'));

// 检测是否是新安装
if(!file_exists(ROOT.'config/database.php'))
{
    if(empty($_GET['s']) || stripos($_GET['s'], 'install') === false)
    {
        $url = __MY_URL__.'index.php?s=/install/index/index';
        exit(header('location:'.$url));
    }
}
?>