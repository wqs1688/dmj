<view qq:if="{{propNumber > 0}}" class="am-badge">
  <view class="am-badge-text {{(propNumber > 99) ? 'am-badge-text-max' : ''}}">
    <text>{{(propNumber > 99) ? '99+' : propNumber}}</text>
  </view>
</view>