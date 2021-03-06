<template name="limitedtimediscount">
  <view class="limitedtimediscount">
    <view class="countdown">
      <image class="icon" src="/images/plugins/limitedtimediscount/detail-icon.png" mode="aspectFit"></image>
      <text class="text-title"> {{plugins_limitedtimediscount_data.title || '限时秒杀'}}</text>
      <view class="time-right fr">
        <block qq:if="{{plugins_limitedtimediscount_is_show_time}}">
          <view class="timer-hours millisecond fr">{{plugins_limitedtimediscount_time_millisecond}}</view>
          <view class="ds fr">秒</view>
          <view class="timer-hours seconds fr">{{plugins_limitedtimediscount_data.time.seconds}}</view>
          <view class="ds fr">分</view>
          <view class="timer-hours minutes fr">{{plugins_limitedtimediscount_data.time.minutes}}</view>
          <view class="ds fr">时</view>
          <view class="timer-hours hours fr">{{plugins_limitedtimediscount_data.time.hours}}</view>
        </block>
        <view class="timer-title fr">{{plugins_limitedtimediscount_data.desc || '距离结束还有'}}</view>
      </view>
    </view>
  </view>
</template>