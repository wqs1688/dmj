<view class="form-container">
  <view class="form-gorup bg-white money-container">
    <view class="form-gorup-title">充值金额</view>
    <input type="digit" name="money" value="{{recharge_money_value || ''}}" placeholder-class="cr-ccc" class="cr-666" placeholder="请输入充值金额" bindinput="recharge_money_value_input_event" maxlength="6" />
  </view>

  <view class="form-gorup">
    <button class="bg-main" type="default" hover-class="none" disabled="{{form_submit_disabled_status}}" bindtap="form_submit_event">提交</button>
  </view>
</view>