<template>
    <view class="page-box">
<!--        <uni-nav-bar title="账号登录" :status-bar="true">
        </uni-nav-bar> -->
        
	<view class="container">
		<image class="bg-box" src="/static/images/login-bg.jpg" mode="aspectFill"></image>
        <view class="content-box">
            <view class="login-title">
                <text>安卓消防题库</text>
            </view>
            <view class="login-box">
                <view class="input-line">
                    <text class="input-label">账号</text>
                    <input type="text" v-model="loginForm.username" placeholder="请输入您的手机号">
                </view>
                <view class="input-line">
                    <text class="input-label">密码</text>
                    <input type="text" password="true" v-model="loginForm.password" placeholder="请输入密码">
                </view> 
            </view>     
			 <view class="register-tips" @tap="navRegister">
				 <text>还没账号？</text>
				 <text class="text text-blue">点我注册</text>
			 </view>
            <button class="login-btn"  @tap="handleLogin">登录</button>
<!--            <view class="line">or</view>
            <view class="other-login">
                <view class="wechat-login">
                    <uni-icons type="weixin" color="#23d96e" size="26"></uni-icons>
                    <text>微信登录</text>
                </view>
            </view> -->
        </view>
        
        <uni-popup ref="popup" type="message">
            <uni-popup-message type="error" :message="errMsg" :duration="2000"></uni-popup-message>
        </uni-popup>
	</view>        
    </view>

</template> 

<script>    
    import { mapGetters } from 'vuex'
	export default {
        components: {

        },
		data() {
			return {
                loginForm: {
                    username: '',
                    password: '',                    
                },
                errMsg: "错误消息"
			}
		},
		computed: {
			...mapGetters(['name', 'avatar', 'group_name'])
		},
		onLoad() {
			if(this.name && this.group_name) {
				 uni.reLaunch({
					url: "/pages/index/index"
				 })	;			
			}

		},
		methods: {
            handleLogin() {
                if (this.loginForm.username == "" || this.loginForm.password == "") {
                    this.errMsg = "账号或密码不能为空！";
                    this.$refs.popup.open();
                    return;
                }
                uni.showLoading({
                    title: '登录中...',
                })
                this.$store.dispatch("user/login", this.loginForm).then(() => {
                    uni.hideLoading();
                    uni.reLaunch({
                        url: "/pages/index/index"
                    });
                }).catch(errMsg => {
                    uni.hideLoading();
                    this.errMsg = errMsg;
                    this.$refs.popup.open();
                });
            },
            navRegister() {
                uni.navigateTo({
                    url: '../register/register'
                })
            },
		}
	}
</script>

<style lang="scss">
    .page,uni-page-body,html,body {
        height: 100%;
        overflow: hidden;
    }
	.container {
        background-color: $jw-gray-page-color;
        height: 100%;
        position: relative;
        z-index: 1;
        padding-top: 17vh;
        padding-left: 40rpx;
        padding-right: 40rpx;
	}
    
    .bg-box {
        width: 100%;
        height: 40vh;
/*        border-bottom-left-radius: 55%;
        border-bottom-right-radius: 60%; */
        clip-path: ellipse(90vw 40vw at 70% 30%);
        position: absolute;
        top: 0;
        z-index: -1;
        left: 0;
    }  
    .content-box {
        position: relative;
        z-index: 1;
    }
    
    .login-title {
        color: white;
        font-size: 55rpx;
    }
    
    .login-box {
        margin-top: 40rpx;
        background-color: white;
        border-radius: 20rpx;
        box-shadow: 10rpx 10rpx 50rpx 1rpx rgba($color: #000000, $alpha: 0.1);
        padding: 40rpx 30rpx;
    }
    .input-line {
        margin-bottom: 30rpx;
    }
    .input-label {
        font-size: $jw-content-size;
        color: $jw-gray-general-color;
        margin-bottom: 20rpx;
        display: block;
        padding-left: 15rpx;
    }
    .login-box input {
        background-color: $jw-gray-input-color2;
        border-radius: 10rpx;
        height: 80rpx;
        padding-left: 20rpx;
        padding-right: 20rpx;
    }
    
    .login-btn {
        background-image: linear-gradient(
            to right, 
            $jw-primary-color, 
            $jw-primary-secondary-color
        );
        color: white;
        margin-top: 50rpx;
        height: 85rpx;
        line-height: 85rpx;
    }
    
    // 中间横线
    .line {
        position: relative;
        color: $jw-gray-tips-color;
        text-align: center;
        margin-top: 50rpx;
        margin-bottom: 50rpx;
    }
    .line::after, .line::before {
        position: absolute;
        content: '';
        width: 44%;
        height: 1rpx;
        background-color: $jw-gray-input-color;
        top: 50%;
    }
    .line::after {
        left: 0;
    }
    .line::before {
        right: 0;
    }
    
    // 底部微信登录按钮
    .other-login {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .wechat-login {
        font-size: 30rpx;
        line-height: 35rpx;
        height: 90rpx;
        width: 270rpx;
        display: flex;
        align-items: center;
        justify-content: center;
        color: $jw-gray-secondary-color;
        background-color: #fff;
        box-shadow: 5rpx 5rpx 50rpx rgba($color: #666, $alpha: 0.1);
        border-radius: 13rpx;
    }
    .wechat-login text {
        margin-left: 10rpx;
    }
	
	// 注册提示
	.register-tips {
		padding-left: 20rpx;
		margin-top: 25rpx;
		font-size: 30rpx;
	}
</style>
