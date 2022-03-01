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

use app\service\WarehouseService;

/**
 * 用户动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-06-08
 * @desc    description
 */
class User
{
    // 基础条件
    public $condition_base = [];

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
			$name1 = '反选';
			$name2 = '全选';
			$name3 = '用户ID';
			$name4 = '头像';
			$name5 = '海外仓';
			$name6 = '用户名';
			$name7 = '昵称';
			$name8 = '微信';
			$name9 = '手机';
			$name10 = '邮箱';
			$name11 = '性别';
			$name12 = '状态';
			$name13 = '所在省';
			$name14 = '所在市';
			$name15 = '详细地址';
			$name16 = '生日';
			$name17 = '可用积分';
			$name18 = '锁定积分';
			$name19 = '出库费';
			$name20 = '手续费';
			$name21 = '注册时间';
			$name22 = '更新时间';
			$name23 = '操作';
		}else{
			$name1 = 'Selecção inversa';
			$name2 = 'Selecionar tudo';
			$name3 = 'ID do utilizador';
			$name4 = 'retrato da cabeça';
			$name5 = 'Armazém no exterior';
			$name6 = 'nome do utilizador';
			$name7 = 'Apelido';
			$name8 = 'WeChat';
			$name9 = 'celular';
			$name10 = 'Correspondência';
			$name11 = 'Gênero sexual';
			$name12 = 'Estado';
			$name13 = 'Província';
			$name14 = 'cidade';
			$name15 = 'Endereço';
			$name16 = 'Aniversário';
			$name17 = 'Pontos Disponíveis';
			$name18 = 'Pontos de bloqueio';
			$name19 = 'Taxa de entrega';
			$name20 = 'taxa de manuseio';
			$name21 = 'Horário de registro';
			$name22 = 'tempo de atualização';
			$name23 = 'operação';
			
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/user/index'),
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/user/delete'),
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
                    //'width'             => 80,
                ],
                [
                    'label'         => $name3,
                    'view_type'     => 'field',
                    'view_key'      => 'id',
                    'width'         => 105,
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'id',
                        'where_type'        => '=',
                    ],
                ],
                [
                    'label'         => $name4,
                    'view_type'     => 'module',
                    'view_key'      => 'user/module/avatar',
                ],
                [
                    'label'         => $name5,
                    'view_type'     => 'field',
                    'view_key'      => 'warehouse_id',
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
                    'view_key'      => 'username',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name7,
                    'view_type'     => 'field',
                    'view_key'      => 'nickname',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name8,
                    'view_type'     => 'field',
                    'view_key'      => 'wechat',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name9,
                    'view_type'     => 'field',
                    'view_key'      => 'mobile',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name10,
                    'view_type'     => 'field',
                    'view_key'      => 'email',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name11,
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
                    'label'         => $name12,
                    'view_type'     => 'field',
                    'view_key'      => 'status',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_user_status_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_user_status_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name13,
                    'view_type'     => 'field',
                    'view_key'      => 'province',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name14,
                    'view_type'     => 'field',
                    'view_key'      => 'city',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name15,
                    'view_type'     => 'field',
                    'view_key'      => 'address',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name16,
                    'view_type'     => 'field',
                    'view_key'      => 'birthday_text',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'date',
                        'form_name'         => 'birthday',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name17,
                    'view_type'     => 'field',
                    'view_key'      => 'integral',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name18,
                    'view_type'     => 'field',
                    'view_key'      => 'locking_integral',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name19,
                    'view_type'     => 'field',
                    'view_key'      => 'out_fee',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => $name20,
                    'view_type'     => 'field',
                    'view_key'      => 'handing_fee',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => $name21,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name22,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name23,
                    'view_type'     => 'operate',
                    'view_key'      => 'user/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }
	
	/**
     * 获取地区组列表
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-11
     * @desc    description
     */
    public function GetWarehouseList()
    {
        // 角色
        $params = [
            'where'     => ['is_delete_time'=>0],
            'field'     => 'id,name',
        ];
        $res = WarehouseService::getWarehouses($params);
        return $res;
    }
}
?>
