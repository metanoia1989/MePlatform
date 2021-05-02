const TokenKey = 'azxftk_auth_token'

export function getToken() {
  return  uni.getStorageSync(TokenKey);
}

export function setToken(token) {
  return uni.setStorageSync(TokenKey, token)
}

export function removeToken() {
  return uni.removeStorageSync(TokenKey)
}

export function redirectLogin() {
  return uni.reLaunch({
      url: "/pages/login/login"
  });
}
