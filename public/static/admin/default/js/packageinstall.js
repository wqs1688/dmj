/**
 * 软件安装异步请求步骤
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2021-02-22
 * @desc    description
 * @param   {[string]}        key [操作key（仅download和install需要）]
 * @param   {[string]}        opt [操作类型（url 获取下载地址， download 下载插件包， install 安装插件包）]
 * @param   {[string]}        msg [提示信息]
 */
function RequestHandle(key, opt, msg)
{
    // 操作容器
    var $container = $('.packageinstall-container');
    var $progress = $('.progress-container');
    var $error = $('.error-container');
    var $success = $('.success-container');

    // 获取参数值
    var id = $container.data('id') || 0;
    var type = $container.data('type') || null;
    var terminal = $container.data('terminal') || null;
    var url = $container.data('url') || null;
    var admin_url = $container.data('admin-url') || null;
    if(id == 0 || type == null || url == null)
    {
        $progress.addClass('am-hide');
        $error.removeClass('am-hide');
        $error.find('.msg-text').text('请求参数有误');
        return false;
    }

    // 默认获取地址
    if((opt || null) == null)
    {
        opt = 'url';
    }

    // 加载提示
    $progress.find('.msg-text').text(msg || '正在获取中...');

    // ajax
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        timeout: 305000,
        data: {"id":id, "type":type, "opt":opt, "key":key || '', "terminal":terminal || ''},
        success: function(result)
        {
            if((result || null) != null && result.code == 0)
            {
                switch(opt)
                {
                    // 获取下载地址
                    case 'url' :
                        RequestHandle(result.data, 'download', '正在下载中...');
                        break;

                    // 下载插件包
                    case 'download' :
                        RequestHandle(result.data, 'install', '正在安装中...');
                        break;

                    // 安装完成
                    case 'install' :
                        $progress.addClass('am-hide');
                        $error.addClass('am-hide');
                        $success.removeClass('am-hide');
                        setTimeout(function()
                        {
                            window.location.href = admin_url;
                        }, 2000);
                        break;
                }
            } else {
                $progress.addClass('am-hide');
                $error.removeClass('am-hide');
                $error.find('.msg-text').text(((result || null) == null) ? '返回数据格式错误' : (result.msg || '异常错误'));
            }
        },
        error: function(xhr, type)
        {
            $progress.addClass('am-hide');
            $error.removeClass('am-hide');
            $error.find('.msg-text').text(HtmlToString(xhr.responseText) || '异常错误');
        }
    });
}

$(function()
{
    // 请求安装
    RequestHandle();
});