<view qq:if="{{save_base_data != null && save_base_data.total_price > 0}}">
  <form bindsubmit="formSubmit" qq:if="{{data_list_loding_status == 0}}">
    <view class="content-top bg-white spacing-mb">
      发票金额 <text class="cr-main">{{save_base_data.total_price}}</text> 元
    </view>
    <view class="form-container spacing-mb oh">
      <view class="form-gorup bg-white">
        <view class="form-gorup-title">发票类型<text class="form-group-tips-must">必选</text></view>
        <picker name="invoice_type" bindchange="form_invoice_type_event" value="{{form_invoice_type_index}}" range="{{can_invoice_type_list}}" range-key="name">
          <view class="picker {{can_invoice_type_list[form_invoice_type_index] == undefined ? 'cr-ccc' : 'cr-666'}} arrow-right">
            {{can_invoice_type_list[form_invoice_type_index] == undefined ? '请选择发票类型' : can_invoice_type_list[form_invoice_type_index]['name']}}
          </view>
        </picker>
      </view>

      <view class="form-gorup bg-white">
        <view class="form-gorup-title">申请类型<text class="form-group-tips-must">必选</text></view>
        <picker name="apply_type" bindchange="form_apply_type_event" disabled="{{form_apply_type_disabled}}" value="{{form_apply_type_index}}" range="{{apply_type_list}}" range-key="name">
          <view class="picker {{apply_type_list[form_apply_type_index] == undefined ? 'cr-ccc' : 'cr-666'}} arrow-right">
            {{apply_type_list[form_apply_type_index] == undefined ? '请选择申请类型' : apply_type_list[form_apply_type_index]['name']}}
          </view>
        </picker>
      </view>

      <view qq:if="{{invoice_content_list.length > 0}}" class="form-gorup bg-white">
        <view class="form-gorup-title">发票内容<text class="form-group-tips-must">必选</text></view>
        <picker name="invoice_content" bindchange="form_invoice_content_event" value="{{form_invoice_content_index}}" range="{{invoice_content_list}}">
          <view class="picker {{invoice_content_list[form_invoice_content_index] == undefined ? 'cr-ccc' : 'cr-666'}} arrow-right">
            {{invoice_content_list[form_invoice_content_index] == undefined ? '请选择发票内容' : invoice_content_list[form_invoice_content_index]}}
          </view>
        </picker>
      </view>

      <view class="form-gorup bg-white">
        <view class="form-gorup-title">发票抬头<text class="form-group-tips-must">必填</text></view>
        <input type="text" name="invoice_title" placeholder-class="cr-ccc" class="cr-666" placeholder="发票抬头、最多200个字符" maxlength="200" value="{{data.invoice_title || ''}}" />
      </view>

      <!-- 企业信息 -->
      <view qq:if="{{company_container}}">
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">企业统一社会信用代码或纳税识别号<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="invoice_code" placeholder-class="cr-ccc" class="cr-666" placeholder="企业统一社会信用代码或纳税识别号、最多160个字符" maxlength="160" value="{{data.invoice_code || ''}}" />
        </view>
      </view>

      <!-- 企业专票信息 -->
      <view qq:if="{{company_special_container}}">
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">企业开户行名称<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="invoice_bank" placeholder-class="cr-ccc" class="cr-666" placeholder="企业开户行名称、最多200个字符" maxlength="200" value="{{data.invoice_bank || ''}}" />
        </view>
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">企业开户帐号<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="invoice_account" placeholder-class="cr-ccc" class="cr-666" placeholder="企业开户帐号、最多160个字符" maxlength="160" value="{{data.invoice_account || ''}}" />
        </view>
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">企业联系电话<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="invoice_tel" placeholder-class="cr-ccc" class="cr-666" placeholder="企业联系电话 6~15 个字符" maxlength="15" value="{{data.invoice_tel || ''}}" />
        </view>
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">企业注册地址<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="invoice_address" placeholder-class="cr-ccc" class="cr-666" placeholder="企业注册地址、最多230个字符" maxlength="230" value="{{data.invoice_address || ''}}" />
        </view>
      </view>

      <!-- 收件人信息 -->
      <view qq:if="{{addressee_container}}">
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">收件人姓名<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="name" placeholder-class="cr-ccc" class="cr-666" placeholder="收件人姓名格式 2~30 个字符之间" maxlength="30" value="{{data.name || ''}}" />
        </view>
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">收件人电话<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="tel" placeholder-class="cr-ccc" class="cr-666" placeholder="收件人电话 6~15 个字符" maxlength="15" value="{{data.tel || ''}}" />
        </view>
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">收件人地址<text class="form-group-tips-must">必填</text></view>
          <input type="text" name="address" placeholder-class="cr-ccc" class="cr-666" placeholder="收件人地址、最多230个字符" maxlength="230" value="{{data.address || ''}}" />
        </view>
      </view>

      <!-- 电子邮箱信息 -->
      <view qq:if="{{email_container}}">
        <view class="form-gorup bg-white">
          <view class="form-gorup-title">电子邮箱<text class="form-group-tips">选填</text></view>
          <input type="text" name="email" placeholder-class="cr-ccc" class="cr-666" placeholder="电子邮箱、最多60个字符" maxlength="60" value="{{data.email || ''}}" />
        </view>
      </view>

      <view class="form-gorup bg-white">
        <view class="form-gorup-title">备注<text class="form-group-tips">选填</text></view>
        <input type="text" name="user_note" placeholder-class="cr-ccc" class="cr-666" placeholder="备注最多230个字符" maxlength="60" value="{{data.user_note || ''}}" />
      </view>
      <view class="form-gorup">
        <button class="bg-main submit-bottom" type="default" formType="submit" hover-class="none" loading="{{form_submit_loading}}" disabled="{{form_submit_loading}}">提交</button>
      </view>
    </view>
  </form>
</view>
<view qq:else>
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>