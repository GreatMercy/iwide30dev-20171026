import fontMap from '@/components/common/fontMap'
export default {
  functional: true,
  render (h, ctx) {
    const { type, loading, disabled, plain, size, tag, nativeType, font } = ctx.props
    let _class = [
      'jfk-button',
      type ? 'jfk-button--' + type : '',
      size ? 'jfk-button--' + size : ''
    ]
    if (loading) {
      _class.push('is-loading')
    }
    if (disabled) {
      _class.push('is-disabled')
    }
    if (plain) {
      _class.push('is-plain')
    }
    const { staticClass = '', attrs = {}, style } = ctx.data
    _class = _class.join(' ') + ' ' + staticClass
    if (tag === 'button' && nativeType) {
      attrs.type = nativeType
    }
    let children = ctx.children
    if (font && ctx.children) {
      children = []
      ctx.children.forEach(function (child) {
        if (child.tag) {
          children.push(child)
        } else {
          let i = 0
          let childs = []
          let text = child.text
          let len = text.length
          while (i < len) {
            let name = fontMap[text[i]]
            if (name) {
              let c = 'jfk-font jfk-button__text-item icon-font_zh_' + name + '_' + font
              childs.push(<i class={c}></i>)
            }
            i++
          }
          let _c = 'jfk-button__text jfk-button__text--length-' + childs.length
          children.push(<span class={_c}>{childs}</span>)
        }
      })
    }
    return h(tag, {
      class: _class,
      attrs,
      style,
      on: {
        'click': ctx.listeners.click
      }
    }, children)
  },
  props: {
    type: {
      type: String,
      default: 'default'
    },
    plain: Boolean,
    size: String,
    loading: Boolean,
    disabled: Boolean,
    font: String,
    tag: {
      type: String,
      default: 'button'
    },
    nativeType: String
  }
}
