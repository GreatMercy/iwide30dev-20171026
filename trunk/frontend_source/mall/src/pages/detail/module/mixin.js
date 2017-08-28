export default {
  beforeCreate () {
    // 85 顶部 底部相加高度  34 20 poup 顶部 底部高度 67 标题高度
    this.maxHeight = document.documentElement.clientHeight - 85 - 34 - 50 - 67
    console.log(this.maxHeight)
  },
  data () {
    return {
      settingId: '-1',
      pricePackage: this.price
    }
  },
  computed: {
    specVisible: {
      get () {
        return this.visible
      },
      set (val) {
        this.$emit('update:visible', val)
      }
    },
    buttonDisabled () {
      return this.settingId === '-1'
    }
  },
  methods: {
    handleSubmitSettingId () {
      if (this.settingId !== '-1') {
        this.specVisible = false
      }
    },
    onClose (type) {
      if (type !== 'cancel') {
        this.$emit('submit-setting-id', this.settingId)
      }
    }
  },
  props: {
    isIntegral: Boolean,
    visible: {
      type: Boolean,
      required: true,
      default: false
    },
    productId: {
      type: String,
      required: true
    },
    price: {
      type: String,
      required: true
    }
  }
}
