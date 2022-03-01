<view qq:if="{{data_list.length > 0}}">
  <block qq:if="{{category_show_level == 1}}">
    <!-- 一级模式 -->
    <view class="model-one  oh">
      <block qq:for="{{data_list}}" qq:key="key" qq:for-item="v">
        <view class="content-item" data-value="{{v.id}}" bindtap="category_event">
          <view class="content bg-white wh-auto">
            <image qq:if="{{(v.icon || null) != null}}" src="{{v.icon}}" mode="aspectFit" class="icon" />
            <view class="text single-text">{{v.name}}</view>
          </view>
        </view>
      </block>
    </view>
  </block>
  <block qq:else>
    <!-- 一级内导航 -->
    <view class='left-nav'>
      <block qq:for="{{data_list}}" qq:key="key">
        <view class='items {{item.active || ""}}' data-index="{{index}}" bindtap='nav_event'>
          <text>{{item.name}}</text>
        </view>
      </block>
    </view>
    <view class='right-container'>
      <!-- 一级内基础容 -->
      <view qq:if="{{(data_content || null) != null}}" class="right-content">
        <view qq:if="{{(data_content.vice_name || null) != null || (data_content.describe || null) != null}}" class="one-content bg-white" data-value="{{data_content.id}}" bindtap="category_event">
          <view qq:if="{{(data_content.vice_name || null) != null}}" class="one-vice-name cr-main" style="color:{{data_content.bg_color}};">{{data_content.vice_name}}</view>
          <view qq:if="{{(data_content.describe || null) != null}}" class="one-desc">{{data_content.describe}}</view>
        </view>
        <!-- 一二级数据渲染 -->
        <block qq:if="{{data_content.items.length > 0}}">
          <!-- 二级模式 -->
          <block qq:if="{{category_show_level == 2}}">
            <view class="two-content bg-white oh">
              <block qq:for="{{data_content.items}}" qq:key="key" qq:for-item="v">
                <view class="content-item" data-value="{{v.id}}" bindtap="category_event">
                  <view class="content wh-auto">
                    <image qq:if="{{(v.icon || null) != null}}" src="{{v.icon}}" mode="aspectFit" class="icon" />
                    <view class="text single-text">{{v.name}}</view>
                  </view>
                </view>
              </block>
            </view>
          </block>
          <!-- 三级模式 -->
          <block qq:if="{{category_show_level == 3}}">
            <block qq:for="{{data_content.items}}" qq:key="key" qq:for-item="v">
              <view class="bg-white oh">
                <view class="tc two-name" data-value="{{v.id}}" bindtap="category_event">{{v.name}}</view>
                <block qq:if="{{v.items.length > 0}}">
                  <block qq:for="{{v.items}}" qq:key="key" qq:for-item="vs">
                    <view class="content-item" data-value="{{vs.id}}" bindtap="category_event">
                      <view class="content wh-auto">
                        <image qq:if="{{(vs.icon || null) != null}}" src="{{vs.icon}}" mode="aspectFit" class="icon" />
                        <view class="text single-text">{{vs.name}}</view>
                      </view>
                    </view>
                  </block>
                </block>
              </view>
            </block>
          </block>
        </block>
        <block qq:else>
          <import src="/pages/common/nodata.qml" />
          <template is="nodata" data="{{status: 0, msg: '没有子分类数据'}}"></template>
        </block>
      </view>
    </view>
  </block>
</view>

<view qq:if="{{data_list.length == 0 && data_list_loding_status != 0}}">
  <import src="/pages/common/nodata.qml" />
  <template is="nodata" data="{{status: data_list_loding_status}}"></template>
</view>

<!-- 快捷导航 -->
<component-quick-nav></component-quick-nav>