<?php
// +----------------------------------------------------------------------
// | 葡萄牙语
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------

/**
 * 葡萄牙语语言包
 * @author   R
 * @version  0.0.1
 * @datetime 2021-12-20
 */
return [
    'test' => 'pt-br',
    // 系统版本列表
    'common_system_version_list'          =>  [
            '1.1.0' => ['value' => '1.1.0', 'name' => 'v1.1.0'],
            '1.2.0' => ['value' => '1.2.0', 'name' => 'v1.2.0'],
            '1.3.0' => ['value' => '1.3.0', 'name' => 'v1.3.0'],
            '1.4.0' => ['value' => '1.4.0', 'name' => 'v1.4.0'],
            '1.5.0' => ['value' => '1.5.0', 'name' => 'v1.5.0'],
            '1.6.0' => ['value' => '1.6.0', 'name' => 'v1.6.0'],
            '1.7.0' => ['value' => '1.7.0', 'name' => 'v1.7.0'],
            '1.8.0' => ['value' => '1.8.0', 'name' => 'v1.8.0'],
            '1.8.1' => ['value' => '1.8.1', 'name' => 'v1.8.1'],
            '1.9.0' => ['value' => '1.9.0', 'name' => 'v1.9.0'],
            '1.9.1' => ['value' => '1.9.1', 'name' => 'v1.9.1'],
            '1.9.2' => ['value' => '1.9.2', 'name' => 'v1.9.2'],
            '1.9.3' => ['value' => '1.9.3', 'name' => 'v1.9.3'],
            '2.0.0' => ['value' => '2.0.0', 'name' => 'v2.0.0'],
            '2.0.1' => ['value' => '2.0.1', 'name' => 'v2.0.1'],
            '2.0.2' => ['value' => '2.0.2', 'name' => 'v2.0.2'],
            '2.0.3' => ['value' => '2.0.3', 'name' => 'v2.0.3'],
        ],

    // 用户注册类型列表
    'common_user_reg_type_list'          =>  [
            0 => ['value' => 'sms', 'name' => 'Mensagem curta'],
            1 => ['value' => 'email', 'name' => 'Correspondência'],
            2 => ['value' => 'username', 'name' => 'nome do usuário'],
        ],

    // 登录方式
    'common_login_type_list'     =>  [
            0 => ['value' => 'username', 'name' => 'Senha da conta', 'checked' => true],
            1 => ['value' => 'email', 'name' => 'Código de verificação de e-mail'],
            2 => ['value' => 'sms', 'name' => 'Código de verificação do telefone'],
        ],
    
    // 性别
    'common_gender_list'                =>  [
            0 => ['id' => 0, 'name' => 'Guarde segredo', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Fêmea'],
            2 => ['id' => 2, 'name' => 'macho'],
        ],

    // 关闭开启状态
    'common_close_open_list'          =>  [
            0 => ['value' => 0, 'name' => 'fecho'],
            1 => ['value' => 1, 'name' => 'Ligar'],
        ],

    // 是否启用
    'common_is_enable_tips'             =>  [
            0 => ['id' => 0, 'name' => 'Não habilitado'],
            1 => ['id' => 1, 'name' => 'ativado'],
        ],
    'common_is_enable_list'             =>  [
            0 => ['id' => 0, 'name' => 'Não habilitado'],
            1 => ['id' => 1, 'name' => 'habilitar', 'checked' => true],
        ],

    // 是否显示
    'common_is_show_list'               =>  [
            0 => ['id' => 0, 'name' => 'Não mostre'],
            1 => ['id' => 1, 'name' => 'exposição', 'checked' => true],
        ],

    // 状态
    'common_state_list'             =>  [
            0 => ['id' => 0, 'name' => 'indisponível'],
            1 => ['id' => 1, 'name' => 'acessível', 'checked' => true],
        ],

    // excel编码列表
    'common_excel_charset_list'         =>  [
            0 => ['id' => 0, 'value' => 'utf-8', 'name' => 'utf-8', 'checked' => true],
            1 => ['id' => 1, 'value' => 'gbk', 'name' => 'gbk'],
        ],

    // 支付状态
    'common_order_pay_status'   => [
            0 => ['id' => 0, 'name' => 'Ser pago', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Pago'],
            2 => ['id' => 2, 'name' => 'devolveu'],
            3 => ['id' => 3, 'name' => 'Reembolso parcial'],
        ],

    // 用户端 - 订单管理
    'common_order_user_status'          =>  [
            0 => ['id' => 0, 'name' => 'a ser confirmado', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Pagamento Pendente'],
            2 => ['id' => 2, 'name' => 'a ser entregue'],
            3 => ['id' => 3, 'name' => 'Enviado'],
            4 => ['id' => 4, 'name' => 'concluído'],
            5 => ['id' => 5, 'name' => 'Cancelado'],
            6 => ['id' => 6, 'name' => 'fechado'],
        ],

    // 后台管理 - 订单管理
    'common_order_admin_status'         =>  [
            0 => ['id' => 0, 'name' => 'a ser confirmado', 'checked' => true],
            1 => ['id' => 1, 'name' => 'confirmado/Ser pago'],
            2 => ['id' => 2, 'name' => 'a ser entregue/retirada pendente'],
            3 => ['id' => 3, 'name' => 'Enviado/recebimento pendente'],
            4 => ['id' => 4, 'name' => 'concluído'],
            5 => ['id' => 5, 'name' => 'Cancelado'],
            6 => ['id' => 6, 'name' => 'fechado'],
        ],
		
	// 后台共通头部
	'common_admin_nav_title'         => "primeira página",
	'admin_theme_site_name'          => "casa de cevada",
	'common_admin_title'             => "Sistema de gerenciamento de plano de fundo",
	'common_admin_title_1'           => "Ver página inicial",
	'common_admin_title_2'           => "Ligar na tela cheia",
	'common_admin_title_3_1'         => "configurado",
	'common_admin_title_3_2'         => "Logout.",
	'common_admin_title_4'           => "Selecção de línguas",
	'common_admin_init_stat'         => "Estatísticas da loja",
	'common_admin_init_stat_user'    => "Total de usuários",
	'common_admin_init_date1'        => "mês passado",
	'common_admin_init_date2'        => "mês atual",
	'common_admin_init_date3'        => "ontem",
	'common_admin_init_date4'        => "hoje",
	'common_admin_init_stat_order'   => "ordem total",
	'common_admin_init_stat_deal'    => "volume total de transações",
	'common_admin_init_stat_inco'    => "rendimento total",
	'common_admin_init_deal_trend'   => "Tendência de rotatividade de pedidos nos últimos 30 dias",
	'common_admin_init_order_trend'  => "Tendência de negociação de pedidos nos últimos 30 dias",
	'common_admin_init_hot_product'  => "Produtos mais vendidos nos últimos 30 dias",
	'common_admin_init_pay'          => "Forma de pagamento nos últimos 30 dias",
	'common_admin_config_title1'     => "Configuração básica",
	'common_admin_config_title2'     => "Conecte-se",
	'common_admin_config_title3'     => "mercadoria",
	'common_admin_config_title4'     => "expandir",
	'common_admin_config_comment1'   => "1. A imagem de fundo padrão está localizada no diretório [público / estático / admin / padrão / imagens / login]",
	'common_admin_config_comment2'   => "2. Depois de mudar a imagem, você precisa modificar a variável [bg Josu Imagens Loulou] no método [logininfo] no arquivo [aplicativo / admin / controller / Admin. PHP].",
    'common_admin_config_comment3'   => "Por favor, aplique na plataforma aberta do mapa Baidu",
	'common_admin_config_comment4'   => "Ver o tutorial de configuração",
	'common_admin_config_comment5'   => "preservação",
    'common_admin_config_comment6'   => "Selecione a imagem",
    'common_page_text1'              => "redirecionar para",
    'common_page_text2'              => "Pagina",
    'common_page_text3'              => "dados",
    'common_page_text4'              => "frequentes",

    // 优惠券类型
    'common_coupon_type'            =>  [
            0 => ['id' => 0, 'name' => 'Atividades divertidas', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Registre-se para enviar'],
        ],

    // 用户优惠券状态
    'common_user_coupon_status'         =>  [
            0 => ['id' => 0, 'name' => 'Não usado', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Usava'],
            2 => ['id' => 2, 'name' => 'expirado'],
        ],

    // 所属平台
    'common_platform_type'          =>  [
            'pc'     => ['value' => 'pc', 'name' => 'site do computador'],
            'h5'     => ['value' => 'h5', 'name' => 'Site móvel H5'],
            'ios' => ['value' => 'ios', 'name' => 'APLICATIVO Apple'],
            'android' => ['value' => 'android', 'name' => 'APLICATIVO Android'],
            'weixin' => ['value' => 'weixin', 'name' => 'Miniaplicativo WeChat'],
            'alipay' => ['value' => 'alipay', 'name' => 'Miniaplicativo Alipay'],
            'baidu' => ['value' => 'baidu', 'name' => 'Miniaplicativo Baidu'],
            'toutiao' => ['value' => 'toutiao', 'name' => 'miniaplicativo de título'],
            'qq' => ['value' => 'qq', 'name' => 'miniaplicativo QQ'],
        ],

    // app平台
    'common_app_type'          =>  [
            'ios' => ['value' => 'ios', 'name' => 'APLICATIVO Apple'],
            'android' => ['value' => 'android', 'name' => 'APLICATIVO Android'],
        ],

    // 小程序平台
    'common_appmini_type'          =>  [
            'weixin' => ['value' => 'weixin', 'name' => 'Miniaplicativo WeChat'],
            'alipay' => ['value' => 'alipay', 'name' => 'Miniaplicativo Alipay'],
            'baidu' => ['value' => 'baidu', 'name' => 'Miniaplicativo Baidu'],
            'toutiao' => ['value' => 'toutiao', 'name' => 'miniaplicativo de título'],
            'qq' => ['value' => 'qq', 'name' => 'miniaplicativo QQ'],
        ],

    // 小程序url跳转类型
    'common_jump_url_type'  =>  [
            0 => ['value' => 0, 'name' => 'Página da Internet'],
            1 => ['value' => 1, 'name' => 'Página interna (mini programa ou endereço interno do APP)'],
            2 => ['value' => 2, 'name' => 'Applet externo (o appid do applet sob o mesmo corpo principal)'],
        ],

    // 扣除库存规则
    'common_deduction_inventory_rules_list'         =>  [
            0 => ['id' => 0, 'name' => 'Pedido confirmado com sucesso', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Pedido pago com sucesso'],
            2 => ['id' => 2, 'name' => 'Encomenda enviada'],
        ],

    // 是否已读
    'common_is_read_list'               =>  [
            0 => ['id' => 0, 'name' => 'Não lida', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Tenho lido'],
        ],

    // 消息类型
    'common_message_type_list'          =>  [
            0 => ['id' => 0, 'name' => 'padrão', 'checked' => true],
        ],

    // 用户积分 - 操作类型
    'common_integral_log_type_list'             =>  [
            0 => ['id' => 0, 'name' => 'reduzir', 'checked' => true],
            1 => ['id' => 1, 'name' => 'Aumentar'],
        ],

    // 是否上架/下架
    'common_is_shelves_list'                    =>  [
            0 => ['id' => 0, 'name' => 'derrubar'],
            1 => ['id' => 1, 'name' => 'na prateleira', 'checked' => true],
            2 => ['id' => 2, 'name' => 'sob revisão'],
        ],

    // 是否
    'common_is_text_list'   =>  [
            0 => ['id' => 0, 'name' => 'não', 'checked' => true],
            1 => ['id' => 1, 'name' => 'sim'],
        ],

    // 用户状态
    'common_user_status_list'           =>  [
            0 => ['id' => 0, 'name' => 'normal', 'checked' => true],
            1 => ['id' => 1, 'name' => 'sem falar', 'tips' => 'Usuário proibido de falar'],
            2 => ['id' => 2, 'name' => 'Desativar login', 'tips' => 'O usuário está proibido de fazer login'],
            3 => ['id' => 3, 'name' => 'revisão pendente', 'tips' => 'O usuário está aguardando revisão'],
        ],

    // 导航数据类型
    'common_nav_type_list'              =>  [
            'custom' => ['value'=>'custom', 'name'=>'customizar'],
            'article' => ['value'=>'article', 'name'=>'artigo'],
            'customview' => ['value'=>'customview', 'name'=>'personalizar página'],
            'goods_category' => ['value'=>'goods_category', 'name'=>'Categorias'],
        ],

    // 搜索框下热门关键字类型
    'common_search_keywords_type_list'      =>  [
            0 => ['value' => 0, 'name' => 'fecho'],
            1 => ['value' => 1, 'name' => 'automático'],
            2 => ['value' => 2, 'name' => 'customizar'],
        ],

    // 发送状态
    'common_send_status_list'       =>  [
            0 => ['value' => 0, 'name' => 'ainda não foi enviado'],
            1 => ['value' => 1, 'name' => 'enviando'],
            2 => ['value' => 2, 'name' => 'Enviado com sucesso'],
            3 => ['value' => 3, 'name' => 'Sucesso parcial'],
            4 => ['value' => 4, 'name' => 'Falha ao enviar'],
        ],

    // 发布状态
    'common_release_status_list'        =>  [
            0 => ['value' => 0, 'name' => 'Não publicado'],
            1 => ['value' => 1, 'name' => 'anunciando'],
            2 => ['value' => 2, 'name' => 'Publicados'],
            3 => ['value' => 3, 'name' => 'Sucesso parcial'],
            4 => ['value' => 4, 'name' => 'Falha ao publicar'],
        ],

    // 处理状态
    'common_handle_status_list' =>  [
            0 => ['value' => 0, 'name' => 'não processado'],
            1 => ['value' => 1, 'name' => 'Em processamento'],
            2 => ['value' => 2, 'name' => 'processado'],
            3 => ['value' => 3, 'name' => 'Sucesso parcial'],
            4 => ['value' => 4, 'name' => 'Falha no processamento'],
        ],

    // 支付宝生活号菜单事件类型
    'common_alipay_life_menu_action_type_list'  =>  [
            0 => ['value' => 0, 'out_value' => 'out', 'name' => 'menu do evento'],
            1 => ['value' => 1, 'out_value' => 'link', 'name' => 'menu de links'],
            2 => ['value' => 2, 'out_value' => 'tel', 'name' => 'Clique para chamar'],
            3 => ['value' => 3, 'out_value' => 'map', 'name' => 'Clique para ver o mapa'],
            4 => ['value' => 4, 'out_value' => 'consumption', 'name' => 'Clique para ver o usuário e o número de vida'],
        ],

    // app事件类型
    'common_app_event_type' =>  [
            0 => ['value' => 0, 'name' => 'Página da Internet'],
            1 => ['value' => 1, 'name' => 'Página interna (mini programa/endereço interno do APP)'],
            2 => ['value' => 2, 'name' => 'Applet externo (o appid do applet sob o mesmo corpo principal)'],
            3 => ['value' => 3, 'name' => 'Ir para o mapa nativo para visualizar o local especificado'],
            4 => ['value' => 4, 'name' => 'discar número'],
        ],

    // 订单售后类型
    'common_order_aftersale_type_list' =>  [
            0 => ['value' => 0, 'name' => 'Apenas reembolso', 'desc' => 'As mercadorias não foram recebidas (não assinadas), sob a premissa de negociação e acordo', 'icon' => 'am-icon-random', 'class' => 'am-fl'],
            1 => ['value' => 1, 'name' => 'reembolso / devolução', 'desc' => 'Mercadorias recebidas, necessidade de devolver as mercadorias recebidas', 'icon' => 'am-icon-retweet', 'class' => 'am-fr'],
        ],

    // 订单售后状态
    'common_order_aftersale_status_list' =>  [
            0 => ['value' => 0, 'name' => 'a ser confirmado'],
            1 => ['value' => 1, 'name' => 'retorno pendente'],
            2 => ['value' => 2, 'name' => 'revisão pendente'],
            3 => ['value' => 3, 'name' => 'concluído'],
            4 => ['value' => 4, 'name' => 'rejeitado'],
            5 => ['value' => 5, 'name' => 'Cancelado'],
        ],

    // 订单售后退款方式
    'common_order_aftersale_refundment_list' =>  [
            0 => ['value' => 0, 'name' => 'Retroceder'],
            1 => ['value' => 1, 'name' => 'Voltar para a carteira'],
            2 => ['value' => 2, 'name' => 'Processamento manual'],
        ],

    // 商品评分
    'common_goods_comments_rating_list' =>  [
            0 => ['value'=>0, 'name'=>'Não avaliado', 'badge'=>''],
            1 => ['value'=>1, 'name'=>'1分', 'badge'=>'danger'],
            2 => ['value'=>2, 'name'=>'2分', 'badge'=>'warning'],
            3 => ['value'=>3, 'name'=>'3分', 'badge'=>'secondary'],
            4 => ['value'=>4, 'name'=>'4分', 'badge'=>'primary'],
            5 => ['value'=>5, 'name'=>'5分', 'badge'=>'success'],
        ],

    // 商品评论业务类型
    'common_goods_comments_business_type_list' =>  [
            'order' => ['value' => 'order', 'name' => 'Pedido'],
        ],

    // 站点类型
    'common_site_type_list' =>  [
            0 => ['value' => 0, 'name' => 'Vendas'],
            1 => ['value' => 1, 'name' => 'Exibir'],
            2 => ['value' => 2, 'name' => 'Escolher'],
            3 => ['value' => 3, 'name' => 'vendas virtuais'],
            4 => ['value' => 4, 'name' => 'venda + retirada', 'is_ext' => 1],
            5 => ['value' => 5, 'name' => 'Armazenar no armazem'],
        ],

    // 管理员状态
    'common_admin_status_list'               =>  [
            0 => ['value' => 0, 'name' => 'normal', 'checked' => true],
            1 => ['value' => 1, 'name' => 'pausa'],
            2 => ['value' => 2, 'name' => 'resignado'],
        ],

    // 支付日志状态
    'common_pay_log_status_list'            => [
            0 => ['value' => 0, 'name' => 'Ser pago', 'checked' => true],
            1 => ['value' => 1, 'name' => 'Pago'],
            2 => ['value' => 2, 'name' => 'fechado'],
        ],

    // 商品参数组件类型
    'common_goods_parameters_type_list'     => [
            0 => ['value' => 0, 'name' => 'tudo'],
            1 => ['value' => 1, 'name' => 'Detalhes', 'checked' => true],
            2 => ['value' => 2, 'name' => 'Base'],
        ],

    // 商品关联排序类型
    'goods_order_by_type_list'              => [
            0 => ['value' => 'g.access_count,g.sales_count,g.id', 'name' => 'compreensivo', 'checked' => true],
            1 => ['value' => 'g.sales_count', 'name' => 'vendas'],
            2 => ['value' => 'g.access_count', 'name' => 'grau de calor'],
            3 => ['value' => 'g.min_price', 'name' => 'preço'],
            4 => ['value' => 'g.id', 'name' => 'atualizado'],
        ],

    // 商品关联排序规则
    'goods_order_by_rule_list'           => [
            0 => ['value' => 'desc', 'name' => 'descendente(desc)', 'checked' => true],
            1 => ['value' => 'asc', 'name' => 'Ascendente(asc)'],
        ],

    // 首页数据类型
    'common_site_floor_data_type_list'           => [
            0 => ['value' => 0, 'name' => 'modo automático', 'checked' => true],
            1 => ['value' => 1, 'name' => 'modo manual'],
        ],

    // 色彩值
    'common_color_list'                 =>  [
            '',
            'am-badge-primary',
            'am-badge-secondary',
            'am-badge-success',
            'am-badge-warning',
            'am-badge-danger',
        ],

    // 文件上传错误码
    'common_file_upload_error_list'     =>  [
            1 => 'O tamanho do arquivo excede o máximo permitido upload pelo servidor',
            2 => 'O tamanho do arquivo excede o limite do navegador. Verifique se ele excede [configurações do site > limite máximo de apego]',
            3 => 'Os arquivos são apenas parcialmente carregados',
            4 => 'Nenhum arquivo encontrado para enviar',
            5 => 'Pasta temporária do servidor não encontrada',
            6 => 'Pasta temporária do servidor não encontrada',
            7 => 'falha na gravação do arquivo',
            8 => 'A extensão de upload de arquivo não está ativada',
        ],
    
    // 商品入库状态
    'common_warehouse_status_list' =>  [
            0 => ['value' => 0, 'name' => 'ser reconhecido'],
            1 => ['value' => 1, 'name' => 'Em estoque'],
            2 => ['value' => 2, 'name' => 'rejeitado'],
            3 => ['value' => 3, 'name' => 'armazenamento pendente'],
            4 => ['value' => 4, 'name' => 'admitido'],
        ],

    // 正则
    // 用户名
    'common_regex_username'             =>  '^[A-Za-z0-9_]{2,18}$',

    // 用户名
    'common_regex_pwd'                  =>  '^.{6,18}$',

    // 手机号码
    'common_regex_mobile'               =>  '^1((3|4|5|6|7|8|9){1}\d{1})\d{8}$',

    // 座机号码
    'common_regex_tel'                  =>  '^\d{3,4}-?\d{8}$',

    // 电子邮箱
    'common_regex_email'                =>  '^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$',

    // 身份证号码
    'common_regex_id_card'              =>  '^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$',

    // 价格格式
    'common_regex_price'                =>  '^([0-9]{1}\d{0,7})(\.\d{1,2})?$',

    // ip
    'common_regex_ip'                   =>  '^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$',

    // url
    'common_regex_url'                  =>  '^http[s]?:\/\/[A-Za-z0-9-]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$',

    // 控制器名称
    'common_regex_control'              =>  '^[A-Za-z]{1}[A-Za-z0-9_]{0,29}$',

    // 方法名称
    'common_regex_action'               =>  '^[A-Za-z]{1}[A-Za-z0-9_]{0,29}$',

    // 顺序
    'common_regex_sort'                 =>  '^[0-9]{1,3}$',

    // 日期
    'common_regex_date'                 =>  '^\d{4}-\d{2}-\d{2}$',

    // 分数
    'common_regex_score'                =>  '^[0-9]{1,3}$',

    // 分页
    'common_regex_page_number'          =>  '^[1-9]{1}[0-9]{0,2}$',

    // 时段格式 10:00-10:45
    'common_regex_interval'             =>  '^\d{2}\:\d{2}\-\d{2}\:\d{2}$',

    // 颜色
    'common_regex_color'                =>  '^(#([a-fA-F0-9]{6}|[a-fA-F0-9]{3}))?$',

    // id逗号隔开
    'common_regex_id_comma_split'       =>  '^\d(\d|,?)*\d$',

    // url伪静态后缀
    'common_regex_url_html_suffix'      =>  '^[a-z]{0,8}$',

    // 图片比例值
    'common_regex_image_proportion'     =>  '^([1-9]{1}[0-9]?|[1-9]{1}[0-9]?\.{1}[0-9]{1,2}|100|0)?$',

    // 版本号
    'common_regex_version'              => '^[0-9]{1,6}\.[0-9]{1,6}\.[0-9]{1,6}$',

    'common_handle_text1'               => 'Por favor, insira',
    'common_handle_text2'               => 'por favor escolha',
    'common_handle_text3'               => 'minimo',
    'common_handle_text4'               => 'valor maximo',
    'common_handle_text5'               => 'Comecar',
    'common_handle_text6'               => 'Terminar',

    'common_confirm_title'              => 'Lembrete quente',
    'common_confirm_msg'                => 'Nao pode ser restaurado apos o cancelamento, tem certeza de continuar?',
    'common_confirm_sure'               => 'Certo',
    'common_confirm_cancel'             => 'Cancelar',
    ];
?>
