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

/**
 * 模块语言包
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return [
    // 图片验证码
    'site_images_verify_rules_list'  => [
            0 => ['value' => 'bgcolor', 'name' => '彩色背景'],
            1 => ['value' => 'textcolor', 'name' => '彩色文本'],
            2 => ['value' => 'point', 'name' => '干扰点'],
            3 => ['value' => 'line', 'name' => '干扰线'],
        ],

    // 时区
    'site_timezone_list' => [
        'Pacific/Pago_Pago' => '(标准时-11:00) 中途岛、萨摩亚群岛',
        'Pacific/Rarotonga' => '(标准时-10:00) 夏威夷',
        'Pacific/Gambier' => '(标准时-9:00) 阿拉斯加',
        'America/Dawson' => '(标准时-8:00) 太平洋时间(美国和加拿大)',
        'America/Creston' => '(标准时-7:00) 山地时间(美国和加拿大)',
        'America/Belize' => '(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城',
        'America/Eirunepe' => '(标准时-5:00) 东部时间(美国和加拿大)、波哥大',
        'America/Antigua' => '(标准时-4:00) 大西洋时间(加拿大)、加拉加斯',
        'America/Argentina/Buenos_Aires' => '(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦',
        'America/Noronha' => '(标准时-2:00) 中大西洋',
        'Atlantic/Cape_Verde' => '(标准时-1:00) 亚速尔群岛、佛得角群岛',
        'Africa/Ouagadougou' => '(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡',
        'Europe/Andorra' => '(标准时+1:00) 中欧时间、安哥拉、利比亚',
        'Europe/Mariehamn' => '(标准时+2:00) 东欧时间、开罗，雅典',
        'Asia/Bahrain' => '(标准时+3:00) 巴格达、科威特、莫斯科',
        'Asia/Dubai' => '(标准时+4:00) 阿布扎比、马斯喀特、巴库',
        'Asia/Kolkata' => '(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇',
        'Asia/Dhaka' => '(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚',
        'Indian/Christmas' => '(标准时+7:00) 曼谷、河内、雅加达',
        'Asia/Shanghai' => '(标准时+8:00)北京、重庆、香港、新加坡',
        'Australia/Darwin' => '(标准时+9:00) 东京、汉城、大阪、雅库茨克',
        'Australia/Adelaide' => '(标准时+10:00) 悉尼、关岛',
        'Australia/Currie' => '(标准时+11:00) 马加丹、索罗门群岛',
        'Pacific/Fiji' => '(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛'
    ],

    'second_nav_list' => [
	    [
			'name'	=> '基础配置',
			'type'	=> 'base',
		],
		[
			'name'	=> '网站设置',
			'type'	=> 'siteset',
		],
		[
			'name'	=> '站点类型',
			'type'	=> 'sitetype',
		],
		[
			'name'	=> '用户注册',
			'type'	=> 'register',
		],
		[
			'name'	=> '用户登录',
			'type'	=> 'login',
		],
		[
			'name'	=> '密码找回',
			'type'	=> 'forgetpwd',
		],
		[
			'name'	=> '验证码',
			'type'	=> 'verify',
		],
		[
			'name'	=> '订单售后',
			'type'	=> 'orderaftersale',
		],
		[
			'name'	=> '附件',
			'type'	=> 'attachment',
		],
		[
			'name'	=> '缓存',
			'type'	=> 'cache',
		],
		[
			'name'	=> '扩展项',
			'type'	=> 'extends',
		],	
	],
	
	'siteset_nav_list'  =>  [
	    [
			'name'	=> '首页',
			'type'	=> 'index',
		],
		[
			'name'	=> '商品',
			'type'	=> 'goods',
		],
		[
			'name'	=> '搜索',
			'type'	=> 'search',
		],
		[
			'name'	=> '订单',
			'type'	=> 'order',
		],
		[
			'name'	=> '优惠',
			'type'	=> 'discount',
		],
		[
			'name'	=> '扩展',
			'type'	=> 'extends',
		],
	],
	
	'site_lang_list'   => [
	    '1' => '&lang=zh-cn',
		'2' => '&lang=pt-br',
	],
	
	'site_nav_login_text'    => "左侧图片最多可上传3张图片、每次随机展示其中一张",
	'site_nav_register_text' => "可自定义背景图片、默认底灰色",
	'site_base_index_text1'  => "选择logo",
	'site_base_index_text2'  => "站点状态",
	'site_base_index_text3'  => "备案信息",
	'site_base_index_text4'  => "其他",
	
	'site_siteset_index_text1' => "基础",
	'site_siteset_index_text2' => "暂无数据，请先到 / 商品管理->商品分类、一级分类设置首页推荐",
	'site_siteset_index_text3' => "自动模式",
	'site_siteset_index_text4' => "配置每个楼层最多展示多少个商品",
	'site_siteset_index_text5' => "不建议将数量修改的太大、会导致PC端左侧空白区域太大",
	'site_siteset_index_text6' => "综合为：热度->销量->最新 进行 降序(desc)排序",
	'site_siteset_index_text7' => "手动模式",
	'site_siteset_index_text8' => "可点击商品标题拖拽排序、按照顺序展示",
	'site_siteset_index_text9' => "不建议添加很多商品、会导致PC端左侧空白区域太大",
	'site_siteset_index_text10' => "商品添加",
	'site_siteset_index_text11' => "商品分类",
	'site_siteset_index_text12' => "一级",
	'site_siteset_index_text13' => "二级",
	'site_siteset_index_text14' => "三级",
	'site_siteset_index_text15' => "商品名称",
	'site_siteset_index_text16' => "搜索",
	'site_siteset_index_text17' => "请搜索商品",
	
	
	'site_siteset_goods_text1' => "级",
	'site_siteset_goods_text2' => "默认展示3级，最低1级、最高3级",
	'site_siteset_goods_text3' => "层级不一样、前端分类页样式也会不一样",
	'site_siteset_goods_text4' => "保存",
	
	
	'site_siteset_extends_text1' => "基础配置",
	'site_siteset_extends_text2' => "快捷导航",
	'site_siteset_extends_text3' => "用户地址",
	
	'site_sitetype_text1' => "销售型、常规电商流程，用户选择收货地址下单支付 -> 商家发货 -> 确认收货 -> 订单完成",
	'site_sitetype_text2' => "展示型、仅展示产品，可发起咨询（不能下单）",
	'site_sitetype_text3' => "自提点、下单时选择自提货物地址，用户下单支付 -> 确认提货 -> 订单完成",
	'site_sitetype_text4' => "虚拟销售、常规电商流程，用户下单支付 -> 自动发货 -> 确认提货 -> 订单完成",
	'site_sitetype_text5' => "存入仓库、把选中的商品存入仓库，商品所有者为当前操作用户",
	'site_sitetype_text6' => "展示型",
	'site_sitetype_text7' => "自提点",
	'site_sitetype_text8' => "移除",
	'site_sitetype_text9' => "编辑",
	'site_sitetype_text10' => "添加地址",
	'site_sitetype_text11' => "虚拟销售",
	'site_sitetype_text12' => "地址添加",
	'site_sitetype_text13' => "logo图片",
	'site_sitetype_text14' => "选传",
	'site_sitetype_text15' => "建议300x300px",
	'site_sitetype_text16' => "上传图片",
	'site_sitetype_text17' => "别名",
	'site_sitetype_text18' => "选填",
	'site_sitetype_text19' => "必填",
	'site_sitetype_text20' => "联系人",
	'site_sitetype_text21' => "联系电话",
	'site_sitetype_text22' => "详细地址",
	'site_sitetype_text23' => "定位",
	'site_sitetype_text24' => "别名格式最多 16 个字符",
	'site_sitetype_text25' => "联系人格式 2~16 个字符之间",
	'site_sitetype_text26' => "联系电话格式有误",
	'site_sitetype_text27' => "详细地址格式 1~80 个字符之间",
	'site_sitetype_text28' => "确认",
	
	'site_register_text' => "选择图片",
	
	'site_login_text' => '图片',
	'site_login_text1' => '背景色',
	
    'site_orderaftersale_text' => '天',
	
	'site_attachment_text1' => '默认否、建议开启上传图片重新绘制、防止木马病毒图片上传',
	'site_attachment_text2' => '开启后gif动态图片将失效、由于重新绘制图片大小也会改变',
	
	'site_cache_text1' => '默认使用的文件缓存、使用Redis缓存PHP需要先安装Redis扩展',
	'site_cache_text2' => '请确保Redis服务稳定性（Session使用缓存后、服务不稳定可能导致后台也无法登录）',
	'site_cache_text3' => '如遇到Redis服务异常无法登录管理后台、修改配置文件',
	'site_cache_text4' => '目录下',
	'site_cache_text5' => '文件',
	'site_cache_text6' => 'Session缓存配置',
	'site_cache_text7' => '数据缓存配置',
	'site_cache_text8' => '秒',
	
	'site_extends_text1' => '定时脚本配置',
	'site_extends_text2' => '建议将脚本地址添加到linux定时任务定时请求即可（结果 sucs:0, fail:0 冒号后面则是处理的数据条数，sucs成功，fali失败）',
	'site_extends_text3' => '分钟',
	'site_extends_text4' => 'CDN配置',
	'site_extends_text5' => '未设置则使用当前站点域名',
	
	'sms_nav_text1' => '短信设置',
	'sms_nav_text2' => '消息模板',
	'sms_nav_text3' => '阿里云短信管理地址',
	'sms_nav_text4' => '点击去阿里云购买短信',
	'sms_message_text1' => '后台',
	'sms_message_text2' => '前端',
	
	'email_nav_text1' => '邮箱设置',
	'email_nav_text2' => '消息模板',
	'email_nav_text3' => '参考相关邮箱配置教程',
	'email_nav_text4' => '点击去看教程',
	'email_index_text1' => '测试接收的邮件地址',
	'email_index_text2' => '请先保存配置后，再进行测试',
	'email_index_text3' => '测试接收的邮件地址',
	'email_index_text4' => '测试',
	
	'seo_index_text1' => '参考伪静态配置教程',
	'seo_index_text2' => '点击去看教程',
	
	'agreement_nav_text' => '前端访问协议地址增加参数 is_content=1 则仅展示纯协议内容',
	'agreement_register_text' => '查看详情',
	
	'form_operate_text1' => '删除',
	'form_operate_text2' => '重置',
	'form_operate_text3' => '搜索',
	'form_operate_text4' => '设置',
	'form_operate_text5' => '详情',
	'form_operate_text6' => '编辑',
	'form_operate_text7' => '删除',
	'form_operate_text8' => '核查',
	'form_operate_text9' => '入库',
	'form_operate_text10' => '库存',
    'form_operate_text11' => '复制',
	
	'admin_index_text1' => '新增',
	'admin_index_text2' => '超级管理员默认拥有所有权限，不可更改。',
	
	'admin_save_text' => '管理员',
	'admin_save_text1' => '添加',
	'admin_save_text2' => '编辑',
	'admin_save_text3' => '返回',
	'admin_save_text4' => '用户名',
	'admin_save_text5' => '登录密码',
	'admin_save_text6' => '手机号码',
	'admin_save_text7' => '电子邮箱',
	'admin_save_text8' => '权限组',
	'admin_save_text9' => '状态',
	'admin_save_text10' => '负责地区',
	'admin_save_text11' => '选填',
	'admin_save_text12' => '必选',
	'admin_save_text13' => '必填',
	'admin_save_text14' => '不可更改',
	'admin_save_text15' => '用户名格式 5~18 个字符（可以是字母数字下划线）',
	'admin_save_text16' => '密码格式 6~18 个字符',
	'admin_save_text17' => '手机号码格式错误',
	'admin_save_text18' => '电子邮箱格式错误、最多60个字符',
	'admin_save_text19' => '可选择',
	'admin_save_text20' => '性别',
	
	'admin_user_text' => '导出Excel',
	'admin_user_text1' => '暂无头像',
	
	'admin_useraddr_text' => '默认',
	'admin_useraddr_text1' => '否',
	'admin_useraddr_text2' => '经度',
	'admin_useraddr_text3' => '纬度',
	'admin_useraddr_text4' => '查看位置',
	
	'user_save_text1' =>'用户',
	'user_save_text2' =>'添加',
	'user_save_text3' =>'编辑',
	'user_save_text4' =>'返回',
	'user_save_text5' =>'用户名',
	'user_save_text6' =>'用户名 2~30 个字符',
	'user_save_text7' =>'昵称',
	'user_save_text8' =>'昵称最多 16 个字符',
	'user_save_text9' =>'微信号',
	'user_save_text10' =>'手机号码',
	'user_save_text11' =>'电子邮箱',
	'user_save_text12' =>'电子邮箱格式错误',
	'user_save_text13' =>'支付宝openid',
	'user_save_text14' =>'请填写支付宝openid',
	'user_save_text15' =>'百度openid',
	'user_save_text16' =>'请填写百度openid',
	'user_save_text17' =>'头条openid',
	'user_save_text18' =>'请填写头条openid',
	'user_save_text19' =>'QQopenid',
	'user_save_text20' =>'请填写QQopenid',
	'user_save_text21' =>'QQunionid',
	'user_save_text22' =>'请填写QQunionid',
	'user_save_text23' =>'微信openid',
	'user_save_text24' =>'微信unionid',
	'user_save_text25' =>'请填写微信unionid',
	'user_save_text26' =>'微信webopenid',
	'user_save_text27' =>'请填写微信webopenid',
	'user_save_text28' =>'生日',
	'user_save_text29' =>'生日格式有误',
	'user_save_text30' =>'详细地址',
	'user_save_text31' =>'详细地址2~60 个字符',
	'user_save_text32' =>'积分',
	'user_save_text33' =>'出库费（不填时使用平台默认值）',
	'user_save_text34' =>'出库费',
	'user_save_text35' =>'填写正确格式',
	'user_save_text36' =>'手续费（不填时使用平台默认值）',
	'user_save_text37' =>'手续费',
	'user_save_text38' =>'邀请用户ID',
	'user_save_text39' =>'请输入邀请用户ID',
	'user_save_text40' =>'登录密码',
	'user_save_text41' =>'登录密码格式 6~18 个字符之间',
	'user_save_text42' =>'海外仓',
	'user_save_text43' =>'用户状态',
	
	'order_operate_text1' => '详情',
	'order_operate_text2' => '确认',
	'order_operate_text3' => '取消',
	'order_operate_text4' => '支付',
	'order_operate_text5' => '取货',
	'order_operate_text6' => '发货',
	'order_operate_text7' => '收货',
	'order_operate_text8' => '删除',
	'order_operate_text9' => '是否操作收货，操作后不可恢复',
	'order_operate_text10' => '删除后无法恢复，确定继续吗',
	'order_operate_text11' => '是否操作收货，操作后不可恢复',
	'order_operate_text12' => '取消后无法恢复，确定继续吗',
	'order_operate_text13' => '温馨提示',
	'order_operate_text14' => '取消',
	'order_operate_text15' => '确定',
	
	'order_index_text1' => '取货码',
	'order_index_text2' => '确认',
	'order_index_text3' => '发货操作',
	'order_index_text4' => '快递单号',
	'order_index_text5' => '支付操作',
	
	'order_detail_text1' => '订单商品',
	'order_detail_text2' => '收货地址',
	'order_detail_text3' => '收件人',
	'order_detail_text4' => '收件电话',
	'order_detail_text5' => '详细地址',
	'order_detail_text6' => '身份证信息',
	'order_detail_text7' => '姓名',
	'order_detail_text8' => '号码',
	'order_detail_text9' => '照片',
	'order_detail_text10' => '查看位置',
	'order_detail_text11' => '取货信息',
	'order_detail_text12' => '联系信息',
	'order_detail_text13' => '密钥信息',
	'order_detail_text14' => '未配置数据',
	'order_detail_text15' => '无',
	
	'inbound_detail_text1' => '入库信息',
	'inbound_detail_text2' => '外包装参数',
	'inbound_detail_text3' => '长',
	'inbound_detail_text4' => '宽',
	'inbound_detail_text5' => '高',
	'inbound_detail_text6' => '重量',
	'inbound_detail_text7' => '商品信息',
	'inbound_detail_text8' => '商品名',
	'inbound_detail_text9' => '规格',
	'inbound_detail_text10' => 'SKU码',
	'inbound_detail_text11' => '入库数量',
	'inbound_detail_text12' => '核查信息',
	'inbound_detail_text13' => '状态',
	'inbound_detail_text14' => '快递',
	'inbound_detail_text15' => '核查结果',
	'inbound_detail_text16' => '商品入库信息',
	'inbound_detail_text17' => '依赖入库数量',
	'inbound_detail_text18' => '实际入库数量',
	
	'warehousegoods_index_text1' => '添加',
	'warehousegoods_index_text2' => '商品添加',
	'warehousegoods_index_text3' => '仓库',
	'warehousegoods_index_text4' => '商品分类',
	'warehousegoods_index_text5' => '一级',
	'warehousegoods_index_text6' => '二级',
	'warehousegoods_index_text7' => '三级',
	'warehousegoods_index_text8' => '商品名称',
	'warehousegoods_index_text9' => '请搜索商品',
	
	'warehousegoods_detail_text1' => '规格库存',
	'warehousegoods_detail_text2' => '规格',
	'warehousegoods_detail_text3' => '库存',
	'warehousegoods_detail_text4' => '无',

    'warehousegoods_inventory_text1' => '规格',
    'warehousegoods_inventory_text2' => '库存',
    'warehousegoods_inventory_text3' => '确认',
    'warehousegoods_inventory_text4' => '无规格数据',
    'warehousegoods_inventory_text5' => '批量设置的值',

    'goods_info_text1' => '品牌',
    'goods_info_text2' => '商品',
    'goods_info_text3' => '添加',
    'goods_info_text4' => '编辑',
    'goods_info_text5' => '返回',
    'goods_info_text6' => '基础信息',
    'goods_info_text7' => '商品规格',
    'goods_info_text8' => '商品参数',
    'goods_info_text9' => '商品相册',
    'goods_info_text10' => '商品视频',
    'goods_info_text11' => '手机详情',
    'goods_info_text12' => '电脑详情',
    'goods_info_text13' => '虚拟信息',
    'goods_info_text14' => '扩展数据',
    'goods_info_text15' => '标题名称',
    'goods_info_text16' => '必填',
    'goods_info_text17' => '商品简述',
    'goods_info_text18' => '选填',
    'goods_info_text19' => '商品简述格式 最多230个字符',
    'goods_info_text20' => '标题名称格式 2~160 个字符',
    'goods_info_text21' => '商品型号',
    'goods_info_text22' => '商品型号格式 最多30个字符',
    'goods_info_text23' => '商品分类',
    'goods_info_text24' => '至少选择一个',
    'goods_info_text25' => '请选择',
    'goods_info_text26' => '请至少选择一个商品分类',
    'goods_info_text27' => '一级',
    'goods_info_text28' => '二级',
    'goods_info_text29' => '三级',
    'goods_info_text30' => '可选',
    'goods_info_text31' => '请选择品牌',
    'goods_info_text32' => '生产地',
    'goods_info_text33' => '请选择生产地',
    'goods_info_text34' => '库存单位',
    'goods_info_text35' => '库存单位格式 1~6 个字符',
    'goods_info_text36' => '购买赠送积分比例',
    'goods_info_text37' => '购买赠送积分比例 0~100 的数字',
    'goods_info_text38' => '按照商品金额比例乘以数量的比例进行发放',
    'goods_info_text39' => '最低起购数量',
    'goods_info_text40' => '默认数值 1',
    'goods_info_text41' => '单次最大购买数量',
    'goods_info_text42' => '单次最大数值 100000000, 小于等于0或空则不限',
    'goods_info_text43' => '商品类型',
    'goods_info_text44' => '当前系统配置的站点类型为',
    'goods_info_text45' => '如果商品类型未配置则跟随系统配置的站点类型',
    'goods_info_text46' => '当设置的商品类型不在系统设置的站点类型包含的时候，商品加入购物车功能将失效',
    'goods_info_text47' => '请选择商品类型',
    'goods_info_text48' => '封面图片',
    'goods_info_text49' => '选传',
    'goods_info_text50' => '留空则取相册第一张图、建议800*800px',
    'goods_info_text51' => '上传图片',
    'goods_info_text52' => '扣减库存',
    'goods_info_text53' => '扣除规则根据后台配置->扣除库存规则而定',
    'goods_info_text54' => '否',
    'goods_info_text55' => '是',
    'goods_info_text56' => '上下架',
    'goods_info_text57' => '下架后用户不可见',
    'goods_info_text58' => '下架',
    'goods_info_text59' => '上架',
    'goods_info_text60' => '商品外参数',
    'goods_info_text61' => '长',
    'goods_info_text62' => '宽',
    'goods_info_text63' => '高',
    'goods_info_text64' => '重量',
    'goods_info_text65' => '请填写长度',
    'goods_info_text66' => '请填写宽度',
    'goods_info_text67' => '请填写高度',
    'goods_info_text68' => '请填写重量',
    'goods_info_text69' => '快递选择',
    'goods_info_text70' => '请选择价格',
    'goods_info_text71' => '配送费',
    'goods_info_text72' => '快捷操作',
    'goods_info_text73' => '请选择模板',
    'goods_info_text74' => '粘贴商品参数配置信息',
    'goods_info_text75' => '确认',
    'goods_info_text76' => '复制配置',
    'goods_info_text77' => '清空参数',
    'goods_info_text78' => '商品相册',
    'goods_info_text79' => '可拖拽图片进行排序，建议图片尺寸一致800*800px、最多30张',
    'goods_info_text80' => '必传',
    'goods_info_text81' => '上传相册',
    'goods_info_text82' => '设置手机详情后、在手机模式下将展示手机详情、比如[小程序、APP]',
    'goods_info_text83' => '选传',
    'goods_info_text84' => '视频比图文更有具带入感，仅支持 mp4 格式',
    'goods_info_text85' => '上传视频',
    'goods_info_text86' => '图片',
    'goods_info_text87' => '文本内容',
    'goods_info_text88' => '删除',
    'goods_info_text89' => '拖拽排序',
    'goods_info_text90' => '文本内容最多 105000 个字符',
    'goods_info_text91' => '添加手机详情',
    'goods_info_text92' => '该区域为插件扩展数据，请按照插件文档填写相应的值',
    'goods_info_text93' => '',
    'goods_info_text94' => '',
    'goods_info_text95' => '',
    'goods_info_text96' => '',
    'goods_info_text97' => '',
    'goods_info_text98' => '',
    'goods_info_text99' => '',
    'goods_info_text100' => '',
    'goods_info_text101' => '',
    'goods_info_text102' => '',
    'goods_info_text103' => '',
    'goods_info_text104' => '',
    'goods_info_text105' => '',
    'goods_info_text106' => '',
    'goods_info_text107' => '',
    'goods_info_text108' => '',
    'goods_info_text109' => '',
	
	'admin_form_fields_text1' => '可点击拖拽调整显示顺序、如需恢复点击重置即可',
	'admin_form_fields_text2' => '全选',
	'admin_form_fields_text3' => '反选',
	'admin_form_fields_text4' => '重置',
	'admin_form_fields_text5' => '确认',
	'admin_form_fields_text6' => '处理中',
	
	'admin_nodata_text' => '没有相关数据',
    // seo
    // url模式列表
    'seo_url_model_list'        =>  [
            0 => ['value' => 0, 'name' => '兼容模式', 'checked' => true],
            1 => ['value' => 1, 'name' => 'PATHINFO模式'],
            2 => ['value' => 2, 'name' => 'PATHINFO模式+短地址'],
        ],

    // 用户excel导出标题列表
    'excel_user_title_list'     =>  [
            'username'      =>  [
                    'name' => '用户名',
                    'type' => 'string',
                ],
            'nickname'      =>  [
                    'name' => '昵称',
                    'type' => 'int',
                ],
            'gender_text'   =>  [
                    'name' => '性别',
                    'type' => 'string',
                ],
            'birthday_text'=>   [
                    'name' => '生日',
                    'type' => 'string',
                ],
            'status_text'=>   [
                    'name' => '状态',
                    'type' => 'string',
                ],
            'mobile'        =>  [
                    'name' => '手机号码',
                    'type' => 'int',
                ],
            'email'         =>  [
                    'name' => '电子邮箱',
                    'type' => 'string',
                ],
            'province'      =>  [
                    'name' => '所在省',
                    'type' => 'string',
                ],
            'city'      =>  [
                    'name' => '所在市',
                    'type' => 'string',
                ],
            'address'       =>  [
                    'name' => '详细地址',
                    'type' => 'string',
                ],
            'add_time'      =>  [
                    'name' => '注册时间',
                    'type' => 'string',
                ],
        ],
];
?>
