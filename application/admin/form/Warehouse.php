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
 * 仓库动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-07-07
 * @desc    description
 */
class Warehouse
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
     * @date    2020-06-16
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
        $lang = isset($params['lang'])?"&lang=".$params['lang']:"";
		if($params["system_admin"]["lang_type"] == 1){
			$title1 = '是否启用';
			$title2 = '反选';
			$title3 = '全选';
			$title4 = '名称/别名';
			$title5 = '权重';
			$title6 = '创建时间';
			$title7 = '更新时间';
			$title8 = '操作';
			$title9 = '联系人';
			$title10 = '联系电话';
			$title11 = '所在省';
			$title12 = '所在市';
			$title13 = '所在区/县';
			$title14 = '详细地址';
			$title15 = '经纬度';
		}else{
			$title1 = 'Ativar ou não';
            $title2 = 'Inverter seleção';
            $title3 = 'Selecionar tudo';
            $title4 = 'Nome/Alias';
            $title5 = 'Peso';
            $title6 = 'Hora de Criação';
            $title7 = 'Hora de atualização';
            $title8 = 'Operação';
            $title9 = 'Contato';
            $title10 = 'Telefone de contato';
            $title11 = 'Província';
            $title12 = 'Localização Cidade';
            $title13 = 'Localização Distrito/Condado';
            $title14 = 'Endereço detalhado';
            $title15 = 'latitude e longitude';
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_enable',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/warehouse/index').$lang,
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/warehouse/delete'),
                'delete_key'    => 'ids',
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
                    'label'         => $title4,
                    'view_type'     => 'module',
                    'view_key'      => 'warehouse/module/info',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'sort_field'    => 'name',
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'name|alias',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $title5,
                    'view_type'     => 'field',
                    'view_key'      => 'level',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $title1,
                    'view_type'     => 'status',
                    'view_key'      => 'is_enable',
                    'post_url'      => MyUrl('admin/warehouse/statusupdate'),
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
                    'label'         => $title9,
                    'view_type'     => 'field',
                    'view_key'      => 'contacts_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $title10,
                    'view_type'     => 'field',
                    'view_key'      => 'contacts_tel',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $title11,
                    'view_type'     => 'field',
                    'view_key'      => 'province_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'province',
                        'data'              => $this->RegionItems('province'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title12,
                    'view_type'     => 'field',
                    'view_key'      => 'city_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'city',
                        'data'              => $this->RegionItems('city'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title13,
                    'view_type'     => 'field',
                    'view_key'      => 'county_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'county',
                        'data'              => $this->RegionItems('county'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $title14,
                    'view_type'     => 'field',
                    'view_key'      => 'address',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $title15,
                    'view_type'     => 'module',
                    'view_key'      => 'warehouse/module/position',
                    'grid_size'     => 'sm',
                ],
                [
                    'label'         => $title6,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title7,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $title8,
                    'view_type'     => 'operate',
                    'view_key'      => 'warehouse/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 获取地区数据
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-08
     * @desc    description
     * @param   [string]          $field [地区字段]
     */
    public function RegionItems($field)
    {
        $result = [];
        $ids = Db::name('Warehouse')->where($this->condition_base)->column($field);
        if(!empty($ids))
        {
            $result = RegionService::RegionNode(['field'=>'id,name', 'where'=>['id'=>$ids]]);
        }
        return $result;
    }
}
?>
