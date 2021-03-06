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
            0 => ['value' => 'bgcolor', 'name' => 'fundo colorido'],
            1 => ['value' => 'textcolor', 'name' => 'texto colorido'],
            2 => ['value' => 'point', 'name' => 'ponto de interferência'],
            3 => ['value' => 'line', 'name' => 'linha de interferência'],
        ],

    // 时区
    'site_timezone_list' => [
        'Pacific/Pago_Pago' => '(horário padrão-11:00) Midway, Samoa',
        'Pacific/Rarotonga' => '(horário padrão-10:00) Havaí',
        'Pacific/Gambier' => '(horário padrão-9:00) Alasca',
        'America/Dawson' => '(horário padrão-8:00) Horário do Pacífico (EUA e Canadá)',
        'America/Creston' => '(horário padrão-7:00) Hora da montanha (EUA e Canadá)',
        'America/Belize' => '(horário padrão-6:00) Hora Central (EUA e Canadá), Cidade do México',
        'America/Eirunepe' => '(horário padrão-5:00) Hora do Leste (EUA e Canadá), Bogotá',
        'America/Antigua' => '(horário padrão-4:00) Horário do Atlântico (Canadá), Caracas',
        'America/Argentina/Buenos_Aires' => '(horário padrão-3:00) Brasil, Buenos Aires, Georgetown',
        'America/Noronha' => '(horário padrão-2:00) meio-atlântico',
        'Atlantic/Cape_Verde' => '(horário padrão-1:00) Açores, Ilhas de Cabo Verde',
        'Africa/Ouagadougou' => '(格林尼治horário padrão) Horário da Europa Ocidental, Londres, Casablanca',
        'Europe/Andorra' => '(horário padrão+1:00) Horário da Europa Central, Angola, Líbia',
        'Europe/Mariehamn' => '(horário padrão+2:00) Horário da Europa Oriental, Cairo, Atenas',
        'Asia/Bahrain' => '(horário padrão+3:00) Bagdá, Kuwait, Moscou',
        'Asia/Dubai' => '(horário padrão+4:00) Abu Dhabi, Mascate, Baku',
        'Asia/Kolkata' => '(horário padrão+5:00) Ecaterimburgo, Islamabad, Carachi',
        'Asia/Dhaka' => '(horário padrão+6:00) Almaty, Daca, Nova Aberia',
        'Indian/Christmas' => '(horário padrão+7:00) Bangkok, Hanói, Jacarta',
        'Asia/Shanghai' => '(horário padrão+8:00)Pequim, Chongqing, Hong Kong, Singapura',
        'Australia/Darwin' => '(horário padrão+9:00) Tóquio, Seul, Osaka, Yakutsk',
        'Australia/Adelaide' => '(horário padrão+10:00) Sydney, Guam',
        'Australia/Currie' => '(horário padrão+11:00) Magadan, Ilhas Salomão',
        'Pacific/Fiji' => '(horário padrão+12:00) Auckland, Wellington, Kamchatka'
    ],

    'second_nav_list' => [
	    [
			'name'	=> 'Configuração básica',
			'type'	=> 'base',
		],
		[
			'name'	=> 'Configurações do site',
			'type'	=> 'siteset',
		],
		[
			'name'	=> 'tipo de site',
			'type'	=> 'sitetype',
		],
		[
			'name'	=> 'Registro do usuário',
			'type'	=> 'register',
		],
		[
			'name'	=> 'Login de usuário',
			'type'	=> 'login',
		],
		[
			'name'	=> 'recuperar senha',
			'type'	=> 'forgetpwd',
		],
		[
			'name'	=> 'Código de verificação',
			'type'	=> 'verify',
		],
		[
			'name'	=> 'pedido pós-venda',
			'type'	=> 'orderaftersale',
		],
		[
			'name'	=> 'Apêndice',
			'type'	=> 'attachment',
		],
		[
			'name'	=> 'esconderijo',
			'type'	=> 'cache',
		],
		[
			'name'	=> 'extensão',
			'type'	=> 'extends',
		],	
	],
	
	'siteset_nav_list'  =>  [
	    [
			'name'	=> 'primeira página',
			'type'	=> 'index',
		],
		[
			'name'	=> 'mercadoria',
			'type'	=> 'goods',
		],
		[
			'name'	=> 'procurar',
			'type'	=> 'search',
		],
		[
			'name'	=> 'Pedido',
			'type'	=> 'order',
		],
		[
			'name'	=> 'desconto',
			'type'	=> 'discount',
		],
		[
			'name'	=> 'expandir',
			'type'	=> 'extends',
		],
	],
	
	'site_lang_list'   => [
	    '1' => '&lang=zh-cn',
		'2' => '&lang=pt-br',
	],
	
	'site_nav_login_text'    => "Você pode fazer upload de até 3 fotos na imagem à esquerda, e uma delas será exibida aleatoriamente a cada vez",
	'site_nav_register_text' => "Imagem de fundo personalizável, cinza inferior padrão",
	'site_base_index_text1'  => "escolha o logotipo",
	'site_base_index_text2'  => "status do site",
	'site_base_index_text3'  => "Registrar informação",
	'site_base_index_text4'  => "de outros",
	
	'site_siteset_index_text1' => "Base",
	'site_siteset_index_text2' => "Não há dados, por favor vá para a classificação de mercadorias / gestão de mercadorias > e classificação primária que define a página inicial para recomendação",
	'site_siteset_index_text3' => "modo automático",
	'site_siteset_index_text4' => "Configure o número máximo de produtos exibidos em cada andar",
	'site_siteset_index_text5' => "Não é recomendado modificar muito o número, isso fará com que a área em branco esquerda no lado do PC seja muito grande",
	'site_siteset_index_text6' => "A síntese é: Popularidade->Vendas->Última classificação em ordem decrescente (desc)",
	'site_siteset_index_text7' => "modo manual",
	'site_siteset_index_text8' => "Você pode clicar e arrastar o título do produto para classificar e exibir em ordem",
	'site_siteset_index_text9' => "Não é recomendado adicionar muitos produtos, isso fará com que a área em branco esquerda no lado do PC seja muito grande",
	'site_siteset_index_text10' => "adição do produto",
	'site_siteset_index_text11' => "Classificação das mercadorias",
	'site_siteset_index_text12' => "Nível 1",
	'site_siteset_index_text13' => "Nível 2",
	'site_siteset_index_text14' => "Nível 3",
	'site_siteset_index_text15' => "Nome do Produto",
	'site_siteset_index_text16' => "procurar",
	'site_siteset_index_text17' => "Por favor, procure por produtos",
	
	
	'site_siteset_goods_text1' => "Nível",
	'site_siteset_goods_text2' => "O nível de exibição padrão 3, o nível mínimo 1, o nível máximo 3",
	'site_siteset_goods_text3' => "O nível é diferente e o estilo da página de classificação do front-end também será diferente",
	'site_siteset_goods_text4' => "preservação",
	
	'site_siteset_extends_text1' => "Configuração básica",
	'site_siteset_extends_text2' => "navegação rápida",
	'site_siteset_extends_text3' => "Endereço do usuário",
	
    'site_sitetype_text1' => "Tipo de venda, processo regular de e-commerce, o usuário seleciona o endereço de entrega para fazer um pedido e pagar -> o comerciante envia a mercadoria -> confirma o recebimento -> o pedido é concluído",
    'site_sitetype_text2' => "Tipo de exibição, apenas exibir produtos, pode iniciar consulta (não pode fazer pedidos)",
    'site_sitetype_text3' => "ponto de retirada automática, selecione o endereço de retirada automática ao fazer um pedido, o usuário faz um pedido para pagar -> confirmar a retirada -> o pedido está concluído",
    'site_sitetype_text4' => "Vendas virtuais, processo regular de e-commerce, pagamento do pedido do usuário -> entrega automática -> confirmar entrega -> pedido concluído",
    'site_sitetype_text5' => "Loja no armazém, armazene o produto selecionado no armazém, o proprietário do produto é o usuário operacional atual",
    'site_sitetype_text6' => "Tipo de exibição",
    'site_sitetype_text7' => "Ponto de auto-relato",
    'site_sitetype_text8' => "Remover",
    'site_sitetype_text9' => "Editar",
    'site_sitetype_text10' => "Adicionar endereço",
    'site_sitetype_text11' => "Venda Virtual",
    'site_sitetype_text12' => "Adicionar Endereço",
    'site_sitetype_text13' => "imagem do logotipo",
    'site_sitetype_text14' => "Biografia Selecionada",
    'site_sitetype_text15' => "Recomendado 300x300px",
    'site_sitetype_text16' => "Carregar imagem",
    'site_sitetype_text17' => "Alias",
    'site_sitetype_text18' => "Opcional",
    'site_sitetype_text19' => "Obrigatório",
    'site_sitetype_text20' => "Contato",
    'site_sitetype_text21' => "Número de contato",
    'site_sitetype_text22' => "Endereço detalhado",
    'site_sitetype_text23' => "Localização",
    'site_sitetype_text24' => "Formato de alias até 16 caracteres",
    'site_sitetype_text25' => "Formato de contato entre 2~16 caracteres",
    'site_sitetype_text26' => "O formato do telefone de contato está incorreto",
    'site_sitetype_text27' => "O formato de endereço detalhado tem entre 1 e 80 caracteres",
    'site_sitetype_text28' => "Confirmar",
    	
    'site_register_text' => "Selecionar imagem",
    'site_login_text' => 'imagem',
    'site_login_text1' => 'cor de fundo',
	
    'site_orderaftersale_text' => 'dias',
    'site_attachment_text1' => 'Não, por padrão, é recomendado habilitar o upload de imagens para redesenhar, evitando o upload de imagens do vírus cavalo de Tróia',
    'site_attachment_text2' => 'Após a abertura, a imagem dinâmica do gif será inválida, e o tamanho da imagem também será alterado devido ao redesenho',	
    
    'site_cache_text1' => 'O cache de arquivo padrão, usando o Redis para armazenar o PHP em cache, precisa instalar a extensão Redis primeiro',
    'site_cache_text2' => 'Por favor, assegure a estabilidade do serviço Redis (após a sessão usar o cache, o serviço pode ficar instável e o segundo plano pode não conseguir fazer login)',
    'site_cache_text3' => 'Se você encontrar uma exceção no serviço Redis, não poderá fazer login no plano de fundo de gerenciamento e modificar o arquivo de configuração',
    'site_cache_text4' => 'sob o diretório',
    'site_cache_text5' => 'arquivo',
    'site_cache_text6' => 'Configuração do cache da sessão',
    'site_cache_text7' => 'Configuração de cache de dados',
    'site_cache_text8' => 'segundos',
    	
    'site_extends_text1' => 'Configuração de script temporizado',
    'site_extends_text2' => 'Recomenda-se adicionar o endereço do script à solicitação de tempo da tarefa de temporização do linux (resultado sucs:0, fail:0 O número de dados processados ​​após os dois pontos, sucesso sucesso, falha falha)',
    'site_extends_text3' => 'minutos',
    'site_extends_text4' => 'configuração de CDN',
    'site_extends_text5' => 'Se não definido, use o nome de domínio do site atual',
    	
    'sms_nav_text1' => 'Configurações de SMS',
    'sms_nav_text2' => 'modelo de mensagem',
    'sms_nav_text3' => 'Endereço de gerenciamento de SMS na nuvem do Alibaba',
    'sms_nav_text4' => 'Clique para ir ao Alibaba Cloud para comprar SMS',
    'sms_message_text1' => 'fundo',
    'sms_message_text2' => 'front end',
    	
    'email_nav_text1' => 'Configurações de e-mail',
    'email_nav_text2' => 'modelo de mensagem',
    'email_nav_text3' => 'Consulte o tutorial de configuração de caixa de correio relevante',
    'email_nav_text4' => 'Clique para ver o tutorial',
    'email_index_text1' => 'Testar o endereço de e-mail recebido',
    'email_index_text2' => 'Por favor, salve a configuração antes de testar',
    'email_index_text3' => 'Testar o endereço de e-mail recebido',
    'email_index_text4' => 'Teste',
    	
    'seo_index_text1' => 'consulte o tutorial de configuração pseudo-estática',
    'seo_index_text2' => 'Clique para ver o tutorial',
    	
    'agreement_nav_text' => 'Adicione o parâmetro is_content=1 ao endereço do protocolo de acesso front-end para exibir apenas o conteúdo do protocolo puro',
    'agreement_register_text' => 'Ver detalhes',
	
	'form_operate_text1' => 'deletar',
	'form_operate_text2' => 'Reiniciar',
	'form_operate_text3' => 'pesquisa',
	'form_operate_text4' => 'configurado',
	'form_operate_text5' => 'detalhes',
	'form_operate_text6' => 'editar',
	'form_operate_text7' => 'deletar',
	'form_operate_text8' => 'verificar',
    'form_operate_text9' => 'armazenamento',
	'form_operate_text10' => 'estoque',
    'form_operate_text11' => 'copia de',
	
	'admin_index_text1' => 'recém adicionado',
    'admin_index_text2' => 'Super administradores têm todas as permissões por padrão e não podem ser alteradas. ',
    	
    'admin_save_text' => 'Administrador',
    'admin_save_text1' => 'Adicionar',
    'admin_save_text2' => 'editar',
    'admin_save_text3' => 'retornar',
    'admin_save_text4' => 'nome de usuário',
    'admin_save_text5' => 'senha de login',
    'admin_save_text6' => 'número do celular',
    'admin_save_text7' => 'e-mail',
    'admin_save_text8' => 'grupo de autoridade',
    'admin_save_text9' => 'status',
    'admin_save_text10' => 'área responsável',
    'admin_save_text11' => 'opcional',
    'admin_save_text12' => 'Obrigatório',
    'admin_save_text13' => 'obrigatório',
    'admin_save_text14' => 'Não pode ser alterado',
    'admin_save_text15' => 'Formato do nome de usuário 5~18 caracteres (pode ser sublinhado alfanumérico)',
    'admin_save_text16' => 'formato de senha 6~18 caracteres',
    'admin_save_text17' => 'Erro no formato do número do celular',
    'admin_save_text18' => 'Erro no formato do e-mail, máximo de 60 caracteres',
    'admin_save_text19' => 'opcional',
    'admin_save_text20' => 'Gênero sexual',
    
    	
    'admin_user_text' => 'Exportar Excel',
    'admin_user_text1' => 'Sem avatar',
    	
    'admin_useraddr_text' => 'padrão',
    'admin_useraddr_text1' => 'Não',

	'admin_useraddr_text2' => 'longitude',
	'admin_useraddr_text3' => 'latitude',
	'admin_useraddr_text4' => 'Ver local',
	
	'user_save_text1' => 'usuário',
    'user_save_text2' => 'Adicionar',
    'user_save_text3' => 'Editar',
    'user_save_text4' => 'retornar',
    'user_save_text5' => 'nome de usuário',
    'user_save_text6' => 'Nome de usuário 2~30 caracteres',
    'user_save_text7' => 'apelido',
    'user_save_text8' => 'apelido de até 16 caracteres',
    'user_save_text9' => 'WeChat',
    'user_save_text10' => 'número do celular',
    'user_save_text11' => 'e-mail',
    'user_save_text12' => 'erro de formato de e-mail',
    'user_save_text13' => 'Alipay openid',
    'user_save_text14' => 'Por favor, preencha Alipay openid',
    'user_save_text15' => 'Baidu openid',
    'user_save_text16' => 'Por favor, preencha Baidu openid',
    'user_save_text17' => 'headline openid',
    'user_save_text18' => 'Por favor, preencha o título openid',
    'user_save_text19' => 'QQopenid',
    'user_save_text20' => 'Por favor, preencha QQopenid',
    'user_save_text21' => 'QQunionid',
    'user_save_text22' => 'Por favor, preencha QQunionid',
    'user_save_text23' => 'WeChat openid',
    'user_save_text24' => 'WeChat unionid',
    'user_save_text25' => 'Por favor, preencha WeChat unionid',
    'user_save_text26' => 'WeChat webopenid',
    'user_save_text27' => 'Por favor, preencha WeChat webopenid',
    'user_save_text28' => 'aniversário',
    'user_save_text29' => 'formato de aniversário está errado',
    'user_save_text30' => 'endereço detalhado',
    'user_save_text31' => 'endereço detalhado 2~60 caracteres',
    'user_save_text32' => 'pontos',
    'user_save_text33' => 'Taxa de exportação (o valor padrão da plataforma é usado quando não preenchido)',
    'user_save_text34' => 'taxa de saída',
    'user_save_text35' => 'preencha o formato correto',
    'user_save_text36' => 'taxa de manuseio (o valor padrão da plataforma é usado quando não preenchido)',
    'user_save_text37' => 'taxa de manuseio',
    'user_save_text38' => 'convidar ID de usuário',
    'user_save_text39' => 'Por favor, digite o ID do usuário do convite',
    'user_save_text40' => 'senha de login',
    'user_save_text41' => 'Formato da senha de login entre 6~18 caracteres',
    'user_save_text42' => 'armazém no exterior',
	'user_save_text43' =>'status do usuário','order_operate_text1' => 'detalhes',

    'order_operate_text2' => 'confirmar',
    'order_operate_text3' => 'Cancelar',
    'order_operate_text4' => 'pagamento',
    'order_operate_text5' => 'Pegar',
    'order_operate_text6' => 'envio',
    'order_operate_text7' => 'Recibo',
    'order_operate_text8' => 'excluir',
	'order_operate_text9' => 'Se operar o recibo, não pode ser recuperado após a operação',
    'order_operate_text10' => 'Não pode ser restaurado após a exclusão, tem certeza de continuar',
	'order_operate_text11' => 'Se operar o recibo, não pode ser restaurado após a operação',
    'order_operate_text12' => 'Não pode ser restaurado após o cancelamento, tem certeza de continuar',
	'order_operate_text13' => 'Lembrete quente',
	'order_operate_text14' => 'Cancelar',
    'order_operate_text15' => 'OK',
	
	'order_index_text1' => 'Pegar código',
    'order_index_text2' => 'Confirmar',
    'order_index_text3' => 'operação de envio',
    'order_index_text4' => 'Expresso número de rastreamento',
    'order_index_text5' => 'operação de pagamento',
	
	'order_detail_text1' => 'pedido item',
    'order_detail_text2' => 'endereço de entrega',
    'order_detail_text3' => 'destinatário',
    'order_detail_text4' => 'Recibo de telefone',
    'order_detail_text5' => 'endereço detalhado',
    'order_detail_text6' => 'Informações do cartão de identificação',
    'order_detail_text7' => 'nome',
    'order_detail_text8' => 'número',
    'order_detail_text9' => 'foto',
    'order_detail_text10' => 'Ver posição',
    'order_detail_text11' => 'Informações de coleta',
    'order_detail_text12' => 'informações de contato',
    'order_detail_text13' => 'informações chave',
    'order_detail_text14' => 'Dados não configurados',
    'order_detail_text15' => 'nenhum',
	
	'inbound_detail_text1' => 'Informações de entrada',
    'inbound_detail_text2' => 'parâmetros de empacotamento externo',
    'inbound_detail_text3' => 'longo',
    'inbound_detail_text4' => 'largura',
    'inbound_detail_text5' => 'alto',
    'inbound_detail_text6' => 'peso',
    'inbound_detail_text7' => 'Informações da mercadoria',
    'inbound_detail_text8' => 'nome comercial',
    'inbound_detail_text9' => 'especificação',
    'inbound_detail_text10' => 'Código SKU',
    'inbound_detail_text11' => 'Quantidade de entrada',
    'inbound_detail_text12' => 'verificar informações',
    'inbound_detail_text13' => 'status',
    'inbound_detail_text14' => 'Expresso',
    'inbound_detail_text15' => 'verificar resultado',
	'inbound_detail_text16' => 'Informações de armazenamento de mercadorias',
    'inbound_detail_text17' => 'dependendo do número de armazéns',
    'inbound_detail_text18' => 'quantidade de entrada real',
	
	'warehousegoods_index_text1' => 'Adicionar',
    'warehousegoods_index_text2' => 'bens adicionados',
    'warehousegoods_index_text3' => 'armazém',
    'warehousegoods_index_text4' => 'classificação de mercadorias',
    'warehousegoods_index_text5' => 'Nível 1',
    'warehousegoods_index_text6' => 'secundário',
    'warehousegoods_index_text7' => 'três níveis',
    'warehousegoods_index_text8' => 'nome da mercadoria',
    'warehousegoods_index_text9' => 'Por favor, procure mercadorias',
	
	'warehousegoods_detail_text1' => 'inventário de especificações',
    'warehousegoods_detail_text2' => 'especificação',
    'warehousegoods_detail_text3' => 'estoque',
    'warehousegoods_detail_text4' => 'nenhum',
	
	'warehousegoods_inventory_text1' => 'especificação',
    'warehousegoods_inventory_text2' => 'inventário',
    'warehousegoods_inventory_text3' => 'Confirmar',
    'warehousegoods_inventory_text4' => 'Sem dados de especificação',
    'warehousegoods_inventory_text5' => 'Valor definido do lote',

	'goods_info_text1' => 'marca',
    'goods_info_text2' => 'bens',
    'goods_info_text3' => 'Adicionar',
    'goods_info_text4' => 'Editar',
    'goods_info_text5' => 'retornar',
    'goods_info_text6' => 'informações básicas',
    'goods_info_text7' => 'especificações de mercadorias',
    'goods_info_text8' => 'parâmetros de mercadorias',
    'goods_info_text9' => 'álbum de mercadorias',
    'goods_info_text10' => 'vídeo de mercadorias',
    'goods_info_text11' => 'Detalhes do celular',
    'goods_info_text12' => 'detalhes do computador',
    'goods_info_text13' => 'informações virtuais',
    'goods_info_text14' => 'dados estendidos',
    'goods_info_text15' => 'nome do título',
    'goods_info_text16' => 'obrigatório',
    'goods_info_text17' => 'breve descrição da mercadoria',
    'goods_info_text18' => 'opcional',
    'goods_info_text19' => 'Formato de descrição da mercadoria até 230 caracteres',
    'goods_info_text20' => 'Formato do nome do título 2~160 caracteres',
    'goods_info_text21' => 'modelo de mercadorias',
    'goods_info_text22' => 'formato de modelo de mercadoria até 30 caracteres',
    'goods_info_text23' => 'classificação de mercadorias',
    'goods_info_text24' => 'selecione pelo menos um',
    'goods_info_text25' => 'Por favor, escolha',
    'goods_info_text26' => 'Por favor, selecione pelo menos uma categoria de produto',
    'goods_info_text27' => 'Nível 1',
    'goods_info_text28' => 'Secundário',
    'goods_info_text29' => 'Nível 3',
    'goods_info_text30' => 'opcional',
    'goods_info_text31' => 'Por favor, selecione uma marca',
    'goods_info_text32' => 'local de produção',
    'goods_info_text33' => 'Por favor, selecione o local de produção',
    'goods_info_text34' => 'unidade de manutenção de estoque',
    'goods_info_text35' => 'Formato da unidade de estoque 1~6 caracteres',
    'goods_info_text36' => 'Proporção de pontos de bônus de compra',
    'goods_info_text37' => 'Compre a proporção do número de pontos de bônus 0~100',
    'goods_info_text38' => 'emitido de acordo com a proporção da quantidade de mercadorias multiplicada pela quantidade',
    'goods_info_text39' => 'Quantidade mínima de compra',
    'goods_info_text40' => 'valor padrão 1',
    'goods_info_text41' => 'Quantidade máxima única de compra',
    'goods_info_text42' => 'Valor máximo único 100000000, sem limite se menor ou igual a 0 ou vazio',
    'goods_info_text43' => 'tipo de mercadoria',
    'goods_info_text44' => 'O tipo de site da configuração atual do sistema é',
    'goods_info_text45' => 'Se o tipo de mercadoria não estiver configurado, siga o tipo de site configurado pelo sistema',
    'goods_info_text46' => 'Quando o tipo de produto definido não estiver incluído no tipo de site definido pelo sistema, a função de adicionar o produto ao carrinho de compras será inválida',
    'goods_info_text47' => 'Por favor, selecione o tipo de mercadoria',
    'goods_info_text48' => 'Imagem de capa',
    'goods_info_text49' => 'Biografia Selecionada',
    'goods_info_text50' => 'Se você deixar em branco, tire a primeira foto do álbum, sugira 800*800px',
    'goods_info_text51' => 'Enviar fotos',
    'goods_info_text52' => 'Deduzir inventário',
    'goods_info_text53' => 'As regras de dedução são determinadas de acordo com a configuração em segundo plano -> regras de dedução de estoque',
    'goods_info_text54' => 'Não',
    'goods_info_text55' => 'Sim',
    'goods_info_text56' => 'Para cima e para baixo na prateleira',
    'goods_info_text57' => 'Os usuários não serão visíveis após a retirada da prateleira',
    'goods_info_text58' => 'fora da prateleira',
    'goods_info_text59' => 'na prateleira',
    'goods_info_text60' => 'parâmetros externos de mercadorias',
    'goods_info_text61' => 'longo',
    'goods_info_text62' => 'largura',
    'goods_info_text63' => 'alto',
    'goods_info_text64' => 'peso',
    'goods_info_text65' => 'Por favor, preencha o comprimento',
    'goods_info_text66' => 'Por favor, preencha a largura',
    'goods_info_text67' => 'Por favor, preencha a altura',
    'goods_info_text68' => 'Por favor, preencha o peso',
    'goods_info_text69' => 'Expressar escolha',
    'goods_info_text70' => 'Por favor, selecione o preço',
    'goods_info_text71' => 'taxa de entrega',
    'goods_info_text72' => 'Operação de atalho',
    'goods_info_text73' => 'Por favor, selecione um modelo',
    'goods_info_text74' => 'Colar informações de configuração de parâmetro de mercadoria',
    'goods_info_text75' => 'confirmar',
    'goods_info_text76' => 'Copiar configuração',
    'goods_info_text77' => 'limpar parâmetros',
    'goods_info_text78' => 'álbum de mercadorias',
    'goods_info_text79' => 'Você pode arrastar e soltar fotos para classificar, é recomendado que o tamanho da imagem seja igual a 800*800px, até 30 fotos',
    'goods_info_text80' => 'deve passar',
    'goods_info_text81' => 'carregar album',
    'goods_info_text82' => 'Após definir os detalhes do celular, os detalhes do celular serão exibidos no modo de celular, como [mini programa, APP]',
    'goods_info_text83' => 'Biografia Selecionada',
    'goods_info_text84' => 'Vídeo é mais imersivo do que gráfico e texto, suporta apenas o formato mp4',
    'goods_info_text85' => 'Enviar vídeo',
    'goods_info_text86' => 'imagem',
    'goods_info_text87' => 'conteúdo de texto',
    'goods_info_text88' => 'excluir',
    'goods_info_text89' => 'Ordenar por arrastar e soltar',
    'goods_info_text90' => 'Conteúdo de texto de até 105.000 caracteres',
    'goods_info_text91' => 'Adicionar detalhes do celular',
    'goods_info_text92' => 'Esta área são os dados da extensão do plug-in, por favor preencha o valor correspondente de acordo com o documento do plug-in',
	
	'admin_form_fields_text1' => 'Clique e arraste para ajustar a ordem de exibição, se precisar restaurar, clique para redefinir',
    'admin_form_fields_text2' => 'selecionar tudo',
    'admin_form_fields_text3' => 'Seleção inversa',
    'admin_form_fields_text4' => 'Redefinir',
    'admin_form_fields_text5' => 'Confirmar',
    'admin_form_fields_text6' => 'Processando',

	'admin_nodata_text' => 'Nenhum dado relevante',
    // seo
    // url模式列表
    'seo_url_model_list'        =>  [
            0 => ['value' => 0, 'name' => 'Modo de compatibilidade', 'checked' => true],
            1 => ['value' => 1, 'name' => 'Modo PATHINFO'],
            2 => ['value' => 2, 'name' => 'Modo PATHINFO + endereço curto'],
        ],

    // 用户excel导出标题列表
    'excel_user_title_list'     =>  [
            'username'      =>  [
                    'name' => 'nome do usuário',
                    'type' => 'string',
                ],
            'nickname'      =>  [
                    'name' => 'Apelido',
                    'type' => 'int',
                ],
            'gender_text'   =>  [
                    'name' => 'Gênero sexual',
                    'type' => 'string',
                ],
            'birthday_text'=>   [
                    'name' => 'Aniversário',
                    'type' => 'string',
                ],
            'status_text'=>   [
                    'name' => 'Estado',
                    'type' => 'string',
                ],
            'mobile'        =>  [
                    'name' => 'número de celular',
                    'type' => 'int',
                ],
            'email'         =>  [
                    'name' => 'E-mail',
                    'type' => 'string',
                ],
            'province'      =>  [
                    'name' => 'Província',
                    'type' => 'string',
                ],
            'city'      =>  [
                    'name' => 'cidade',
                    'type' => 'string',
                ],
            'address'       =>  [
                    'name' => 'Endereço',
                    'type' => 'string',
                ],
            'add_time'      =>  [
                    'name' => 'Horário de registro',
                    'type' => 'string',
                ],
        ],
];
?>
