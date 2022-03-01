/**
 * 外包装参数数据创建
 * @author  R
 * @version 1.0.0
 * @date    2021-07-22
 * @desc    description
 * @param   {[int]}           type  [展示类型（0,1,2）]
 * @param   {[string]}        name  [参数名称]
 * @param   {[string]}        value [参数值]
 */
 function ParametersItemHtmlCreated(obj)
 {
     var index = parseInt(Math.random()*1000001);
     var html = $("#product_hidden").html();
     var html = html.replace("<table>","").replace("</table>",""); 
     // 数据添加
     var $parameters_table = $(obj).parent().prev().find('.parameters-table');
     $parameters_table.append(html);
 }

$(function()
{
    // 搜索商品
    $(document).on('change', '.selection-container .chosen-select', function()
    {
        // 请求参数
        var url = $('.selection-container').data('search-url');
        var goods_id = $('.selection-form-goods').val();

        var $this = $(this);
        $.AMUI.progress.start();
        // $this.button('loading');
        $('.goods-spec-container').html('');
        $.ajax({
            url: url,
            type: 'post',
            data: {"goods_id":goods_id},
            dataType: 'json',
            success:function(res)
            {
                $.AMUI.progress.done();
                // $this.button('reset');
                if(res.code == 0)
                {
                    $('.goods-spec-container').attr('data-is-init', 0);
                    $('.goods-spec-container').html(res.data.data);
                } else {
                    Prompt(res.msg);
                    $('.goods-spec-container').html('<div class="table-no"><i class="am-icon-warning"></i> '+res.msg+'</div>');
                }
            },
            error: function(xhr, type)
            {
                $.AMUI.progress.done();
                // $this.button('reset');
                var msg = HtmlToString(xhr.responseText) || '异常错误';
                Prompt(msg, null, 30);
                $('.goods-spec-container').html('<div class="table-no"><i class="am-icon-warning"></i> '+msg+'</div>');
            }
        });
    });

    // 外包装参数添加
    var $parameters_table = $('.parameters-table');
    $('.parameters-line-add').on('click', function()
    {
        // 追加内容
        $("div[id='product_hidden'] *").attr("disabled",false);
        ParametersItemHtmlCreated(this);
    });

    // 外包装参数移除
    $parameters_table.on('click', '.line-remove', function()
    {alert($(this).parent().attr('class'));
        $(this).parents('tr').remove();
    });

    $('.parameters-box-add').on('click', function(){
        var html = $("#box_hidden").html();
        $(".am-padding-vertical-xs").append('<div class="am-form-group-add">'+html+'</div>');
        $(".am-form-group-add").each(function(){
           var i = $(this).index()+1;
           $(this).find('.am-form-gm').text('外箱'+i+'参数');
        });
    });
    
    $('.am-btn-sm').on('click',function(){
        $(".am-form-group-add").each(function(index,item){
            $(this).find("select[name='goods_id[]']").attr("name","goods_id"+index+"[]");
            $(this).find("input[name='parameters_sku[]']").attr("name","parameters_sku"+index+"[]");
            $(this).find("input[name='parameters_cnt[]']").attr("name","parameters_cnt"+index+"[]");
        });
        $("div[id='product_hidden'] *").attr("disabled",true);
        $("div[id='box_hidden'] *").attr("disabled",true);
        $("form").submit();
    });
});
