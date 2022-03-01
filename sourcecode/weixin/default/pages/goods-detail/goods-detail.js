const app = getApp();
Page({
  data: {
    indicator_dots: false,
    indicator_color: 'rgba(0, 0, 0, .3)',
    indicator_active_color: '#e31c55',
    autoplay: true,
    circular: true,
    data_bottom_line_status: false,
    data_list_loding_status: 1,
    data_list_loding_msg: '',
    params: null,

    goods: null,
    goods_photo: [],
    goods_specifications_choose: [],
    goods_content_app: [],
    popup_status: false,
    goods_favor_text: '收藏',
    goods_favor_icon: '/images/goods-detail-favor-icon-0.png',
    temp_buy_number: 1,
    buy_event_type: 'buy',
    buy_button: {},

    goods_spec_base_price: 0,
    goods_spec_base_original_price: 0,
    goods_spec_base_inventory: 0,
    goods_spec_base_images: '',

    show_field_price_text: null,
    goods_video_is_autoplay: false,
    popup_share_status: false,

    // 购物车快捷导航
    quick_nav_cart_count: 0,

    // 基础配置
    currency_symbol: app.data.currency_symbol,
    common_app_is_poster_share: 0,
    common_app_is_good_thing : 0,
    common_app_is_online_service: 0,
    common_app_is_use_mobile_detail: 0,
    common_is_goods_detail_show_photo: 0,
    common_app_customer_service_tel: null,

    // 好物圈分享信息
    share_product: {
      "item_code": "",
      "title": "",
      "desc": "",
      "category_list": [],
      "image_list": [],
      "src_mini_program_path": "",
      "brand_info": {},
    },

    // 限时秒杀插件
    plugins_limitedtimediscount_is_valid: 0,
    plugins_limitedtimediscount_data: null,
    plugins_limitedtimediscount_is_show_time: true,
    plugins_limitedtimediscount_time_millisecond: 0,
    plugins_limitedtimediscount_timer: null,
    plugins_limitedtimediscount_timers: null,

    // 优惠劵
    plugins_coupon_data: null,
    temp_coupon_receive_index: null,
    temp_coupon_receive_value: null,
  },

  onLoad(params) {
    // 启动参数处理
    params = app.launch_params_handle(params);
    
    // 参数赋值,初始化
    //params['goods_id']=12;
    this.setData({params: params});

    // 数据加载
    this.init();
  },

  onShow() {
    wx.setNavigationBarTitle({title: (this.data.goods == null) ? app.data.common_pages_title.goods_detail : this.data.goods.title});

    // 初始化配置
    this.init_config();

    // 显示分享菜单
    app.show_share_menu();
  },

  // 初始化配置
  init_config(status) {
    if((status || false) == true) {
      this.setData({
        currency_symbol: app.get_config('currency_symbol'),
        common_app_is_use_mobile_detail: app.get_config('config.common_app_is_use_mobile_detail'),
        common_is_goods_detail_show_photo: app.get_config('config.common_is_goods_detail_show_photo'),
        common_app_is_online_service: app.get_config('config.common_app_is_online_service'),
        common_app_is_good_thing: app.get_config('config.common_app_is_good_thing'),
        common_app_is_poster_share: app.get_config('config.common_app_is_poster_share'),
        common_app_customer_service_tel: app.get_config('config.common_app_customer_service_tel'),
      });
    } else {
      app.is_config(this, 'init_config');
    }
  },

  // 获取数据
  init() {
    // 参数校验
    if((this.data.params.goods_id || null) == null)
    {
      wx.stopPullDownRefresh();
      this.setData({
        data_bottom_line_status: false,
        data_list_loding_status: 2,
        data_list_loding_msg: '商品ID有误',
      });
    } else {
      var self = this;

      // 加载loding
      wx.showLoading({title: '加载中...'});
      this.setData({
        data_list_loding_status: 1
      });

      wx.request({
        url: app.get_request_url("detail", "goods"),
        method: "POST",
        data: {goods_id: this.data.params.goods_id},
        dataType: "json",
        header: { 'content-type': 'application/x-www-form-urlencoded' },
        success: res => {
          wx.stopPullDownRefresh();
          wx.hideLoading();
          if (res.data.code == 0) {
            var data = res.data.data;
            self.setData({
              data_bottom_line_status: true,
              data_list_loding_status: 3,
              goods: data.goods,
              indicator_dots: (data.goods.photo.length > 1),
              autoplay: (data.goods.photo.length > 1),
              goods_photo: data.goods.photo,
              goods_specifications_choose: data.goods.specifications.choose || [],
              goods_content_app: data.goods.content_app || [],
              temp_buy_number: data.goods.buy_min_number || 1,
              goods_favor_text: (data.goods.is_favor == 1) ? '已收藏' : '收藏',
              goods_favor_icon: '/images/goods-detail-favor-icon-' + data.goods.is_favor+'.png',
              buy_button: data.buy_button || null,

              goods_spec_base_price: data.goods.price,
              goods_spec_base_original_price: data.goods.original_price,
              goods_spec_base_inventory: data.goods.inventory,
              goods_spec_base_images: data.goods.images,
              show_field_price_text: (data.goods.show_field_price_text == '销售价') ? null : (data.goods.show_field_price_text.replace(/<[^>]+>/g, "") || null),

              'share_product.item_code': data.goods.id.toString(),
              'share_product.title': data.goods.title,
              'share_product.image_list': data.goods.photo.map(function (v) { return v.images;}),
              'share_product.desc': data.goods.simple_desc,
              'share_product.category_list': data.goods.category_names || [],
              'share_product.src_mini_program_path': '/pages/goods-detail/goods-detail?goods_id='+data.goods.id,
              'share_product.brand_info.name': data.goods.brand_name,

              plugins_limitedtimediscount_data: data.plugins_limitedtimediscount_data || null,
              plugins_limitedtimediscount_is_valid: ((data.plugins_limitedtimediscount_data || null) != null && (data.plugins_limitedtimediscount_data.is_valid || 0) == 1) ? 1 : 0,

              plugins_coupon_data: data.plugins_coupon_data || null,
              quick_nav_cart_count: data.common_cart_total || 0,
            });

            // 限时秒杀倒计时
            if (this.data.plugins_limitedtimediscount_is_valid == 1)
            {
              this.plugins_limitedtimediscount_countdown();
            }

            // 标题
            wx.setNavigationBarTitle({ title: data.goods.title });

            // 不能选择规格处理
            this.goods_specifications_choose_handle_dont(0);
          } else {
            self.setData({
              data_bottom_line_status: false,
              data_list_loding_status: 0,
              data_list_loding_msg: res.data.msg,
            });
          }
        },
        fail: () => {
          wx.stopPullDownRefresh();
          wx.hideLoading();
          self.setData({
            data_bottom_line_status: false,
            data_list_loding_status: 2,
            data_list_loding_msg: '服务器请求出错',
          });

          app.showToast("服务器请求出错");
        }
      });
    }
  },

  // 不能选择规格处理
  goods_specifications_choose_handle_dont(key) {
    var temp_data = this.data.goods_specifications_choose || [];
    if(temp_data.length <= 0)
    {
      return false;
    }

    // 是否不能选择
    for(var i in temp_data)
    {
      for(var k in temp_data[i]['value'])
      {
        if(i > key)
        {
          temp_data[i]['value'][k]['is_dont'] = 'spec-dont-choose',
          temp_data[i]['value'][k]['is_disabled'] = '';
          temp_data[i]['value'][k]['is_active'] = '';
        }

        // 当只有一个规格的时候
        if(key == 0 && temp_data.length == 1)
        {
          temp_data[i]['value'][k]['is_disabled'] = ((temp_data[i]['value'][k]['is_only_level_one'] || null) != null && (temp_data[i]['value'][k]['inventory'] || 0) <= 0) ? 'spec-items-disabled' : '';
        }
      }
    }
    this.setData({goods_specifications_choose: temp_data});
  },

  // 下拉刷新
  onPullDownRefresh() {
    this.init();
  },

  // 购买弹层关闭
  popup_close_event(e) {
    this.setData({popup_status: false});
  },

  // 进入店铺
  shop_event(e)
  {
    wx.switchTab({
      url: '/pages/index/index'
    });
  },

  // 导航购买按钮事件
  nav_buy_submit_event(e) {
    var type = e.currentTarget.dataset.type || 'buy';
    var value = e.currentTarget.dataset.value || null;
    switch(type)
    {
      // 展示型、拨打电话
      case 'show' :
        app.call_tel(value || this.data.common_app_customer_service_tel);
        break;
      
      // 购买、加入购物车
      case 'buy' :
      case 'cart' :
        this.setData({ popup_status: true, buy_event_type: type });
        break;

      // 默认
      default :
        app.showToast('事件未处理');
    }
  },

  // 收藏事件
  goods_favor_event(e)
  {
    var user = app.get_user_info(this, 'goods_favor_event');
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        wx.navigateTo({
          url: "/pages/login/login?event_callback=goods_favor_event"
        });
        return false;
      } else {
        wx.showLoading({title: '处理中...'});

        wx.request({
          url: app.get_request_url('favor', 'goods'),
          method: 'POST',
          data: {"id": this.data.goods.id},
          dataType: 'json',
          success: (res) => {
            wx.hideLoading();
            if(res.data.code == 0)
            {
              this.setData({
                'goods.is_favor': res.data.data.status,
                goods_favor_text: res.data.data.text,
                goods_favor_icon: '/images/goods-detail-favor-icon-'+res.data.data.status+'.png'
              });
              app.showToast(res.data.msg, "success");
            } else {
              if (app.is_login_check(res.data, this, 'goods_favor_event')) {
                app.showToast(res.data.msg);
              }
            }
          },
          fail: () => {
            wx.hideLoading();

            app.showToast('服务器请求出错');
          }
        });
      }
    }
  },

  // 加入购物车事件
  goods_cart_event(spec) {
    var user = app.get_user_info(this, 'goods_buy_confirm_event');
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        wx.navigateTo({
          url: "/pages/login/login?event_callback=goods_buy_confirm_event"
        });
        return false;
      } else {
        wx.showLoading({title: '处理中...' });
        wx.request({
          url: app.get_request_url('save', 'cart'),
          method: 'POST',
          data: { "goods_id": this.data.goods.id, "stock": this.data.temp_buy_number, "spec": JSON.stringify(spec) },
          dataType: 'json',
          success: (res) => {
            wx.hideLoading();
            if (res.data.code == 0) {
              this.setData({ quick_nav_cart_count: res.data.data});
              this.popup_close_event();
              app.showToast(res.data.msg, "success");
            } else {
              if (app.is_login_check(res.data, this, 'goods_buy_confirm_event')) {
                app.showToast(res.data.msg);
              }
            }
          },
          fail: () => {
            wx.hideLoading();

            app.showToast('服务器请求出错');
          }
        });
      }
    }
  },

  // 规格事件
  goods_specifications_event(e) {
    var key = e.currentTarget.dataset.key || 0;
    var keys = e.currentTarget.dataset.keys || 0;
    var temp_data = this.data.goods_specifications_choose;
    var temp_images = this.data.goods_spec_base_images;

    // 不能选择和禁止选择跳过
    if((temp_data[key]['value'][keys]['is_dont'] || null) == null && (temp_data[key]['value'][keys]['is_disabled'] || null) == null)
    {
      // 规格选择
      for(var i in temp_data)
      {
        for(var k in temp_data[i]['value'])
        {
          if((temp_data[i]['value'][k]['is_dont'] || null) == null && (temp_data[i]['value'][k]['is_disabled'] || null) == null)
          {
            if(key == i)
            {
              if(keys == k && (temp_data[i]['value'][k]['is_active'] || null) == null)
              {
                temp_data[i]['value'][k]['is_active'] = 'spec-active';
                if((temp_data[i]['value'][k]['images'] || null) != null)
                {
                  temp_images = temp_data[i]['value'][k]['images'];
                }
              } else {
                temp_data[i]['value'][k]['is_active'] = '';
              }
            }
          }
        }
      }
      this.setData({ goods_specifications_choose: temp_data, goods_spec_base_images: temp_images, temp_buy_number: this.data.goods.buy_min_number || 1});

      // 不能选择规格处理
      this.goods_specifications_choose_handle_dont(key);

      // 获取下一个规格类型
      this.get_goods_specifications_type(key);

      // 获取规格详情
      this.get_goods_specifications_detail();
    }
  },

  // 获取下一个规格类型
  get_goods_specifications_type(key) {
    var temp_data = this.data.goods_specifications_choose;
    var active_index = key+1;
    var sku_count = temp_data.length;

    if(active_index <= 0 || active_index >= sku_count)
    {
      return false;
    }

    // 获取规格值
    var spec = [];
    for(var i in temp_data)
    {
      for(var k in temp_data[i]['value'])
      {
        if((temp_data[i]['value'][k]['is_active'] || null) != null)
        {
          spec.push({"type": temp_data[i]['name'], "value": temp_data[i]['value'][k]['name']});
          break;
        }
      }
    }
    if(spec.length <= 0)
    {
      return false;
    }

    // 获取数据
    wx.request({
      url: app.get_request_url('spectype', 'goods'),
      method: 'POST',
      data: { "id": this.data.goods.id, "spec": JSON.stringify(spec) },
      dataType: 'json',
      success: (res) => {
        if (res.data.code == 0) {
          var spec_count = spec.length;
          var index = (spec_count > 0) ? spec_count : 0;
          if(index < sku_count)
          {
            for(var i in temp_data)
            {
              for(var k in temp_data[i]['value'])
              {
                if(index == i)
                {
                  temp_data[i]['value'][k]['is_dont'] = '';
                  var temp_value = temp_data[i]['value'][k]['name'];
                  var temp_status = false;
                  for(var t in res.data.data)
                  {
                    if(res.data.data[t] == temp_value)
                    {
                      temp_status = true;
                      break;
                    }
                  }
                  if(temp_status == true)
                  {
                    temp_data[i]['value'][k]['is_disabled'] = '';
                  } else {
                    temp_data[i]['value'][k]['is_disabled'] = 'spec-items-disabled';
                  }
                }
              }
            }
            this.setData({goods_specifications_choose: temp_data});
          }
        } else {
          app.showToast(res.data.msg);
        }
      },
      fail: () => {
        app.showToast("服务器请求出错");
      }
    });
  },

  // 获取规格详情
  get_goods_specifications_detail() {
    // 是否全部选中
    var temp_data = this.data.goods_specifications_choose;
    var sku_count = temp_data.length;
    var active_count = 0;

    // 获取规格值
    var spec = [];
    for(var i in temp_data)
    {
      for(var k in temp_data[i]['value'])
      {
        if((temp_data[i]['value'][k]['is_active'] || null) != null)
        {
          active_count++;
          spec.push({"type": temp_data[i]['name'], "value": temp_data[i]['value'][k]['name']});
          break;
        }
      }
    }
    if(spec.length <= 0 || active_count < sku_count)
    {
      this.setData({
        goods_spec_base_price: this.data.goods.price,
        goods_spec_base_original_price: this.data.goods.original_price,
        goods_spec_base_inventory: this.data.goods.inventory,
      });
      return false;
    }

    // 获取数据
    wx.request({
      url: app.get_request_url('specdetail', 'goods'),
      method: 'POST',
      data: { "id": this.data.goods.id, "spec": JSON.stringify(spec) },
      dataType: 'json',
      success: (res) => {
        if (res.data.code == 0) {
          this.setData({
            goods_spec_base_price: res.data.data.price,
            goods_spec_base_original_price: res.data.data.original_price,
            goods_spec_base_inventory: res.data.data.inventory,
          });
        } else {
          app.showToast(res.data.msg);
        }
      },
      fail: () => {
        app.showToast("服务器请求出错");
      }
    });
  },

  // 数量输入事件
  goods_buy_number_blur(e) {
    var buy_number = parseInt(e.detail.value) || 1;
    this.setData({temp_buy_number: buy_number});
    this.goods_buy_number_func(buy_number);
  },

  // 数量操作事件
  goods_buy_number_event(e) {
    var type = parseInt(e.currentTarget.dataset.type) || 0;
    var temp_buy_number = parseInt(this.data.temp_buy_number);
    if(type == 0)
    {
      var buy_number = temp_buy_number - 1;
    } else {
      var buy_number = temp_buy_number + 1;
    }
    this.goods_buy_number_func(buy_number);
  },

  // 数量处理方法
  goods_buy_number_func(buy_number) {
    var buy_min_number = parseInt(this.data.goods.buy_min_number) || 1;
    var buy_max_number = parseInt(this.data.goods.buy_max_number) || 0;
    var inventory = parseInt(this.data.goods_spec_base_inventory);
    var inventory_unit = this.data.goods.inventory_unit;
    if(buy_number < buy_min_number)
    {
      buy_number = buy_min_number;
      if(buy_min_number > 1)
      {
        app.showToast('起购'+buy_min_number+inventory_unit);
      }
    }
    if(buy_max_number > 0 && buy_number > buy_max_number)
    {
      buy_number = buy_max_number;
      app.showToast('限购'+buy_max_number+inventory_unit);
    }
    if(buy_number > inventory)
    {
      buy_number = inventory;
      app.showToast('库存数量'+inventory+inventory_unit);
    }
    this.setData({temp_buy_number: buy_number});
  },

  // 确认
  goods_buy_confirm_event(e) {
    var user = app.get_user_info(this, 'goods_buy_confirm_event');
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        wx.navigateTo({
          url: "/pages/login/login?event_callback=goods_buy_confirm_event"
        });
        return false;
      } else {
        // 属性
        var temp_data = this.data.goods_specifications_choose;
        var sku_count = temp_data.length;
        var active_count = 0;
        var spec = [];
        if(sku_count > 0)
        {
          for(var i in temp_data)
          {
            for(var k in temp_data[i]['value'])
            {
              if((temp_data[i]['value'][k]['is_active'] || null) != null)
              {
                active_count++;
                spec.push({"type": temp_data[i]['name'], "value": temp_data[i]['value'][k]['name']});
              }
            }
          }
          if(active_count < sku_count)
          {
            app.showToast('请选择属性');
            return false;
          }
        }
        
        // 操作类型
        switch (this.data.buy_event_type) {
          case 'buy' :
            // 进入订单确认页面
            var data = {
              "buy_type": "goods",
              "goods_id": this.data.goods.id,
              "stock": this.data.temp_buy_number,
              "spec": JSON.stringify(spec)
            };
            wx.navigateTo({
              url: '/pages/buy/buy?data=' + encodeURIComponent(JSON.stringify(data))
            });
            this.popup_close_event();
            break;

          case 'cart' :
            this.goods_cart_event(spec);
            break;

          default :
            app.showToast("操作事件类型有误");
        }
      }
    }
  },

  // 详情图片查看
  goods_detail_images_view_event(e) {
    var value = e.currentTarget.dataset.value || null;
    if(value != null)
    {
      wx.previewImage({
        current: value,
        urls: [value]
      });
    }
  },
  // 商品相册图片查看
  goods_photo_view_event(e) {
    var index = e.currentTarget.dataset.index;
    var all = [];
    for (var i in this.data.goods_photo)
    {
      all.push(this.data.goods_photo[i]['images']);
    }
    wx.previewImage({
      current: all[index],
      urls: all
    });
  },

  // 视频播放
  goods_video_play_event(e) {
    this.setData({ goods_video_is_autoplay: true});
  },

  // 视频关闭
  goods_video_close_event(e) {
    this.setData({ goods_video_is_autoplay: false });
  },

  // 分享开启弹层
  popup_share_event(e) {
    this.setData({ popup_share_status: true });
  },

  // 分享弹层关闭
  popup_share_close_event(e) {
    this.setData({ popup_share_status: false });
  },

  // 显示秒杀插件-倒计时
  plugins_limitedtimediscount_countdown() {
    // 销毁之前的任务
    clearInterval(this.data.plugins_limitedtimediscount_timer);
    clearInterval(this.data.plugins_limitedtimediscount_timers);

    // 定时参数
    var status = this.data.plugins_limitedtimediscount_data.time.status || 0;
    var msg = this.data.plugins_limitedtimediscount_data.time.msg || '';
    var hours = parseInt(this.data.plugins_limitedtimediscount_data.time.hours) || 0;
    var minutes = parseInt(this.data.plugins_limitedtimediscount_data.time.minutes) || 0;
    var seconds = parseInt(this.data.plugins_limitedtimediscount_data.time.seconds) || 0;
    var self = this;
    if (status == 1) {
      // 秒
      var timer = setInterval(function () {
        if (seconds <= 0) {
          if (minutes > 0) {
            minutes--;
            seconds = 59;
          } else if (hours > 0) {
            hours--;
            minutes = 59;
            seconds = 59;
          }
        } else {
          seconds--;
        }

        self.setData({
          'plugins_limitedtimediscount_data.time.hours': (hours < 10) ? '0' + hours : hours,
          'plugins_limitedtimediscount_data.time.minutes': (minutes < 10) ? '0' + minutes : minutes,
          'plugins_limitedtimediscount_data.time.seconds': (seconds < 10) ? '0' + seconds : seconds,
          plugins_limitedtimediscount_timer: timer,
        });

        if (hours <= 0 && minutes <= 0 && seconds <= 0) {
          // 停止时间
          clearInterval(timer);

          // 活动已结束
          self.setData({
            'plugins_limitedtimediscount_data.desc': '活动已结束',
            plugins_limitedtimediscount_is_show_time: false,
          });
        }
      }, 1000);

      // 毫秒
      var count = 0;
      var timers = setInterval(function () {
        count++;
        self.setData({ plugins_limitedtimediscount_time_millisecond: count});
        if(count > 9) {
          count = 0;
        }
        if (self.data.plugins_limitedtimediscount_is_show_time == false) {
          clearInterval(timers);
        }
      }, 100);
      self.setData({
        plugins_limitedtimediscount_timers: timers,
      });
    } else {
      // 活动已结束
      self.setData({
        'plugins_limitedtimediscount_data.desc': msg,
        plugins_limitedtimediscount_is_show_time: false,
      });
    }
  },

  // 页面销毁时执行
  onUnload: function () {
    clearInterval(this.data.plugins_limitedtimediscount_timer);
    clearInterval(this.data.plugins_limitedtimediscount_timers);
  },

  // 商品海报分享
  poster_event() {
    var user = app.get_user_info(this, 'poster_event');
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        wx.navigateTo({
          url: "/pages/login/login?event_callback=poster_event"
        });
        return false;
      } else {
        wx.showLoading({ title: '生成中...' });
        wx.request({
          url: app.get_request_url('goodsposter', 'distribution', 'distribution'),
          method: 'POST',
          data: { "goods_id": this.data.goods.id },
          dataType: 'json',
          success: (res) => {
            wx.hideLoading();
            if (res.data.code == 0) {
              wx.previewImage({
                current: res.data.data,
                urls: [res.data.data]
              });
            } else {
              if (app.is_login_check(res.data, this, 'poster_event')) {
                app.showToast(res.data.msg);
              }
            }
          },
          fail: () => {
            wx.hideLoading();
            app.showToast("服务器请求出错");
          }
        });
      }
    }
  },

  // 优惠劵领取事件
  coupon_receive_event(e) {
    // 参数处理
    if((e || null) == null)
    {
      var index = this.data.temp_coupon_receive_index;
      var value = this.data.temp_coupon_receive_value;
    } else {
      var index = e.currentTarget.dataset.index;
      var value = e.currentTarget.dataset.value;
      this.setData({temp_coupon_receive_index: index, temp_coupon_receive_value: value});
    }

    // 登录校验
    var user = app.get_user_info(this, 'coupon_receive_event');
    if (user != false) {
      // 用户未绑定用户则转到登录页面
      if (app.user_is_need_login(user)) {
        wx.navigateTo({
          url: "/pages/login/login?event_callback=coupon_receive_event"
        });
        return false;
      } else {
        var self = this;
        var temp_list = this.data.plugins_coupon_data.data;
        if (temp_list[index]['is_operable'] != 0) {
          wx.showLoading({ title: "处理中..." });
          wx.request({
            url: app.get_request_url("receive", "coupon", "coupon"),
            method: "POST",
            data: { "coupon_id": value },
            dataType: "json",
            header: { 'content-type': 'application/x-www-form-urlencoded' },
            success: res => {
              wx.hideLoading();
              if (res.data.code == 0) {
                app.showToast(res.data.msg, "success");
                if (self.data.plugins_coupon_data.base != null && self.data.plugins_coupon_data.base.is_repeat_receive != 1) {
                  temp_list[index]['is_operable'] = 0;
                  temp_list[index]['is_operable_name'] = '已领取';
                  self.setData({ 'plugins_coupon_data.data': temp_list });
                }
              } else {
                if (app.is_login_check(res.data, self, 'coupon_receive_event')) {
                  app.showToast(res.data.msg);
                }
              }
            },
            fail: () => {
              wx.hideLoading();
              app.showToast("服务器请求出错");
            }
          });
        }
      }
    }
  },

  // 自定义分享
  onShareAppMessage() {
    var user_id = app.get_user_cache_info('id', 0) || 0;
    return {
      title: this.data.goods.title+'-'+app.data.application_title,
      desc: app.data.application_describe,
      path: '/pages/goods-detail/goods-detail?goods_id=' + this.data.goods.id +'&referrer='+user_id,
      imageUrl: this.data.goods.images
    };
  },

  // 分享朋友圈
  onShareTimeline() {
    var user_id = app.get_user_cache_info('id', 0) || 0;
    return {
      title: this.data.goods.title+'-'+app.data.application_title,
      query: 'goods_id=' + this.data.goods.id +'&referrer='+user_id,
      imageUrl: this.data.goods.images
    };
  },
});
