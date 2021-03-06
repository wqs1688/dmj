<form qq:if="{{check_status == 1}}" bindsubmit="form_submit" class="form-container oh">
  <view class="form-gorup bg-white">
    <view class="form-gorup-title">提现金额<text class="form-group-tips-must">必填</text></view>
    <input type="digit" name="money" value="{{default_data.money || ''}}" placeholder-class="cr-ccc" class="cr-666" placeholder="提现金额，最低{{(data_base.cash_minimum_amount || 0) <= 0 ? 0.01 : data_base.cash_minimum_amount}}元，最高{{can_cash_max_money}}元" />
    <view class="tips form-tips">
      <view qq:if="{{(data_base || null) == null || data_base.is_cash_retain_give != 0}}">赠送金额不可提现</view>
      <view qq:if="{{(data_base || null) != null && data_base.cash_minimum_amount > 0}}">提现最低金额 {{data_base.cash_minimum_amount}} 元起</view>
      <view>当前可提现金额 <text class="cr-main">{{can_cash_max_money}}</text> 元</view>
      <view>当前可用金额 <text class="cr-666">{{user_wallet.normal_money}}</text> 元</view>
      <view>当前赠送金额 <text class="cr-666">{{user_wallet.give_money}}</text> 元</view>
    </view>
  </view>

  <view class="form-gorup bg-white">
    <view class="form-gorup-title">收款平台<text class="form-group-tips-must">必填</text></view>
    <input type="text" name="bank_name" value="{{default_data.bank_name || ''}}" placeholder-class="cr-ccc" class="cr-666" maxlength="60" placeholder="收款平台格式 1~60 个字符之间" />
    <view class="tips form-tips">
      强烈建议优先填写国有4大银行(中国银行、中国建设银行、中国工商银行和中国农业银行) 请填写详细的开户银行分行名称，虚拟账户如支付宝、财付通、微信 直接填写 相应的名称 即可。
    </view>
  </view>

  <view class="form-gorup bg-white">
    <view class="form-gorup-title">收款账号<text class="form-group-tips-must">必填</text></view>
    <input type="text" name="bank_accounts" value="{{default_data.bank_accounts || ''}}" placeholder-class="cr-ccc" class="cr-666" maxlength="60" placeholder="收款账号格式 1~60 个字符之间" />
    <view class="tips form-tips">
      银行账号或虚拟账号(支付宝、财付通、微信等账号)
    </view>
  </view>

  <view class="form-gorup bg-white">
    <view class="form-gorup-title">开户人姓名<text class="form-group-tips-must">必填</text></view>
    <input type="text" name="bank_username" value="{{default_data.bank_username || ''}}" placeholder-class="cr-ccc" class="cr-666" maxlength="30" placeholder="开户人姓名格式 1~30 个字符之间" />
    <view class="tips form-tips">
      收款账号的开户人真实姓名
    </view>
  </view>

  <view class="form-gorup">
    <button class="bg-main" type="default" formType="submit" hover-class="none" disabled="{{form_submit_disabled_status}}">提交</button>
  </view>
</form>

<view qq:if="{{check_status === 0}}" class="overdue tc">
  <view class="msg cr-888">安全验证已超时，请重新验证再操作</view>
  <navigator hover-class="none" open-type="navigateBack">
    <button size="mini" type="primary" hover-class="none" class="submit-cash">返回重新申请提现</button>
  </navigator>
</view>
<view qq:else>
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>