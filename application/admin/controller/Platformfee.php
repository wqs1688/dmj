<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | 平台费用
// +----------------------------------------------------------------------
// | Author: R
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\service\PlatformfeeService;

/**
 * 平台费用
 * @author   R
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2021-12-16
 */
class Platformfee extends Common
{
	/**
	 * 构造方法
	 * @author   R
	 * @version  0.0.1
	 * @datetime 2021-12-16
	 */
	public function __construct()
	{
		// 调用父类前置方法
		parent::__construct();

		// 登录校验
		$this->IsLogin();

		// 权限校验
		$this->IsPower();
	}

	/**
     * [Index 列表]
     * @author   R
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2021-12-16
     */
	public function Index()
	{
		// 获取列表
        $data_params = [
            'where'         => $this->form_where,
            'order_by'      => $this->form_order_by['data'],
        ];
		$ret = PlatformfeeService::FeeList($data_params);
		$this->assign('data_list', $ret['data']);
		return $this->fetch();
	}

    /**
     * 详情
     * @author   R
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2021-12-16
     */
    public function Detail()
    {
        if(!empty($this->data_request['id']))
        {
            // 条件
            $where = [
                ['id', '=', intval($this->data_request['id'])],
            ];

            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => $where,
            ];
            $ret = PlatformfeeService::FeeList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            $this->assign('data', $data);
        }
        return $this->fetch();
    }

	/**
	 * [Save 数据保存]
	 * @author   R
	 * @version  0.0.1
	 * @datetime 2021-12-16
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = $this->data_request;
        return PlatformfeeService::FeeSave($params);
	}

	/**
	 * [Delete 删除]
	 * @author   R
	 * @version  0.0.1
	 * @datetime 2021-12-16
	 */
	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = $this->data_request;
        $params['user_type'] = 'admin';
        return PlatformfeeService::FeeDelete($params);
	}

	/**
	 * [StatusUpdate 状态更新]
	 * @author   R
	 * @version  0.0.1
	 * @datetime 2021-12-16
	 */
	public function StatusUpdate()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = $this->data_request;
        return PlatformfeeService::FeeStatusUpdate($params);
	}
}
?>
