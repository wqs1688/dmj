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
use app\service\RegionService;

/**
 * 用户地址动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-06-19
 * @desc    description
 */
class UserAddress
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-18
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
		if($params["system_admin"]["lang_type"] == 1){
			$name1 = '反选';
			$name2 = '全选';
			$name3 = '用户信息';
			$name4 = '别名';
			$name5 = '联系人';
			$name6 = '联系电话';
			$name7 = '所属市';
			$name8 = '所属区/县';
			$name9 = '详细地址';
			$name10 = '经纬度';
			$name11 = '身份证信息';
			$name12 = '是否默认';
			$name13 = '创建时间';
			$name14 = '更新时间';
			$name15 = '操作';
			$name16 = '所属省';
		}else{
			$name1 = 'Selecção inversa';
			$name2 = 'Selecionar tudo';
			$name3 = 'pseudônimo';
			$name4 = 'retrato da cabeça';
			$name5 = 'contato';
			$name6 = 'número de contato';
			$name7 = 'Cidade';
			$name8 = 'Distrito/Condado';
			$name9 = 'Endereço';
			$name10 = 'latitude e longitude';
			$name11 = 'Informações de identificação';
			$name12 = 'padrão';
			$name13 = 'tempo de criação';
			$name14 = 'tempo de atualização';
			$name15 = 'operação';
			$name16 = 'Província';
			
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/useraddress/index'),
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/useraddress/delete'),
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
                    'width'             => 80,
                ],
                [
                    'label'         => $name3,
                    'view_type'     => 'module',
                    'view_key'      => 'lib/module/user',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'user_id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueUserInfo',
                        'placeholder'           => '请输入用户名/昵称/手机/邮箱',
                    ],
                ],
                [
                    'label'         => $name4,
                    'view_type'     => 'field',
                    'view_key'      => 'alias',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name5,
                    'view_type'     => 'field',
                    'view_key'      => 'name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name6,
                    'view_type'     => 'field',
                    'view_key'      => 'tel',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name16,
                    'view_type'     => 'field',
                    'view_key'      => 'province_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'province',
                        'data'              => $this->RegionProvinceItems(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name7,
                    'view_type'     => 'field',
                    'view_key'      => 'city_name',
                    'is_sort'       => 1,
                    'sort_field'    => 'city',
                ],
                [
                    'label'         => $name8,
                    'view_type'     => 'field',
                    'view_key'      => 'county_name',
                    'is_sort'       => 1,
                    'sort_field'    => 'county',
                ],
                [
                    'label'         => $name9,
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
                    'label'         => $name10,
                    'view_type'     => 'module',
                    'view_key'      => 'useraddress/module/position',
                    'grid_size'     => 'sm',
                ],
                [
                    'label'         => $name11,
                    'view_type'     => 'module',
                    'view_key'      => 'useraddress/module/idcard_info',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'sort_field'    => 'idcard_number',
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'idcard_name|idcard_number',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name12,
                    'view_type'     => 'module',
                    'view_key'      => 'useraddress/module/is_default',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'is_default',
                        'where_type'        => 'in',
                        'data'              => lang('common_is_text_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name13,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name14,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name15,
                    'view_type'     => 'operate',
                    'view_key'      => 'useraddress/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 用户信息条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-30
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
     * 获取地区省份数据
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-08
     * @desc    description
     */
    public function RegionProvinceItems()
    {
        return RegionService::RegionNode(['field'=>'id,name', 'where'=>['pid'=>0]]);;
    }
}
?>