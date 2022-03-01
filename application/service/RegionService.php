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
namespace app\service;

use think\Db;

/**
 * 地区服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class RegionService
{

    /**
     * 获取一条完整地址信息
     * @date    20211217
     */
    public static function Address($params=[])
    {
        if(!$params['zip'])
        {
            return [];
        }

        $addr = Db::name('Region')->alias('r3')
            ->join(['__REGION__'=>'r2'], 'r3.pid=r2.id')
            ->join(['__REGION__'=>'r1'], 'r2.pid=r1.id')
            ->field('r3.id as country,r2.id as city,r1.id as province')
            ->where('r3.zip', $params['zip'])->find();
        return $addr;
    }

    /**
     * 获取地区名称
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-19
     * @desc    description
     * @param   [array|int]          $region_ids [地区id]
     */
    public static function RegionName($region_ids = 0)
    {
        if(empty($region_ids))
        {
            return null;
        }

        // 参数处理查询数据
        if(is_array($region_ids))
        {
            $region_ids = array_filter(array_unique($region_ids));
        }
        if(!empty($region_ids))
        {
            $data = Db::name('Region')->where(['id'=>$region_ids])->column('name', 'id');
        }

        // id数组则直接返回
        if(is_array($region_ids))
        {
            return empty($data) ? [] : $data;
        }
        return (!empty($data) && is_array($data) && array_key_exists($region_ids, $data)) ? $data[$region_ids] : null;
    }

    /**
     * 获取地区id下列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-09T00:13:02+0800
     * @param    [array]                    $params [输入参数]
     */
    public static function RegionItems($params = [])
    {
        $pid = isset($params['pid']) ? intval($params['pid']) : 0;
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'sort asc,id asc' : trim($params['order_by']);
        return Db::name('Region')->field($field)->where(['pid'=>$pid, 'is_enable'=>1])->order($order_by)->select();
    }

    /**
     * 获取地区节点数据
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-21
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function RegionNode($params = [])
    {
        // 数据参数
        $field = empty($params['field']) ? 'id,name,level,letters' : $params['field'];
        $where = empty($params['where']) ? [] : $params['where'];
        $order_by = empty($params['order_by']) ? 'sort asc,id asc' : trim($params['order_by']);

        // 基础条件
        $where['is_enable'] = 1;
        return Db::name('Region')->where($where)->field($field)->order($order_by)->select();
    }

    /**
     * 获取地区节点数据
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-16T23:54:46+0800
     * @param    [array]          $params [输入参数]
     */
    public static function RegionNodeSon($params = [])
    {
        // id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = 'id,pid,name,sort,is_enable';
        $data = Db::name('Region')->field($field)->where(['pid'=>$id])->order('sort asc,id asc')->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('Region')->where(['pid'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }

    /**
     * 地区保存
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-17T01:04:03+0800
     * @param    [array]          $params [输入参数]
     */
    public static function RegionSave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,16',
                'error_msg'         => '名称格式 2~16 个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'name'                  => $params['name'],
            'pid'                   => isset($params['pid']) ? intval($params['pid']) : 0,
            'sort'                  => isset($params['sort']) ? intval($params['sort']) : 0,
            'is_enable'             => isset($params['is_enable']) ? intval($params['is_enable']) : 0,
        ];

        // 添加
        if(empty($params['id']))
        {
            $data['add_time'] = time();
            $data['id'] = Db::name('Region')->insertGetId($data);
            if($data['id'] <= 0)
            {
                return DataReturn('添加失败', -100);
            }
        } else {
            $data['upd_time'] = time();
            if(Db::name('Region')->where(['id'=>intval($params['id'])])->update($data) === false)
            {
                return DataReturn('编辑失败', -100);
            } else {
                $data['id'] = $params['id'];
            }
        }
        return DataReturn('操作成功', 0, json_encode($data));
    }

    /**
     * 地区删除
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-17T02:40:29+0800
     * @param    [array]          $params [输入参数]
     */
    public static function RegionDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '删除数据id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'admin',
                'error_msg'         => '用户信息有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 获取分类下所有分类id
        $ids = self::RegionItemsIds([$params['id']]);
        $ids[] = $params['id'];

        // 开始删除
        if(Db::name('Region')->where(['id'=>$ids])->delete())
        {
            return DataReturn('删除成功', 0);
        }
        return DataReturn('删除失败', -100);
    }

    /**
     * 获取地区下的所有子级id
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-08-29
     * @desc    description
     * @param   [array]          $ids       [id数组]
     * @param   [int]            $is_enable [是否启用 null, 0否, 1是]
     * @param   [string]         $order_by  [排序, 默认sort asc]
     */
    public static function RegionItemsIds($ids = [], $is_enable = null, $order_by = 'sort asc')
    {
        $where = ['pid'=>$ids];
        if($is_enable !== null)
        {
            $where['is_enable'] = $is_enable;
        }
        $data = Db::name('Region')->where($where)->order($order_by)->column('id');
        if(!empty($data))
        {
            $temp = self::RegionItemsIds($data, $is_enable, $order_by);
            if(!empty($temp))
            {
                $data = array_merge($data, $temp);
            }
        }
        $data = empty($data) ? $ids : array_unique(array_merge($ids, $data));
        return $data;
    }

    /**
     * 获取地区所有数据、最多三级
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-12-29
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function RegionAll($params = [])
    {
        // 缓存
        $key = config('shopxo.cache_region_all_key');
        $data = cache($key);
        if(empty($data))
        {
            // 所有一级
            $field = 'id,pid,name';
            $data = self::RegionNode(['field'=>$field,'where'=>['pid'=>0]]);
            if(!empty($data))
            {
                // 所有二级
                $two = self::RegionNode(['field'=>$field,'where'=>['pid'=>array_column($data, 'id')]]);
                $two_group = [];
                $three_group = [];
                if(!empty($two))
                {
                    // 所有三级
                    $three = self::RegionNode(['field'=>$field,'where'=>['pid'=>array_column($two, 'id')]]);
                    if(!empty($three))
                    {
                        // 三级集合组
                        foreach($three as $v)
                        {
                            if(!array_key_exists($v['pid'], $three_group))
                            {
                                $three_group[$v['pid']] = [];
                            }
                            $pid = $v['pid'];
                            unset($v['pid']);
                            $three_group[$pid][] = $v;
                        }
                    }

                    // 二级集合
                    foreach($two as $v)
                    {
                        // 是否存在三级数据
                        $v['items'] = array_key_exists($v['id'], $three_group) ? $three_group[$v['id']] : [];
                        

                        // 集合组
                        if(!array_key_exists($v['pid'], $two_group))
                        {
                            $two_group[$v['pid']] = [];
                        }
                        $pid = $v['pid'];
                        unset($v['pid']);
                        $two_group[$pid][] = $v;
                    }
                }

                // 一级集合
                foreach($data as $k=>$v)
                {
                    $data[$k]['items'] = array_key_exists($v['id'], $two_group) ? $two_group[$v['id']] : [];
                }

                // 存储缓存
                cache($key, $data, 60);
            }
        }

        return DataReturn('success', 0, $data);
    }
}
?>
