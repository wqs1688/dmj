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
namespace app\admin\form;

use think\Db;
use app\service\GoodsService;
use app\service\RegionService;
use app\service\BrandService;

/**
 * 商品动态表格
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-05-16
 * @desc    description
 */
class Goods
{
    // 基础条件
    public $condition_base = [
        ['g.is_delete_time', '=', 0],
    ];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-05-16
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
		$lang = isset($params['lang'])?"&lang=".$params['lang']:"";
		if($params["system_admin"]["lang_type"] == 1){
			$name1 = '反选';
			$name2 = '全选';
			$name3 = '商品ID';
			$name4 = '商品信息';
			$name5 = '请输入商品名称/简述/SEO信息';
			$name6 = '商品分类';
			$name7 = '品牌';
			$name8 = '销售价格';
			$name9 = '原价';
			$name10 = '库存总量';
			$name11 = '上下架';
			$name12 = '扣减库存';
			$name13 = '商品类型';
			$name14 = '商品型号';
			$name15 = '生产地';
			$name16 = '购买赠送积分比例';
			$name17 = '单次最低起购数量';
			$name18 = '单次最大购买数量';
			$name19 = '销量';
			$name20 = '访问次数';
			$name21 = '创建时间';
			$name22 = '更新时间';
			$name23 = '操作';
			$name24 = '基础信息';
		}else{
			$name1 = 'Inverter seleção';
            $name2 = 'selecionar tudo';
            $name3 = 'ID do item';
            $name4 = 'Informações do produto';
            $name5 = 'Por favor, digite o nome do produto/breve descrição/informação de SEO';
            $name6 = 'Categoria do Produto';
            $name7 = 'marca';
            $name8 = 'Preço de Venda';
            $name9 = 'Preço Original';
            $name10 = 'Inventário total';
            $name11 = 'Descarregando';
            $name12 = 'Deduzir Inventário';
            $name13 = 'Tipo de Item';
            $name14 = 'Modelo de item';
            $name15 = 'Local de Produção';
            $name16 = 'Relação de pontos de bônus de compra';
            $name17 = 'Quantidade mínima única de compra';
            $name18 = 'Quantidade máxima de compra única';
            $name19 = 'Vendas';
            $name20 = 'Visitas';
            $name21 = 'criado';
            $name22 = 'Hora de atualização';
            $name23 = 'Operação';
            $name24 = 'Informações básicas';
		}
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'status_field'  => 'is_shelves',
                'is_search'     => 1,
                'search_url'    => MyUrl('admin/goods/index').$lang,
                'is_delete'     => 1,
                'delete_url'    => MyUrl('admin/goods/delete'),
                'delete_key'    => 'ids',
                'detail_title'  => $name24,
            ],
            // 表单配置
            'form' => [
                [
                    'view_type'         => 'checkbox',
                    'is_checked'        => 0,
                    'checked_text'      => $name1,
                    'not_checked_text'  => $name2,
                    'align'             => 'center',
                    //'width'             => 80,
                ],
                [
                    'label'         => $name3,
                    'view_type'     => 'field',
                    'view_key'      => 'id',
                    'width'         => 105,
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => '=',
                    ],
                ],
                [
                    'label'         => $name4,
                    'view_type'     => 'module',
                    'view_key'      => 'goods/module/info',
                    'grid_size'     => 'lg',
                    'is_sort'       => 1,
                    'sort_field'    => 'title',
                    'search_config' => [
                        'form_type'         => 'input',
                        'form_name'         => 'title|simple_desc|seo_title|seo_keywords|seo_keywords',
                        'where_type'        => 'like',
                        'placeholder'       => $name5
                    ],
                ],
                [
                    'label'         => $name6,
                    'view_type'     => 'field',
                    'view_key'      => 'category_text',
                    'search_config' => [
                        'form_type'             => 'module',
                        'template'              => 'lib/module/goods_category',
                        'form_name'             => 'id',
                        'where_type'            => 'in',
                        'where_value_custom'    => 'WhereValueGoodsCategory',
                        'data'                  => GoodsService::GoodsCategoryAll(),
                    ],
                ],
                [
                    'label'         => $name7,
                    'view_type'     => 'field',
                    'view_key'      => 'brand_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'module',
                        'template'          => 'lib/module/category_brand',
                        'form_name'         => 'brand_id',
                        'data'              => BrandService::CategoryBrand(),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                    ],
                ],
                [
                    'label'         => $name8,
                    'view_type'     => 'field',
                    'view_key'      => 'price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'form_name'         => 'min_price',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name9,
                    'view_type'     => 'field',
                    'view_key'      => 'original_price',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'form_name'         => 'min_original_price',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => $name10,
                    'view_type'     => 'field',
                    'view_key'      => ['inventory', 'inventory_unit'],
                    'view_key_join' => ' ',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'form_name'         => 'inventory',
                    ],
                ],
                [
                    'label'         => $name11,
                    'view_type'     => 'status',
                    'view_key'      => 'is_shelves',
                    'post_url'      => MyUrl('admin/goods/statusupdate'),
                    'is_form_su'    => 1,
                    'align'         => 'center',
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
                    'label'         => $name12,
                    'view_type'     => 'status',
                    'view_key'      => 'is_deduction_inventory',
                    'post_url'      => MyUrl('admin/goods/statusupdate'),
                    'align'         => 'center',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_is_text_list'),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name13,
                    'view_type'     => 'field',
                    'view_key'      => 'site_type',
                    'view_data_key' => 'name',
                    'view_data'     => lang('common_site_type_list'),
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'where_type'        => 'in',
                        'data'              => lang('common_site_type_list'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name14,
                    'view_type'     => 'field',
                    'view_key'      => 'model',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => $name15,
                    'view_type'     => 'field',
                    'view_key'      => 'place_origin_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'select',
                        'form_name'         => 'place_origin',
                        'data'              => RegionService::RegionItems(['pid'=>0]),
                        'data_key'          => 'id',
                        'data_name'         => 'name',
                        'where_type'        => 'in',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => $name16,
                    'view_type'     => 'field',
                    'view_key'      => 'give_integral',
                    'view_join_last'=> '%',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name17,
                    'view_type'     => 'field',
                    'view_key'      => 'buy_min_number',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name18,
                    'view_type'     => 'field',
                    'view_key'      => 'buy_max_number',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name19,
                    'view_type'     => 'field',
                    'view_key'      => 'sales_count',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name20,
                    'view_type'     => 'field',
                    'view_key'      => 'access_count',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                    ],
                ],
                [
                    'label'         => $name21,
                    'view_type'     => 'field',
                    'view_key'      => 'add_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name22,
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => $name23,
                    'view_type'     => 'operate',
                    'view_key'      => 'goods/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
        ];
    }

    /**
     * 商品分类条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-03
     * @desc    description
     * @param   [array]           $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereValueGoodsCategory($value, $params = [])
    {
        if(!empty($value))
        {
            // 是否为数组
            if(!is_array($value))
            {
                $value = [$value];
            }

            // 获取分类下的所有分类 id
            $cids = GoodsService::GoodsCategoryItemsIds($value, 1);

            // 获取商品 id
            $ids = Db::name('GoodsCategoryJoin')->where(['category_id'=>$cids])->column('goods_id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }
}
?>
