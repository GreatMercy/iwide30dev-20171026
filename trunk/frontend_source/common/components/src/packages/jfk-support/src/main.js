export default {
  functional: true,
  render (h) {
    return h('section', {
      class: 'jfk-support',
      domProps: {
        innerHTML: '<div class="jfk-support__logo-box"><a href="javascript:;" class="jfk-support__logo">广州金房卡信息科技有限公司</a></div><p class="jfk-support__info">POWERED BY 金房卡</p>'
      }
    })
  }
}
