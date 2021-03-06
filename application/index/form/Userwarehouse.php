<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
namespace app\index\form;

use think\Db;

/**
 * 用户申请入库管理动态表格
 * @author  R
 * @version 1.0.0
 * @date    2021-07-08
 * @desc    description
 */
class UserWareHouse
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
            $this->condition_base[] = ['w.user_id', '=', $params['system_user']['id']];
            $this->condition_base[] = ['w.del_flg', '=', 0];
        }
    }

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-30
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
                'search_url'    => MyUrl('index/userwarehouse/index'),
                // 'is_delete'     => 1,
                // 'delete_url'    => MyUrl('index/userwarehouse/delete'),
                // 'delete_key'    => 'ids',
                'is_add'        => 1,
                'add_url'       => MyUrl('index/userwarehouse/add'),
                'add_form'      => MyUrl('index/userwarehouse/addform'),
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
                    'label'         => "入库ID",
                    'view_type'     => 'field',
                    'view_key'      => 'put_id',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => '入库日期',
                    'view_type'     => 'module',
                    'view_key'      => 'userwarehouse/module/date',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                        'form_name'         => 'w.add_time',
                    ],
                ],
                [
                    'label'         => '状态',
                    'view_type'     => 'field',
                    'view_key'      => 'status',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_warehouse_status_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_warehouse_status_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => '商品信息',
                    'view_type'     => 'field',
                    'view_key'      => 'product_name',
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
                    'label'         => '入库依赖数',
                    'view_type'     => 'module',
                    'view_key'      => 'userwarehouse/module/rely',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => '入库实际数',
                    'view_type'     => 'module',
                    'view_key'      => 'userwarehouse/module/real',
                    'is_sort'       => 1,
                ],
                [
                    'label'         => '仓储费(SKU/日)',
                    'view_type'     => 'field',
                    'view_key'      => 'price',
                    'is_sort'       => 1
                ],
                [
                    'label'         => '操作',
                    'view_type'     => 'operate',
                    'view_key'      => 'userwarehouse/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }
}
?>
