<qs src="../../../../utils/tools.qs" module="tools" />
<scroll-view scroll-y="{{true}}" class="scroll-box" bindscrolltolower="scroll_lower" lower-threshold="30">
  <view class="data-list">
    <block qq:if="{{data_list.length > 0}}">
      <view class="item bg-white spacing-mb" qq:for="{{data_list}}" qq:key="key">
        <view class="base oh br-b">
          <view bindtap="selected_event" data-type="node" data-value="{{item.id}}" class="fl selected">
            <image class="icon" src="/images/default-select{{tools.indexOf(select_ids, item.id) ? '-active' : ''}}-icon.png" mode="widthFix" />
          </view>
          <text class="cr-666">{{item.add_time}}</text>
        </view>
        <navigator url="/pages/user-order-detail/user-order-detail?id={{item.id}}" hover-class="none">
          <view class="content">
            <view class="single-text">
              <text class="title cr-666">订单编号</text>
              <text class="value">{{item.order_no}}</text>
            </view>
            <view class="single-text">
              <text class="title cr-666">订单总价</text>
              <text class="value">{{item.total_price}}</text>
              <text class="unit cr-888">元</text>
            </view>
            <view class="single-text">
              <text class="title cr-666">支付金额</text>
              <text class="value">{{item.pay_price}}</text>
              <text class="unit cr-888">元</text>
            </view>
            <view class="single-text">
              <text class="title cr-666">订单单价</text>
              <text class="value">{{item.price}}</text>
              <text class="unit cr-888">元</text>
            </view>
          </view>
        </navigator>
        <view class="operation tr br-t-dashed">
          <navigator url="/pages/plugins/invoice/invoice-saveinfo/invoice-saveinfo?ids={{item.id}}&type=order&is_redirect=1" hover-class="none">
            <button class="cr-666 br" type="default" size="mini" hover-class="none">开票</button>
          </navigator>
        </view>
      </view>
    
      <!-- 合并开票 -->
      <view qq:if="{{select_ids.length > 0}}">
        <button class="submit-fixed invoice-merge-submit" type="default" size="mini" hover-class="none" bindtap="invoice_merge_event">合并开票</button>
      </view>
  </block>

    <view qq:if="{{data_list.length == 0}}">
      <import src="/pages/common/nodata.qml" />
      <template is="nodata" data="{{status: data_list_loding_status}}">
      </template>
    </view>

    <import src="/pages/common/bottom_line.qml" />
    <template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>
  </view>
</scroll-view>