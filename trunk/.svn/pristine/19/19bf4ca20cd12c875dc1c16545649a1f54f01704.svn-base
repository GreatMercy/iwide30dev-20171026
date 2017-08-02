<template>
  <div class="info">
    <h2 class="f24">餐厅信息</h2>
    <location :hotelName="hotelDetail.hotel_name"
    :phone="hotelDetail.hotel_tel"
    :address="hotelDetail.hotel_address"
    :latitude="hotelDetail.hotel_latitude"
    :longitude="hotelDetail.hotel_longitude">
    </location>
  </div>
</template>

<script>
  import location from '@components/location/index' // 餐厅信息

  export default {
    components: {
      location
    },
    computed: {
      hotelDetail () {
        return this.$store.getters.orderDetail['shop'] || {'hotel_name': '', 'hotel_tel': '', 'hotel_latitude': '', 'hotel_longitude': ''}
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  .info {
    h2 {
      color: $lightGray;
      margin: px2rem(76) 0 px2rem(46) 0;
    }
    padding: 0 px2rem(30);
  }

</style>
