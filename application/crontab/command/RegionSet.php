<?php
/**
 * R
 * 2021/12/09
 * japan region data insert
 *
 */

namespace app\crontab\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class RegionSet extends Command
{
    protected function configure()
    {
        $this->setName('region_set')
            ->setDescription('japan region data insert into region table');
    }

    protected function execute(Input $input, Output $output)
    {
        echo date('Y-m-d H:i:s') . " BATCH START =============>\n";

        try {
            echo $cnt = intval(`wc -l /usr/project/dmj-shop/data/KEN_ALL.CSV | awk '{print $1}'`);
            echo "\n";

            Db::startTrans();

            $idx = 0;
            $data_path = '/usr/project/dmj-shop/data/';
            $handle = fopen($data_path.'KEN_ALL.CSV', 'r');

            while (!feof($handle)) {
                $line = fgets($handle);
                $data = mb_convert_encoding($line,'UTF-8','Shift_JIS');
                $data = str_getcsv($data,',');
                if (empty($data) || empty($data[0])){
                    continue;
                }

                $data[8] = (isset($data[8]) ? $data[8] : '');
                $data[7] = (isset($data[7]) ? $data[7] : '');
                $data[2] = isset($data[2]) ? $data[2] : "";

                $city = Db::name('Region')->where('name', $data[7])->where('level', 4)->column('id');
                if (! count($city)) continue;

                $arr = [
                    'pid' => $city[0],
                    'name' => $data[8],
                    'zip' => $data[2],
                    'level' => 5
                ];

                $town = Db::name('Region')->where('pid', $city[0])->where('level', 5)
                    ->where('name', $data[8])->field('count(id) as count')->find();
                if ($town['count'] == 0) {
                    if (! Db::name('Region')->insertGetId($arr)) {
                        Db::rollback();

                        echo 'insert error,city:' . $city;
                    }
                    $idx += 1;
                }
            }

            Db::commit();

            fclose($handle);
            echo $idx . " 条数据！\n";
        } catch (Exception $e) {
            Db::rollback();

            echo $e->getMessage();
        }

        echo 'BATCH END <=============' . date('Y-m-d H:i:s') . "\n";
    }
}
