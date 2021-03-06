const app = getApp();
Page({
  data: {
    params: null,
    data_list_loding_status: 1,
    data_list_loding_msg: '',
    data_bottom_line_status: false,

    detail: null,
    detail_list: [],
    extension_data: [],
    site_fictitious: null,
  },

  onLoad(params) {
    this.setData({ params: params });
  },

  onShow() {
    swan.setNavigationBarTitle({ title: app.data.common_pages_title.user_order_detail });

    // 数据加载
    this.init();
  },

  // 获取数据
  init() {
    var self = this;
    swan.showLoading({ title: "加载中..." });
    this.setData({
      data_list_loding_status: 1
    });

    swan.request({
      url: app.get_request_url("detail", "order"),
      method: "POST",
      data: {
        id: this.data.params.id
      },
      dataType: "json",
      success: res => {
        swan.hideLoading();
        swan.stopPullDownRefresh();
        if (res.data.code == 0) {
          var data = res.data.data;
          self.setData({
            detail: data.data,
            detail_list:[
                {name: "出货服务", value: data.data.warehouse_name || ''},
                {name: "订单模式", value: data.data.order_model_name || '' },
                {name: "订单编号", value: data.data.order_no || ''},
                {name: "订单状态", value: data.data.status_name || ''},
                {name: "支付状态", value: data.data.pay_status_name || ''},
                {name: "订单单价", value: data.data.price || ''},
                {name: "订单总价", value: data.data.total_price || ''},
                {name: "优惠金额", value: data.data.preferential_price || ''},
                {name: "增加金额", value: data.data.increase_price || '' },
                {name: "支付金额", value: data.data.pay_price || ''},
                {name: "支付方式", value: (data.data.payment_name || '') + ((data.data.is_under_line_text || null) == null ? '' : '（' + data.data.is_under_line_text +'）')},
                {name: "快递公司", value: data.data.express_name || ''},
                {name: "快递单号", value: data.data.express_number || ''},
                {name: "用户留言", value: data.data.user_note || ''},
                {name: "创建时间", value: data.data.add_time || ''},
                {name: "确认时间", value: data.data.confirm_time || ''},
                {name: "支付时间", value: data.data.pay_time || ''},
                {name: "发货时间", value: data.data.delivery_time || ''},
                {name: "收货时间", value: data.data.collect_time || ''},
                {name: "取消时间", value: data.data.cancel_time || ''},
                {name: "关闭时间", value: data.data.close_time || ''},
            ],
            extension_data: data.data.extension_data || [],
            site_fictitious: data.site_fictitious || null,
            data_list_loding_status: 3,
            data_bottom_line_status: true,
            data_list_loding_msg: ''
          });
        } else {
          self.setData({
            data_list_loding_status: 2,
            data_bottom_line_status: false,
            data_list_loding_msg: res.data.msg
          });
          if (app.is_login_check(res.data, self, 'init')) {
            app.showToast(res.data.msg);
          }
        }
      },
      fail: () => {
        swan.hideLoading();
        swan.stopPullDownRefresh();
        self.setData({
          data_list_loding_status: 2,
          data_bottom_line_status: false,
          data_list_loding_msg: '服务器请求出错'
        });

        app.showToast("服务器请求出错");
      }
    });
  },

  // 地图查看
  address_map_event(e) {
    if ((this.data.detail.address_data || null) == null) {
      app.showToast("地址有误");
      return false;
    }
    var data = this.data.detail.address_data;

    // 打开地图
    var name = data.alias || data.name || '';
    var address = (data.province_name || '') + (data.city_name || '') + (data.county_name || '') + (data.address || '');
    app.open_location(data.lng, data.lat, name, address);
  },

  // 下拉刷新
  onPullDownRefresh() {
    this.init();
  }

});