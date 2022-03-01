<?php
// +----------------------------------------------------------------------
// | DMJ
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\admin\form;

use think\Db;
use app\service\WarehouseService;
use app\service\RegionService;

/**
 * 商品入库动态表格
 * @author  R
 * @version 1.0.0
 * @date    2020-07-22
 * @desc    description
 */
class Inbound
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
		$lang = isset($params['lang'])?"&lang=".$params['lang']:"";
		if($params["system_admin"]["lang_type"] == 1){
			$title1 = '基础信息';
			$title2 = '反选';
			$title3 = '全选';
			$title4 = '申请用户';
			$title5 = '申请ID';
			$title6 = '商品信息';
			$title7 = '入库总量';
			$title8 = '状态';
			$title9 = '创建时间';
			$title10 = '更新时间';
			$title11 = '操作';
			$title12 = '请输入用户名/昵称/手机/邮箱';
		}else{
			$title1 = 'Informações Básicas';
            $title2 = 'Inverter seleção';
            $title3 = 'Selecionar tudo';
            $title4 = 'Aplicar usuário';
            $title5 = 'ID do aplicativo';
            $title6 = 'Informações do Produto';
            $title7 = 'Total de entrada';
            $title8 = 'Estado';
            $title9 = 'Hora de Criação';
            $title10 = 'Hora de atualização';
            $title11 = 'Operação';
            $title12 = 'Por favor, digite nome de usuário/apelido/celular/e-mail';
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_enable',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/inbound/index').$lang,
                // 'is_delete'     => 1,
                // 'delete_url'    => MyUrl('admin/inbound/delete'),
                'delete_key'    => 'ids',
                'detail_title'  => $title1,
            ],
            // 表单配置
            'form' => [
                [
                    'view_type'         => 'checkbox',
                    'is_checked'        => 0,
                    'checked_text'      => $title2,
                    'not_checked_text'  => $title3,
                    'align'             => 'center',
                    //'width'             => 80,
                ],
                [
                    'label'         => $title4,
                    'view_type'     => 'module',
                    'view_key'      => 'lib/module/user',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'user_id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueUserInfo',
                        'placeholder'           => $title12,
                    ],
                ],
                [
                    'label'         => $title5,
                    'view_type'     => 'field',
                    'view_key'      => 'put_id',
                    'grid_size'     => 'lg',
                    'is_sort'       => 1,
                    'sort_field'    => 'goods_id',
                ],
                [
                    'label'         => $title6,
                    'view_type'     => 'field',
                    'view_key'      => 'product_name',
                    'align'         => 'center',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => $title7,
                    'view_type'     => 'field',
                    'view_key'      => 'goods_num',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => $title8,
                    'view_type'     => 'field',
                    'view_key'      => 'w.status',
                    'view_data_key' => 'value',
                    'view_data'     => lang('common_warehouse_status_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_warehouse_status_list'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title9,
                    'view_type'     => 'field',
                    'view_key'      => 'w.add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title10,
                    'view_type'     => 'field',
                    'view_key'      => 'w.upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title11,
                    'view_type'     => 'operate',
                    'view_key'      => 'inbound/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 获取入库数据
     * @author  R
     * @version 1.0.0
     * @date    2020-07-22
     * @desc    description
     */
    public function WarehouseList()
    {
        $result = [];
        $ids = array_unique(Db::name('GoodsWarehouse')->column('warehouse_id'));
        if(!empty($ids))
        {
            $ret = WarehouseService::WarehouseIdsAllList($ids);
            if($ret['code'] == 0)
            {
                $result = $ret['data'];
            }
        }
        return $result;
    }

    /**
     * 商品信息条件处理
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereGoodsInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取关联的商品 id
            $ids = Db::name('GoodsWarehouse')->alias('wg')->join(['__GOODS__'=>'g'], 'wg.goods_id=g.id')->where('g.title|g.model', 'like', '%'.$value.'%')->column('wg.id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }
}
?>
