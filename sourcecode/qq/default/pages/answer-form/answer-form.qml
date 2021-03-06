<form bindsubmit="formSubmit" qq:if="{{data_list_loding_status == 0}}">
    <view class="form-input bg-white spacing-mb">
        <input type="text" class="wh-auto" name="name" placeholder="联系人" maxlength="30" />
    </view>
    <view class="form-input bg-white spacing-mb">
        <input type="number" class="wh-auto" name="tel" placeholder="联系电话" maxlength="15" />
    </view>
    <view class="form-input bg-white spacing-mb">
        <textarea name="content" class="content-textarea" maxlength="160" placeholder="请详细描述问题，我们将尽快为您解答！" />
    </view>

    <view class="bottom-btn-box fixed">
        <button type="default" formType="submit" class="my-btn-default" hover-class="none" bindtap="submit_event" loading="{{form_submit_loading}}" disabled="{{form_submit_loading}}">提交</button>
    </view>
</form>

<view qq:if="{{data_list_loding_status != 0}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status, msg: data_list_loding_msg}}"></template>
</view>