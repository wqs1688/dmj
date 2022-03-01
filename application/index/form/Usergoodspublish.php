<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
namespace app\index\form;

use think\Db;

/**
 * 用户商品发布管理动态表格
 * @author  R
 * @version 1.0.0
 * @date    2021-07-08
 * @desc    description
 */
class UserGoodsPublish
{
    // 基础条件
    public $condition_base = [];

    /**
     * @author  R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function __construct($params = [])
    {
        // 用户信息
        if(!empty($params['system_user']))
        {
            $this->condition_base[] = ['p.user_id', '=', $params['system_user']['id']];
        }
    }

    /**
     * 入口
     * @author  R
     * @version 1.0.0
     * @date    2021-07-30
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
                'search_url'    => MyUrl('index/usergoodspublish/index'),
                // 'is_delete'     => 1,
                // 'delete_url'    => MyUrl('index/usergoodspublish/delete'),
                // 'delete_key'    => 'ids',
                'is_add'        => 1,
                'add_url'       => MyUrl('index/usergoodspublish/add'),
                'add_form'      => MyUrl('index/usergoodspublish/addform'),
            ],
            // 表单配置
            'form' => [
                [
                    'view_type'         => 'checkbox',
                    'is_checked'        => 0,
                    'checked_text'      => '反选',
                    'not_checked_text'  => '全选',
                    'align'             => 'center',
                    'width'             => 80,
                ],
                [
                    'label'         => '商品信息',
                    'view_type'     => 'module',
                    'view_key'      => 'usergoodspublish/module/goods',
                    'grid_size'     => 'lg',
                    'is_sort'       => 1,
                    'sort_field'    => 'g.title',
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'g.title|g.model|g.simple_desc|g.seo_title|g.seo_keywords|g.seo_keywords',
                        'where_type'        => 'like',
                        'placeholder'       => '请输入商品名称/简述/SEO信息'
                    ],
                ],
                [
                    'label'         => '分销价格(日本円)',
                    'view_type'     => 'module',
                    'view_key'      => 'usergoodspublish/module/price',
                    'grid_size'     => 'lg',
                ],
                [
                    'label'         => '状态',
                    'view_type'     => 'field',
                    'view_key'      => 'is_shelves',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_is_shelves_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_is_shelves_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => '在库数',
                    'view_type'     => 'field',
                    'view_key'      => 'inventory_private',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'form_name'         => 'g.inventory_private',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => '登录时间',
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                        'form_name'         => 'p.add_time',
                    ],
                ],
                [
                    'label'         => '操作',
                    'view_type'     => 'operate',
                    'view_key'      => 'usergoodspublish/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }
}
?>
