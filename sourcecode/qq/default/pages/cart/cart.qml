<view qq:if="{{data_list.length > 0}}" class="page">
  <view qq:for="{{data_list}}" qq:key="key" class="goods-item oh bg-white {{common_site_type == 1 ? 'exhibition-mode-data' : ''}}">
    <!-- 选择 -->
    <view qq:if="{{common_site_type != 1}}" bindtap="selected_event" data-type="node" data-index="{{index}}" class="fl selected">
      <image class="icon" src="/images/default-select{{(item.is_error || 0) == 1 ? '-disabled' : ((item.selected || false) ? '-active' : '')}}-icon.png" mode="widthFix" />
    </view>

    <view class="bg-white items">
      <!-- 图片/链接 -->
      <navigator url="/pages/goods-detail/goods-detail?goods_id={{item.goods_id}}">
        <image class="goods-image fl" src="{{item.images}}" mode="aspectFill" />
      </navigator>

      <!-- 基础 -->
      <view class="goods-base">
        <view class="goods-title multi-text">{{item.title}}
        </view>
        <block qq:if="{{item.spec != null}}">
          <view class="goods-spec cr-888" qq:for="{{item.spec}}" qq:key="key" qq:for-item="spec">{{spec.type}}:{{spec.value}}</view>
        </block>
      </view>
      <!-- 数量 -->
      <view class="number-content tc oh">
        <view  bindtap="goods_buy_number_event" class="number-submit tc cr-888 fl" data-index="{{index}}" data-type="0">-</view>
        <input  bindblur="goods_buy_number_blur" class="tc cr-888 fl" type="number" value="{{item.stock}}" data-index="{{index}}" />
        <view  bindtap="goods_buy_number_event" class="number-submit tc cr-888 fl" data-index="{{index}}" data-type="1">+</view>
      </view>

      <!-- 价格 -->
      <view class="oh goods-price">
        <text class="sales-price">{{currency_symbol}}{{item.price}}</text>
        <text qq:if="{{item.original_price > 0}}" class="original-price">{{currency_symbol}}{{item.original_price}}</text>
        <text class="buy-number cr-888">x{{item.stock}}</text>

        <!-- 错误 -->
        <text qq:if="{{(item.is_error || 0) == 1}}" class="error-msg">{{item.error_msg}}</text>

        <!-- 移除 -->
        <view class="fr remove" data-id="{{item.id}}" data-goodsid="{{item.goods_id}}" data-index="{{index}}" bindtap="cart_remove_event">移除</view>
      </view>
    </view>
  </view>

  <!-- 操作导航 -->
  <view qq:if="{{data_list.length > 0}}" class="buy-nav oh wh-auto">
    <!-- 展示型 -->
    <block qq:if="{{common_site_type == 1}}">
      <view class="exhibition-mode">
        <button class="bg-main wh-auto" type="default" bindtap="exhibition_submit_event" hover-class="none">{{common_is_exhibition_mode_btn_text}}</button>
      </view>
    </block>

    <!-- 销售,自提,虚拟销售 -->
    <block qq:else>
      <view class="nav-base bg-white fl br-t single-text">
        <view bindtap="selected_event" data-type="all" class="fl selected">
          <image class="icon" src="/images/default-select{{is_selected_all ? '-active' : ''}}-icon.png" mode="widthFix" />
          <text>全选</text>
        </view>
        <view class="fr price">
          <view class="sales-price single-text fr">{{currency_symbol}}{{total_price}}</view>
          <view class="fr">合计：</view>
        </view>
      </view>
      <view class="fr nav-submit">
        <button class="bg-main wh-auto" type="default" bindtap="buy_submit_event" disabled="{{buy_submit_disabled_status}}" hover-class="none">结算</button>
      </view>
    </block>
  </view>
</view>

<!-- 空购物车 -->
<view qq:if="{{data_list.length == 0 && data_list_loding_status == 0}}" class="no-data-box tc">
  <image src="/images/default-cart-empty.png" mode="widthFix" />
  <view class="no-data-tips">{{data_list_loding_msg || '购物车空空如也'}}</view>
  <navigator url="/pages/index/index" open-type="switchTab"  hover-class="none">
    <button type="default" class="my-btn-default" hover-class="none">去逛逛</button>
  </navigator>
</view>

<view qq:if="{{data_list.length == 0 && data_list_loding_status != 0}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>

<!-- 快捷导航 -->
<component-quick-nav></component-quick-nav>