const app = getApp();
Page({
  data: {
    data_list_loding_status: 1,
    data_bottom_line_status: false,
    data_list: [],
    params: null,
    is_default: 0,

    user_location_cache_key: app.data.cache_userlocation_key,
    user_location: null,
    is_first: 1,
    home_extraction_address_position: 0,
  },

  onLoad(params) {
    this.setData({
      params: params,
      home_extraction_address_position: app.get_config('config.home_extraction_address_position', 0),
    });
  },

  onReady: function () {
    // 清除位置缓存信息
    my.removeStorage({key: this.data.user_location_cache_key});

    // 是否获取位置
    if((this.data.params.is_buy || 0) == 1 && this.data.home_extraction_address_position == 1)
    {
      my.navigateTo({
        url: '/pages/common/open-setting-location/open-setting-location'
      });
    }
  },

  onShow() {
    my.setNavigationBar({ title: app.data.common_pages_title.extraction_address });
    
    // 是否需要选择地理位置
    if(this.data.home_extraction_address_position == 1)
    {
      // 首次不请求数据
      if(this.data.is_first == 0)
      {
        this.user_location_init();
        this.init();
      }
    } else {
      this.init();
    }
    
    this.setData({ is_first: 0 });
  },

  // 初始化
  init() {
    var user = app.get_user_info(this, "init");
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        my.redirectTo({
          url: "/pages/login/login?event_callback=init"
        });
        return false;
      } else {
        // 获取数据
        this.get_data_list();
      }
    } else {
      this.setData({
        data_list_loding_status: 0,
        data_bottom_line_status: false,
      });
    }
  },

  // 地址信息初始化
  user_location_init() {
    var result = my.getStorageSync({key: this.data.user_location_cache_key}) || null;
    var data = null;
    if (result != null && (result.data || null) != null)
    {
      data = {
        name: result.data.name || null,
        address: result.data.address || null,
        lat: result.data.latitude || null,
        lng: result.data.longitude || null
      }
    }
    this.setData({user_location: data});
  },

  // 获取数据列表
  get_data_list() {
    // 加载loding
    my.showLoading({ title: "加载中..." });
    this.setData({
      data_list_loding_status: 1
    });

    // 获取数据
    var data = {};

    // 是否有坐标
    if((this.data.user_location || null) != null)
    {
      data['lng'] = this.data.user_location.lng;
      data['lat'] = this.data.user_location.lat;
    }

    // 获取数据
    my.request({
      url: app.get_request_url("extraction", "useraddress"),
      method: "POST",
      data: data,
      dataType: "json",
      success: res => {
        my.hideLoading();
        my.stopPullDownRefresh();
        if (res.data.code == 0) {
          if (res.data.data.length > 0) {
            // 获取当前默认地址
            var is_default = 0;
            for (var i in res.data.data) {
              if (res.data.data[i]['is_default'] == 1) {
                is_default = res.data.data[i]['id'];
              }
            }

            // 设置数据
            this.setData({
              data_list: res.data.data,
              is_default: is_default,
              data_list_loding_status: 3,
              data_bottom_line_status: true,
            });
          } else {
            this.setData({
              data_list_loding_status: 0
            });
          }
        } else {
          this.setData({
            data_list_loding_status: 0
          });
          if (app.is_login_check(res.data, this, 'get_data_list')) {
            app.showToast(res.data.msg);
          }
        }
      },
      fail: () => {
        my.hideLoading();
        my.stopPullDownRefresh();

        this.setData({
          data_list_loding_status: 2
        });
        app.showToast("服务器请求出错");
      }
    });
  },

  // 下拉刷新
  onPullDownRefresh() {
    this.get_data_list();
  },

  // 地图查看
  address_map_event(e) {
    var index = e.currentTarget.dataset.index || 0;
    var data = this.data.data_list[index] || null;
    if (data == null)
    {
      app.showToast("地址有误");
      return false;
    }

    // 打开地图
    var name = data.alias || data.name || '';
    var address = (data.province_name || '') + (data.city_name || '') + (data.county_name || '') + (data.address || '');
    app.open_location(data.lng, data.lat, name, address);
  },

  // 地址内容事件
  address_conent_event(e) {
    var index = e.currentTarget.dataset.index || 0;
    var is_back = this.data.params.is_back || 0;
    if (is_back == 1) {
      my.setStorage({
        key: app.data.cache_buy_user_address_select_key,
        data: this.data.data_list[index]
      });
      my.navigateBack();
    }
  },

});
