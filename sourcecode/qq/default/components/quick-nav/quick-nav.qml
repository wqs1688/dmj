<!-- 开启事件 -->
<movable-area qq:if="{{quick_status == 1}}" class="quick-nav-movable-container">
  <movable-view direction="all" x="{{x}}" y="{{y}}" animation="{{false}}" class="quick-nav-event-submit" bindtap="quick_open_event">
    <image src="/images/quick-submit-icon.png" mode="widthFix"></image>
  </movable-view>
</movable-area>

<!-- 弹窗 -->
<component-popup prop-show="{{popup_status}}" prop-position="bottom" bindonclose="quick_close_event">
  <view class="quick-nav-popup-container">
    <view class="close oh">
      <view class="icon-right" catchtap="quick_close_event">
        <icon type="clear" size="20" />
      </view>
    </view>
    <view class="quick-nav-popup-content">
      <view qq:if="{{data_list.length > 0}}" class="quick-nav-data-list">
        <view class="items" qq:for="{{data_list}}" qq:key="key">
          <view class="items-content" data-value="{{item.event_value}}" data-type="{{item.event_type}}" bindtap="navigation_event" style="background-color:{{item.bg_color}}">
            <image src="{{item.images_url}}" mode="aspectFit" />
          </view>
          <view class="title">{{item.name}}</view>
        </view>
      </view>
      <view qq:else>
        <import src="/pages/common/nodata.qml" />
        <template is="nodata" data="{{status: 0}}"></template>
      </view>
    </view>
  </view>
</component-popup>