<?php
// +----------------------------------------------------------------------
// | 2021/09/06
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\index\controller;

use app\service\SeoService;
use app\service\AmazonService;

/**
 * 亚马逊平台
 * @author   R
 * @version  0.0.1
 * @datetime 2021-09-06
 */
class Amazon extends Common
{
    /**
     * 构造方法
     * @author   R
     * @version 1.0.0
     * @date    2021-09-06
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }

    /**
     * 平台信息
     * @author  R
     * @version 1.0.0
     * @date    2021-09-06
     * @desc    description
     */
    public function Index()
    {
		// 订单总数
		$order_number = AmazonService::OrderNumberYesterdayTodayTotal();
		$this->assign('order_number', $order_number['data']);

		// 订单成交总量
		$order_complete_number = AmazonService::OrderCompleteYesterdayTodayTotal();
		$this->assign('order_complete_number', $order_complete_number['data']);

		// 订单收入总计
		$order_complete_money = AmazonService::OrderCompleteMoneyYesterdayTodayTotal();
		$this->assign('order_complete_money', $order_complete_money['data']);

		// 近30日订单成交金额走势
		$order_profit_chart = AmazonService::OrderProfitSevenTodayTotal();
		$this->assign('order_profit_chart', $order_profit_chart['data']);

		// 近30日订单交易走势
		$order_trading_trend = AmazonService::OrderTradingTrendSevenTodayTotal();
		$this->assign('order_trading_trend', $order_trading_trend['data']);

        // 浏览器名称
        $this->assign('home_seo_site_title', SeoService::BrowserSeoTitle('亚马逊平台', 1));

        return $this->fetch();
    }

}
?>