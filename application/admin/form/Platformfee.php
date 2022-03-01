<?php
// +----------------------------------------------------------------------
// | 平台费用
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\admin\form;

use app\service\PlatformfeeService;

/**
 * 平台费用动态表格
 * @author  R
 * @version 1.0.0
 * @date    2021-12-16
 * @desc    description
 */
class Platformfee
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  R
     * @version 1.0.0
     * @date    2021-12-16
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_enable',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/platformfee/index'),
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/platformfee/delete'),
                'delete_key'    => 'ids',
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
                    'label'         => '名称',
                    'view_type'     => 'field',
                    'view_key'      => 'name_zh',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'name_zh',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '费用',
                    'view_type'     => 'field',
                    'view_key'      => 'value',
                ],
                [
                    'label'         => '英文名称',
                    'view_type'     => 'field',
                    'view_key'      => 'name_en',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'name_en',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '描述',
                    'view_type'     => 'field',
                    'view_key'      => 'description',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '是否启用',
                    'view_type'     => 'status',
                    'view_key'      => 'is_enable',
                    'post_url'      => MyUrl('admin/platformfee/statusupdate'),
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
                    'label'         => '创建时间',
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => '更新时间',
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => '操作',
                    'view_type'     => 'operate',
                    'view_key'      => 'platformfee/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }
}
?>
