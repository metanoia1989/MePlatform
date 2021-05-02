<template>
	<view class="container">
        <view style="height: 1rpx;"></view>
        <view class="content-box">
            <view class="register-box">
                <view class="input-line">
                    <text class="input-label">手机号</text>
                    <view class="picker">
                        <input type="number" placeholder="请输入您的手机号码" @input="inputPhoneNum" v-model="registerForm.username">
                        <view class="form-input-btn">
                            <view v-if="ableSend" class="small-btn danger" @tap="sendMsg">获取验证码</view>
                            <view v-if="alreadySend" class="small-btn grays">{{seconds + "s后重新获取"}}</view>
                        </view>
                    </view>
                </view>
                <view class="input-line">
                    <text class="input-label">验证码</text>
                    <input type="text" placeholder="请输入验证码" v-model="registerForm.code">
                </view>
                <view class="input-line">
                    <text class="input-label">单位名称</text>
                    <input type="text" placeholder="请输入您的单位名称" v-model="registerForm.company">
                </view>
                <view class="input-line">
                    <text class="input-label">真实姓名</text>
                    <input type="text" placeholder="请输入您的真实姓名" v-model="registerForm.usertruename">
                </view>
                <view class="input-line">
                    <text class="input-label">所在区域</text>
                    <!-- <input type="text" v-model="registerForm.area"> -->
                    <uni-combox :candidates="areas" placeholder="请选择所在城市" v-model="registerForm.area"></uni-combox>
                </view>
                <view class="input-line">
                    <text class="input-label">密码</text>
                    <input type="text" placeholder="请输入密码" password="true" v-model="registerForm.userpassword">
                </view> 
                <view class="input-line">
                    <text class="input-label">重复密码</text>
                    <input type="text" placeholder="请输入重复密码" password="true" v-model="repeatpassword">
                </view> 
            </view>     

            <button class="register-btn"  @tap="handleRegister">注册</button>
        </view>
        
        <uni-popup ref="popup" type="message">
            <uni-popup-message type="error" :message="errMsg" :duration="2000"></uni-popup-message>
        </uni-popup>
	</view>        
</template> 

<script>    
    import { mapGetters } from 'vuex'
    import { sendSms, register } from '@/api/user.js' 

	export default {
        components: {

        },
		data() {
			return {
                registerForm: {
                    username: '',
                    code: '',
                    usertruename: '',
                    company: '',                    
                    area: '',                    
                    userpassword: '',                    
                },
                repeatpassword: '',
                keysName: {
                    username: '手机号',
                    code: '验证码',
                    company: '单位名称',                    
                    usertruename: '真实姓名',
                    area: '区域',                    
                    userpassword: '密码',                    
                },
                errMsg: "错误消息",
				areas: [
					"广州市", "深圳市", "佛山市", "东莞市",
                    "中山市", "珠海市", "江门市", "肇庆市",
                    "惠州市", "汕头市", "潮州市", "揭阳市",
                    "汕尾市", "湛江市", "茂名市", "阳江市",
                    "云浮市", "韶关市", "清远市", "梅州市",
                    "河源市",
				],
                // 验证码
                seconds: 60,
                ableSend: true,
                alreadySend: false,
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
            handleRegister() {
                for (let key in this.registerForm) {
                    if (!this.registerForm[key]) {
                        this.errMsg = this.keysName[key] + "不能为空！";
                        return this.$refs.popup.open();
                    }
                }
                if (this.registerForm.userpassword != this.repeatpassword) {
                    this.errMsg = "两次密码输入不一致！"
                    return this.$refs.popup.open();
                } 
                uni.showLoading({
                    title: '注册中...',
                })
                register(this.registerForm).then(() => {
                    uni.hideLoading();
                    uni.showToast({
                        title: '账号注册成功！',
                        duration: 1000, 
                        complete: () => {
                            setTimeout(() => {
                                uni.reLaunch({
                                    url: "/pages/login/login"
                                });
                            }, 1000);
                        },
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
              /**
               * 接收、验证手机号
               * @param {object} e 
               */
              inputPhoneNum(e) {
                const mobile = e.detail.value;
                console.log('mobile:' + mobile)

                if(mobile.length < 11) return;
                const pass = this.checkPhoneNum(mobile)
                if(pass && mobile.length === 11) {
                  if(!this.alreadySend) {
                      this.ableSend = true;
                  }
                } 
              },

              /**
               * 验证手机号
               * @param {int} mobile 
               */
              checkPhoneNum(mobile) {
                const str = /^1\d{10}$/
                if(str.test(mobile)) {
                  return true;
                } else {
                    this.ableSend = true;
                    this.errMsg = "无效的手机号码！"
                    this.$refs.popup.open();
                    return false;
                }
              },

              /**
               * 发送验证码
               */
              sendMsg: function() {
                if (!this.checkPhoneNum(this.registerForm.username)) {
                    return;
                }
                sendSms(this.registerForm.username).then(result => {
                    this.ableSend = false;
                    this.alreadySend = true;
                    this.timer()
                }).catch(error => {
                    this.errMsg = error;
                    this.$refs.popup.open();
                });
              },

              /**
               * 发送验证后 60秒倒计时
               */
              timer: function() { 
                const setTimer = setInterval(() => {
                    this.seconds = this.seconds - 1;

                  if(this.seconds <= 0) {
                      this.seconds = 60;
                      this.ableSend = true;
                      this.alreadySend = false;
                    clearInterval(setTimer);
                  }
                }, 1000);
              },


		}
	}
</script>

<style lang="scss">
    .page,uni-page-body,html,body {
        // height: 100%;
        // overflow: hidden;

    }
	.container {
        background-color: $jw-gray-page-color;
        // height: 100%;
        position: relative;
        z-index: 1;
        padding-left: 40rpx;
        padding-right: 40rpx;
	}
    
    .content-box {
        position: relative;
        z-index: 1;
		padding-bottom: 50rpx;
    }
    
    .register-title {
        color: black;
        font-size: 55rpx;
		padding-top: 30rpx;
		text-align: center;
		display: none;
    }
    
    .register-box {
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

    .register-box input , .uni-combox {
        background-color: $jw-gray-input-color2;
        border-radius: 10rpx;
        height: 80rpx;
        padding-left: 20rpx;
        padding-right: 20rpx;
    }
    
    .register-btn {
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
    

    // 手机号样式
    .picker {
        display: flex;
        align-items: center;
    }
    .form-input-btn {
        margin-left: 20rpx;
    }
    .small-btn {
      max-width: 260rpx;
      min-width: 210rpx;
      height: 60rpx;
      line-height: 60rpx;
      font-size: 28rpx;
      padding-left: 13rpx;
      padding-right: 13rpx;
      border-radius: 10rpx;
      text-align: center;
    }

    .danger {
      background-color: #ef4e3a;
      color: #fff;
    }

    .grays {
      background-color: #999;
      color: #fff;
    }
    

</style>
