import {
    getToken, redirectLogin
} from './auth'

var app_domain = process.env.NODE_ENV === 'development' 
    ? 'http://azxftk.test' // 开发环境
    : 'https://aztk.anzhuoxfpx.com'; // 生产环境
// app_domain = 'https://aztk.anzhuoxfpx.com';
const app_url =  app_domain + "/miniapi";

class request {
    constructor() {
		this._header = null;

    }

    /**
     * 设置统一的异常处理
     */
    setErrorHandler(handler) {
        this._errorHandler = handler;
    }

    /**
     * GET类型的网络请求
     */
    getRequest(url, data, header = this._header) {
        return this.requestAll(url, data, header, 'GET')
    }

    /**
     * DELETE类型的网络请求
     */
    deleteRequest(url, data, header = this._header) {
        return this.requestAll(url, data, header, 'DELETE')
    }

    /**
     * PUT类型的网络请求
     */
    putRequest(url, data, header = this._header) {
        return this.requestAll(url, data, header, 'PUT')
    }

    /**
     * POST类型的网络请求
     */
    postRequest(url, data, header = this._header) {
        return this.requestAll(url, data, header, 'POST')
    }

    /**
     * 网络请求
     */
    requestAll(url, data, header, method) {
		if (!header) {
			header = {
			    'Content-Type': 'application/x-www-form-urlencoded',
			}
		}
        var token = getToken()
        if (token) {
            header["Authorization"] = 'Bearer ' + token;
        }
        return new Promise((resolve, reject) => {
            uni.request({
                url: app_url + url,
                data: data,
                header: header,
                method: method,
                success: (res => {
                    //200: 服务端业务处理正常结束
                    const { data } = res;
                    console.log(url, data);
                    
                    if (data.status == 0) {
                        resolve(data.result)
                    } else if (data.status == 1000 || data.status == 1003) {
                        // 登录态失效，跳转登录页面
                        redirectLogin()
                    } else {
                        reject(data.message);
                    }
                }),
                fail: (res => {
                    console.log("请求出错了", res)
					console.log("请求地址：", app_url + url)
                    uni.showToast({
                        title: "服务器繁忙！",
                        image: "/static/images/fail.png"
                    });
                })
            })
        })
    }
}

export default request;
export { app_domain };