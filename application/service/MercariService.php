<?php
// +----------------------------------------------------------------------
// | 2021/09/06
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\service;

use think\Db;

/**
 * メルカリ数据统计服务层
 * @author   R
 * @version  0.0.1
 * @datetime 2021-09-06
 */
class MercariService
{
    // 近3天,近7天,近15天,近30天
    private static $nearly_three_days;
    private static $nearly_seven_days;
    private static $nearly_fifteen_days;
    private static $nearly_thirty_days;

    // 近30天
    private static $thirty_time_start;
    private static $thirty_time_end;

    // 近15天
    private static $fifteen_time_start;
    private static $fifteen_time_end;

    // 近7天
    private static $seven_time_start;
    private static $seven_time_end;

    // 上月
    private static $last_month_time_start;
    private static $last_month_time_end;

    // 当月
    private static $same_month_time_start;
    private static $same_month_time_end;

    // 昨天
    private static $yesterday_time_start;
    private static $yesterday_time_end;

    // 今天
    private static $today_time_start;
    private static $today_time_end;

    /**
     * 初始化
     * @author   R
     * @version 1.0.0
     * @date    2021-09-06
     * @desc    description
     * @param    [array]          $params [输入参数]
     */
    public static function Init($params = [])
    {
        static $object = null;
        if(!is_object($object))
        {
            // 初始化标记对象，避免重复初始化
            $object = (object) [];

            // 近30天日期
            self::$thirty_time_start = strtotime(date('Y-m-d 00:00:00', strtotime('-30 day')));
            self::$thirty_time_end = time();

            // 近15天日期
            self::$fifteen_time_start = strtotime(date('Y-m-d 00:00:00', strtotime('-15 day')));
            self::$fifteen_time_end = time();

            // 近7天日期
            self::$seven_time_start = strtotime(date('Y-m-d 00:00:00', strtotime('-7 day')));
            self::$seven_time_end = time();

            // 上月
            self::$last_month_time_start = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month', strtotime(date('Y-m', time())))));
            self::$last_month_time_end = strtotime(date('Y-m-t 23:59:59', strtotime('-1 month', strtotime(date('Y-m', time())))));

            // 当月
            self::$same_month_time_start = strtotime(date('Y-m-01 00:00:00'));
            self::$same_month_time_end = time();

            // 昨天日期
            self::$yesterday_time_start = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
            self::$yesterday_time_end = strtotime(date('Y-m-d 23:59:59', strtotime('-1 day')));

            // 今天日期
            self::$today_time_start = strtotime(date('Y-m-d 00:00:00'));
            self::$today_time_end = time();

            // 近3天,近7天,近15天,近30天
            $nearly_all = [
                3   => 'nearly_three_days',
                7   => 'nearly_seven_days',
                15  => 'nearly_fifteen_days',
                30  => 'nearly_thirty_days',
            ];
            foreach($nearly_all as $day=>$name)
            {
                $date = [];
                $time = time();
                for($i=0; $i<$day; $i++)
                {
                    $date[] = [
                        'start_time'    => strtotime(date('Y-m-d 00:00:00', time()-$i*3600*24)),
                        'end_time'      => strtotime(date('Y-m-d 23:59:59', time()-$i*3600*24)),
                        'name'          => date('Y-m-d', time()-$i*3600*24),
                    ];
                }
                self::${$name} = array_reverse($date);
            }
        }
    }

    /**
     * 订单总数,今日,昨日,当月,上月总数
     * @author   R
     * @version  0.0.1
     * @datetime 2021-09-06
     * @param    [array]          $params [输入参数]
     */
    public static function OrderNumberYesterdayTodayTotal($params = [])
    {
        // 初始化
        self::Init($params);

        // 订单状态
        // （0待确认, 1已确认/待支付, 2已支付/待发货, 3已发货/待收货, 4已完成, 5已取消, 6已关闭）

        // 总数
        $where = [
            ['status', '<=', 4],
        ];
        // $total_count = Db::name('Order')->where($where)->count();

        // 上月
        $where = [
            ['status', '<=', 4],
            ['add_time', '>=', self::$last_month_time_start],
            ['add_time', '<=', self::$last_month_time_end],
        ];
        // $last_month_count = Db::name('Order')->where($where)->count();

        // 当月
        $where = [
            ['status', '<=', 4],
            ['add_time', '>=', self::$same_month_time_start],
            ['add_time', '<=', self::$same_month_time_end],
        ];
        // $same_month_count = Db::name('Order')->where($where)->count();

        // 昨天
        $where = [
            ['status', '<=', 4],
            ['add_time', '>=', self::$yesterday_time_start],
            ['add_time', '<=', self::$yesterday_time_end],
        ];
        // $yesterday_count = Db::name('Order')->where($where)->count();

        // 今天
        $where = [
            ['status', '<=', 4],
            ['add_time', '>=', self::$today_time_start],
            ['add_time', '<=', self::$today_time_end],
        ];
        // $today_count = Db::name('Order')->where($where)->count();

        // 数据组装
        $result = [
            'total_count'       => 589,
            'last_month_count'  => 589,
            'same_month_count'  => 622,
            'yesterday_count'   => 32,
            'today_count'       => 29,
        ];
        return DataReturn('处理成功', 0, $result);
    }

    /**
     * 订单成交总量,今日,昨日,当月,上月总数
     * @author   R
     * @version  0.0.1
     * @datetime 2021-09-06
     * @param    [array]          $params [输入参数]
     */
    public static function OrderCompleteYesterdayTodayTotal($params = [])
    {
        // 初始化
        self::Init($params);

        // 订单状态
        // （0待确认, 1已确认/待支付, 2已支付/待发货, 3已发货/待收货, 4已完成, 5已取消, 6已关闭）
        
        // 总数
        $where = [
            ['status', '=', 4],
        ];
        // $total_count = Db::name('Order')->where($where)->count();

        // 上月
        $where = [
            ['status', '=', 4],
            ['add_time', '>=', self::$last_month_time_start],
            ['add_time', '<=', self::$last_month_time_end],
        ];
        // $last_month_count = Db::name('Order')->where($where)->count();

        // 当月
        $where = [
            ['status', '=', 4],
            ['add_time', '>=', self::$same_month_time_start],
            ['add_time', '<=', self::$same_month_time_end],
        ];
        // $same_month_count = Db::name('Order')->where($where)->count();

        // 昨天
        $where = [
            ['status', '=', 4],
            ['add_time', '>=', self::$yesterday_time_start],
            ['add_time', '<=', self::$yesterday_time_end],
        ];
        // $yesterday_count = Db::name('Order')->where($where)->count();

        // 今天
        $where = [
            ['status', '=', 4],
            ['add_time', '>=', self::$today_time_start],
            ['add_time', '<=', self::$today_time_end],
        ];
        // $today_count = Db::name('Order')->where($where)->count();

        // 数据组装
        $result = [
            'total_count'       => 589,
            'last_month_count'  => 589,
            'same_month_count'  => 622,
            'yesterday_count'   => 32,
            'today_count'       => 29,
        ];
        return DataReturn('处理成功', 0, $result);
    }

    /**
     * 订单收入总计,今日,昨日,当月,上月总数
     * @author   R
     * @version  0.0.1
     * @datetime 2021-09-06
     * @param    [array]          $params [输入参数]
     */
    public static function OrderCompleteMoneyYesterdayTodayTotal($params = [])
    {
        // 初始化
        self::Init($params);

        // 订单状态
        // （0待确认, 1已确认/待支付, 2已支付/待发货, 3已发货/待收货, 4已完成, 5已取消, 6已关闭）
        
        // 总数
        $where = [
            ['status', 'in', [2,3,4]],
        ];
        // $total_count = Db::name('Order')->where($where)->sum('total_price');

        // 上月
        $where = [
            ['status', 'in', [2,3,4]],
            ['add_time', '>=', self::$last_month_time_start],
            ['add_time', '<=', self::$last_month_time_end],
        ];
        // $last_month_count = Db::name('Order')->where($where)->sum('total_price');

        // 当月
        $where = [
            ['status', 'in', [2,3,4]],
            ['add_time', '>=', self::$same_month_time_start],
            ['add_time', '<=', self::$same_month_time_end],
        ];
        // $same_month_count = Db::name('Order')->where($where)->sum('total_price');

        // 昨天
        $where = [
            ['status', 'in', [2,3,4]],
            ['add_time', '>=', self::$yesterday_time_start],
            ['add_time', '<=', self::$yesterday_time_end],
        ];
        // $yesterday_count = Db::name('Order')->where($where)->sum('total_price');

        // 今天
        $where = [
            ['status', 'in', [2,3,4]],
            ['add_time', '>=', self::$today_time_start],
            ['add_time', '<=', self::$today_time_end],
        ];
        // $today_count = Db::name('Order')->where($where)->sum('total_price');

        // 数据组装
        $result = [
            'total_count'       => '1189,212.87',
            'last_month_count'  => '142,909.53',
            'same_month_count'  => '133,220.03',
            'yesterday_count'   => '50,873.22',
            'today_count'       => '47,233.01',
        ];
        return DataReturn('处理成功', 0, $result);
    }

    /**
     * 订单收益趋势, 30天数据
     * @author   R
     * @version  0.0.1
     * @datetime 2021-09-06
     * @param    [array]          $params [输入参数]
     */
    public static function OrderProfitSevenTodayTotal($params = [])
    {
        // 初始化
        self::Init($params);

        // 订单状态列表
        $order_status_list = lang('common_order_user_status');
        $status_arr = array_column($order_status_list, 'id');

        // 循环获取统计数据
        $data = [];
        $value_arr = [];
        $name_arr = [];
        if(!empty($status_arr))
        {
            foreach(self::$nearly_thirty_days as $day)
            {
                // 当前日期名称
                $name_arr[] = $day['name'];

                // 根据状态获取数量
                // foreach($status_arr as $status)
                // {
                //     // 获取订单
                //     $where = [
                //         ['status', '=', $status],
                //         ['add_time', '>=', $day['start_time']],
                //         ['add_time', '<=', $day['end_time']],
                //     ];
                //     $value_arr[$status][] = Db::name('Order')->where($where)->sum('pay_price');
                // }

                $value_arr[0][] = mt_rand(0.01, 199.01);
                $value_arr[1][] = mt_rand(0.01, 199.01);
                $value_arr[2][] = mt_rand(0.01, 1200.01);
                $value_arr[3][] = mt_rand(299.01, 5900.01);
                $value_arr[4][] = mt_rand(1200.01, 19999.01);
                $value_arr[5][] = mt_rand(0.01, 199.01);
                $value_arr[6][] = mt_rand(1200.01, 19999.01);
            }
        }
        

        // 数据格式组装
        foreach($status_arr as $status)
        {
            $data[] = [
                'name'      => $order_status_list[$status]['name'],
                'type'      => ($status == 4) ? 'line' : 'bar',
                'tiled'     => '总量',
                'data'      => empty($value_arr[$status]) ? [] : $value_arr[$status],
            ];
        }

        // 数据组装
        $result = [
            'title_arr' => array_column($order_status_list, 'name'),
            'name_arr'  => $name_arr,
            'data'      => $data,
        ];
        return DataReturn('处理成功', 0, $result);
    }

    /**
     * 订单交易趋势, 30天数据
     * @author   R
     * @version  0.0.1
     * @datetime 2021-09-06
     * @param    [array]          $params [输入参数]
     */
    public static function OrderTradingTrendSevenTodayTotal($params = [])
    {
        // 初始化
        self::Init($params);

        // 订单状态列表
        $order_status_list = lang('common_order_user_status');
        $status_arr = array_column($order_status_list, 'id');

        // 循环获取统计数据
        $data = [];
        $value_arr = [];
        $name_arr = [];
        if(!empty($status_arr))
        {
            foreach(self::$nearly_thirty_days as $day)
            {
                // 当前日期名称
                $name_arr[] = $day['name'];

                // 根据状态获取数量
                // foreach($status_arr as $status)
                // {
                //     // 获取订单
                //     $where = [
                //         ['status', '=', $status],
                //         ['add_time', '>=', $day['start_time']],
                //         ['add_time', '<=', $day['end_time']],
                //     ];
                //     $value_arr[$status][] = Db::name('Order')->where($where)->count();
                // }

                $value_arr[0][] = mt_rand(1, 19);
                $value_arr[1][] = mt_rand(1, 19);
                $value_arr[2][] = mt_rand(1, 120);
                $value_arr[3][] = mt_rand(29, 590);
                $value_arr[4][] = mt_rand(12, 199);
                $value_arr[5][] = mt_rand(1, 19);
                $value_arr[6][] = mt_rand(120, 199);
            }
        }

        // 数据格式组装
        foreach($status_arr as $status)
        {
            $data[] = [
                'name'      => $order_status_list[$status]['name'],
                'type'      => ($status == 4) ? 'bar' : 'line',
                'tiled'     => '总量',
                'data'      => empty($value_arr[$status]) ? [] : $value_arr[$status],
            ];
        }

        // 数据组装
        $result = [
            'title_arr' => array_column($order_status_list, 'name'),
            'name_arr'  => $name_arr,
            'data'      => $data,
        ];
        return DataReturn('处理成功', 0, $result);
    }

}
?>