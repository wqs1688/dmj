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
namespace app\admin\form;

use think\Db;
use app\service\PaymentService;
use app\service\ExpressService;

/**
 * 订单动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-06-08
 * @desc    description
 */
class Order
{
    // 基础条件
    public $condition_base = [
        ['is_delete_time', '=', 0],
    ];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
		if($params["system_admin"]["lang_type"] == 1){
			$name1 = '基础信息';
			$name2 = '用户信息';
			$name3 = '请输入用户名/昵称/手机/邮箱';
			$name4 = '请输入订单ID/订单号/商品名称/型号';
			$name5 = '订单状态';
			$name6 = '支付状态';
			$name7 = '总价(元)';
			$name8 = '支付金额';
			$name9 = '单价';
			$name10 = '出货仓库';
			$name11 = '订单模式';
			$name12 = '来源';
			$name13 = '地址信息';
			$name14 = '取货信息';
			$name15 = '退款金额';
			$name16 = '退货数量';
			$name17 = '购买总数';
			$name18 = '增加金额';
			$name19 = '优惠金额';
			$name20 = '支付方式';
			$name21 = '用户备注';
			$name22 = '扩展信息';
			$name23 = '快递公司';
			$name24 = '快递单号';
			$name25 = '最新售后';
			$name26 = '用户是否评论';
			$name27 = '确认时间';
			$name28 = '支付时间';
			$name29 = '发货时间';
			$name30 = '完成时间';
			$name31 = '取消时间';
			$name32 = '关闭时间';
			$name33 = '创建时间';
			$name34 = '更新时间';
			$name35 = '操作';
		}else{
			$name1 = 'Informações básicas';
            $name2 = 'Informações do usuário';
            $name3 = 'Por favor, digite nome de usuário/apelido/telefone celular/e-mail';
            $name4 = 'Por favor, insira o ID do pedido/número do pedido/nome do produto/modelo';
            $name5 = 'Status do pedido';
            $name6 = 'Status do pagamento';
            $name7 = 'Preço total (yuan)';
            $name8 = 'Valor do pagamento';
            $name9 = 'Preço Unitário';
            $name10 = 'Armazém de Envio';
            $name11 = 'Modo de Pedido';
            $name12 = 'fonte';
            $name13 = 'Informações de endereço';
            $name14 = 'Informações de coleta';
            $name15 = 'Valor do reembolso';
            $name16 = 'Quantidade de devolução';
            $name17 = 'Total de compras';
            $name18 = 'Adicionar valor';
            $name19 = 'Valor da promoção';
            $name20 = 'Forma de pagamento';
            $name21 = 'Notas do usuário';
            $name22 = 'Informações estendidas';
            $name23 = 'Express Co.';
            $name24 = 'Expresso número de rastreamento';
            $name25 = 'Último pós-venda';
            $name26 = 'O usuário comenta?';
            $name27 = 'Hora da confirmação';
            $name28 = 'Hora do pagamento';
            $name29 = 'Prazo de entrega';
            $name30 = 'Tempo de conclusão';
            $name31 = 'Hora de cancelamento';
            $name32 = 'Hora de fechamento';
            $name33 = 'criado';
            $name34 = 'Hora de atualização';
            $name35 = 'Operação';
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/order/index'),
                'detail_title'  => $name1,
                'is_middle'     => 0,
            ],
            // 表单配置
            'form' => [
                [
                    'label'         => $name1,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/goods',
                    'grid_size'     => 'xl',
                    'is_detail'     => 0,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereBaseGoodsInfo',
                        'placeholder'           => $name4,
                    ],
                ],
                [
                    'label'         => $name2,
                    'view_type'     => 'module',
                    'view_key'      => 'lib/module/user',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'user_id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueUserInfo',
                        'placeholder'           => $name3,
                    ],
                ],
                [
                    'label'         => $name5,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/status',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'status',
                        'where_type'        => 'in',
                        'data'              => lang('common_order_admin_status'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name6,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/pay_status',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'pay_status',
                        'where_type'        => 'in',
                        'data'              => lang('common_order_pay_status'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name7,
                    'view_type'     => 'field',
                    'view_key'      => 'total_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name8,
                    'view_type'     => 'field',
                    'view_key'      => 'pay_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name9,
                    'view_type'     => 'field',
                    'view_key'      => 'price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name10,
                    'view_type'     => 'field',
                    'view_key'      => 'warehouse_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'warehouse_id',
                        'where_type'        => 'in',
                        'data'              => $this->OrderWarehouseList(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name11,
                    'view_type'     => 'field',
                    'view_key'      => 'order_model',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_site_type_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_site_type_list'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name12,
                    'view_type'     => 'field',
                    'view_key'      => 'client_type',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_platform_type'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_platform_type'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name13,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/address',
                    'grid_size'     => 'sm',
                    'is_detail'     => 0,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueAddressInfo',
                    ],
                ],
                [
                    'label'         => $name14,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/take',
                    'width'         => 125,
                    'is_detail'     => 0,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueTakeInfo',
                    ],
                ],
                [
                    'label'         => $name15,
                    'view_type'     => 'field',
                    'view_key'      => 'refund_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name16,
                    'view_type'     => 'field',
                    'view_key'      => 'returned_quantity',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name17,
                    'view_type'     => 'field',
                    'view_key'      => 'buy_number_count',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name18,
                    'view_type'     => 'field',
                    'view_key'      => 'increase_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name19,
                    'view_type'     => 'field',
                    'view_key'      => 'preferential_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name20,
                    'view_type'     => 'field',
                    'view_key'      => 'payment_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'payment_id',
                        'where_type'        => 'in',
                        'data'              => PaymentService::PaymentList(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name21,
                    'view_type'     => 'field',
                    'view_key'      => 'user_note',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name22,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/extension',
                    'grid_size'     => 'sm',
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'extension_data',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name23,
                    'view_type'     => 'field',
                    'view_key'      => 'express_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'express_id',
                        'data'              => ExpressService::ExpressList(),
                        'where_type'        => 'in',
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name24,
                    'view_type'     => 'field',
                    'view_key'      => 'express_number',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name25,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/aftersale',
                    'grid_size'     => 'sm',
                ],
                [
                    'label'         => $name26,
                    'view_type'     => 'module',
                    'view_key'      => 'order/module/is_comments',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'             => 'select',
                        'where_type'            => 'in',
                        'form_name'             => 'user_is_comments',
                        'data'                  => lang('common_is_text_list'),
                        'data_key'              => 'id',
                        'data_name'             => 'name',
                        'where_type_custom'     => 'WhereTypyUserIsComments',
                        'where_value_custom'    => 'WhereValueUserIsComments',
                        'is_multiple'           => 1,
                    ],
                ],
                [
                    'label'         => $name27,
                    'view_type'     => 'field',
                    'view_key'      => 'confirm_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name28,
                    'view_type'     => 'field',
                    'view_key'      => 'pay_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name29,
                    'view_type'     => 'field',
                    'view_key'      => 'delivery_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name30,
                    'view_type'     => 'field',
                    'view_key'      => 'collect_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name31,
                    'view_type'     => 'field',
                    'view_key'      => 'cancel_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name32,
                    'view_type'     => 'field',
                    'view_key'      => 'close_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name33,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name34,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name35,
                    'view_type'     => 'operate',
                    'view_key'      => 'order/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 评论条件符号处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $form_key     [表单数据key]
     * @param   [array]           $params       [输入参数]
     */
    public function WhereTypyUserIsComments($form_key, $params = [])
    {
        if(isset($params[$form_key]))
        {
            // 条件值是 0,1
            // 解析成数组，都存在则返回null，则1 >， 0 =
            $value = explode(',', urldecode($params[$form_key]));
            if(count($value) == 1)
            {
                return in_array(1, $value) ? '>' : '=';
            }
        }
        return null;
    }

    /**
     * 评论条件值处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $form_key     [表单数据key]
     * @param   [array]           $params       [输入参数]
     */
    public function WhereValueUserIsComments($value, $params = [])
    {
        return (count($value) == 2) ? null : 0;
    }

    /**
     * 订单仓库列表
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-29
     * @desc    description
     */
    public function OrderWarehouseList()
    {
        $data = [];
        $wids = Db::name('Order')->column('warehouse_id');
        if(!empty($wids))
        {
            $where = ['id'=>$wids];
            $order_by = 'level desc, id desc';
            $data = Db::name('Warehouse')->field('id,name')->where($where)->order($order_by)->select();
        }
        return $data;
    }

    /**
     * 取货码条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereValueTakeInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取订单 id
            $ids = Db::name('OrderExtractionCode')->where('code', '=', $value)->column('order_id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }

    /**
     * 收件地址条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereValueAddressInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取订单 id
            $ids = Db::name('OrderAddress')->where('name|tel|address', 'like', '%'.$value.'%')->column('order_id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }

    /**
     * 用户信息条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereValueUserInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取用户 id
            $ids = Db::name('User')->where('username|nickname|mobile|email', 'like', '%'.$value.'%')->column('id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }

    /**
     * 基础条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-08
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereBaseGoodsInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 订单ID、订单号
            $ids = Db::name('Order')->where(['id|order_no'=>$value])->column('id');

            // 获取订单详情搜索的订单 id
            if(empty($ids))
            {
                $ids = Db::name('OrderDetail')->where('title|model', 'like', '%'.$value.'%')->column('order_id');
            }

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }
}
?>
