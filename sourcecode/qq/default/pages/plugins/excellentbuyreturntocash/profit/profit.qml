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
        <text class="cr-666">{{item.add_time}}</text>
        <text class="fr cr-main">{{item.status_name}}</text>
      </view>
      <navigator url="/pages/plugins/excellentbuyreturntocash/profit-detail/profit-detail?id={{item.id}}" hover-class="none">
        <view class="content">
          <view class="single-text">
            <text class="title cr-666">订单金额</text>
            <text class="value">{{item.total_price}}</text>
            <text class="unit cr-888">元</text>
          </view>
          <view class="single-text">
            <text class="title cr-666">退款金额</text>
            <text class="value">{{item.refund_price}}</text>
            <text class="unit cr-888">元</text>
          </view>
          <view class="single-text">
            <text class="title cr-666">有效金额</text>
            <text class="value">{{item.valid_price}}</text>
            <text class="unit cr-888">元</text>
          </view>
          <view class="single-text">
            <text class="title cr-666">返现金额</text>
            <text class="value">{{item.profit_price}}</text>
            <text class="unit cr-888">元</text>
          </view>
        </view>
      </navigator>
      <view class="operation tr br-t-dashed">
        <button class="br" type="default" size="mini" hover-class="none" data-oid="{{item.order_id}}" bindtap="list_submit_order_event">查看订单</button>
        <button qq:if="{{item.status == 2}}" class="settlement-submit" type="default" size="mini" hover-class="none" data-index="{{index}}" bindtap="list_submit_settlement_event">立即结算</button>
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