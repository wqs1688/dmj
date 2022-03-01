<?php
/**
 * R
 * 2021/11/24
 * Warehousing Cost Deduction
 *
 */

namespace app\crontab\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class WarehousingCostDeduction extends Command
{
    protected function configure()
    {
        $this->setName('storage_pay')
            ->setDescription('warehouse cost deduction');
    }

    protected function execute(Input $input, Output $output)
    {
        echo date('Y-m-d H:i:s') . " BATCH START =============>\n";

        $entry_goods = Db::name('WarehouseGoodsHistory')
            ->where('is_entry', 1)
            ->where('add_time', '<', time() - 86400 * 15)
            ->select();
        // var_dump($entry_goods);
        
        if (count($entry_goods) <= 0) {echo "No Data! Interrupt... \n";exit;}

        $costs = [];
        foreach ($entry_goods as $goods) {
            $where = [
                'is_entry' => 0,
                'goods_id' => $goods['goods_id']
            ];
            $out_num = Db::name('WarehouseGoodsHistory')->where($where)->sum('inventory');
            
            // user id
            $user_id = ltrim(substr($goods['goods_sku'], 0, 4), '0');

            // goods warehouse price
            if ($goods['inventory'] - $out_num > 0) {
                $cost = ($goods['inventory'] - $out_num) * $goods['price'];

                if (array_key_exists($user_id, $costs)) {
                    $costs[$user_id] += $cost;
                } else {
                    $costs[$user_id] = $cost;
                }
            }
        }
        //var_dump($costs);

        if (is_array($costs) && count($costs) > 0) {
            foreach ($costs as $id => $cost) {
                $user = Db::name('User')->where('id', $id)->column('integral', 'id');
                if (count($user) > 0){
                    $old_integral = $user[$id];

                    echo "user-- $id, cost-- $cost, old_integral-- $old_integral \n";
                    
                    // update user.integral
                    $upd = [
                        'integral' => (int) ($old_integral - $cost)
                    ];
                    if (! Db::name('User')->where('id', $id)->update($upd) ) {
                        echo "Update user.integral field! user_id=$id \n";
                    } else {
                        // update user_integral_log
                        $ist = [
                            'user_id' => $id,
                            'type' => 0,
                            'original_integral' => $old_integral,
                            'new_integral' => $upd['integral'],
                            'operation_integral' => $cost,
                            'msg' => 'storage fee',
                            'module' => 1,
                            'add_time' => time()
                        ];
                        if (! Db::name('UserIntegralLog')->insertGetId($ist) ) {
                            echo "Insert user_integral_log error ! user_id=$id \n";
                        }
                    }
                }
            }
        }

        echo 'BATCH END <=============' . date('Y-m-d H:i:s') . "\n";
    }
}
