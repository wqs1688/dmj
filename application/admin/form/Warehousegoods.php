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
use app\service\WarehouseService;
use app\service\RegionService;

/**
 * 仓库商品动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-07-12
 * @desc    description
 */
class WarehouseGoods
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-16
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
			$title4 = '请输入商品名称/型号';
			$title5 = '仓库';
			$title6 = '是否启用';
			$title7 = '总库存';
			$title8 = '创建时间';
			$title9 = '更新时间';
			$title10 = '操作';
		}else{
			$title1 = 'Informações Básicas';
            $title2 = 'Inverter seleção';
            $title3 = 'Selecionar tudo';
            $title4 = 'Por favor, digite o nome/modelo do produto';
            $title5 = 'Armazém';
            $title6 = 'Ativar ou não';
            $title7 = 'Inventário Total';
            $title8 = 'Hora de Criação';
            $title9 = 'Hora de atualização';
            $title10 = 'Operação';
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_enable',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/warehousegoods/index').$lang,
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/warehousegoods/delete'),
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
                    'width'             => 80,
                ],
                [
                    'label'         => $title1,
                    'view_type'     => 'module',
                    'view_key'      => 'warehousegoods/module/goods',
                    'grid_size'     => 'lg',
                    'is_sort'       => 1,
                    'sort_field'    => 'goods_id',
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereGoodsInfo',
                        'placeholder'           => $title4,
                    ],
                ],
                [
                    'label'         => $title5,
                    'view_type'     => 'field',
                    'view_key'      => 'warehouse_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'warehouse_id',
                        'data'              => $this->WarehouseList(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title6,
                    'view_type'     => 'status',
                    'view_key'      => 'is_enable',
                    'post_url'      => MyUrl('admin/warehousegoods/statusupdate').$lang,
                    'is_form_su'    => 1,
                    'align'         => 'center',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_is_enable_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title7,
                    'view_type'     => 'field',
                    'view_key'      => 'inventory',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $title8,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title9,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title10,
                    'view_type'     => 'operate',
                    'view_key'      => 'warehousegoods/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 获取仓库数据
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-12
     * @desc    description
     */
    public function WarehouseList()
    {
        $result = [];
        $ids = array_unique(Db::name('WarehouseGoods')->column('warehouse_id'));
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
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-12
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereGoodsInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取关联的商品 id
            $ids = Db::name('WarehouseGoods')->alias('wg')->join(['__GOODS__'=>'g'], 'wg.goods_id=g.id')->where('g.title|g.model', 'like', '%'.$value.'%')->column('wg.id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }
}
?>