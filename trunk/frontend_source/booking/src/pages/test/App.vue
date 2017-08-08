<template>
  <div class="jfk-pages">
    <div class="jfk-pages__theme"></div>
    <h1 @click="togglePopup">test</h1>
    <jfk-picker v-if="slots.length" class="font-size--28" :showToolbar="true" :valueKey="pickValueKey" :slots="slots" @change="onValuesChange">
      <div class="jfk-flex is-justify-space-between font-size--32">
        <span class="font-color-light-gray">取消</span>
        <span class="color-golden" @click="handleSaveArea">完成</span>
      </div>
    </jfk-picker>
  </div>
</template>
<script>
  import { findIndex } from '@/utils/utils'
  import { getExpressTree } from '@/service/http'
  const getAddressSlots = function (data, ids) {
    let result = []
    if (data.length) {
      let idx0 = 0
      let idx1 = 0
      let idx2 = 0
      if (ids[0]) {
        idx0 = findIndex(data, function (o) {
          return o.region_id === ids[0]
        })
        idx0 = idx0 === -1 ? 0 : idx0
      }
      let citys = data[idx0].children
      if (ids[1]) {
        idx1 = findIndex(citys, function (o) {
          return o.region_id === ids[1]
        })
        idx1 = idx1 === -1 ? 0 : idx1
      }
      let regions = citys[idx1].children
      if (regions && ids[2]) {
        idx2 = findIndex(regions, function (o) {
          return o.region_id === ids[2]
        })
        idx2 = idx2 === -1 ? 0 : idx2
      }
      result = [
        {
          flex: 1,
          values: data,
          defaultIndex: idx0
        }, {
          flex: 1,
          values: citys,
          defaultIndex: idx1
        }
      ]
      if (regions) {
        result.push({
          flex: 1,
          values: regions,
          defaultIndex: idx2
        })
      } else {
        result.push({
          flex: 0,
          values: []
        })
      }
    }
    return result
  }
  export default {
    data () {
      return {
        types: ['default', 'primary', 'ghost'],
        visible: false,
        pickValueKey: 'region_name',
        addressRegionIds: ['2', '52', '503'],
        addressData: [],
        slots: []
      }
    },
    created () {
      let that = this
      getExpressTree().then(function (res) {
        that.addressData = res.web_data[0].children
        that.slots = getAddressSlots(that.addressData, that.addressRegionIds)
      })
    },
    methods: {
      togglePopup () {
        this.visible = !this.visible
      },
      handleDateClick (val) {
        console.log(val)
      },
      onValuesChange (picker, values) {
        if (values) {
          let i = values[0].region_id
          let j = values[1] && values[1].region_id
          let newSlots = getAddressSlots(this.addressData, [i, j])
          picker.setSlotValues(1, newSlots[1].values)
          picker.setSlotValues(2, newSlots[2].values)
        }
      },
      handleSaveArea () {
        let data = this.$children[0].getValues()
        console.log(data)
      }
    }
  }
</script>
<style>
  li{
    padding: 90px;
  }
  .jfk-calendar {
    padding-top: 100px;
  }
</style>
