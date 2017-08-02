<template>
  <div class="pay-footer">
    <div class="content">
      <a href="javascript:void(0)" class="need-pay">
        <div class="container">
          <span class="title f24" v-html="title"></span><span class="f24">¥</span>
          <span class="price f48" v-html="price"></span>
        </div>
      </a>
      <a href="javascript:void(0)" class="submit ta-c f32" v-html="submitTitle" @click="submit"></a>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        default: '总计'
      },
      submitTitle: {
        type: String,
        default: '立即结算'
      },
      price: [String, Number]
    },
    methods: {
      submit () {
        this.$emit('pay')
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../common/scss/include';

  .pay-footer {
    @include footer(px2rem(100));

    .content {
      @extend %clb;
      a {
        float: left;
        height: px2rem(100);
      }

      .need-pay {
        width: 60%;
        background: $bgColor;
        padding: px2rem(30) 0;

        .container {
          padding-left: px2rem(40);
          display: table-cell;
          height: px2rem(40);
          vertical-align: bottom;

          span {
            color: $white;
          }

          .title {
            margin-right: px2rem(20);
          }
        }
      }

      .submit {
        width: 40%;
        height: px2rem(100);
        line-height: px2rem(100);
        color: $white;
        background: $orange;
      }

    }

  }

</style>
