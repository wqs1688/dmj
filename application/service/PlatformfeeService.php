<?php
// +----------------------------------------------------------------------
// | 平台费用
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\service;

use think\Db;
use app\service\GoodsService;

/**
 * 平台费用服务层
 * @author   R
 * @version  0.0.1
 * @datetime 2021-12-16
 */
class PlatformfeeService
{
    /**
     * 列表
     * @author   R
     * @version 1.0.0
     * @date    2021-12-16
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function FeeList($params = [])
    {
        $field = empty($params['field']) ? '*' : $params['field'];
        $where = empty($params['where']) ? [] : $params['where'];
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);
        $data = Db::name('PlatformFee')->field($field)->where($where)->order($order_by)->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                // 时间
                if(isset($v['add_time']))
                {
                    $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                }
                if(isset($v['upd_time']))
                {
                    $v['upd_time'] = empty($v['upd_time']) ? '' : date('Y-m-d H:i:s', $v['upd_time']);
                }
            }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 保存
     * @author   R
     * @version 1.0.0
     * @date    2021-12-16
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function FeeSave($params = [])
    {
        // 请求类型
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name_zh',
                'checked_data'      => '2,16',
                'error_msg'         => '名称格式 2~16 个字符',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'name_en',
                'checked_data'      => '2,16',
                'error_msg'         => '英文名称格式 2~16 个字符',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'is_enable',
                'checked_data'      => [0,1],
                'error_msg'         => '是否显示范围值有误',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'description',
                'checked_data'      => '60',
                'error_msg'         => '描述不能大于60个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'name_zh'                   => $params['name_zh'],
            'description'               => $params['description'],
            'name_en'                   => $params['name_en'],
            'value'                     => $params['value'],
            'is_enable'                 => intval($params['is_enable']),
        ];

        if(empty($params['id']))
        {
            $data['add_time'] = time();
            if(Db::name('PlatformFee')->insertGetId($data) > 0)
            {
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            $data['upd_time'] = time();
            if(Db::name('PlatformFee')->where(['id'=>intval($params['id'])])->update($data))
            {
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100); 
        }
    }

    /**
     * 删除
     * @author   R
     * @version 1.0.0
     * @date    2021-12-16
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function FeeDelete($params = [])
    {
        // 参数是否有误
        if(empty($params['ids']))
        {
            return DataReturn('操作id有误', -1);
        }
        // 是否数组
        if(!is_array($params['ids']))
        {
            $params['ids'] = explode(',', $params['ids']);
        }

        // 删除操作
        if(Db::name('PlatformFee')->where(['id'=>$params['ids']])->delete())
        {
            return DataReturn('删除成功');
        }

        return DataReturn('删除失败', -100);
    }

    /**
     * 状态更新
     * @author   R
     * @version  0.0.1
     * @datetime 2021-12-16
     * @param    [array]          $params [输入参数]
     */
    public static function FeeStatusUpdate($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'field',
                'error_msg'         => '未指定操作字段',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'state',
                'checked_data'      => [0,1],
                'error_msg'         => '状态有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据更新
        if(Db::name('PlatformFee')->where(['id'=>intval($params['id'])])->update([$params['field']=>intval($params['state']), 'upd_time'=>time()]))
        {
            return DataReturn('编辑成功');
        }
        return DataReturn('编辑失败', -100);
    }

    /**
     * 查询所有平台费用值
     */
    public static function AllFee($params=[])
    {
        $data = Db::name('PlatformFee')->where('is_enable', 1)->column('value', 'name_en');

        return DataReturn('处理成功', 0, $data);
    }
}
?>
