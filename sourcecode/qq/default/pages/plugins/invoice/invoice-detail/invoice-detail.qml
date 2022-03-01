<view qq:if="{{detail != null}}">
  <view qq:if="{{detail_list.length > 0}}" class="panel-item">
    <view class="panel-title">申请信息</view>
    <view class="panel-content bg-white">
      <view qq:for="{{detail_list}}" qq:key="item" class="item br-b oh">
        <view class="title fl">{{item.name}}</view>
        <view class="content fl br-l">{{item.value}}</view>
      </view>
    </view>
  </view>

  <!-- 快递信息 -->
  <view qq:if="{{detail.status == 2 && detail.invoice_type != 0 && express_data.length > 0}}" class="panel-item spacing-mt">
    <view class="panel-title">快递信息</view>
    <view class="panel-content bg-white">
      <view qq:for="{{express_data}}" qq:key="item" class="item br-b oh">
        <view class="title fl">{{item.name}}</view>
        <view class="content fl br-l">{{item.value}}</view>
      </view>
    </view>
  </view>

  <!-- 电子发票 -->
  <view qq:if="{{detail.status == 2 && detail.invoice_type == 0 && (detail.electronic_invoice || null) != null}}" class="panel-item spacing-mt">
    <view class="panel-title">电子发票</view>
    <view class="panel-content bg-white">
      <view qq:for="{{detail.electronic_invoice}}" qq:key="item" class="item br-b oh">
        <view class="content" bindtap="electronic_invoice_event" data-value="{{item.url}}">{{item.title}}</view>
      </view>
    </view>
    <view class="tips">可点击发票名称复制后、到浏览器打开地址下载发票。</view>
  </view>

  <import src="/pages/common/bottom_line.qml" />
  <template is="bottom_line" data="{{status: data_bottom_line_status}}"></template>
</view>

<view qq:if="{{detail == null}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>

  <view qq:if="{{data_list_loding_status != 1}}" class="nav-back tc wh-auto">
    <navigator open-type="navigateBack" hover-class="none">
      <button type="default" size="mini" class="cr-888 br" hover-class="none">返回</button>
    </navigator>
  </view>
</view>