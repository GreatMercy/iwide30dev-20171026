import JfkButton from '@/components/common/button'
export default {
  data () {
    return {
      detail: 'javascript:;'
    }
  },
  components: {
    JfkButton
  },
  computed: {
    info () { // 有效信息取值
      if (this.type === 'killsec') {
        return this.item.killsec || {}
      }
      if (this.type === 'groupon') {
        return this.item.groupon || {}
      }
      return this.item
    },
    price () {
      if (this.type === 'killsec') { // 秒杀
        return this.info.killsec_price
      }
      if (this.type === 'groupon') {
        return this.info.group_price
      }
      return this.info.price_package
    },
    buttonText () {
      if (this.type === 'killsec') {
        return this.lgtTenMinutes ? '去秒杀' : '订阅提醒'
      } else {
        return '购买'
      }
    }
  },
  methods: {
    clickHandler () {
      console.log(this)
    }
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    lgtTenMinutes: Boolean,
    startedKillsec: Boolean
  }
}
