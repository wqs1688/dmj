<view qq:if="{{is_show_open_setting}}" class="open-setting-view">
  <view class="content bg-white">
    <view class="msg cr-888">开启相应的权限服务</view>
    <view class="value cr-666">获取[ <text>位置信息</text> ]权限</view>
    <button type="primary" open-type="openSetting" size="mini" bindopensetting="setting_callback_event">打开设置页</button>    
  </view>
</view>
<view qq:else class="open-setting-loding">
  <image src="/images/default-bg-loding.gif" class="avatar dis-block" mode="widthFix" />
</view>