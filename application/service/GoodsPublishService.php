<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
namespace app\service;

use think\Db;
use think\facade\Hook;
use app\service\ResourcesService;
use app\service\UserService;
use app\service\GoodsService;
use app\service\WarehouseGoodsService;

/**
 * 商品发布服务层
 * @author   R
 * @version 1.0.0
 * @date    2021-07-08
 * @desc    description
 */
class GoodsPublishService
{
    /**
     * 商品发布/取消
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function GoodsPublishCancel($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '商品id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'user',
                'error_msg'         => '用户信息有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 查询用户状态是否正常 
        $ret = UserService::UserStatusCheck('id', $params['user']['id']);
        if($ret['code'] != 0)
        {
            return $ret;
        }

        // 开始操作
        $data = ['goods_id'=>intval($params['id']), 'user_id'=>$params['user']['id']];
        $temp = Db::name('GoodsFavor')->where($data)->find();
        if(empty($temp))
        {
            // 添加收藏
            $data['add_time'] = time();
            if(Db::name('GoodsFavor')->insertGetId($data) > 0)
            {
                return DataReturn('收藏成功', 0, [
                    'text'      => '已收藏',
                    'status'    => 1,
                    'count'     => self::GoodsFavorTotal(['goods_id'=>$data['goods_id']]),
                ]);
            } else {
                return DataReturn('收藏失败');
            }
        } else {
            // 是否强制收藏
            if(isset($params['is_mandatory_favor']) && $params['is_mandatory_favor'] == 1)
            {
                return DataReturn('收藏成功', 0, [
                    'text'      => '已收藏',
                    'status'    => 1,
                    'count'     => self::GoodsFavorTotal(['goods_id'=>$data['goods_id']]),
                ]);
            }

            // 删除收藏
            if(Db::name('GoodsFavor')->where($data)->delete() > 0)
            {
                return DataReturn('取消成功', 0, [
                    'text'      => '收藏',
                    'status'    => 0,
                    'count'     => self::GoodsFavorTotal(['goods_id'=>$data['goods_id']]),
                ]);
            } else {
                return DataReturn('取消失败');
            }
        }
    }

    /**
     * 前端商品发布列表条件
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function UserGoodsPublishListWhere($params = [])
    {
        $where = [
            ['g.is_delete_time', '=', 0]
        ];

        // 用户id
        if(!empty($params['user']))
        {
            $where[]= ['p.user_id', '=', $params['user']['id']];
        }

        if(!empty($params['keywords']))
        {
            $where[] = ['g.title|g.model|g.simple_desc|g.seo_title|g.seo_keywords|g.seo_keywords', 'like', '%'.$params['keywords'].'%'];
        }

        return $where;
    }

    /**
     * 商品发布总数
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]          $where [条件]
     */
    public static function GoodsPublishTotal($where = [])
    {
        return (int) Db::name('GoodsPublish')->alias('p')->join(['__GOODS__'=>'g'], 'g.id=p.goods_id')->where($where)->count();
    }

    /**
     * 商品发布列表
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function GoodsPublishList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? 'p.*,ifnull(0,sum(wg.inventory)) as inventory,ifnull(0,sum(wg.inventory_private)) as inventory_private, g.title,g.title_color, g.original_price, g.price, g.min_price, g.images, g.is_shelves, g.inventory, g.inventory_private,g.length,g.width,g.height,g.weight' : $params['field'];
        $order_by = empty($params['order_by']) ? 'p.id desc' : $params['order_by'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取数据
        $data = Db::name('GoodsPublish')->alias('p')
		            ->join(['__GOODS__'=>'g'], 'g.id=p.goods_id')
					->join(['__WAREHOUSE_GOODS__'=>'wg'], 'wg.goods_id=p.goods_id','left')
					->field($field)->where($where)->group('p.goods_id')->limit($m, $n)->order($order_by)->select();
        if(!empty($data))
        {
            // 商品数据处理
            $ret = GoodsService::GoodsDataHandle($data, ['data_key_field'=>'goods_id']);
            $data = $ret['data'];
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 发布的商品信息
     * @author   R
     * @version 1.0.0
     * @date    2021-07-20
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function GoodsPublishAll($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? 'p.*, g.title, g.original_price, g.price, g.min_price, g.images, g.is_shelves' : $params['field'];
        $data = Db::name('GoodsPublish')->alias('p')->join(['__GOODS__'=>'g'], 'g.id=p.goods_id')->field($field)->where($where)->select();

        return $data;
    }

    public static function GoodsSkuCheck($params){
        $sku = $params["sku"];
        $data = Db::name('GoodsSpecBase')->where(['barcode'=>$sku])->select();
        $cnt = count($data);
        return DataReturn('处理成功', 0, $cnt);    
    }

    public static function GoodsTitleCheck($params){
        $title = $params["title"];
        $user_id = $params["user_id"];
        $pid = $params["pid"];
        $field = 'p.id';
        $where = ['title'=>$title,'user_id'=>$user_id];
        $ret = Db::name('GoodsPublish')->alias('p')->join(['__GOODS__'=>'g'], 'g.id=p.goods_id')
                ->field($field)->where($where)->select();
        $cnt = count($ret);
        if($cnt == 1 && $ret[0]['id'] != $pid){
            return 1; 
        }
        return 0;
    }
    /**
     * 商品发布保存
     * @author   R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function GoodsPublishSave($params = [])
    {
        // 参数校验
        $ret = self::GoodsPublishSaveParamsCheck($params);
        if($ret['code'] != 0)
        {
            return $ret;
        }

        // 规格基础
        $specifications_base = self::GetFormGoodsSpecificationsBaseParams($params);
        if($specifications_base['code'] != 0)
        {
            return $specifications_base;
        }

        // 规格值
        $specifications = self::GetFormGoodsSpecificationsParams($params);
        if($specifications['code'] != 0)
        {
            return $specifications;
        }
        
        // 相册
        $photo = self::GetFormGoodsPhotoParams($params);
        if($photo['code'] != 0)
        {
            return $photo;
        }

        // 其它附件
        $data_fields = ['images'];
        $attachment = ResourcesService::AttachmentParams($params, $data_fields);
        if($attachment['code'] != 0)
        {
            return $attachment;
        }

        // 封面图片、默认相册第一张
        $images = empty($attachment['data']['images']) ? (isset($photo['data'][0]) ? $photo['data'][0] : '') : $attachment['data']['images'];

        // 编辑器内容
        $content_web = empty($params['content_web']) ? '' : ResourcesService::ContentStaticReplace(htmlspecialchars_decode($params['content_web']), 'add');
        
        // 基础数据
        $data = [
            'title'                     => $params['title'],
            'title_color'               => empty($params['title_color']) ? '' : $params['title_color'],
            'simple_desc'               => $params['simple_desc'],
            'model'                     => $params['model'],
            'photo_count'               => count($photo['data']),
            'images'                    => $images,
            'content_web'               => $content_web,
            'is_exist_many_spec'        => empty($specifications['data']['title']) ? 0 : 1,
            'spec_base'                 => empty($specifications_base['data']) ? '' : json_encode($specifications_base['data'], JSON_UNESCAPED_UNICODE),
            'is_shelves'                => $params['is_shelves'] ?? 2,
            'length'                    => $params['length'],
            'width'                     => $params['width'],
            'height'                    => $params['height'],
            'weight'                    => $params['weight'],
        ];

        // 商品保存处理钩子
        $hook_name = 'plugins_service_goods_publish_handle';
        $ret = HookReturnHandle(Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'params'        => &$params,
            'data'          => &$data,
            'spec'          => $specifications['data'],
            'goods_id'      => isset($params['id']) ? intval($params['id']) : 0,
        ]));
        if(isset($ret['code']) && $ret['code'] != 0)
        {
            return $ret;
        }

        // 启动事务
        Db::startTrans();

        // 捕获异常
        try {
            // 添加/编辑
            if(empty($params['pid']))
            {
                $data['add_time'] = time();
                $goods_id = Db::name('Goods')->insertGetId($data);
                if($goods_id <= 0)
                {
                    throw new \Exception('添加失败');
                }
            } else {
                $data['upd_time'] = time();
                if(Db::name('Goods')->where(['id'=>intval($params['id'])])->update($data))
                {
                    $goods_id = $params['id'];
                } else {
                    throw new \Exception('更新失败');
                }
            }

            // 发布信息
            $ret = self::GoodsPublishInsert($params['user']['id'], $goods_id);
            if($ret['code'] != 0)
            {
                throw new \Exception('goods publish' . $ret['msg']);
            }

            // 分类
            $ret = self::GoodsCategoryInsert(explode(',', $params['category_id']), $goods_id);
            if($ret['code'] != 0)
            {
                throw new \Exception('category' . $ret['msg']);
            }

            // 规格
            $specifications['data']['userId'] = $params['user']['id'];
            $ret = self::GoodsSpecificationsInsert($specifications['data'], $goods_id);
            if($ret['code'] != 0)
            {
                throw new \Exception('spec' . $ret['msg']);
            } else {
                // 更新商品基础信息
                $ret = self::GoodsSaveBaseUpdate($goods_id);
                if($ret['code'] != 0)
                {
                    throw new \Exception('goods update' . $ret['msg']);
                }
            }

            // 相册
            $ret = self::GoodsPhotoInsert($photo['data'], $goods_id);
            if($ret['code'] != 0)
            {
                throw new \Exception('goods photo' . $ret['msg']);
            }
            
            // 仓库规格库存同步
            $ret = WarehouseGoodsService::GoodsSpecChangeInventorySync($goods_id);
            if($ret['code'] != 0)
            {
                throw new \Exception('warehouse goods spec' . $ret['msg']);
            }

            // 完成
            Db::commit();
        } catch(\Exception $e) {
            Db::rollback();
            return DataReturn($e->getMessage(), -1);
        }

        // 商品保存后钩子
        $hook_name = 'plugins_service_goods_publish_end';
        Hook::listen($hook_name, [
            'hook_name'     => $hook_name,
            'is_backend'    => true,
            'params'        => $params,
            'data'          => $data,
            'goods_id'      => $goods_id,
        ]);

        // 返回信息
        return DataReturn('操作成功', 0);
    }

    /**
     * 商品库存数据
     * @author  R
     * @version 1.0.0
     * @date    2021-08-10
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GoodsInventoryData($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'goods_id',
                'error_msg'         => '数据id有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 获取仓库商品
        $where = [
            'goods_id'    => intval($params['goods_id']),
        ];
        $warehouse_goods = Db::name('WarehouseGoods')->where($where)->find();
        if(empty($warehouse_goods))
        {
            return DataReturn('无相关商品数据', -1);
        }

        // 获取商品规格
        $res = GoodsService::GoodsSpecificationsActual($warehouse_goods['goods_id']);
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
            'md5_key'               => $keys,
            'warehouse_goods_id'    => $warehouse_goods['id'],
            'warehouse_id'          => $warehouse_goods['warehouse_id'],
            'goods_id'              => $warehouse_goods['goods_id'],
        ];
        $inventory_data = Db::name('WarehouseGoodsSpec')->where($where)->column('inventory', 'md5_key');
        $inventory_private_data = Db::name('WarehouseGoodsSpec')->where($where)->column('inventory_private', 'md5_key');
        $goods_spec_price = Db::name('GoodsSpecBase')->where(['goods_id'=>$warehouse_goods['goods_id']])->all();

        if(!empty($inventory_data))
        {
            foreach($inventory_spec as $k => &$v)
            {
                if(array_key_exists($v['md5_key'], $inventory_data))
                {
                    $v['inventory'] = $inventory_data[$v['md5_key']];
                    $v['inventory_public'] = $inventory_data[$v['md5_key']] - $inventory_private_data[$v['md5_key']];
                    $v['spec_price'] = $goods_spec_price[$k]['price'];
                    $v['spec_id'] = $goods_spec_price[$k]['id'];
                }
            }
        }

        // 返回数据
        $result = [
            'data'  => $warehouse_goods,
            'spec'  => $inventory_spec,
        ];
        return DataReturn('success', 0, $result);
    }

    /**
     * 商品库存数据保存
     * @author  R
     * @version 1.0.0
     * @date    2021-08-10
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GoodsInventorySave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'goods_id',
                'error_msg'         => '数据id有误',
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
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 公开件数确认
        $inventory_public = array_sum($params['specifications_inventory_public']);
        if (array_sum($params['specifications_inventory']) > 20 && intval($inventory_public) < 20)
        {
            return DataReturn('公开数量不能少于 20 件！！', -1);
        }

        // 获取仓库商品
        $where = [
            'goods_id'    => intval($params['goods_id']),
        ];
        $warehouse_goods = Db::name('WarehouseGoods')->where($where)->find();
        if(empty($warehouse_goods))
        {
            return DataReturn('无相关商品数据', -1);
        }

        // 数据组装
        $inventory = [];
        $data = [];
        foreach($params['specifications_spec'] as $k=>$v)
        {
            // 规格值,md5key,库存 必须存在
            if(!empty($v) && array_key_exists($k, $params['specifications_md5_key']) && array_key_exists($k, $params['specifications_inventory']))
            {
                $inventory = intval($params['specifications_inventory'][$k]);
                $inventory_private = isset($params['specifications_inventory_public']) 
                    ? $inventory - intval($params['specifications_inventory_public'][$k]) : 0;
                
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

        // 启动事务
        Db::startTrans();

        // 捕获异常
        try {
        
            // 删除原始数据
            $where = [
                'warehouse_id'          => $warehouse_goods['warehouse_id'],
                'goods_id'              => $warehouse_goods['goods_id'],
            ];
            Db::name('WarehouseGoodsSpec')->where($where)->delete();

            // 添加数据
            if(!empty($data))
            {
                if(Db::name('WarehouseGoodsSpec')->insertAll($data) < count($data))
                {
                    throw new \Exception('规格库存添加失败');
                }
            }

            // 仓库商品更新
            if(!Db::name('WarehouseGoods')->where(['id'=>$warehouse_goods['id']])->update([
                'inventory' => array_sum(array_column($data, 'inventory')),
                'inventory_private' => array_sum(array_column($data, 'inventory_private')),
                'upd_time'  => time(),
            ]))
            {
                throw new \Exception('库存商品更新失败');
            }

            // 同步商品库存
            $ret = self::GoodsSpecInventorySync($warehouse_goods['goods_id']);
            if($ret['code'] != 0)
            {
                throw new \Exception($ret['msg']);
            }

            // 规格价格更新
            $ret = self::GoodsSpecBaseUpd($params);
            if($ret['code'] != 0)
            {
                throw new \Exception($ret['msg']);
            }

            // 更新商品基础信息
            $ret = self::GoodsSaveBaseUpdate($warehouse_goods['goods_id']);
            if($ret['code'] != 0)
            {
                throw new \Exception('goods update' . $ret['msg']);
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
     * 商品规格库存同步
     * @author  R
     * @version 1.0.0
     * @date    2021-08-10
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
        $inventory_private_total = 0;

        // 商品规格库存
        foreach($res['value'] as $v)
        {
            $inventory_info = self::WarehouseGoodsSpecInventory($goods_id, str_replace(GoodsService::$goods_spec_to_string_separator, '', $v['value']));
            $data = [
                'inventory' => $inventory_info['inventory'],
                'inventory_private' => $inventory_info['inventory_private'],
            ];
            if(Db::name('GoodsSpecBase')->where(['id'=>$v['base_id'], 'goods_id'=>$goods_id])->update($data) === false)
            {
                return DataReturn('商品规格库存同步失败', -20);
            }
            $inventory_total += $inventory_info['inventory'];
            $inventory_private_total += $inventory_info['inventory_private'];
        }

        // 商品库存
        $data = [
            'inventory' => $inventory_total,
            'inventory_private' => $inventory_private_total,
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

        return DataReturn('更新成功', 0);
    }

    /**
     * 商品规格基础价格更新
     * @author  R
     * @version 1.0.0
     * @date    2021-08-18
     * @desc    description
     * @param   [int]          $goods_id [商品id]
     */
    public static function GoodsSpecBaseUpd($params = [])
    {
        if (isset($params['spec_base_id']) && is_array($params['spec_base_id']))
        {
            foreach($params['spec_base_id'] as $k => $v)
            {
                if (Db::name('GoodsSpecBase')->where(['id'=>$v])->update(['price' => $params['specifications_price'][$k]]) === false)
                {
                    return DataReturn('商品规格价格更新失败', -20);
                }
            }
        }

        return DataReturn('商品规格价格更新成功', 0);
    }

    /**
     * 根据商品id和规格获取库存
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-16
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
        $inventory = (int) Db::name('WarehouseGoodsSpec')->where($where)->sum('inventory');
        $inventory_private = (int) Db::name('WarehouseGoodsSpec')->where($where)->sum('inventory_private');

        return [
            'inventory' => $inventory,
            'inventory_private' => $inventory_private,
        ];
    }

    /**
     * 商品发布保存参数校验
     * @author  R
     * @version 1.0.0
     * @date    2021-07-08
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    private static function GoodsPublishSaveParamsCheck($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'title',
                'checked_data'      => '2,160',
                'error_msg'         => '标题名称格式 2~160 个字符',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'simple_desc',
                'checked_data'      => '230',
                'is_checked'        => 1,
                'error_msg'         => '商品简述格式 最多230个字符',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'model',
                'checked_data'      => '30',
                'is_checked'        => 1,
                'error_msg'         => '商品型号格式 最多30个字符',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'category_id',
                'error_msg'         => '请至少选择一个商品分类',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }
        return DataReturn('success', 0);
    }

    /**
     * 获取规格基础参数
     * @author  R
     * @version 1.0.0
     * @date    2021-07-10
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public static function GetFormGoodsSpecificationsBaseParams($params = [])
    {
        $result = [];
        foreach($params as $k=>$v)
        {
            if(substr($k, 0, 16) == 'spec_base_title_')
            {
                $key = substr($k, 16);
                $result[] = [
                    'title'     => $v,
                    'value'     => isset($params['spec_base_value_'.$key]) ? $params['spec_base_value_'.$key] : [],
                ];
            }
        }
        return DataReturn('success', 0, $result);
    }

    /**
     * 获取规格值参数
     * @author   R
     * @version 1.0.0
     * @date    2021-07-10
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function GetFormGoodsSpecificationsParams($params = [])
    {
        $data = [];
        $title = [];
        $images = [];

        // 基础字段数据字段长度
        $base_count = 2;

        // 规格值
        foreach($params as $k=>$v)
        {
            if(substr($k, 0, 15) == 'specifications_')
            {
                $keys = explode('_', $k);
                if(count($keys) > 1)
                {
                    if($keys[1] != 'name')
                    {
                        foreach($v as $ks=>$vs)
                        {
                            if($keys[1] == 'extends')
                            {
                                $data[$ks][] = empty($vs) ? null : htmlspecialchars_decode($vs);
                            } else {
                                $data[$ks][] = trim($vs);
                            }
                        }
                    }
                }
            }
        }
        
        // 规格处理
        if(!empty($data[0]))
        {
            $count = count($data[0])-$base_count;

            if($count > 0)
            {
                // 列之间是否存在相同的值
                $column_value = [];
                foreach($data as $data_value)
                {
                    foreach($data_value as $temp_key=>$temp_value)
                    {
                        if($temp_key < $count)
                        {
                            $column_value[$temp_key][] = $temp_value;
                        }
                    }
                }
                if(!empty($column_value) && count($column_value) > 1)
                {
                    $temp_column = [];
                    foreach($column_value as $column_key=>$column_val)
                    {
                        foreach($column_value as $column_keys=>$column_vals)
                        {
                            if($column_key != $column_keys)
                            {
                                $temp = array_intersect($column_val, $column_vals);
                                $temp_column = array_merge($temp_column, $temp);
                            }
                        }
                    }
                    if(!empty($temp_column))
                    {
                        return DataReturn('规格值列之间不能重复['.implode(',', array_unique($temp_column)).']', -1);
                    }
                }

                // 规格值是否重复
                if(!empty($column_value[0]))
                {
                    $temp_row_data = [];
                    $temp_row_count = count($column_value);
                    foreach($column_value[0] as $row_key=>$row_value)
                    {
                        for($i=0; $i<$temp_row_count; $i++)
                        {
                            if(isset($column_value[$i][$row_key]))
                            {
                                if(isset($temp_row_data[$row_key]))
                                {
                                    $temp_row_data[$row_key] .= $column_value[$i][$row_key];
                                } else {
                                    $temp_row_data[$row_key] = $column_value[$i][$row_key];
                                }
                            }
                        }
                    }
                    if(!empty($temp_row_data))
                    {
                        $unique_all = array_unique($temp_row_data);
                        $repeat_rows_all = array_diff_assoc($temp_row_data, $unique_all); 
                        if(!empty($repeat_rows_all))
                        {
                            return DataReturn('规格值不能重复['.implode(',', array_unique($repeat_rows_all)).']', -1);
                        }
                    }
                }
                
                // 规格名称
                $names_value = [];
                $names = array_slice($data[0], 0, $count);
                foreach($names as $v)
                {
                    foreach($params as $ks=>$vs)
                    {
                        if(substr($ks, 0, 21) == 'specifications_value_')
                        {
                            if(in_array($v, $vs))
                            {
                                $key = substr($ks, 21);
                                if(!empty($params['specifications_name_'.$key]))
                                {
                                    $spec_name = trim($params['specifications_name_'.$key]);
                                    $title[$spec_name] = [
                                        'name'  => $spec_name,
                                        'value' => array_unique($vs),
                                    ];
                                    $names_value[] = $params['specifications_name_'.$key];
                                }
                            }
                        }
                    }
                }

                // 规格名称列之间是否存在重复
                $unique_all = array_unique($names_value);
                $repeat_names_all = array_diff_assoc($names_value, $unique_all); 
                if(!empty($repeat_names_all))
                {
                    return DataReturn('规格名称列之间不能重复['.implode(',', array_unique($repeat_names_all)).']', -1);
                }
            } else {
                if(!isset($data[0][0]) || $data[0][0] < 0)
                {
                    return DataReturn('请填写有效的规格销售价格', -1);
                }
                if(!isset($data[0][1]) || $data[0][1] < 0)
                {
                    return DataReturn('请填写规格库存', -1);
                }
            }
        } else {
            return DataReturn('请填写规格', -1);
        }

        // 规格图片
        if(!empty($params['spec_images_name']) && !empty($params['spec_images']))
        {
            foreach($params['spec_images_name'] as $k=>$v)
            {
                if(!empty($params['spec_images'][$k]))
                {
                    $images[$v] = $params['spec_images'][$k];
                }
            }
        }

        return DataReturn('success', 0, ['data'=>$data, 'title'=>$title, 'images'=>$images]);
    }

    /**
     * 获取商品相册
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-10
     * @desc    description
     * @param   [array]          $params [输入参数]
     * @return  [array]                  [一维数组但图片地址]
     */
    public static function GetFormGoodsPhotoParams($params = [])
    {
        if(empty($params['photo']))
        {
            return DataReturn('请上传相册', -1);
        }

        $result = [];
        if(!empty($params['photo']) && is_array($params['photo']))
        {
            foreach($params['photo'] as $v)
            {
                $result[] = ResourcesService::AttachmentPathHandle($v);
            }
        }
        return DataReturn('success', 0, $result);
    }

    /**
     * 商品发布信息添加
     * @author   R
     * @version 1.0.0
     * @date    2021-07-09
     * @desc    description
     * @param   [array]          $user_id  [用户id]
     * @param   [int]            $goods_id [商品id]
     * @return  [array]                    [boolean | msg]
     */
    public static function GoodsPublishInsert($user_id, $goods_id)
    {
        // 查询商品发布信息
        $data = Db::name('GoodsPublish')->where(['goods_id'=>$goods_id])->find();
        
        if(empty($user_id))
        {
            return DataReturn('商品发布信息添加失败', -1);
        }

        $temp_data = [
            'user_id' => $user_id,
            'goods_id' => $goods_id,
        ];

        if(empty($data))
        {
            $temp_data['add_time'] = time();
            $publish_id = Db::name('GoodsPublish')->insertGetId($temp_data);
            if($publish_id <= 0)
            {
                throw new \Exception('商品发布信息添加失败');
            }
        } else {
            $temp_data['upd_time'] = time();
            if(Db::name('GoodsPublish')->where(['id'=>intval($data['id'])])->update($temp_data))
            {
                $publish_id = $data['id'];
            } else {
                throw new \Exception('商品发布信息更新失败');
            }
        }

        return DataReturn('商品发布信息操作成功', 0);
    }

    /**
     * 商品分类添加
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-10
     * @desc    description
     * @param   [array]          $data     [数据]
     * @param   [int]            $goods_id [商品id]
     * @return  [array]                    [boolean | msg]
     */
    public static function GoodsCategoryInsert($data, $goods_id)
    {
        Db::name('GoodsCategoryJoin')->where(['goods_id'=>$goods_id])->delete();
        if(!empty($data))
        {
            foreach($data as $category_id)
            {
                $temp_category = [
                    'goods_id'      => $goods_id,
                    'category_id'   => $category_id,
                    'add_time'      => time(),
                ];
                if(Db::name('GoodsCategoryJoin')->insertGetId($temp_category) <= 0)
                {
                    return DataReturn('商品分类添加失败', -1);
                }
            }
        }
        return DataReturn('添加成功', 0);
    }

    /**
     * 商品规格添加
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-10
     * @desc    description
     * @param   [array]          $data     [数据]
     * @param   [int]            $goods_id [商品id]
     * @return  [array]                    [boolean | msg]
     */
    public static function GoodsSpecificationsInsert($data, $goods_id)
    {
        // 删除原来的数据
        Db::name('GoodsSpecType')->where(['goods_id'=>$goods_id])->delete();
        Db::name('GoodsSpecValue')->where(['goods_id'=>$goods_id])->delete();
        Db::name('GoodsSpecBase')->where(['goods_id'=>$goods_id])->delete();

        // 类型
        if(!empty($data['title']))
        {
            foreach($data['title'] as &$v)
            {
                $spec = [];
                foreach($v['value'] as $vs)
                {
                    $spec[] = [
                        'name'      => $vs,
                        'images'    => isset($data['images'][$vs]) ? ResourcesService::AttachmentPathHandle($data['images'][$vs]) : '',
                    ];
                }
                $v['goods_id']  = $goods_id;
                $v['value']     = json_encode($spec, JSON_UNESCAPED_UNICODE);
                $v['add_time']  = time();
            }
            if(Db::name('GoodsSpecType')->insertAll($data['title']) < count($data['title']))
            {
                return DataReturn('规格类型添加失败', -1);
            }
        }

        // 基础/规格值
        if(!empty($data['data']))
        {
            // 基础字段
            $count = count($data['data'][0]);
            $temp_key = ['price', 'barcode'];
            $key_count = count($temp_key);

            // 等于key总数则只有一列基础规格
            if($count == $key_count)
            {
                $temp_data = [
                    'goods_id' => $goods_id,
                    'add_time' => time(),
                ];
                for($i=0; $i<$count; $i++)
                {
                    if($temp_key[$i] == 'barcode' && strlen($data['data'][0][$i]) == 6){
                        $val = "C1".sprintf("%04s",$data['userId']).$data['data'][0][$i];
                    }else{
                        $val = $data['data'][0][$i];
                    }
                    $temp_data[$temp_key[$i]] = $val;
                }

                // 获取仓库规格库存
                $inventory_info = WarehouseGoodsService::WarehouseGoodsSpecInventory($goods_id);
                $temp_data['inventory'] = $inventory_info['inventory']?$inventory_info['inventory']:0;
                $temp_data['inventory_private'] = $inventory_info['inventory_private']?$inventory_info['inventory_private']:0;
                // 规格基础添加
                if(Db::name('GoodsSpecBase')->insertGetId($temp_data) <= 0)
                {
                    return DataReturn('规格基础添加失败', -1);
                }
                
            // 多规格操作
            } else {
                $base_start = $count-$key_count;
                $value = [];
                $base = [];
                foreach($data['data'] as $v)
                {
                    $temp_value = [];
                    $temp_data = [
                        'goods_id' => $goods_id,
                        'add_time' => time(),
                    ];
                    for($i=0; $i<$count; $i++)
                    {
                        if($i < $base_start)
                        {
                            $temp_value[] = [
                                'goods_id'  => $goods_id,
                                'value'     => $v[$i],
                                'add_time'  => time()
                            ];
                        } else {
                            if($temp_key[$i-$base_start] == 'barcode' && strlen($v[$i]) == 6){
                                $val = "C1".sprintf("%04s",$data['userId']).$v[$i];
                            }else{
                                $val = $v[$i];
                            }
                            $temp_data[$temp_key[$i-$base_start]] = $val;
                        }
                    }

                    // 获取仓库规格库存
                    $inventory_info = WarehouseGoodsService::WarehouseGoodsSpecInventory($goods_id, implode('', array_column($temp_value, 'value')));
                    $temp_data['inventory'] = $inventory_info['inventory']?$inventory_info['inventory']:0;
                    $temp_data['inventory_private'] = $inventory_info['inventory_private']?$inventory_info['inventory_private']:0;
                    // 规格基础添加
                    $base_id = Db::name('GoodsSpecBase')->insertGetId($temp_data);
                    if(empty($base_id))
                    {
                        return DataReturn('规格基础添加失败', -1);
                    }

                    // 规格值添加
                    foreach($temp_value as &$value)
                    {
                        $value['goods_spec_base_id'] = $base_id;
                    }
                    if(Db::name('GoodsSpecValue')->insertAll($temp_value) < count($temp_value))
                    {
                        return DataReturn('规格值添加失败', -1);
                    }
                }
            }
        }

        return DataReturn('添加成功', 0);
    }

    /**
     * 商品保存基础信息更新
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-12-16T01:56:42+0800
     * @param    [int]            $goods_id [商品id]
     */
    public static function GoodsSaveBaseUpdate($goods_id)
    {
        $data = Db::name('GoodsSpecBase')->field('min(price) AS min_price, max(price) AS max_price, sum(inventory) AS inventory, min(original_price) AS min_original_price, max(original_price) AS max_original_price')->where(['goods_id'=>$goods_id])->find();
        if(empty($data))
        {
            return DataReturn('没找到商品基础信息', -1);
        }

        // 销售价格 - 展示价格
        $data['price'] = (!empty($data['max_price']) && $data['min_price'] != $data['max_price']) ? $data['min_price'].'-'.$data['max_price'] : $data['min_price'];

        // 原价价格 - 展示价格
        $data['original_price'] = (!empty($data['max_original_price']) && $data['min_original_price'] != $data['max_original_price']) ? $data['min_original_price'].'-'.$data['max_original_price'] : $data['min_original_price'];

        // 更新商品表
        $data['upd_time'] = time();
        if(Db::name('Goods')->where(['id'=>$goods_id])->update($data))
        {
            return DataReturn('操作成功', 0);
        }
        return DataReturn('操作失败', 0);
    }

    /**
     * 商品相册添加
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-10
     * @desc    description
     * @param   [array]          $data     [数据]
     * @param   [int]            $goods_id [商品id]
     * @return  [array]                    [boolean | msg]
     */
    public static function GoodsPhotoInsert($data, $goods_id)
    {
        Db::name('GoodsPhoto')->where(['goods_id'=>$goods_id])->delete();
        if(!empty($data))
        {
            foreach($data as $k=>$v)
            {
                $temp_photo = [
                    'goods_id'  => $goods_id,
                    'images'    => $v,
                    'is_show'   => 1,
                    'sort'      => $k,
                    'add_time'  => time(),
                ];
                if(Db::name('GoodsPhoto')->insertGetId($temp_photo) <= 0)
                {
                    return DataReturn('相册添加失败', -1);
                }
            }
        }
        return DataReturn('添加成功', 0);
    }

    /**
     * 规格值组合
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-16
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
}
?>
