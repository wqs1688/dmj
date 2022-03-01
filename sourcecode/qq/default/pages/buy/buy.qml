<block qq:if="{{common_site_type == 1}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: 2, msg: '展示型不允许提交订单'}}"></template>
</block>
<block qq:else>
  <view qq:if="{{goods_list.length > 0}}" class="page">
    <!-- 销售+自提 模式选择 -->
    <view qq:if="{{common_site_type == 4}}" class="buy-header-nav oh tc">
      <block qq:for="{{buy_header_nav}}" qq:key="key">
        <view class="item fl {{site_model == item.value ? 'cr-main' : 'cr-666'}}" data-value="{{item.value}}" bindtap="buy_header_nav_event">{{item.name}}</view>
      </block>
    </view>

    <!-- 地址 -->
    <block qq:if="{{common_site_type == 0 || common_site_type == 2 || common_site_type == 4}}">
      <view class="address bg-white arrow-right" bindtap="address_event">
        <view qq:if="{{address != null}}">
          <view class="address-base oh">
            <text qq:if="{{(address.alias || null) != null}}" class="address-alias">{{address.alias}}</text>
            <text>{{address.name}}</text>
            <text class="fr">{{address.tel}}</text>
          </view>
          <view class="address-detail oh">
            <image class="icon fl" src="/images/user-address.png" mode="widthFix" />
            <view class="text fr">{{address.province_name || ''}}{{address.city_name || ''}}{{address.county_name || ''}}{{address.address || ''}}</view>
          </view>
        </view>
        <view qq:if="{{address == null}}" class="no-address cr-888">
          {{(common_site_type == 0 || (common_site_type == 4 && site_model == 0)) ? '请选择收货地址' : '请选择取货地址'}}
        </view>
      </view>
      <view class="address-divider spacing-mb"></view>
    </block>

    <!-- 商品数据 -->
    <view class="goods-group-list bg-white spacing-mb" qq:for="{{goods_list}}" qq:for-item="group" qq:key="key">
      <!-- 仓库分组 -->
      <view class="goods-group-hd oh br-b">
        <view class="fl">
          <text class="goods-group-title">{{group.name}}</text>
          <text qq:if="{{(group.alias || null) != null}}" class="goods-group-alias">{{group.alias}}</text>
        </view>
        <view qq:if="{{(group.lng || null) != null && (group.lat || null) != null}}" class="fr">
          <view class="goods-group-map-submit br" data-index="{{index}}" bindtap="map_event">查看地图</view>
        </view>
      </view>
      <!-- 商品 -->
      <view qq:for="{{group.goods_items}}" qq:key="keys" class="goods-item oh">
        <image class="goods-image fl" src="{{item.images}}" mode="aspectFill" />
        <view class="goods-base">
          <view class="goods-title multi-text">{{item.title}}</view>
          <block qq:if="{{item.spec != null}}">
            <view class="goods-spec cr-888" qq:for="{{item.spec}}" qq:key="key" qq:for-item="spec">{{spec.type}}:{{spec.value}}
            </view>
          </block>
        </view>
        <view class="oh goods-price">
          <text class="sales-price">{{currency_symbol}}{{item.price}}
          </text>
          <text qq:if="{{item.original_price > 0}}" class="original-price">{{currency_symbol}}{{item.original_price}}
          </text>
          <text class="buy-number cr-888">x{{item.stock}}
          </text>
        </view>
      </view>
      <!-- 优惠劵 -->
      <view qq:if="{{(plugins_coupon_data || null) != null && (plugins_coupon_data[index] || null) != null && (plugins_coupon_data[index].coupon_data || null) != null && (plugins_coupon_data[index].coupon_data.coupon_list || null) != null && plugins_coupon_data[index].coupon_data.coupon_list.length > 0}}" class="plugins-coupon bg-white spacing-mb arrow-right" data-index="{{index}}" bindtap="plugins_coupon_open_event">
        <text class="cr-666">优惠劵</text>
        <text class="cr-ccc fr">{{((plugins_choice_coupon_value || null) != null && (plugins_choice_coupon_value[group.id] || null) != null) ? plugins_choice_coupon_value[group.id] : '请选择优惠券'}}</text>
      </view>
      <!-- 扩展数据展示 -->
      <view qq:if="{{group.order_base.extension_data.length > 0}}" class="extension-list spacing-mt">
        <view qq:for="{{group.order_base.extension_data}}" qq:key="key" class="item oh">
          <text class="cr-666 fl">{{item.name}}
          </text>
          <text class="text-tips fr">{{item.tips}}
          </text>
        </view>
      </view>
      <!-- 小计 -->
      <view class="oh tr goods-group-footer spacing-mt spacing-mb">
        <text qq:if="{{group.order_base.total_price != group.order_base.actual_price}}" class="original-price">{{currency_symbol}}{{group.order_base.total_price}}</text>
        <text class="sales-price">{{currency_symbol}}{{group.order_base.actual_price}}</text>
      </view>
    </view>

    <!-- 留言 -->
    <view class="content-textarea-container bg-white spacing-mb">
      <textarea qq:if="{{user_note_status}}" bindblur="bind_user_note_blur_event" bindinput="bind_user_note_event" focus="{{true}}" value="{{user_note_value}}" maxlength="60" placeholder="留言" />
      <view qq:else bindtap="bind_user_note_tap_event" class="{{(user_note_value || null) == null ? 'cr-888' : ''}}">{{user_note_value || '留言'}}</view>
    </view>

    <!-- 积分 -->
    <view qq:if="{{(plugins_points_data || null) != null && (plugins_points_data.discount_price || 0) > 0}}" class="plugins-points-buy-container bg-white spacing-mb">
      <view class="select oh">
        <text qq:if="{{plugins_points_data.discount_type == 1}}">使用{{plugins_points_data.use_integral}}个积分兑换商品</text>
        <text qq:else>使用积分{{plugins_points_data.use_integral}}个</text>
        <text class="sales-price">-{{currency_symbol}}{{plugins_points_data.discount_price}}</text>
        <view bindtap="points_event" class="fr">
          <image class="icon" src="/images/default-select{{plugins_points_status ? '-active' : ''}}-icon.png" mode="widthFix" />
        </view>
      </view>
      <view class="desc">
        <text qq:if="{{plugins_points_data.discount_type == 1}}">你有积分{{plugins_points_data.user_integral}}个</text>
        <text qq:else>你有积分{{plugins_points_data.user_integral}}个，可用{{plugins_points_data.use_integral}}个</text>
      </view>
    </view>

    <!-- 支付方式 -->
    <view qq:if="{{payment_list.length > 0 && common_order_is_booking != 1}}" class="payment-list bg-white oh">
      <view class="item tc fl" qq:for="{{payment_list}}" qq:key="key">
        <view class="item-content br {{(item.selected || '')}}" data-value="{{item.id}}" bindtap="payment_event">
          <image qq:if="{{(item.logo || null) != null}}" class="icon" src="{{item.logo}}" mode="widthFix" />
          <text>{{item.name}}</text>
        </view>
      </view>
    </view>

    <!-- 导航 -->
    <view class="buy-nav oh wh-auto">
      <view class="nav-base bg-white fl br-t single-text">
        <text>合计：</text>
        <text class="sales-price">{{currency_symbol}}{{total_price}}</text>
      </view>
      <view class="fr nav-submit">
        <button class="bg-main wh-auto" type="default" bindtap="buy_submit_event" disabled="{{buy_submit_disabled_status}}" hover-class="none">提交订单</button>
      </view>
    </view>
  </view>

  <view qq:if="{{goods_list.length == 0}}">
      <import src="/pages/common/nodata.qml" />
      <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
  </view>

  <!-- 优惠劵选择 -->
  <component-popup prop-show="{{popup_plugins_coupon_status}}" prop-position="bottom" bindonclose="plugins_coupon_close_event">
    <qs src="../../utils/tools.qs" module="tools" />
    <view class="plugins-coupon-popup bg-white">
      <view class="close oh">
        <view class="fr" catchtap="plugins_coupon_close_event">
          <icon type="clear" size="20" />
        </view>
      </view>
      <view qq:if="{{popup_plugins_coupon_index != null &&  (plugins_coupon_data || null) != null && (plugins_coupon_data[popup_plugins_coupon_index] || null) != null && (plugins_coupon_data[popup_plugins_coupon_index].coupon_data || null) != null && (plugins_coupon_data[popup_plugins_coupon_index].coupon_data.coupon_list || null) != null && plugins_coupon_data[popup_plugins_coupon_index].coupon_data.coupon_list.length > 0}}" class="coupon-container oh br-b">
        <view class="not-use-tips tc">
          <text data-wid="{{plugins_coupon_data[popup_plugins_coupon_index].warehouse_id}}" bindtap="plugins_coupon_not_use_event">不使用优惠劵</text>
        </view>
        <block qq:for="{{plugins_coupon_data[popup_plugins_coupon_index].coupon_data.coupon_list}}" qq:key="item">
          <view class="item spacing-mt bg-white {{tools.indexOf(plugins_use_coupon_ids, item.id) ? 'item-disabled' : ''}}" style="border:1px solid {{item.coupon.bg_color_value}};">
            <view class="v-left fl">
              <view class="base single-text" style="color:{{item.coupon.bg_color_value}};">
                <text qq:if="{{item.coupon.type == 0}}" class="symbol">{{currency_symbol}}</text>
                <text class="price">{{item.coupon.discount_value}}</text>
                <text class="unit">{{item.coupon.type_unit}}</text>
                <text qq:if="{{(item.coupon.desc || null) != null}}" class="desc cr-888">{{item.coupon.desc}}</text>
              </view>
              <view qq:if="{{(item.coupon.use_limit_type_name || null) != null}}" class="base-tips cr-666 single-text">{{item.coupon.use_limit_type_name}}</view>
              <view class="base-time cr-888 single-text">{{item.time_start_text}} 至 {{item.time_end_text}}</view>
            </view>
            <view class="v-right fr" style="background:{{item.coupon.bg_color_value}};" data-wid="{{plugins_coupon_data[popup_plugins_coupon_index].warehouse_id}}" data-value="{{item.id}}" bindtap="plugins_coupon_use_event">
              <text class="circle"></text>
              <text>{{tools.indexOf(plugins_use_coupon_ids, item.id) ? '已选' : '选择'}}</text>
            </view>
          </view>
        </block>
      </view>
    </view>
  </component-popup>
</block>

<!-- 快捷导航 -->
<component-quick-nav></component-quick-nav>