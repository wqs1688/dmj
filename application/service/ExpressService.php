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
use app\service\ResourcesService;

/**
 * 快递服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ExpressService
{
    /**
     * 获取地区名称
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-19
     * @desc    description
     * @param   [array|int]          $express_ids [快递id]
     */
    public static function ExpressName($express_ids = 0)
    {
        if(empty($express_ids))
        {
            return null;
        }

        // 参数处理查询数据
        if(is_array($express_ids))
        {
            $express_ids = array_filter(array_unique($express_ids));
        }
        if(!empty($express_ids))
        {
            $data = Db::name('Express')->where(['id'=>$express_ids])->column('name', 'id');
        }

        // id数组则直接返回
        if(is_array($express_ids))
        {
            return empty($data) ? [] : $data;
        }
        return (!empty($data) && is_array($data) && array_key_exists($express_ids, $data)) ? $data[$express_ids] : null;
    }

    /**
     * 快递列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-19
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function ExpressList($params = [])
    {
        $where = [];
        if(isset($params['is_enable']))
        {
            $where['is_enable'] = intval($params['is_enable']);
        }
        if(isset($params['warehouse_id']))
        {
            $ret = Db::name('Warehouse')->where(['id'=>$params['warehouse_id']])->field('city')->select();
            $where['city'] = $ret[0]['city'];

        }
        $data = Db::name('Express')->where($where)->field('id,icon,name,sort,is_enable')->order('sort asc')->select();
        return self::DataHandle($data);
    }

    /**
     * 数据处理
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-06
     * @desc    description
     * @param   [array]          $data [二维数组]
     */
    public static function DataHandle($data)
    {
        if(!empty($data) && is_array($data))
        {
            foreach($data as &$v)
            {
                if(is_array($v))
                {
                    if(array_key_exists('icon', $v))
                    {
                        $v['icon'] = ResourcesService::AttachmentPathViewHandle($v['icon']);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 获取快递节点数据
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-16T23:54:46+0800
     * @param    [array]          $params [输入参数]
     */
    public static function ExpressNodeSon($params = [])
    {
        // id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = 'id,pid,icon,name,sort,is_enable';
        $data = Db::name('Express')->field($field)->where(['pid'=>$id])->order('sort asc')->select();
        if(!empty($data))
        {
            $data = self::DataHandle($data);
            foreach($data as &$v)
            {
                $method = Db::name('ExpressMethod')->field('method_name,method_price')->where(['pid'=>$v['id']])->select();
                $v['method']    = $method;
                $v['is_son']    = (Db::name('Express')->where(['pid'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['json']      = json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }

    /**
     * 快递保存
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-17T01:04:03+0800
     * @param    [array]          $params [输入参数]
     */
    public static function ExpressSave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,30',
                'error_msg'         => '名称格式 2~30 个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 其它附件
        $data_fields = ['icon'];
        $attachment = ResourcesService::AttachmentParams($params, $data_fields);
        if($attachment['code'] != 0)
        {
            return $attachment;
        }

        // 数据
        $data = [
            'name'                  => $params['name'],
            'pid'                   => isset($params['pid']) ? intval($params['pid']) : 0,
            'sort'                  => isset($params['sort']) ? intval($params['sort']) : 0,
            'is_enable'             => isset($params['is_enable']) ? intval($params['is_enable']) : 0,
            'icon'                  => $attachment['data']['icon'],
            'province'              => $params['province'],
            'city'                  => $params['city'],
            'county'                => $params['county'],
        ];

        // 添加
        if(empty($params['id']))
        {
            $data['add_time'] = time();
            $data['id'] = Db::name('Express')->insertGetId($data);
            if($data['id'] <= 0)
            {
                return DataReturn('添加失败', -100);
            } 
        } else {
            $data['upd_time'] = time();
            if(Db::name('Express')->where(['id'=>intval($params['id'])])->update($data) === false)
            {
                return DataReturn('编辑失败', -100);
            } else {
                $data['id'] = $params['id'];
                $updata['del_flg'] = 1;
                Db::name('ExpressMethod')->where(['pid'=>intval($params['id'])])->update($updata);
            }
        }
        if(isset($params['method']) && count($params['method'])>0){
            foreach($params['method'] as $key=>$val){
                $method['pid'] = $data['id'];
                $method['method_name'] = $val;
                $method['method_price'] = $params['price'][$key];
                $method['add_time'] = time();
                Db::name('ExpressMethod')->insertGetId($method);
            }
        }

        $res = self::DataHandle([$data]);
        return DataReturn('操作成功', 0, json_encode($res[0]));
    }

    /**
     * 快递删除
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-17T02:40:29+0800
     * @param    [array]          $params [输入参数]
     */
    public static function ExpressDelete($params = [])
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

        // 开始删除
        if(Db::name('Express')->where(['id'=>intval($params['id'])])->delete())
        {
            return DataReturn('删除成功', 0);
        }
        return DataReturn('删除失败', -100);
    }

    public static function getExpressPrice($express,$flg = 1){
        $field = 'name,method_name,method_price';
        if($flg == 1){
            $where = ['em.pid'=>$express];
        }else{
            $where = ['es.name'=>$express];
        }
        $data = Db::name('ExpressMethod')->alias('em')->join(['__EXPRESS__'=>'es'], 'em.pid=es.id')
                    ->field($field)->where($where)->select();
        return $data;
    }
}
?>
