<view class="page">
    <form bindsubmit="form_submit" class="form-container oh">
        <view class="form-gorup bg-white">
            <view class="form-gorup-title">别名<text class="form-group-tips">选填</text></view>
            <input type="text" name="alias" value="{{address_data.alias || ''}}" maxlength="16" placeholder-class="cr-ccc" class="cr-666" placeholder="别名格式最多 16 个字符" />
        </view>

        <view class="form-gorup bg-white">
            <view class="form-gorup-title">联系人<text class="form-group-tips-must">必填</text></view>
            <input type="text" name="name" value="{{address_data.name || ''}}" maxlength="16" placeholder-class="cr-ccc" class="cr-666" placeholder="联系人格式 2~16 个字符之间" />
        </view>

        <view class="form-gorup bg-white">
            <view class="form-gorup-title">联系电话<text class="form-group-tips-must">必填</text></view>
            <input type="text" name="tel" value="{{address_data.tel || ''}}" maxlength="30" placeholder-class="cr-ccc" class="cr-666" placeholder="座机 或 手机" />
        </view>

        <view class="form-gorup bg-white">
            <view class="form-gorup-title">省市区<text class="form-group-tips-must">必选</text></view>
            <view class="select-address oh">
            <view class="section fl">
                <picker name="province" bindchange="select_province_event" value="{{province_value}}" range="{{province_list}}" range-key="name">
                    <view class="name {{(province_value == null) ? 'cr-ccc' : 'cr-666' }}">{{province_list[province_value].name || default_province}}</view>
                </picker>
            </view>
            <view class="section fl">
                <picker qq:if="{{(province_id || null) != null}}" name="city" bindchange="select_city_event" value="{{city_value}}" range="{{city_list}}" range-key="name">
                    <view class="name {{(city_value == null) ? 'cr-ccc' : 'cr-666' }}">{{city_list[city_value].name || default_city}}</view>
                </picker>
                <text qq:else class="cr-ccc" bindtap="region_select_error_event" data-value="请先选择省份">请先选择省份</text>
            </view>
            <view class="section fl">
                <picker qq:if="{{(city_id || null) != null}}" name="county" bindchange="select_county_event" value="{{county_value}}" range="{{county_list}}" range-key="name">
                    <view class="name {{(county_value == null) ? 'cr-ccc' : 'cr-666' }}">{{county_list[county_value].name || default_county}}</view>
                </picker>
                <text qq:else class="cr-ccc" bindtap="region_select_error_event" data-value="请先选择城市">请先选择城市</text>
            </view>
            </view>
        </view>

        <view class="form-gorup bg-white">
            <view class="form-gorup-title">详细地址<text class="form-group-tips-must">必填</text></view>
            <input type="text" name="address" value="{{address_data.address || ''}}" maxlength="80" placeholder-class="cr-ccc" class="cr-666" placeholder="详细地址格式 1~80 个字符之间" />
        </view>

        <view qq:if="{{home_user_address_map_status == 1}}" class="form-gorup bg-white">
            <view class="form-gorup-title">地理位置<text class="form-group-tips-must">必选</text></view>
            <view bindtap="choose_location_event" class="form-gorup-text">
            <view qq:if="{{(user_location || null) == null && (address_data.address || null) == null}}" class="cr-888">请选择地理位置</view>
            <view qq:else class="cr-666">{{((user_location || null) != null && (user_location.name || null) != null) ? user_location.name+' ' : ''}}{{user_location.address || address_data.address || ''}}</view>
            </view>
        </view>

        <view class="form-gorup bg-white">
            <view class="form-gorup-title">是否默认<text class="form-group-tips">选填</text></view>
            <view class="switch">
                <switch name="is_default" checked="{{address_data.is_default == 1 ? true : false}}" color="#04BE02" />
            </view>
        </view>

        <!-- 身份证信息 -->
        <view qq:if="{{home_user_address_idcard_status == 1}}" class="idcard-container">
            <view class="form-gorup bg-white">
                <view class="form-gorup-title">身份证姓名<text class="form-group-tips-must">必填</text><text class="form-group-tips">请务必与上传的身份证件姓名保持一致</text></view>
                <input type="text" name="idcard_name" value="{{address_data.idcard_name || ''}}" maxlength="16" placeholder-class="cr-ccc" class="cr-666" placeholder="身份证姓名格式 2~16 个字符之间" />
            </view>
            <view class="form-gorup bg-white">
                <view class="form-gorup-title">身份证号码<text class="form-group-tips-must">必填</text><text class="form-group-tips">请务必与上传的身份证件号码保持一致</text></view>
                <input type="idcard" name="idcard_number" value="{{address_data.idcard_number || ''}}" maxlength="18" placeholder-class="cr-ccc" class="cr-666" placeholder="身份证号码格式最多18个字符" />
            </view>
            <view class="form-gorup bg-white form-container-upload oh">
                <view class="form-gorup-title">身份证照片<text class="form-group-tips-must">必传</text><text class="form-group-tips">请使用身份证原件拍摄，图片要清晰</text></view>
                <view class="form-upload-data">
                    <view class="item fl">
                        <text qq:if="{{(idcard_images_data.idcard_front || null) != null}}" class="delete-icon" bindtap="upload_delete_event" data-value="idcard_front">x</text>
                        <image src="{{(idcard_images_data.idcard_front || null) != null ? idcard_images_data.idcard_front : '/images/default-idcard-front.jpg'}}" data-value="idcard_front" mode="aspectFill" bindtap="file_upload_event" />
                    </view>
                    <view class="item fl">
                        <text qq:if="{{(idcard_images_data.idcard_back || null) != null}}" class="delete-icon" bindtap="upload_delete_event" data-value="idcard_back">x</text>
                        <image src="{{(idcard_images_data.idcard_back || null) != null ? idcard_images_data.idcard_back : '/images/default-idcard-back.jpg'}}" data-value="idcard_back" mode="aspectFill" bindtap="file_upload_event" />
                    </view>
                </view>
            </view>
        </view>

        <button class="submit-fixed submit-bottom" type="default" formType="submit" hover-class="none" disabled="{{form_submit_disabled_status}}">保存</button>
    </form>
</view>