<?php
// +----------------------------------------------------------------------
// | DamaiJia
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\service;

use think\Db;
use think\facade\Hook;
use app\service\ResourcesService;
use app\service\GoodsService;
use app\service\UserService;
use app\service\WarehouseService;

/**
 * 用户商品入库服务层
 * @author  R
 * @version 1.0.0
 * @date    2021-07-19
 * @desc    description
 */
class UserWarehouseService
{
    /**
     * 数据列表
     * @author  R
     * @version 1.0.0
     * @date    2021-07-19
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function UserWarehouseList($params = [])
    {
        $where = empty($params['where']) ? ["w.del_flg"=>0] : $params['where'];
        $field = empty($params['field']) ? 'w.id,w.user_id,w.status,w.put_id,w.add_time,w.upd_time,sum(d.good_num) as goods_num,GROUP_CONCAT(g.title) as product_name,check_info,express_id,count(g.title) as sku_cnt,count(b.box_id) as box_cnt,sum(good_num) as good_cnt' : $params['field'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        $order_by = empty($params['order_by']) ? 'w.id desc' : trim($params['order_by']);
        $data = Db::name('GoodsWarehouse')->alias('w')
                ->join(['__GOODS_WAREHOUSE_BOX__'=>'b'],'w.put_id=b.put_id')
                ->join(['__GOODS_WAREHOUSE_BOX_DETAIL__'=>'d'],'b.box_id=d.box_id')
                ->join(['__GOODS__'=>'g'], 'g.id=d.good_id')
                ->join(['__USER__'=>'u'], 'u.id=w.user_id')
                ->field($field)->where($where)->group('w.put_id')
                ->order($order_by)->limit($m, $n)->select();
        //->join(['__GOODS__'=>'g'], 'g.id=w.goods_id')->field($field)->where($where)->order($order_by)->limit($m, $n)->select();
        if(!empty($data))
        {
            // 商品数据处理
            $ret = GoodsService::GoodsDataHandle($data, ['data_key_field'=>'goods_id']);
            $data = $ret['data'];

                foreach($data as &$v)
                {
                    // 商品尺寸重量信息
                    //$v['goods_size_weight'] = self::GoodsSizeWeightViewInfo($v['goods_size_weight']);

                    // 商品规格信息
                    //$v['goods_num'] = self::GoodsNumViewInfo($v['goods_num']);
                    $hdata = Db::name('WarehouseGoodsHistory')->field('count(goods_sku) as sku_cnt,sum(inventory) as good_cnt,add_time,price')
                                  ->where(['put_id'=>$v['put_id']])->group('put_id')->select();
                    if(count($hdata) > 0){
                        $v['real_sku_cnt'] = $hdata[0]['sku_cnt'];
                        $v['real_good_cnt'] = $hdata[0]['good_cnt'];
                        $v['real_add_time'] =  date('Y-m-d H:i:s', intval($hdata[0]['add_time']));
                        $v['price'] = $hdata[0]['price'];
                    }else{
                        $v['real_sku_cnt'] = '-';
                        $v['real_good_cnt'] = '-';
                        $v['price'] = '-';
                        $v['real_add_time'] = '-';
                    }
                    $v['user'] = UserService::GetUserViewInfo($v['user_id']);
                }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * admin 入库信息
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]          $data [需要处理的数据]
     */
    public static function InboundList($params = [])
    {
        $where = ["del_flg"=> 1];
        $field = empty($params['field']) ? 'w.*, g.title, g.price, g.min_price, g.images, g.is_shelves' : $params['field'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;
        
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);
        $data = array();//Db::name('GoodsWarehouse')->alias('w')->join(['__GOODS__'=>'g'], 'g.id=w.goods_id')->field($field)->where($where)->order($order_by)->limit($m, $n)->select();
        
        if(!empty($data))
        {
            // 字段列表
            $keys = ArrayKeys($data);

            // 获取商品信息
            if(in_array('goods_id', $keys))
            {
                $goods_params = [
                    'where' => [
                        'id'                => array_unique(array_column($data, 'goods_id')),
                        'is_delete_time'    => 0,
                    ],
                    'field'  => 'id,title,images,price,min_price',
                    'm'      => 0,
                    'n'      => 0,
                ];
                $ret = GoodsService::GoodsList($goods_params);
                $goods = [];
                if(!empty($ret['data']))
                {
                    foreach($ret['data'] as $g)
                    {
                        $goods[$g['id']] = $g;
                    }
                }
            }

            // 仓库名称
            if(in_array('warehouse_id', $keys))
            {
                $warehouse = [];
                $w_ret = WarehouseService::WarehouseIdsAllList(array_column($data, 'warehouse_id'));
                if(!empty($w_ret['data']))
                {
                    foreach($w_ret['data'] as $wv)
                    {
                        $warehouse[$wv['id']] = $wv['name'];
                    }
                }
            }

            // 数据处理
            foreach($data as &$v)
            {
                // 商品尺寸重量信息
                $v['goods_size_weight'] = self::GoodsSizeWeightViewInfo($v['goods_size_weight']);

                // 商品规格信息
                $v['goods_num'] = self::GoodsNumViewInfo($v['goods_num']);
                
                // 用户
                if(isset($v['user_id']))
                {
                    $v['user'] = UserService::GetUserViewInfo($v['user_id']);
                }

                // 商品信息
                if(isset($v['goods_id']))
                {
                    $v['goods'] = isset($goods[$v['goods_id']]) ? $goods[$v['goods_id']] : [];
                }

                // 仓库
                if(isset($v['warehouse_id']))
                {
                    $v['warehouse_name'] = isset($warehouse[$v['warehouse_id']]) ? $warehouse[$v['warehouse_id']] : '';
                }

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
        return $data;
    }

    /**
     * 总数
     * @author  R
     * @version 1.0.0
     * @date    2021-07-19
     * @desc    description
     * @param   [array]          $where [条件]
     */
    public static function UserWarehouseTotal($where = [])
    {
        $cnt = (int)Db::name('GoodsWarehouse')->alias('w')
                ->join(['__USER__'=>'u'], 'u.id=w.user_id')->where($where)->count();
        return $cnt;
    }

    /**
     * 删除
     * @author   R
     * @version 1.0.0
     * @date    2021-07-19
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function UserWarehouseDelete($params = [])
    {
        // 参数是否有误
        if(empty($params['ids']))
        {
            return DataReturn('id有误', -1);
        }
        // 是否数组
        if(!is_array($params['ids']))
        {
            $params['ids'] = explode(',', $params['ids']);
        }

        // 启动事务
        Db::startTrans();

        // 循环处理删除
        foreach($params['ids'] as $k=>$id)
        {
            // 位置
            $index = $k+1;

            // 获取数据
            $warehouse_goods = Db::name('GoodsWarehouse')->where(['id'=>intval($id)])->find();
            if(empty($warehouse_goods))
            {
                return DataReturn('第'.$index.'条数据不存在', -1);
            }

            // 删除商品入库数据
            $where = [
                'id'      => $id
            ];
            // if(Db::name('GoodsWarehouse')->where($where)->delete() !== false)
            // {
            //     // 同步商品库存
            //     $ret = self::GoodsSpecInventorySync($warehouse_goods['goods_id']);
            //     if($ret['code'] != 0)
            //     {
            //         Db::rollback();
            //         return $ret;
            //     }
            // } else {
            //     Db::rollback();
            //     return DataReturn('第'.$index.'删除失败', -100);
            // }
        }

        // 提交事务
        Db::commit();
        return DataReturn('删除成功', 0);
    }

    /**
     * 商品入库信息保存
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function UserWarehouseSave($params = [])
    {
        $ret = self::ParamsCheck($params);
        if($ret !== true)
        {
            //return DataReturn($ret, -1);
        }

        // 启动事务
        Db::startTrans();

        // 捕获异常
        try {

            // 入库申请信息保存
            $ret = self::WarehouseGoodsAdd($params);
            if($ret['code'] != 0)
            {
                throw new \Exception($ret['msg']);
            }

            // 完成
            Db::commit();
            return DataReturn('操作成功', 0);
        } catch(\Exception $e) {
            Db::rollback();
            return DataReturn($e->getMessage(), -1);
        }
    }

    /**
     * 入库信息保存
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function WarehouseGoodsAdd($params = [])
    {
		$user_id=$params['user']['id'];
        $warehouse_id=$params['warehouse_id'];
		if(isset($params['put_id']) && $params['put_id']){
			$where=[
            'put_id'    => $params['put_id'],
            ];
			$up_data=[
            'del_flg' => 1,
            'upd_time'  => time(),
            ];
			Db::name('GoodsWarehouse')->where($where)->update($up_data);
		}
		// 生成入库ID （‘R'+userId+日期）
		$put_id = 'R'.sprintf('%03d',$user_id).date('YmdHis',time());
		
		$data = [
            'put_id'        => $put_id,
            'user_id'       => $user_id,
            'warehouse_id'  => $warehouse_id,
            'add_time'      => time(),
            'upd_time'      => time()
        ];
        if(Db::name('GoodsWarehouse')->insertGetId($data) <= 0)
        {
            return DataReturn('入库申请失败', -100);
        }
		$box_cnt = count($params['parameters_long'])-1;
		for($i=0;$i<$box_cnt;$i++){
			//入库的外箱信息
			$box_data = [
			    'put_id'        => $put_id,
				'box_id'        => $put_id.sprintf("%02d",$i),
				'box_length'    => $params["parameters_long"][$i],
				'box_width'     => $params["parameters_width"][$i],
				'box_height'    => $params["parameters_height"][$i],
                'box_weight'    => $params["parameters_weight"][$i],
				'add_time'      => time(),
                'upd_time'      => time()
			];
			if(Db::name('GoodsWarehouseBox')->insertGetId($box_data) <= 0)
            {
                return DataReturn('入库申请失败', -100);
            }
			$product_cnt = count($params["parameters_sku".$i]);
			for($j=0;$j<$product_cnt;$j++){
				$product_data = [
				    'box_id'        => $put_id.sprintf("%02d",$i),
				    'good_id'       => $params["goods_id".$i][$j],
				    'good_sku'      => $params["parameters_sku".$i][$j],
				    'good_num'      => $params["parameters_cnt".$i][$j],
				    'add_time'      => time(),
                    'upd_time'      => time()
				];
				if(Db::name('GoodsWarehouseBoxDetail')->insertGetId($product_data) <= 0)
                {
                    return DataReturn('入库申请失败', -100);
                }
			}
		}
        return DataReturn('入库申请成功', 0);
    }

    /**
     * 仓库商品库存保存
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function WarehouseGoodsInventorySave($params = [])
    {
        // 获取仓库商品
        $where = [
            'goods_id'    => intval($params['goods_id']),
        ];
        $warehouse_goods = Db::name('WarehouseGoods')->where($where)->find();
        if(empty($warehouse_goods))
        {
            return DataReturn('无相关商品数据', -1);
        }

        // 获取商品的现有规格数据
        $where = [
            'warehouse_id'          => $warehouse_goods['warehouse_id'],
            'goods_id'              => $warehouse_goods['goods_id'],
        ];
        $warehouse_goods_spec = Db::name('WarehouseGoodsSpec')->where($where)->select();

        // 数据组装
        $inventory = [];
        $spec_value = [];
        $md5_key = [];
        $data = [];
        foreach($params['specifications_spec'] as $k=>$v)
        {
            // 规格值,md5key,库存 必须存在
            if(!empty($v) && array_key_exists($k, $params['specifications_md5_key']) && array_key_exists($k, $params['specifications_inventory']))
            {
                // 表中原有的规格数量
                if (isset($warehouse_goods_spec[$k]['inventory']))
                {
                    $inventory_org = intval($warehouse_goods_spec[$k]['inventory']);
                    $inventory_private = intval($warehouse_goods_spec[$k]['inventory_private']);
                } else {
                    $inventory_org = 0;
                    $inventory_private = 0;
                }

                $inventory = $inventory_org
                + intval($params['specifications_inventory'][$k]);

                if($inventory > 0)
                {
                    $data[] = [
                        'warehouse_goods_id'    => $warehouse_goods['id'],
                        'warehouse_id'          => $warehouse_goods['warehouse_id'],
                        'goods_id'              => $warehouse_goods['goods_id'],
                        'md5_key'               => $params['specifications_md5_key'][$k],
                        'spec'                  => htmlspecialchars_decode($v),
                        'inventory'             => $inventory,
                        'inventory_private'     => $inventory_private,
                        'add_time'              => time(),
                    ];
                }
            }
        }

        // 删除原始数据
        Db::name('WarehouseGoodsSpec')->where($where)->delete();
        
        // 添加数据
        if(!empty($data))
        {
            if(Db::name('WarehouseGoodsSpec')->insertAll($data) < count($data))
            {
                return DataReturn('规格库存添加失败', -1);
            }
        }

        // 仓库商品更新
        if(!Db::name('WarehouseGoods')->where(['id'=>$warehouse_goods['id']])->update([
            'inventory' => array_sum(array_column($data, 'inventory')),
            'upd_time'  => time(),
        ]))
        {
            return DataReturn('库存商品更新失败', -1);
        }

        // 同步商品库存
        $ret = self::GoodsSpecInventorySync($warehouse_goods['goods_id']);
        if($ret['code'] != 0)
        {
            return DataReturn($ret['msg'], -1);
        }

        return DataReturn('仓库商品库存保存成功', 0);
    }

    /**
     * 商品规格库存同步
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     */
    public static function GoodsSpecInventorySync($goods_id)
    {
        // 获取商品实际规格
        $res = GoodsService::GoodsSpecificationsActual($goods_id);
        if(empty($res['value']))
        {
            // 没有规格则读取默认规格数据
            $res['value'][] = [
                'base_id'   => Db::name('GoodsSpecBase')->where(['goods_id'=>$goods_id])->value('id'),
                'value'     => 'default',
            ];
        }
        $inventory_total = 0;

        // 商品规格库存
        foreach($res['value'] as $v)
        {
            $inventory = self::WarehouseGoodsSpecInventory($goods_id, str_replace(GoodsService::$goods_spec_to_string_separator, '', $v['value']));
            if(Db::name('GoodsSpecBase')->where(['id'=>$v['base_id'], 'goods_id'=>$goods_id])->update(['inventory'=>$inventory]) === false)
            {
                return DataReturn('商品规格库存同步失败', -20);
            }
            $inventory_total += $inventory;
        }

        // 商品库存
        $data = [
            'inventory' => $inventory_total,
            'upd_time'  => time(),
        ];
        if(Db::name('Goods')->where(['id'=>$goods_id])->update($data) === false)
        {
            return DataReturn('商品库存同步失败', -21);
        }

        // 商品仓库库存修改钩子
        $hook_name = 'plugins_service_warehouse_goods_inventory_sync';
        $ret = HookReturnHandle(Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'goods_id'      => $goods_id
        ]));
        if(isset($ret['code']) && $ret['code'] != 0)
        {
            return $ret;
        }

        return DataReturn('商品规格库存同步成功', 0);
    }

    /**
     * 商品入库信息保存
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GoodsWarehouseDataSave($params = [])
    {
        // 入库规格数量数据格式化
        $goods_num = self::GoodsNumHandle($params);

        // 入库尺寸重量数据格式化
        $goods_size_weight = self::GoodsSizeWeightHandle($params);

        $data = [
            'goods_id'          => intval($params['goods_id']),
            'user_id'           => isset($params['user']['id']) ? intval($params['user']['id']) : $params['user_id'],
            'warehouse_id'      => intval($params['warehouse_id']),
            'goods_num'         => $goods_num,
            'goods_size_weight' => $goods_size_weight,
            'source_address'    => $params['source_address'],
            'status'            => intval($params['status']),
            'check_info'        => $params['check_info'] ?? '',
        ];

        // 添加
        if (empty($params['id']))
        {
            $data['add_time'] = time();
            if(Db::name('GoodsWarehouse')->insertGetId($data) <= 0)
            {
                return DataReturn('商品入库信息保存失败', -100);
            }
        // 编辑
        } else {
            $data['upd_time'] = time();
            if(!Db::name('GoodsWarehouse')->where(['id'=>intval($params['id'])])->update($data))
            {
                return DataReturn('商品入库信息保存失败', -100);
            }
        }

        return DataReturn('商品入库信息保存成功', 0);
    }

    /**
     * 商品入库状态保存
     * @author  R
     * @version 1.0.0
     * @date    2021-08-05
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    // public static function InboundStatusSave($params = [])
    // {
    //     $data = [
    //         'status' => $params['status'],
    //         'upd_time'  => time(),
    //     ];
    //     if(!Db::name('GoodsWarehouse')->where(['id'=>$params['id']])->update($data))
    //     {
    //         return DataReturn('入库状态更新失败', -1);
    //     }

    //     return DataReturn('入库状态更新成功', 0);
    // }

    /**
     * 根据商品id和规格获取库存
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     * @param   [string]       $spec_str [规格值，如 套餐一白色16G（无则 default）]
     */
    public static function WarehouseGoodsSpecInventory($goods_id, $spec_str = 'default')
    {
        // 获取商品仓库
        // 仓库商品是否有效
        $warehouse_ids = Db::name('WarehouseGoods')->where(['goods_id'=>$goods_id, 'is_enable'=>1])->column('warehouse_id');
        if(empty($warehouse_ids))
        {
            return 0;
        }

        // 检查仓库是否启用
        $warehouse_ids = Db::name('Warehouse')->where(['id'=>$warehouse_ids, 'is_enable'=>1, 'is_delete_time'=>0])->column('id');
        if(empty($warehouse_ids))
        {
            return 0;
        }

        // 获取商品规格库存
        $where = [
            'warehouse_id'  => $warehouse_ids,
            'goods_id'      => $goods_id,
            'md5_key'       => md5(empty($spec_str) ? 'default' : $spec_str),
        ];
        return (int) Db::name('WarehouseGoodsSpec')->where($where)->sum('inventory');
    }

    /**
     * 商品规格数据
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function UserWarehouseInventoryData($params = [])
    {
        if (empty($params['goods_id']))
        {
            return DataReturn('参数有误', -1);
        }

        // 获取商品规格
        $res = GoodsService::GoodsSpecificationsActual($params['goods_id']);
        $inventory_spec = [];
        if(!empty($res['value']) && is_array($res['value']))
        {
            // 获取当前配置的库存
            $spec = array_column($res['value'], 'value');
            foreach($spec as $v)
            {
                $arr = explode(GoodsService::$goods_spec_to_string_separator, $v);
                $inventory_spec[] = [
                    'name'      => implode(' / ', $arr),
                    'spec'      => json_encode(self::GoodsSpecMuster($v, $res['title']), JSON_UNESCAPED_UNICODE),
                    'md5_key'   => md5(implode('', $arr)),
                    'inventory' => 0,
                ];
            }
        } else {
            // 没有规格则处理默认规格 default
            $str = 'default';
            $inventory_spec[] = [
                'name'      => '默认规格',
                'spec'      => $str,
                'md5_key'   => md5($str),
                'inventory' => 0,
            ];
        }

        // 获取库存
        $keys = array_column($inventory_spec, 'md5_key');
        $where = [
            'goods_id'              => $params['goods_id'],
        ];
        $inventory_data = Db::name('WarehouseGoodsSpec')->where($where)->column('inventory', 'md5_key');
        if(!empty($inventory_data))
        {
            foreach($inventory_spec as &$v)
            {
                if(array_key_exists($v['md5_key'], $inventory_data))
                {
                    $v['inventory'] = $inventory_data[$v['md5_key']];
                }
            }
        }

        // 返回数据
        $result = [
            'spec'  => $inventory_spec,
        ];
        return DataReturn('success', 0, $result);
    }

    /**
     * 规格值组合
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [string]         $spec_str   [规格字符串，英文逗号分割]
     * @param   [array]          $spec_title [规格类型名称]
     */
    public static function GoodsSpecMuster($spec_str, $spec_title)
    {
        $result = [];
        $arr = explode(GoodsService::$goods_spec_to_string_separator, $spec_str);
        if(count($arr) == count($spec_title))
        {
            foreach($arr as $k=>$v)
            {
                $result[] = [
                    'type'  => $spec_title[$k],
                    'value' => $v,
                ];
            }
        }
        return $result;
    }

    /**
     * 入库商品规格库存信息
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GoodsNumHandle($params = [])
    {
        $inventory = [];
        $data = [];
        foreach($params['specifications_spec'] as $k=>$v)
        {
            // 规格值,md5key,库存 必须存在
            if(!empty($v) && array_key_exists($k, $params['specifications_md5_key']) && array_key_exists($k, $params['specifications_inventory']))
            {
                $inventory = intval($params['specifications_inventory'][$k]);
                if($inventory > 0)
                {
                    $data[] = [
                        'md5_key'               => $params['specifications_md5_key'][$k],
                        'spec'                  => htmlspecialchars_decode($v),
                        'inventory'             => $inventory,
                    ];
                }
            }
        }

        return json_encode($data);
    }

    /**
     * 入库商品尺寸重量信息可视化
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GoodsSizeWeightHandle($params = [])
    {
        $data = [];
        foreach($params['parameters_weight'] as $k=>$v)
        {
            // 长、宽、高、重量 必须存在
            if(!empty($v) && array_key_exists($k, $params['parameters_long']) && array_key_exists($k, $params['parameters_width']) && array_key_exists($k, $params['parameters_height']))
            {
                $data[] = [
                    'parameters_long'   => $params['parameters_long'][$k],
                    'parameters_width'  => $params['parameters_width'][$k],
                    'parameters_height' => $params['parameters_height'][$k],
                    'parameters_weight' => $v,
                ];
            }
        }

        return json_encode($data);
    }

    /**
     * 入库商品尺寸信息可视化
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [string]         $size   [尺寸字符串]
     */
    public static function GoodsSizeWeightViewInfo($size)
    {
        $data_str = '';

        $data = json_decode($size);
        if (is_array($data))
        {
            foreach($data as $v) {
                $data_str .= '【';
                $data_str .= $v->parameters_long . 'cm X ' . $v->parameters_width . 'cm X ' . $v->parameters_height . 'cm ';
                $data_str .= '/' . $v->parameters_weight . 'kg】 ';
            }
        }

        return $data_str;
    }

    /**
     * 入库商品库存信息可视化
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     * @param   [string]         $num   [规格字符串]
     */
    public static function GoodsNumViewInfo($num)
    {
        $data_num = 0;

        $data = json_decode($num);
        if (is_array($data))
        {
            foreach($data as $v) {
                $data_num += $v->inventory;
            }
        }

        return $data_num;
    }

    /**
     * 请求参数校验
     * @author  R
     * @version 1.0.0
     * @date    2021-07-22
     * @desc    description
     */
    public static function ParamsCheck($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'goods_id',
                'error_msg'         => '商品id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'specifications_inventory',
                'error_msg'         => '库存数据有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'specifications_inventory',
                'error_msg'         => '库存数据有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'specifications_md5_key',
                'error_msg'         => '库存唯一值有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'specifications_md5_key',
                'error_msg'         => '库存唯一值有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'specifications_spec',
                'error_msg'         => '库存规格有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'specifications_spec',
                'error_msg'         => '库存规格有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'parameters_long',
                'error_msg'         => '外包装长度有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'parameters_long',
                'error_msg'         => '外包装长度有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'parameters_width',
                'error_msg'         => '外包装宽度有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'parameters_width',
                'error_msg'         => '外包装宽度有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'parameters_height',
                'error_msg'         => '外包装高度有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'parameters_height',
                'error_msg'         => '外包装高度有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'parameters_weight',
                'error_msg'         => '外包装重量有误',
            ],
            [
                'checked_type'      => 'is_array',
                'key_name'          => 'parameters_weight',
                'error_msg'         => '外包装重量有误',
            ],
        ];
        return ParamsChecked($params, $p);
    }

    public static function GoodsGetSpecVal($param){
        $goods_id = $param["goods_id"];
        $field = "gb.id,barcode,group_concat(value separator '-') value";
        $where = ['gb.goods_id'=>$goods_id];
        $data = Db::name('GoodsSpecBase')->alias('gb')
                ->field($field)
                ->join(['__GOODS_SPEC_VALUE__'=>'gv'], 'gb.goods_id = gv.goods_id and gb.id=gv.goods_spec_base_id','left')
                ->where($where)->group('gb.id')->select();
        return DataReturn('处理成功', 0, $data);
    } 
	
	public static function UserWarehouseBox($putId){
		$field = "box_id,box_length,box_width,box_height,box_weight";
		$where = ['put_id'=>$putId];
		$data = Db::name('GoodsWarehouseBox')
		        ->field($field)
				->where($where)->select();
		return DataReturn('处理成功', 0, $data);
	}
	
	public static function UserWarehouseBoxDetail($boxId){
		$field = "good_id,good_sku,good_num,gb.id,title,group_concat(value separator '-') value";
		$where = ['box_id'=>$boxId];
		$data = Db::name('GoodsWarehouseBoxDetail')->alias('gd')
		        ->field($field)
				->join(['__GOODS_SPEC_BASE__'=>'gb'],'gd.good_id=gd.good_id and gd.good_sku=gb.barcode')
                ->join(['__GOODS__'=>'g'],'gd.good_id=g.id')
                ->join(['__GOODS_SPEC_VALUE__'=>'gv'], 'gb.goods_id = gv.goods_id and gb.id=gv.goods_spec_base_id','left')
				->where($where)->group("good_id,good_sku")->select();
		return DataReturn('处理成功', 0, $data);
	}

    public static function UserWarehouseCheck($param){
        $where = ["id" => $param["id"]];
        $up_data = [
                   "status"=>$param["status"],
                   "check_info"=>$param["check_info"],
                   //"express_id"=>$param["express"],
                   "checker"=>$param["admin"]["username"],
                   "upd_time"=>time()
                   ];
        $res = Db::name('GoodsWarehouse')->where($where)->update($up_data);
        if($res == 1){ 
            return DataReturn('操作成功', 0);
        }else{
            return DataReturn('操作', -1);
        }
    }
}
?>
