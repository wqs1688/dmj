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

/**
 * 角色管理动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-06-11
 * @desc    description
 */
class Role
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-11
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
		if($params["system_admin"]["lang_type"] == 1){
			$title1 = '基础信息';
			$title2 = '反选';
			$title3 = '全选';
			$title4 = '角色名称';
			$title5 = '状态';
			$title6 = '创建时间';
			$title7 = '更新时间';
			$title8 = '操作';
		}else{
			$title1 = 'Informação de base';
			$title2 = 'Selecção inversa';
			$title3 = 'Selecionar tudo';
			$title4 = 'Nome do papel';
			$title5 = 'Estado';
			$title6 = 'Tempo de criação';
			$title7 = 'Hora de actualização';
			$title8 = 'operação';
			
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_enable',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/role/index'),
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/role/delete'),
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
                    'not_show_data'     => [1],
                    'not_show_key'      => 'id',
                    'width'             => 80,
                ],
                [
                    'label'         => $title4,
                    'view_type'     => 'field',
                    'view_key'      => 'name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $title5,
                    'view_type'     => 'status',
                    'view_key'      => 'is_enable',
                    'post_url'      => MyUrl('admin/role/statusupdate'),
                    'is_form_su'    => 1,
                    'align'         => 'center',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_is_text_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
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
                    'view_key'      => 'role/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }
}
?>