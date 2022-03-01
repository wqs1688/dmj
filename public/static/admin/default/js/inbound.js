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
 function ParametersItemHtmlCreated(long, width, height, weight)
 {
     var index = parseInt(Math.random()*1000001);
     var html = '<tr class="parameters-line-'+index+'">';
         html += '<td class="am-text-middle">';
         html += '<input type="number" name="parameters_long[]" placeholder="长" value="'+(long || '')+'" maxlength="20" data-validation-message="请填写长度" required />';
         html += '</td>';
         html += '<td class="am-text-middle">';
         html += '<input type="number" name="parameters_width[]" placeholder="宽" value="'+(width || '')+'" data-validation-message="请填写宽度" maxlength="20" required />';
         html += '</td>';
         html += '<td class="am-text-middle">';
         html += '<input type="number" name="parameters_height[]" placeholder="高" value="'+(height || '')+'" maxlength="20" data-validation-message="请填写高度" required />';
         html += '</td>';
         html += '<td class="am-text-middle">';
         html += '<input type="number" name="parameters_weight[]" placeholder="重量" value="'+(weight || '')+'" maxlength="20" data-validation-message="请填写重量" required />';
         html += '</td>';
         html += '<td class="am-text-middle">';
         html += '<span class="am-text-xs cr-red c-p line-remove">移除</span></td>';
         html += '</tr>';
 
     // 数据添加
     var $parameters_table = $('.size-table');
     $parameters_table.append(html);
 }

$(function()
{
    // 外包装参数添加
    var $parameters_table = $('.size-table');
    $('.pkgsize-line-add').on('click', function()
    {
        // 追加内容
        ParametersItemHtmlCreated();
    });

    // 外包装参数移除
    $parameters_table.on('click', '.line-remove', function()
    {
        $(this).parents('tr').remove();
    });

});