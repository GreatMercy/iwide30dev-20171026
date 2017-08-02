export default {
  functional: true,
  render (h, ctx) {
    const { value, text = '', content = '', selected } = ctx.props
    let _value
    if (text && selected !== '1') {
      _value = <div class="jfk-calendar__text">{text}</div>
    } else {
      _value = <div class={{'jfk-calendar__value': true, 'color-golden': selected === '1'}}>
        <i class="date">{value}</i>
      </div>
    }
    return (
      <div class="jfk-calendar__date">
        <div class="jfk-calendar__number  font-color-white">
          <transition name="fade" mode="out-in">{_value}</transition>
        </div>
        <div class="jfk-calendar__content" domPropsInnerHTML={content}></div>
      </div>
    )
  }
}
