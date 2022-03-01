<!-- 货币列表 -->
<view qq:if="{{data_list.length > 0}}" class="exchangerate-container">
  <block qq:for="{{data_list}}" qq:key="item">
    <view class="item oh spacing-mb bg-white" bindtap="selected_event" data-index="{{index}}">
      <view qq:if="{{common_site_type != 1}}"  class="fl icon">
        <image src="/images/default-select{{item.id == data_default.id ? '-active' : ''}}-icon.png" mode="widthFix" />
      </view>
      <view class="fl single-text {{item.id == data_default.id ? 'cr-main' : 'cr-666'}}">{{item.name}} / {{item.symbol}}</view>
    </view>
  </block>
</view>

<view qq:if="{{data_list_loding_status != 3}}">
  <import src="/pages/common/nodata.qqml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>

<import src="/pages/common/bottom_line.qqml" />
<template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>