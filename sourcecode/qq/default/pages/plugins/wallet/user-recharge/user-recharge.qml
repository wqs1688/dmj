<!-- 导航 -->
<view class="nav">
  <block qq:for="{{nav_status_list}}" qq:key="key">
    <view class="item fl tc cr-888 {{nav_status_index == index ? 'active' : ''}}" data-index="{{index}}" bindtap="nav_event">{{item.name}}</view>
  </block>
</view>

<!-- 列表 -->
<scroll-view scroll-y="{{true}}" class="scroll-box" bindscrolltolower="scroll_lower" lower-threshold="30">
  <view class="data-list">
    <view class="item bg-white spacing-mb" qq:if="{{data_list.length > 0}}" qq:for="{{data_list}}" qq:key="key">
      <view class="base oh br-b">
        <text class="cr-666">{{item.add_time_time}}</text>
        <text class="fr cr-main">{{item.status_name}}</text>
      </view>
      <navigator url="/pages/plugins/wallet/user-recharge-detail/user-recharge-detail?id={{item.id}}" hover-class="none">
        <view class="content">
          <view class="single-text">
            <text class="title cr-666">充值单号</text>
            <text class="value">{{item.recharge_no}}</text>
          </view>
          <view class="single-text">
            <text class="title cr-666">充值金额</text>
            <text class="value">{{item.money}}</text>
            <text class="unit cr-888">元</text>
          </view>
          <view class="single-text">
            <text class="title cr-666">支付金额</text>
            <text class="value">{{item.pay_money}}</text>
            <text class="unit cr-888">元</text>
          </view>
        </view>
      </navigator>
      <view qq:if="{{item.status == 0}}" class="operation tr br-t-dashed">
        <button class="submit-pay cr-666 br" type="default" size="mini" bindtap="pay_event" data-value="{{item.id}}" data-index="{{index}}" hover-class="none">支付</button>
        <button class="submit-delete cr-666 br" type="default" size="mini" bindtap="delete_event" data-value="{{item.id}}" data-index="{{index}}" hover-class="none">删除</button>
      </view>
    </view>

    <view qq:if="{{data_list.length == 0}}">
      <import src="/pages/common/nodata.qml" />
      <template is="nodata" data="{{status: data_list_loding_status}}">
      </template>
    </view>

    <import src="/pages/common/bottom_line.qml" />
    <template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>
  </view>
</scroll-view>

<!-- 支付方式 popup -->
<component-popup prop-show="{{is_show_payment_popup}}" prop-position="bottom" bindonclose="payment_popup_event_close">
  <view qq:if="{{payment_list.length > 0}}" class="payment-list oh bg-white">
    <view class="item tc fl" qq:for="{{payment_list}}" qq:key="key">
      <view class="item-content br" data-value="{{item.id}}" bindtap="popup_payment_event">
        <image qq:if="{{(item.logo || null) != null}}" class="icon" src="{{item.logo}}" mode="widthFix" />
        <text>{{item.name}}
        </text>
      </view>
    </view>
  </view>
  <view qq:else class="payment-list oh bg-white tc cr-888">没有支付方式</view>
</component-popup>