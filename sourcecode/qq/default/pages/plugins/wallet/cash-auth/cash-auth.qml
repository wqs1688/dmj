<view qq:if="{{data_list_loding_status != 1}}">
  <view qq:if="{{(data_base.cash_minimum_amount || null) == null || data_base.cash_minimum_amount <= 0 || (user_wallet.normal_money >= data_base.cash_minimum_amount)}}">
    <form qq:if="{{check_account_list.length > 0}}" bindsubmit="form_submit" class="form-container oh">
      <view class="form-gorup bg-white">
        <view class="form-gorup-title">选择身份认证方式<text class="form-group-tips-must">必选</text></view>
        <view class="section">
          <picker name="account_type" bindchange="select_check_account_event" value="{{check_account_value}}" range="{{check_account_list}}" range-key="msg">
              <view class="picker name {{(check_account_value == null) ? 'cr-ccc' : 'cr-666' }}">
                <view qq:if="{{check_account_value == null}}">
                  请选择认证账号
                </view>
                <view qq:else>
                  {{check_account_list[check_account_value]['msg']}}
                </view>
              </view>
          </picker>
        </view>
      </view>

      <view class="form-gorup bg-white verify-input">
        <view class="form-gorup-title">请输入安全验证码<text class="form-group-tips-must">必填</text></view>
        <input type="number" name="verify" placeholder-class="cr-ccc" class="cr-666" placeholder="验证码格式 4 位数字" maxlength="4" />
        <button type="default" hover-class="none" size="mini" loading="{{verify_loading}}" disabled="{{verify_disabled}}" bindtap="verify_send_event" class="verify-sub {{verify_disabled ? 'sub-disabled' : ''}}">{{verify_submit_text}}</button>
      </view>

      <view class="form-gorup">
        <button class="bg-main" type="default" formType="submit" hover-class="none" disabled="{{form_submit_disabled_status}}">提交</button>
      </view>
    </form>

    <view class="view-tips spacing-mt">
      <view class="tips">
        <view>操作提示</view>
        <view>1. 请选择 "<text class="cr-main">绑定邮箱</text>" 或 "<text class="cr-main">绑定手机</text>" 方式其一作为安全校验码的获取方式并正确输入。</view>
        <view>2. 如果您未绑定手机或者邮箱已失效，可以绑定手机后通过接收手机短信完成验证。</view>
        <view>3. 如果您未绑定邮箱或者已失效，可以绑定邮箱后通过接收邮件完成验证。</view>
        <view>4. 请正确输入下方图形验证码，如看不清可点击图片进行更换，输入完成后进行下一步操作。</view>
        <view>5. 收到安全验证码后，请在10分钟内完成验证。</view>
        <view>6. 安全验证成功后，请在30分钟内完成提现申请。</view>
      </view>
    </view>

    <view qq:if="{{check_account_list.length == 0}}" class="bind-mobile-container">
      <navigator url="/pages/login/login" hover-class="none">
        <button type="warn" class="mobile-submit">绑定手机号码</button>
      </navigator>
    </view>
  </view>
  <view qq:else>
    <view class="view-tips spacing-mt">
      <view class="tips">
        <view>提现最低金额 <text class="cr-main">{{data_base.cash_minimum_amount}}</text> 元起</view>
      </view>
    </view>
  </view>
</view>

<view qq:else>
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>