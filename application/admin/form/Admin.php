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

use app\service\AdminService;
use app\service\WarehouseService;

/**
 * 管理员动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-06-11
 * @desc    description
 */
class Admin
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
			$name1 = '反选';
			$name2 = '全选';
			$name3 = '管理员';
			$name4 = '状态';
			$name5 = '管理仓库';
			$name6 = '性别';
			$name7 = '手机';
			$name8 = '邮箱';
			$name9 = '角色组';
			$name10 = '登录次数';
			$name11 = '最后登录时间';
			$name12 = '创建时间';
			$name13 = '更新时间';
			$name14 = '操作';
		}else{
			$name1 = 'Selecção inversa';
			$name2 = 'Selecionar tudo';
			$name3 = 'administradores';
			$name4 = 'Estado';
			$name5 = 'Gerenciar armazém';
			$name6 = 'Sexo';
			$name7 = 'telefone celular';
			$name8 = 'caixa postal';
			$name9 = 'Grupo de papéis';
			$name10 = 'Tempo de login';
			$name11 = 'Última hora de login';
			$name12 = 'Tempo de criação';
			$name13 = 'Hora de actualização';
			$name14 = 'operação';
			
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/admin/index'),
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/admin/delete'),
                'delete_key'    => 'ids',
            ],
            // 表单配置
            'form' => [
                [
                    'view_type'         => 'checkbox',
                    'is_checked'        => 0,
                    'checked_text'      => $name1,
                    'not_checked_text'  => $name2,
                    'align'             => 'center',
                    'not_show_key'      => 'id',
                    'not_show_data'     => [1],
                    'width'             => 80,
                ],
                [
                    'label'         => $name3,
                    'view_type'     => 'field',
                    'view_key'      => 'username',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name4,
                    'view_type'     => 'field',
                    'view_key'      => 'status',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_admin_status_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_admin_status_list'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name5,
                    'view_type'     => 'field',
                    'view_key'      => 'area_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => $this->GetWarehouseList(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name6,
                    'view_type'     => 'field',
                    'view_key'      => 'gender',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_gender_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_gender_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name7,
                    'view_type'     => 'field',
                    'view_key'      => 'mobile',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name8,
                    'view_type'     => 'field',
                    'view_key'      => 'email',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name9,
                    'view_type'     => 'field',
                    'view_key'      => 'role_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'role_id',
                        'where_type'        => 'in',
                        'data'              => $this->GetRoleList(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name10,
                    'view_type'     => 'field',
                    'view_key'      => 'login_total',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name11,
                    'view_type'     => 'field',
                    'view_key'      => 'login_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name12,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name13,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name14,
                    'view_type'     => 'operate',
                    'view_key'      => 'admin/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 获取角色组列表
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-11
     * @desc    description
     */
    public function GetRoleList()
    {
        // 角色
        $params = [
            'where'     => ['is_enable'=>1],
            'field'     => 'id,name',
        ];
        $res = AdminService::RoleList($params);
        return $res['data'];
    }
	
	/**
     * 获取仓库列表
     * @author  H
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-11
     * @desc    description
     */
    public function GetWarehouseList()
    {
        $params = [
            'where'     => ['is_delete_time'=>0],
            'field'     => 'id,name',
        ];
        $res = WarehouseService::getWarehouses($params);
        return $res;
    }
}
?>
