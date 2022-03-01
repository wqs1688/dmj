<view qq:if="{{goods != null}}" class="page">
  <!-- 轮播图片 -->
  <swiper
    indicator-dots="{{indicator_dots}}"
    indicator-color="{{indicator_color}}"
    indicator-active-color="{{indicator_active_color}}"
    autoplay="{{autoplay}}"
    circular="{{circular}}"
    class="goods-photo bg-white"
    qq:if="{{goods_photo.length > 0}}">
    <block qq:for="{{goods_photo}}" qq:key="key">
      <swiper-item>
        <image class="swiper-item wh-auto" bindtap="goods_photo_view_event" data-index="{{index}}" src="{{item.images}}" mode="aspectFit" bindtap="goods_photo_view_event" />
      </swiper-item>
    </block>
  </swiper>

  <!-- 视频 -->
  <block qq:if="{{goods.video.length > 0}}">
    <view qq:if="{{goods_video_is_autoplay}}" class="goods-video">
      <video src="{{goods.video}}" autoplay="{{goods_video_is_autoplay}}" show-center-play-btn="{{true}}" controls="{{false}}" show-play-btn="{{false}}" enable-progress-gesture="{{false}}" show-fullscreen-btn="{{false}}"></video>
    </view>
    <view class="goods-video-submit">
      <image qq:if="{{!goods_video_is_autoplay}}" class="goods-video-play" bindtap="goods_video_play_event" src="/images/goods-detail-video-play.png" mode="aspectFit"></image>
      <image qq:if="{{goods_video_is_autoplay}}" class="goods-video-close"  bindtap="goods_video_close_event" src="/images/goods-detail-video-close.png" mode="aspectFit"></image>
    </view>
  </block>

  <!-- 标题 -->
  <view class="goods-title" style="color:{{goods.title_color}}">{{goods.title}}</view>

  <!-- 简述 -->
  <view qq:if="{{(goods.simple_desc || null) != null}}" class="goods-simple-desc">{{goods.simple_desc}}</view>

  <!-- icon -->
  <view qq:if="{{(goods.plugins_view_icon_data || null) != null && goods.plugins_view_icon_data.length > 0}}" class="goods-icon-container bg-white br-b-dashed oh">
    <block qq:for="{{goods.plugins_view_icon_data}}" qq:key="key">
      <view qq:if="{{(item.name || null) != null}}" class="fl tc" style="{{(item.br_color || null) == null ? '' : 'border:1px solid '+item.br_color+';'}}{{(item.color || null) == null ? '' : 'color: '+item.color+';'}}">{{item.name}}</view>
    </block>
  </view>

  <!-- 面板提示信息 -->
  <view qq:if="{{(goods.plugins_view_panel_data || null) != null && goods.plugins_view_panel_data.length > 0}}" class="goods-panel-container bg-white br-b-dashed oh">
    <block qq:for="{{goods.plugins_view_panel_data}}" qq:key="key">
      <view qq:if="{{(item || null) != null}}">{{item}}</view>
    </block>
  </view>

  <!-- 限时秒杀 -->
  <view qq:if="{{plugins_limitedtimediscount_is_valid == 1}}">
    <import src="/pages/lib/limitedtimediscount/goods-detail.qml" />
    <template is="limitedtimediscount" data="{{plugins_limitedtimediscount_data: plugins_limitedtimediscount_data, plugins_limitedtimediscount_is_show_time: plugins_limitedtimediscount_is_show_time, plugins_limitedtimediscount_time_millisecond: plugins_limitedtimediscount_time_millisecond}}"></template>
  </view>

  <!-- 基础信息 -->
  <view class="goods-base bg-white">
    <view class="goods-price single-text">
      <view class="goods-share tc">
        <button type="default" size="mini" open-type="share" hover-class="none">
          <image src="/images/goods-detail-share-icon.png" mode="scaleToFill" class="dis-block" />
          <view class="cr-888">分享</view>
        </button>
      </view>
      <text qq:if="{{(show_field_price_text || null) != null}}" class="price-icon">{{show_field_price_text}}</text>
      <text class="sales-price">{{currency_symbol}}{{goods.price}}</text>
      <view qq:if="{{(goods.original_price || null) != null && goods.original_price != '0.00'}}" class="original-price">{{currency_symbol}}{{goods.original_price}}</view>
    </view>
    <view class="base-grid br-t-dashed oh">
      <view class="fl tl">
        <text class="cr-888">累计销量</text>
        <text class="cr-main">{{goods.sales_count}}</text>
      </view>
      <view class="fl tc">
        <text class="cr-888">浏览次数</text>
        <text class="cr-main">{{goods.access_count}}</text>
      </view>
      <view class="fl tr">
        <navigator url="/pages/goods-comment/goods-comment?goods_id={{goods.id}}" hover-class="none">
          <text class="cr-888">累计评论</text>
          <text class="cr-main">{{goods.comments_count}}</text>
        </navigator>
      </view>
    </view>
  </view>

  <!-- 商品基础参数 -->
  <view qq:if="{{(goods.parameters || null) != null && goods.parameters.base.length > 0}}" class="goods-parameters parameters-base br-t-dashed bg-white">
    <view class="content-item oh">
      <block qq:for="{{goods.parameters.base}}" qq:key="item">
        <view class="item single-text">
          <text class="name">{{item.name}}:</text>
          <text class="value">{{item.value}}</text>
        </view>
      </block>
    </view>
  </view>

  <!-- 优惠劵 -->
  <view qq:if="{{(plugins_coupon_data || null) != null && plugins_coupon_data.data.length > 0}}" class="coupon-container wh-auto spacing-mt bg-white">
    <scroll-view scroll-x="true">
      <block qq:for="{{plugins_coupon_data.data}}" qq:key="item">
        <view class="item bg-white {{item.is_operable == 0 ? 'item-disabled' : ''}}" style="border:1px solid {{item.bg_color_value}};">
          <view class="v-left fl">
            <view class="base single-text" style="color:{{item.bg_color_value}};">
              <text qq:if="{{item.type == 0}}" class="symbol">{{currency_symbol}}</text>
              <text class="price">{{item.discount_value}}</text>
              <text class="unit">{{item.type_unit}}</text>
            </view>
            <view qq:if="{{(item.use_limit_type_name || null) != null}}" class="base-tips cr-666 single-text">{{item.use_limit_type_name}}</view>
            <view qq:if="{{(item.desc || null) != null}}" class="desc cr-888 single-text">{{item.desc}}</view>
          </view>
          <view class="v-right fr" bindtap="coupon_receive_event" data-index="{{index}}" data-value="{{item.id}}" style="background:{{item.bg_color_value}};">
            <text class="circle"></text>
            <text>{{item.is_operable_name}}</text>
          </view>
        </view>
      </block>
    </scroll-view>
  </view>

  <!-- 商品详情参数 -->
  <view qq:if="{{(goods.parameters || null) != null && goods.parameters.detail.length > 0}}" class="goods-parameters spacing-mt bg-white">
    <view class="spacing-nav-title">
      <text class="line"></text>
      <text class="text-wrapper">商品参数</text>
    </view>
    <view class="content-item oh">
      <block qq:for="{{goods.parameters.detail}}" qq:key="item">
        <view class="item single-text">
          <text class="name">{{item.name}}:</text>
          <text class="value">{{item.value}}</text>
        </view>
      </block>
    </view>
  </view>

  <!-- 商品详情 -->
  <view class="goods-detail spacing-mt bg-white">
    <view class="spacing-nav-title">
      <text class="line"></text>
      <text class="text-wrapper">商品详情</text>
    </view>
    <view class="spacing">
      <!-- 是否详情展示相册 -->
      <block qq:if="{{common_is_goods_detail_show_photo == 1 && goods_photo.length > 0}}">
        <view qq:for="{{goods_photo}}" qq:key="key" class="goods-detail-photo">
          <image qq:if="{{(item.images || null) != null}}" bindtap="goods_detail_images_view_event" data-value="{{item.images}}" class="wh-auto dis-block" src="{{item.images}}" mode="widthFix" />
        </view>
      </block>
      <!-- web详情 -->
      <view qq:if="{{common_app_is_use_mobile_detail == 0}}">
        <rich-text nodes="{{goods.content_web || ''}}"></rich-text>
      </view>
      <!-- 手机独立详情 -->
      <block qq:if="{{common_app_is_use_mobile_detail == 1 && goods_content_app.length > 0}}">
        <view qq:for="{{goods_content_app}}" qq:key="key" class="goods-detail-app">
            <image qq:if="{{(item.images || null) != null}}" bindtap="goods_detail_images_view_event" data-value="{{item.images}}" class="wh-auto dis-block" src="{{item.images}}" mode="widthFix" />
            <view qq:if="{{(item.content || null) != null}}" class="content-items">
              <view qq:for="{{item.content}}" qq:for-item="items">{{items}}</view>
            </view>
        </view>
      </block>
    </view>
  </view>

  <!-- 底线 -->
  <import src="/pages/common/bottom_line.qml" />
  <template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>

  <!-- 底部操作 -->
  <view class="goods-buy-nav wh-auto bg-white">
    <view class="shop fl tc br-t" bindtap="shop_event">
      <image src="/images/goods-detail-home-icon.png" mode="scaleToFill" />
      <text class="dis-block cr-888">首页</text>
    </view>
    <view class="collect fl tc br-t" bindtap="goods_favor_event">
      <image src="{{goods_favor_icon}}" mode="scaleToFill" />
      <text class="dis-block cr-888">{{goods_favor_text}}</text>
    </view>
    <view class="fr goods-buy-nav-btn-number-{{buy_button.count || 0}}">
      <block qq:if="{{(buy_button.data || null) != null && buy_button.data.length > 0}}">
        <block qq:for="{{buy_button.data}}" qq:key="key">
          <block qq:if="{{(item.name || null) != null && (item.type || null) != null}}">
            <button class="fl bg-{{(item.color || 'main') == 'main' ? 'main' : 'warning'}}" type="default" bindtap="nav_buy_submit_event" data-type="{{item.type}}" data-value="{{item.value || ''}}" hover-class="none">{{item.name}}</button>
          </block>
        </block>
      </block>
      <block qq:else>
        <view class="goods-not-buy-tips tc">{{buy_button.error || '暂停销售'}}</view>
      </block>
    </view>
  </view>

  <!-- 购买弹层 -->
  <component-popup prop-show="{{popup_status}}" prop-position="bottom" bindonclose="popup_close_event">
    <view class="goods-popup bg-white">
      <view class="close fr oh">
        <view class="fr" catchtap="popup_close_event">
          <icon type="clear" size="20" />
        </view>
      </view>
      <!-- 规格基础信息 -->
      <view class="goods-popup-base oh br-b">
        <image src="{{goods_spec_base_images}}" mode="scaleToFill" class="br" bindtap="goods_detail_images_view_event" data-value="{{goods_spec_base_images}}" />
        <view class="goods-popup-base-content">
          <view class="goods-price">
            <view class="sales-price">{{currency_symbol}}{{goods_spec_base_price}}</view>
            <view qq:if="{{(goods_spec_base_original_price || null) != null && goods_spec_base_original_price > 0}}" class="original-price">{{currency_symbol}}{{goods_spec_base_original_price}}</view>
          </view>
          <view class="inventory">
            <text class="cr-888">库存</text>
            <text class="cr-666">{{goods_spec_base_inventory}}</text>
            <text class="cr-888">{{goods.inventory_unit}}</text>
          </view>
        </view>
      </view>

      <view class="goods-popup-content">
        <!-- 商品规格 -->
        <view qq:if="{{goods_specifications_choose.length > 0}}" class="goods-spec-choose">
          <view qq:for="{{goods_specifications_choose}}" qq:key="key" qq:for-index="key" class="item br-b">
            <view class="title">{{item.name}}</view>
            <view qq:if="{{item.value.length > 0}}" class="spec">
              <block qq:for="{{item.value}}" qq:key="key" qq:for-index="keys" qq:for-item="items">
                <button catchtap="goods_specifications_event" data-key="{{key}}" data-keys="{{keys}}" type="default" size="mini" hover-class="none" class="{{items.is_active}} {{items.is_dont}} {{items.is_disabled}}">
                  <image qq:if="{{(items.images || null) != null}}" src="{{items.images}}" mode="scaleToFill" />
                  {{items.name}}
                </button>
              </block>
            </view>
          </view>
        </view>

        <!-- 购买数量 -->
        <view class="goods-buy-number oh">
          <view class="title fl">购买数量</view>
          <view class="number-content tc oh">
            <view bindtap="goods_buy_number_event" class="number-submit tc cr-888 fl" data-type="0">-</view>
            <input bindblur="goods_buy_number_blur" class="tc cr-888 fl" type="number" value="{{temp_buy_number}}" />
            <view bindtap="goods_buy_number_event" class="number-submit tc cr-888 fl" data-type="1">+</view>
          </view>
        </view>
      </view>
      <button class="goods-popup-submit bg-main" type="default" catchtap="goods_buy_confirm_event" hover-class="none">确定</button>
    </view>
  </component-popup>
</view>

<view qq:if="{{goods == null}}">
    <import src="/pages/common/nodata.qml" />
    <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>

<!-- 在线客服 -->
<view qq:if="{{common_app_is_online_service == 1}}">
  <import src="/pages/lib/online-service/content.qml" />
  <template is="online_service"></template>
</view>

<!-- 购物车 -->
<navigator url="/pages/cart/cart" open-type="switchTab" hover-class="none">
  <view class="common-quick-nav quick-nav-cart">
    <view class="badge-icon">
      <component-badge prop-number="{{quick_nav_cart_count}}"></component-badge>
    </view>
    <image src="/images/default-cart-icon.png" class="dis-block"></image>
  </view>
</navigator>

<!-- 快捷导航 -->
<component-quick-nav></component-quick-nav>