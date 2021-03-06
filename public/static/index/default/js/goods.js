// 规格弹窗PC显示
function PoptitPcShow()
{
    $(document.body).css('position', 'static');
    $('.theme-signin-left').scrollTop(0);
    $('.theme-popover-mask').hide();
    $('.theme-popover').slideDown(0);
}
// 规格弹窗关闭
function PoptitClose()
{
    if($(window).width() < 1025)
    {
        $(document.body).css('position', 'static');
        $('.theme-signin-left').scrollTop(0);
        $('.theme-popover-mask').hide();
        $('.theme-popover').slideUp(100);
    }
}

/**
 * 评论记录ajax请求
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  1.0.0
 * @datetime 2019-05-13T21:39:55+0800
 * @param    {[int]}                 page [分页值]
 */
function GoodsCommentsHtml(page)
{
    if((page || 1) <= 1)
    {
        $('.goods-page-no-data').removeClass('none');
        $('.goods-page-no-data span').text('加载中...');
    } else {
        $('.goods-page-no-data').addClass('none');
    }

    $.ajax({
        url: $('.goods-comment').data('url'),
        type: 'POST',
        data: {"goods_id": $('.goods-comment').data('goods-id'), "page": page || 1},
        dataType: 'json',
        success: function(result)
        {
            $('.goods-page-no-data').addClass('none');
            if(result.code == 0)
            {
                $('.goods-comment-content').html(result.data.data);
                $('.goods-page-container').html(PageLibrary(result.data.total, result.data.number, page, 2));
            }

            // 没有数据
            if($('.goods-comment-content article').length <= 0)
            {
                $('.goods-page-no-data').removeClass('none');
                $('.goods-page-no-data span').text('没有评论数据');
            }
        },
        error: function(xhr, type)
        {
            $('.goods-page-no-data').removeClass('none');
            $('.goods-page-no-data span').text(xhr.responseText || '请求出现错误，请稍后再试！');
        }
    });
}

/**
 * 购买/加入购物车校验
 * @author   Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2018-09-13
 * @desc    description
 * @param   {[object]}        e [当前标签对象]
 */
function BuyCartCheck(e)
{
    // 参数
    var stock = parseInt($('#text_box').val()) || 1;
    var inventory = parseInt($('.stock-tips .stock').text());
    var min = $('.stock-tips .stock').data('min-limit') || 1;
    var max = $('.stock-tips .stock').data('max-limit') || 0;
    var unit = $('.stock-tips .stock').data('unit') || '';
	var integral = $('#integral').val();
	var price = parseInt($('.goods-price').text());
	var total_price = price*stock;
	if(integral < 	total_price){
		Prompt('现有积分 '+integral+'，不足以支付本次订单，请充值！');
        return false;
	}
    if(stock < min)
    {
        Prompt('最低起购数量'+min+unit);
        return false;
    }
    if(max > 0 && stock > max)
    {
        Prompt('最大限购数量'+max+unit);
        return false;
    }
    if(stock > inventory)
    {
        Prompt('库存数量'+inventory+unit);
        return false;
    }
    

    // 规格
    var spec = [];
    var sku_count = $('.sku-items').length;
    if(sku_count > 0)
    {
        var spec_count = $('.sku-line.selected').length;
        if(spec_count < sku_count)
        {
            $('.sku-items').each(function(k, v)
            {
                if($(this).find('.sku-line.selected').length == 0)
                {
                    $(this).addClass('sku-not-active');
                }
            });
            Prompt('请选择规格');
            return false;
        } else {
            $('.iteminfo_parameter .sku-items').removeClass('sku-not-active');
            $('.theme-signin-left .sku-items li.selected').each(function(k, v)
            {
                spec.push({"type": $(this).data('type-value'), "value": $(this).data('value')})
            });
        }
    }
    var spec_json = JSON.stringify(spec);
    return {
        "stock": stock,
        "spec": spec_json,
        "type": e.attr('data-type')
    };
}

/**
 * 购买/加入购物车处理
 * @author   Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2018-09-13
 * @desc    description
 * @param   {[object]}        e [当前标签对象]
 */
function BuyCartHandle(e)
{
    // 参数
    var params = BuyCartCheck(e);
    if(params === false)
    {
        return false;
    }

    // 操作类型
    switch(params.type)
    {
        // 立即购买
        case 'buy' :
            var $form = $('form.buy-form');
            $form.find('input[name="spec"]').val(JSON.stringify(params.spec));
            $form.find('input[name="stock"]').val(params.stock);
            $form.find('button[type="submit"]').trigger('click');
            break;

        // 加入购物车
        case 'cart' :
            var $form = $('form.cart-form');
            $form.find('input[name="spec"]').val(JSON.stringify(params.spec));
            $form.find('input[name="stock"]').val(params.stock);
            $form.find('button[type="submit"]').trigger('click');
            break;

        // 默认
        default :
            Prompt('操作参数配置有误');
    }
    return true;
}

/**
 * 获取规格详情
 * @author   Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2018-12-14
 * @desc    description
 */
function GoodsSpecDetail()
{
    // 是否全部选中
    var sku_count = $('.theme-signin-left .sku-items').length;
    var active_count = $('.theme-signin-left .sku-items li.selected').length;
    if(active_count < sku_count)
    {
        return false;
    }

    // 获取规格值
    var spec = [];
    $('.theme-signin-left .sku-items li.selected').each(function(k, v)
    {
        spec.push({"type": $(this).data('type-value'), "value": $(this).data('value')})
    });

    // 开启进度条
    $.AMUI.progress.start();

    // ajax请求
    $.ajax({
        url: $('.goods-detail').data('spec-detail-ajax-url'),
        type: 'post',
        dataType: "json",
        timeout: 10000,
        data: {"id": $('.goods-detail').data('id'), "spec": spec},
        success: function(result)
        {
            $.AMUI.progress.done();
            if(result.code == 0)
            {
                var inventory_public = result.data.spec_base.inventory - result.data.spec_base.inventory_private;
                $('.text-info .price-now').text(__currency_symbol__+result.data.spec_base.price);
                $('.goods-price').text(result.data.spec_base.price);
                $('.number-tag input[type="number"]').attr('max', inventory_public);
                $('.stock-tips .stock').text(inventory_public);
                if(result.data.spec_base.original_price > 0)
                {
                    $('.goods-original-price').text(__currency_symbol__+result.data.spec_base.original_price);
                    $('.goods-original-price').parents('.items').show();
                } else {
                    $('.goods-original-price').parents('.items').hide();
                }

                // 扩展数据处理
                var extends_element = result.data.extends_element || [];
                if(extends_element.length > 0)
                {
                    for(var i in extends_element)
                    {
                        if((extends_element[i]['element'] || null) != null && extends_element[i]['content'] !== null)
                        {
                            $(extends_element[i]['element']).html(extends_element[i]['content']);
                        }
                    }
                }
            } else {
                Prompt(result.msg);
            }
        },
        error: function(xhr, type)
        {
            $.AMUI.progress.done();
            Prompt(HtmlToString(xhr.responseText) || '异常错误', null, 30);
        }
    });
}

/**
 * 获取规格类型
 * @author   Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2018-12-14
 * @desc    description
 */
function GoodsSpecType()
{
    // 是否全部选中
    var sku_count = $('.theme-signin-left .sku-items').length;
    var active_count = $('.theme-signin-left .sku-items li.selected').length;
    if(active_count <= 0 || active_count >= sku_count)
    {
        return false;
    }

    // 获取规格值
    var spec = [];
    $('.theme-signin-left .sku-items li.selected').each(function(k, v)
    {
        spec.push({"type": $(this).data('type-value'), "value": $(this).data('value')})
    });

    // 开启进度条
    $.AMUI.progress.start();

    // ajax请求
    $.ajax({
        url: $('.goods-detail').data('spec-type-ajax-url'),
        type: 'post',
        dataType: "json",
        timeout: 10000,
        data: {"id": $('.goods-detail').data('id'), "spec": spec},
        success: function(result)
        {
            $.AMUI.progress.done();
            if(result.code == 0)
            {
                var spec_count = spec.length;
                var index = (spec_count > 0) ? spec_count : 0;
                if(index < sku_count)
                {
                    $('.theme-signin-left .sku-items').eq(index).find('li').each(function(k, v)
                    {
                        $(this).removeClass('sku-dont-choose');
                        var value = $(this).data('value').toString();
                        if(result.data.spec_type.indexOf(value) == -1)
                        {
                            $(this).addClass('sku-items-disabled');
                        } else {
                            $(this).removeClass('sku-items-disabled');
                        }
                    });
                }

                // 扩展数据处理
                var extends_element = result.data.extends_element || [];
                if(extends_element.length > 0)
                {
                    for(var i in extends_element)
                    {
                        if((extends_element[i]['element'] || null) != null && extends_element[i]['content'] !== null)
                        {
                            $(extends_element[i]['element']).html(extends_element[i]['content']);
                        }
                    }
                }
            } else {
                Prompt(result.msg);
            }
        },
        error: function(xhr, type)
        {
            $.AMUI.progress.done();
            Prompt(HtmlToString(xhr.responseText) || '异常错误', null, 30);
        }
    });
}

/**
 * 商品基础数据恢复
 * @author   Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2018-12-25
 * @desc    description
 */
function GoodsBaseRestore()
{
    $('.text-info .price-now').text(__currency_symbol__+$('.text-info .price-now').data('original-price'));
    $('.goods-price').text($('.goods-price').data('original-price'));
    $('.number-tag input[type="number"]').attr('max', $('.number-tag input[type="number"]').data('original-max'));
    $('.stock-tips .stock').text($('.stock-tips .stock').data('original-stock'));

    // 价格处理
    if($('.tb-detail-price .original-price-value').length > 0)
    {
        $('.tb-detail-price .original-price-value').each(function(k, v)
        {
            var price = $(this).data('original-price');
            if(price !== undefined)
            {
                $(this).text(__currency_symbol__+price);
            }
        });
    }
}

/**
 * 规格选择显示
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-08-16
 * @desc    description
 */
function SpecPopupShow(e)
{
    $(document.body).css({"position":"fixed", "width":"100%"});
    $('.theme-popover-mask').show();
    $('.theme-popover').slideDown(200);
    $('.theme-popover .confirm').attr('data-type', e.data('type') || 'buy');    
}

$(function() {
    // 购物车表单初始化
    FromInit('form.cart-form');

    // 商品规格选择
    $('.theme-options').each(function()
    {
        $(this).find('ul>li').on('click', function()
        {
            // 切换规格购买数量清空
            $('#text_box').val($('.stock-tips .stock').data('min-limit') || 1);
            
            // 规格处理
            var length = $('.theme-signin-left .sku-items').length;
            var index = $(this).parents('.sku-items').index();

            if($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');

                // 去掉元素之后的禁止
                $('.theme-signin-left .sku-items').each(function(k, v)
                {
                    if(k > index)
                    {
                        $(this).find('li').removeClass('sku-items-disabled').removeClass('selected').addClass('sku-dont-choose');
                    }
                });

                // 数据还原
                GoodsBaseRestore();

            } else {
                if($(this).hasClass('sku-items-disabled') || $(this).hasClass('sku-dont-choose'))
                {
                    return false;
                }
                $(this).addClass('selected').siblings('li').removeClass('selected');
                $(this).parents('.sku-items').removeClass('sku-not-active');

                // 去掉元素之后的禁止
                if(index < length)
                {
                    $('.theme-signin-left .sku-items').each(function(k, v)
                    {
                        if(k > index)
                        {
                            $(this).find('li').removeClass('sku-items-disabled').removeClass('selected').addClass('sku-dont-choose');
                        }
                    });
                }

                // 是否存在规格图片
                var spec_images = $(this).data('type-images') || null;
                if(spec_images != null)
                {
                    $('.jqzoom').attr('src', spec_images);
                    $('.jqzoom').attr('rel', spec_images);
                    $('.img-info img').attr('src', spec_images);
                }

                // 后面是否还有未选择的规格
                if(index < length-1)
                {
                    // 数据还原
                    GoodsBaseRestore();
                }

                // 获取下一个规格类型
                GoodsSpecType();

                // 获取规格详情
                GoodsSpecDetail();
            }
        });
    });

    // 放大镜初始化
    $('.jqzoom').imagezoom({
        yzoom: 398
    });
    $('#thumblist li a').on('mouseover', function() {
        $(this).parents('li').addClass('tb-selected').siblings().removeClass('tb-selected');
        $('.jqzoom').attr('src', $(this).find('img').attr('mid'));
        $('.jqzoom').attr('rel', $(this).find('img').attr('big'));
    });

    // 规格选择显示事件
    $('.mini-spec-event').on('click', function()
    {
        SpecPopupShow($(this));
    });

    //弹出规格选择
    $('.buy-event').on('click', function() {
        if($(window).width() < 1025) {
            // 是否登录
            if(__user_id__ != 0)
            {
                SpecPopupShow($(this));
            }
        } else {
            PoptitPcShow();
        }
    });
    $('.theme-poptit .close, .btn-op .close').on('click', function() {
        PoptitClose();
    });

    // 购买
    $('.buy-submit, .cart-submit').on('click', function()
    {
        // 是否登录
        if(__user_id__ != 0)
        {
            if($(window).width() >= 1025)
            {
                BuyCartHandle($(this));
            }
        }
    });
    $('.theme-popover .confirm').on('click', function()
    {
        // 是否登录
        if(__user_id__ != 0)
        {
            if($(window).width() < 1025)
            {
                BuyCartHandle($(this));
            }
        }
    });

    // 收藏
    $('.favor-submit').on('click', function()
    {
        // 是否登录
        if(__user_id__ != 0)
        {
            var $this = $(this);

            // ajax请求
            $.AMUI.progress.start();
            $.ajax({
                url: $(this).data('ajax-url'),
                type: 'post',
                dataType: "json",
                timeout: 10000,
                data: {"id": $('.goods-detail').data('id')},
                success: function(result)
                {
                    $.AMUI.progress.done();
                    PoptitClose();

                    if(result.code == 0)
                    {
                        $this.find('.goods-favor-text').text(result.data.text);
                        $this.find('.goods-favor-count').text('('+result.data.count+')');
                        if(result.data.status == 1)
                        {
                            $this.addClass('text-active');
                        } else {
                            $this.removeClass('text-active');
                        }
                        Prompt(result.msg, 'success');
                    } else {
                        Prompt(result.msg);
                    }
                },
                error: function(xhr, type)
                {
                    $.AMUI.progress.done();
                    PoptitClose();
                    Prompt(HtmlToString(xhr.responseText) || '异常错误', null, 30);
                }
            });
        }
    });

    // 视频
    $('.goods-video-submit-start').on('click', function()
    {
        $('.goods-video-container').removeClass('none').trigger('play');
        $('.goods-video-submit-close').removeClass('none');
        $('.goods-video-submit-start').addClass('none');
    });
    $('.goods-video-submit-close').on('click', function()
    {
        $('.goods-video-container').addClass('none').trigger('pause');
        $('.goods-video-submit-close').addClass('none');
        $('.goods-video-submit-start').removeClass('none');
    });

    //获得文本框对象
    var $sotck = $('#text_box');
    var min = $('.stock-tips .stock').data('min-limit') || 1;
    var max = $('.stock-tips .stock').data('max-limit') || 0;
    var unit = $('.stock-tips .stock').data('unit') || '';

    // 手动输入
    $sotck.on('blur', function()
    {
        var number = parseInt($(this).val());
        var inventory = parseInt($('.stock-tips .stock').text());
        if(number > inventory)
        {
            number = inventory;
        }
        if(number <= 1 || isNaN(number))
        {
            number = min;
        }
        $sotck.val(number);
    });

    //数量增加操作
    $('#add').on('click', function()
    {
        var inventory = parseInt($('.stock-tips .stock').text());
        var number = parseInt($sotck.val())+1;
        if(max > 0 && number > max)
        {
            Prompt('最大限购数量'+max+unit);
            return false;
        }
        if(number > inventory)
        {
            Prompt('库存数量'+inventory+unit);
            return false;
        }
        $sotck.val(number);
    });
    //数量减少操作
    $('#min').on('click', function()
    {
        var value = parseInt($sotck.val())-1 || 1;
        if(value < min)
        {
            Prompt('最低起购数量'+min+unit);
            return false;
        }
        $sotck.val(value);
    });

    // 评论
    GoodsCommentsHtml(1);
    $(document).on('click', '.goods-page-container .pagelibrary a', function()
    {
        var page = $(this).data('page') || null;
        if(page != null)
        {
            // 获取数据
            GoodsCommentsHtml(page);

            // 回到评论顶部位置
            $(window).smoothScroll({position: $('.introduce-main').offset().top});
        }
    });

    // 累计评价点击事件
    $('.tm-ind-panel .ind-panel-comment').on('click', function()
    {
        $(window).smoothScroll({position: $('.introduce-main').offset().top});
        $('.introduce-main .am-tabs').tabs('open', 1);
    });

    // tab事件
    $('.introduce-main .am-tabs li').on('click', function()
    {
        $(window).smoothScroll({position: $('.introduce-main').offset().top});
    });

});

// 浏览器窗口实时事件
$(window).resize(function()
{
    var name = document.activeElement.tagName;
    var arr = ['INPUT', 'SELECT', 'TEXTAREA', 'BUTTON'];
    if(arr.indexOf(name) == -1)
    {
        // 规格显示/隐藏处理
        if($(window).width() < 1025)
        {
            PoptitClose();
        } else {
            PoptitPcShow();
        }
    }
});
