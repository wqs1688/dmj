<template name="limitedtimediscount">
  <view qq:if="{{plugins_limitedtimediscount_data.goods.length > 0}}" class="limitedtimediscount">
    <view class="nav-title">
      <image class="nav-icon" src="/images/plugins/limitedtimediscount/nav-icon.png" mode="aspectFit"></image>
      <text class="text-wrapper">限时秒杀</text>
      <view class="countdown">
        <block qq:if="{{plugins_limitedtimediscount_is_show_time}}">
          <view class="timer-hours seconds">{{plugins_limitedtimediscount_data.time.seconds}}</view>
          <view class="ds">:</view>
          <view class="timer-hours minutes">{{plugins_limitedtimediscount_data.time.minutes}}</view>
          <view class="ds">:</view>
          <view class="timer-hours hours">{{plugins_limitedtimediscount_data.time.hours}}</view>
        </block>
        <view class="timer-title">{{plugins_limitedtimediscount_timer_title}}</view>
      </view>
    </view>
    <view class="goods-list">
      <scroll-view scroll-x>
        <view qq:for="{{plugins_limitedtimediscount_data.goods}}" qq:key="key" class="item">
          <navigator url="/pages/goods-detail/goods-detail?goods_id={{item.goods_id}}" hover-class="none">
            <image class="dis-block" src="{{item.images}}" mode="aspectFit"></image>
            <view class="goods-base">
              <view class="goods-title multi-text">{{item.title}}</view>
              <view class="goods-price single-text">{{currency_symbol}}{{item.price}}</view>
              <view qq:if="{{(item.original_price || null) != null}}" class="goods-original-price single-text">{{currency_symbol}}{{item.original_price}}</view>
              <button size="mini">抢购</button>
            </view>
          </navigator>
        </view>
      </scroll-view>
    </view>
  </view>
</template>