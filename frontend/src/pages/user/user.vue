<template>
    <view class="page-box">
        <!--        <uni-nav-bar :fixed="true" :status-bar="true" title="个人中心">
        </uni-nav-bar> -->

        <view class="container">
            <view class="user-info">
                <view class="cu-list menu user-logo">
                    <view class="cu-item" @tap="navProfile">
                        <view class="cu-avatar round xl margin-right-sm shadow-blur-lg bg-img">
                            <image :src="avatar" mode="aspectFit"></image>
                        </view>
                        <view class='content flex-sub'>
                            <view class='padding-left-sm text-xxl text-black padding-top-sm'>
                                <text>{{ name }}</text>
                            </view>
                            <view
                                class='text-lg text-gray text-shadow-a flex justify-between padding-left-sm padding-top-sm'>
                                {{ mobile }}
                            </view>
                        </view>
                    </view>
                </view>
                <view class="user-bg" :style="{ backgroundImage: 'url(' + avatar + ')' }"></view>
            </view>

            <view class="padding flex text-center text-orange bg-white shadow-bottom">
                <view class="flex flex-sub solid-right clazz-box">
                    <text class="text text-gray">班次：</text>
                    <text>{{ group_name }}</text>
                </view>
            </view>

            <view
                class="cu-list menu card-menu margin-top-xl shadow-lg bg-white text-black my-radius sm-border margin-bottom">
                <!-- #ifdef H5 -->
                <view class="cu-item arrow">
                    <button class='content cu-btn' @tap="navOld">
                        <image src='/static/images/about.png' class='png' mode='aspectFit'></image>
                        <text class='text-lg margin-sm'>旧版入口</text>
                    </button>
                </view>
                <!-- #endif -->
                <view class="cu-item arrow">
                    <button class='content cu-btn' @tap="navNotice">
                        <image src='/static/images/fankui.png' class='png' mode='aspectFit'></image>
                        <text class='text-lg margin-sm'>公告通知</text>
                        <uni-badge :text="unreadCount" type="error" v-if="unreadCount > 0"></uni-badge>
                    </button>
                </view>
                <view class="cu-item arrow">
                    <button class='content cu-btn' @tap="navChangePwd">
                        <image src='/static/images/shezhi.png' class='png' mode='aspectFit'></image>
                        <text class='text-lg margin-sm'>修改密码</text>
                    </button>
                </view>
                <!-- 				<view class="cu-item arrow">
					<button class='content cu-btn' @tap="navProfile">
						<image src='/static/images/love.png' class='png' mode='aspectFit'></image>
						<text class='text-lg margin-sm'>账号信息</text>
					</button>
				</view> -->
                
                <!-- #ifdef APP-PLUS -->
                <view class="cu-item arrow">
                    <button class='content cu-btn' @tap="showVersion">
                        <image src='/static/images/about.png' class='png' mode='aspectFit'></image>
                        <text class='text-lg margin-sm'>应用版本</text>
                    </button>
                </view>
                <!-- #endif -->
                <view class="cu-item arrow">
                    <button class='content cu-btn' @tap="$refs.popup.open()">
                        <image src='/static/images/love.png' class='png' mode='aspectFit'></image>
                        <text class='text-lg margin-sm'>退出登录</text>
                    </button>
                </view>



            </view>

            <uni-popup ref="popup" type="dialog">
                <uni-popup-dialog type="info" mode="base" title="提示" content="确认退出登录吗？" @confirm="logout">
                </uni-popup-dialog>
            </uni-popup>
        </view>
    </view>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import {
        getClazzCount
    } from '@/api/user.js';
    import {
        unreadNum
    } from '@/api/notice.js'
    import { app_domain } from '@/utils/request.js'

    export default {
        components: {

        },
        data() {
            return {
                //             name: "刘深海",
                //             avatar:  "/static/images/default-avatar.png",
                //             mobile: "17097387559",
                // group_name: "20210224级广州",
                unreadCount: 0,

            }
        },
        computed: {
            ...mapGetters(['name', 'avatar', 'mobile', 'group_name'])
        },
        onLoad() {
            this.pageInit()
        },
        onPullDownRefresh() {
            this.pageInit()
        },
        methods: {
            pageInit() {
                if (!this.mobile) {
                    this.$store.dispatch('user/getInfo');
                }
                this.fetchUnradNum()
            },
            /**
             * 获取未读公告数
             */
            fetchUnradNum() {
                unreadNum().then(res => {
                    this.unreadCount = res
                    uni.stopPullDownRefresh()
                }).catch(error => {
                    uni.stopPullDownRefresh()
                    uni.showToast({
                        icon: "none",
                        title: error
                    })
                })
            },
            navProfile() {
                // TODO 个人资料页面后续开发，非紧要目标
                // uni.navigateTo({
                //     url: '../profile/profile'
                // })
            },
            navSetting() {
                uni.navigateTo({
                    url: '../setting/setting'
                })
            },
            navChangePwd() {
                console.log("测试导航")
                uni.navigateTo({
                    url: '../changepwd/changepwd'
                })
            },
            logout() {
                this.$store.dispatch("user/logout");
            },
            navNotice() {
                uni.navigateTo({
                    url: '../notice/notice'
                })
            },
            navOld(){
                // #ifdef H5
                window.location.href = app_domain
                // #endif
            },

            showVersion() {
                // #ifdef APP-PLUS
                plus.runtime.getProperty(plus.runtime.appid, function(widgetInfo) {
                    console.log(widgetInfo)
                    const {
                        version
                    } = widgetInfo
                    uni.showToast({
                        title: "版本：v" + String(version),
                        icon: 'none',
                        duration: 2500
                    })
                })
                // #endif

            },
        }
    }
</script>

<style lang="scss">
    .user-info {
        position: relative;
        z-index: 1;
        padding: 100rpx 30rpx;
        background-color: white;
        overflow: hidden;
    }

    .user-logo {
        position: relative;
        z-index: 1;
    }

    .cu-list.menu>.cu-item {
        background-color: transparent;
        ;
    }

    .user-bg {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        // background-color: rgba($color: #000000, $alpha: 0.1);
        opacity: 0.9;
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
        filter: blur(20rpx);

    }

    .clazz-box {
        padding-left: 20rpx;
        font-size: 30rpx;
    }
</style>
