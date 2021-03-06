<image qq:if="{{(data_base || null) != null && (data_base.banner_images || null) != null}}" class="banner wh-auto dis-block" src="{{data_base.banner_images}}" mode="widthFix" />

<!-- 优惠劵列表 -->
<view qq:if="{{data_list.length > 0}}" class="coupon-container">
  <block qq:for="{{data_list}}" qq:key="item">
    <view class="item spacing-mt bg-white {{item.is_operable == 0 ? 'item-disabled' : ''}}" style="border:1px solid {{item.bg_color_value}};">
      <view class="v-left fl">
        <view class="base single-text" style="color:{{item.bg_color_value}};">
          <text qq:if="{{item.type == 0}}" class="symbol">{{currency_symbol}}</text>
          <text class="price">{{item.discount_value}}</text>
          <text class="unit">{{item.type_unit}}</text>
          <text qq:if="{{(item.desc || null) != null}}" class="desc cr-888">{{item.desc}}</text>
        </view>
        <view qq:if="{{(item.use_limit_type_name || null) != null}}" class="base-tips cr-666 single-text">{{item.use_limit_type_name}}</view>
      </view>
      <view class="v-right fr" bindtap="coupon_receive_event" data-index="{{index}}" data-value="{{item.id}}" style="background:{{item.bg_color_value}};">
        <text class="circle"></text>
        <text>{{item.is_operable_name}}</text>
      </view>
    </view>
  </block>
</view>

<view qq:if="{{data_list_loding_status != 3}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>

<import src="/pages/common/bottom_line.qml" />
<template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>