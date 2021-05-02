
/**
 * 格式化日期时间为年月日格式
 * @param String value 日期时间值
 */
export function dateFormat(value) {
    if (!value) {
        return ''
    }
    const date = new Date(value)
    var year = date.getFullYear()
    var month = date.getMonth() + 1
    var day = date.getDate()
    month = month > 9 ? month : '0' + month
    day = day > 9 ? day : '0' + day
    
    return `${year}-${month}-${day}`
} 