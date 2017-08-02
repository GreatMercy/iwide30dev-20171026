/**
 * 基于 es6 语法编写
 * @author huanghoajun
 * @email  yellowhaojun@gmail.com
 * */
import '@scss/popup'
const doc = document
const query = 'querySelectorAll'
const className = 'getElementsByClassName'
/* eslint-disable no-unused-vars */
const S = (s) => {
  return doc[query](s)
}
const ready = {
  extend: function (obj) {
    let newObj = JSON.parse(JSON.stringify(config))
    for (let i in obj) {
      newObj[i] = obj[i]
    }
    return newObj
  }
}

// 默认配置
let config = {
  'type': 'message', // {'message': '信息框', 'loading': '加载'}
  'icon': 'success', // 图标的类型 {'success': '成功的图标', 'error':'失败的图标'}
  'content': '', // 弹窗口内容
  'title': '', // 标题 (sting || boolean)
  'zIndex': 999999, // 弹窗的层级
  'time': 3, // 自动关闭层所需秒数, toast 默认关闭，其他默认不关闭
  'btn': ['确 定'], // 自定义按钮的文本 （只支持2个按钮）
  'shade': true, // 该参数可允许你是否显示遮罩，并且定义遮罩风格 (sting || boolean)
  'shadeClose': false // true，是否点击遮罩时关闭层
}

// 设置背景
const setBackground = () => {
  let shadeStyle = ''
  if (typeof config.shade === 'boolean') {
    if (config.shade === false) {
      shadeStyle = 'background: rgba(0,0,0,0)'
    }
  } else if (typeof config.shade === 'string') {
    shadeStyle = config.shade
  }
  return `z-index:${config['zIndex']};${shadeStyle}`
}

// 根据类型创建 内容
const setContent = () => {
  // 消息框的内容
  // 标题
  let titleStyle = typeof config.title === 'string' ? `<div class="jfk-message-title"> ${config.title} </div>` : ''
  let iconStyle = ''
  if (config.type === 'icon') {
    // 带图标的禁止使用title
    titleStyle = ''
    let iconContent = ''
    if (config.icon === 'success' || config.icon === 'error') {
      iconContent = `jfk-icon-${config.icon}`
    } else {
      iconContent = config.icon
    }
    iconStyle = `<div class="jfk-popup-icon ${iconContent}"></div>`
  }
  // 内容
  let contentStyle = `<div class="jfk-popup-content">${config.content}</div>`
  // 按钮
  let btnContent = ''
  for (let i = 0; i < config.btn.length; i++) {
    btnContent = btnContent + `<a href="javascript:void(0)" class="jfk-popup-btn">${config.btn[i]}</a>`
  }
  // 只有当类型为 message, 才插入按钮
  if (config.type !== 'message' && config.type !== 'icon') {
    btnContent = ''
  }
  let btnStyle = `<div class="jfk-btn-group">${btnContent}</div>`
  // 如果类型为 loading
  let content = `<div class="jfk-popup-animation"><div class="jfk-${config.type}-popup">${iconStyle}${titleStyle}${contentStyle}${btnStyle}</div></div>`
  if (config.type === 'loading') {
    content = '<div class="loader"><div class="loader-inner ball-clip-rotate"><div></div></div></div>'
  }
  return content
}

/**
 * 关闭所有
 * @param {string} type 根据关闭所需类型
 * @param {function} callback 返回的回调
 * */
const closeAll = (type, callback) => {
  function close () {
    for (let i = 0; i < doc[className]('jfk-popup').length; i++) {
      doc.body.removeChild(doc[className]('jfk-popup')[i])
    }
  }

  if (type === 'loading') {
    if (doc[className]('loader-inner').length > 0) {
      close()
      if (typeof callback === 'function') {
        callback()
      }
      return false
    }
  } else {
    close()
  }
}

const popup = function (options) {
  config = ready.extend(options)
  // 创建弹窗
  let container = doc.createElement('div')
  container.setAttribute('class', 'jfk-popup')
  // 根据z-index 和 shade 的值 生成对应的样式
  container.setAttribute('style', setBackground())
  container.innerHTML = setContent()
  // 插入弹窗
  doc.body.appendChild(container)

  // 事件绑定
  let _arguments = arguments
  for (let i = 0; i < doc[className]('jfk-popup-btn').length; i++) {
    doc[className]('jfk-popup-btn')[i].addEventListener('click', function () {
      _arguments[i + 1]()
    }, false)
  }
}
/**
 * 错误的提示
 * @param {string} message 提醒信息
 * @param {function} success 成功的回调
 * @param {boolean} closeMode 默认为关闭所有，为true 只关闭loading
 **/
const errorMessage = (message, success, closeMode) => {
  function showMessage () {
    popup({
      'type': 'icon',
      'icon': 'error',
      'zIndex': 9999999999999999,
      'shade': true,
      'content': message,
      'btn': ['确 定']
    }, () => {
      if (typeof success === 'function') {
        success()
      }
      closeAll()
    })
  }

  if (closeMode) {
    closeAll('loading', showMessage)
  } else {
    closeAll()
    showMessage()
  }
}

/**
 * 成功的提示
 * @param {string} message 提醒信息
 * @param {function} success 成功的回调
 **/
const successMessage = (message, success) => {
  closeAll()
  popup({
    'type': 'icon',
    'icon': 'success',
    'zIndex': 9999999999999999,
    'shade': true,
    'btn': ['确 定'],
    'content': message
  }, () => {
    if (typeof success === 'function') {
      success()
    }
    closeAll()
  })
}

/**
 * loading
 * */
const loading = () => {
  closeAll()
  popup({
    'type': 'loading',
    'zIndex': 9999999999999999,
    'shade': false
  })
}

export { closeAll, popup, errorMessage, loading, successMessage }
