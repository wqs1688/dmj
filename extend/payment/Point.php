<?php
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace payment;

use app\service\PaymentService;

/**
 * 积分支付
 * @author   R
 * @version 1.0.0
 * @date    2021-07-12
 * @desc    description
 */
class Point
{
    // 插件配置参数
    private $config;

    /**
     * 构造方法
     * @author   R
     * @version 1.0.0
     * @date    2021-07-12
     * @desc    description
     * @param   [array]           $params [输入参数（支付配置参数）]
     */
    public function __construct($params = [])
    {
        $this->config = $params;
    }

    /**
     * 配置信息
     * @author   R
     * @version 1.0.0
     * @date    2021-07-12
     * @desc    description
     */
    public function Config()
    {
        // 基础信息
        $base = [
            'name'          => '积分支付',  // 插件名称
            'version'       => '1.0.0',  // 插件版本
            'apply_version' => '不限',  // 适用系统版本描述
            'desc'          => '积分方式支付货款、支持配置自定义支付信息',  // 插件描述（支持html）
            'author'        => 'R',  // 开发者
            'author_url'    => 'http://dmj.5icoffee.net/',  // 开发者主页
        ];

        // 配置信息
        $element = [
            [
                'element'       => 'select',
                'title'         => '自定义支付信息展示',
                'desc'          => '所有端有效',
                'message'       => '请选择是否开启自定义支付',
                'name'          => 'is_custom_pay',
                'is_multiple'   => 0,
                'element_data'  => [
                    ['value'=>0, 'name'=>'关闭'],
                    ['value'=>1, 'name'=>'开启'],
                ],
            ],
            [
                'element'       => 'textarea',
                'name'          => 'content',
                'placeholder'   => '自定义文本',
                'title'         => '自定义文本',
                'desc'          => '可换行、一行一条数据',
                'is_required'   => 0,
                'rows'          => 6,
                'message'       => '请填写自定义文本',
            ],
            [
                'element'       => 'input',
                'type'          => 'text',
                'default'       => '',
                'name'          => 'tips',
                'placeholder'   => '特别提示信息',
                'title'         => '特别提示信息',
                'is_required'   => 0,
                'message'       => '请填写特别提示信息',
            ],
            [
                'element'       => 'input',
                'type'          => 'text',
                'default'       => '',
                'name'          => 'images_url',
                'placeholder'   => '图片地址',
                'title'         => '图片地址',
                'desc'          => '可自定义图片展示',
                'is_required'   => 0,
                'message'       => '请填写图片自定义的地址',
            ],
        ];

        return [
            'base'      => $base,
            'element'   => $element,
        ];
    }

    /**
     * 支付入口
     * @author   R
     * @version 1.0.0
     * @date    2021-07-12
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Pay($params = [])
    {
        if(empty($params))
        {
            return DataReturn('缺少参数', -10);
        }
        
        $payment = new PaymentService();
        $ret = $payment->PointPay($params);

        if(isset($ret['code']) && $ret['code'] == 0)
        {
            return DataReturn('支付成功', 0, MyUrl('index/order/respond', ['appoint_status'=>0]));
        }

        return DataReturn('积分支付处理失败', -100);
    }

//=============================== 下面的都没用 ^_^ ================================================

    /**
     * 支付回调处理
     * @author   R
     * @version 1.0.0
     * @date    2021-07-14
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Respond($params = [])
    {
        $data = empty($_POST) ? $_GET : array_merge($_GET, $_POST);
        ksort($data);

        // 支付状态
        if(!empty($data['trade_no']) && isset($data['total_amount']) && $data['total_amount'] > 0)
        {
            return DataReturn('支付成功', 0, $this->ReturnData($data));
        }
        return DataReturn('处理异常错误', -100);
    }

    /**
     * 自定义成功返回内容
     * @author   R
     * @version 1.0.0
     * @date    2021-07-14
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function SuccessReturn($params = [])
    {
        $data = [
            'payment' => 'Point',
            'status' => 0,
        ];
        
        return DataReturn('支付成功', 0, $data);
    }

    /**
     * 自定义失败返回内容
     * @author   R
     * @version 1.0.0
     * @date    2021-07-14
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function ErrorReturn($params = [])
    {
        $data = [
            'payment' => 'Point',
            'status' => 1,
        ];
        
        return DataReturn('支付失败', 0, $data);
    }

    /**
     * [ReturnData 返回数据统一格式]
     * @author   R
     * @version  1.0.0
     * @datetime 2021-07-16
     * @param    [array]                   $data [返回数据]
     */
    private function ReturnData($data)
    {
        // 返回数据固定基础参数
        $data['trade_no']       = $data['trade_no'];        // 支付平台 - 订单号
        $data['buyer_user']     = $data['user_id'];         // 支付平台 - 用户
        $data['out_trade_no']   = $data['trade_no'];        // 本系统发起支付的 - 订单号
        $data['subject']        = isset($data['subject']) ? $data['subject'] : ''; // 本系统发起支付的 - 商品名称
        $data['pay_price']      = $data['total_amount'];    // 本系统发起支付的 - 总价

        return $data;
    }

}
?>
