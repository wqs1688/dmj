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
namespace app\api\controller;

use app\service\OrderService;
use app\service\PayRequestLogService;
use app\index\controller\Order;

/**
 * 订单支付异步通知
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2018-05-21T10:48:48+0800
 */
class OrderNotify extends Common
{
    /**
     * [__construct 构造方法]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();
    }
    
    /**
     * 支付异步处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-09-12
     * @desc    description
     */
    public function Notify()
    {
        // 支付请求日志添加
        $log_ret = PayRequestLogService::PayRequestLogInsert(OrderService::$business_type_name);

        // 业务处理
        $ret = OrderService::Notify($this->data_request);

        // 响应内容
        $res = ($ret['code'] == 0) ? $this->SuccessReturn() : $this->ErrorReturn();

        // 支付响应日志
        PayRequestLogService::PayRequestLogEnd($log_ret['data'], $ret, $res);

        // 积分支付处理
        if (isset($res['data']['payment']) && $res['data']['payment'] == 'Point')
        {
            header("Location:?s=/index/order/index.html");exit();
        } else {
            // 结束运行
            die($res);
        }
    }

    /**
     * 成功返回
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-09-12
     * @desc    description
     */
    private function SuccessReturn()
    {
        // 支付插件是否自定义返回内容
        $res = $this->ContentReturn('SuccessReturn');

        // 结束输出
        return empty($res) ? 'success' : $res;
    }

    /**
     * 失败返回
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-09-12
     * @desc    description
     */
    private function ErrorReturn()
    {
        // 支付插件是否自定义返回内容
        $res = $this->ContentReturn('ErrorReturn');

        // 结束输出
        return empty($res) ? 'error' : $res;
    }

    /**
     * 输出支付插件自定义内容
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-01
     * @desc    description
     * @param   [string]          $action [操作方法]
     */
    private function ContentReturn($action)
    {
        $payment_type = defined('PAYMENT_TYPE') ? PAYMENT_TYPE : 'Point';
        $payment = 'payment\\'.$payment_type;
        if(class_exists($payment))
        {
            $payment_obj = new $payment();
            if(method_exists($payment_obj, $action))
            {
                return $payment_obj->$action($this->data_request);
            }
        }
        return '';
    }
}