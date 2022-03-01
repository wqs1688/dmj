<view class="page">
  <view qq:if="{{data_list.length > 0}}">
    <view class="item bg-white spacing-mb" qq:for="{{data_list}}" qq:key="key">
      <view bindtap="address_conent_event" data-index="{{index}}">
        <view class="base oh">
          <text qq:if="{{(item.alias || null) != null}}" class="address-alias">{{item.alias}}</text>
          <text>{{item.name}}</text>
          <text class="fr">{{item.tel}}</text>
        </view>
        <view class="address oh">
          <image class="item-icon fl" src="/images/user-address.png" mode="widthFix" />
          <view class="text fr">{{item.province_name || ''}}{{item.city_name || ''}}{{item.county_name || ''}}{{item.address || ''}}</view>
        </view>
      </view>
      <view class="operation br-t oh">
        <view class="default fl" bindtap="address_default_event" data-value="{{item.id}}">
          <image qq:if="{{is_default == item.id}}" class="item-icon" src="/images/default-select-active-icon.png" mode="widthFix" />
          <image qq:else class="item-icon" src="/images/default-select-icon.png" mode="widthFix" />
          <text>设为默认地址</text>
        </view>
        <view class="fr oh submit-items">
          <button qq:if="{{(item.lng || null) != null && (item.lat || null) != null}}" class="cr-666 br" type="default" size="mini" bindtap="address_map_event" data-index="{{index}}" hover-class="none">位置</button>
          <button class="cr-666 br" type="default" size="mini" bindtap="address_edit_event" data-index="{{index}}" hover-class="none">编辑</button>
          <button class="cr-666 br" type="default" size="mini" bindtap="address_delete_event" data-index="{{index}}" data-value="{{item.id}}" hover-class="none">删除</button>
        </view>
      </view>
    </view>
  </view>

  <view qq:if="{{data_list.length == 0}}">
    <import src="/pages/common/nodata.qml" />
    <template is="nodata" data="{{status: data_list_loding_status}}"></template>
  </view>
    
  <import src="/pages/common/bottom_line.qml" />
  <template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>

  <view class="submit-list">
    <navigator url="/pages/user-address-save/user-address-save" open-type="navigate" hover-class="none">
      <button class="submit-fixed submit-bottom" type="default" hover-class="none">添加新地址</button>
    </navigator>
    <button class="submit-fixed submit-bottom import-system-address-submit" type="default" hover-class="none" bindtap="choose_system_address_event">导入QQ地址</button>
  </view>
</view>