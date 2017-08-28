<template>
  <!--<div></div>-->
  <div class="jfk-d-ib jfk-text-split" v-html="content"></div>
</template>
<script>
  export default {
    name: 'jfkTextSplit',
    data () {
      return {
        content: ''
      }
    },
    props: {
      text: {
        type: String,
        default: ''
      }
      ,
      split: {
        type: Number,
        default: 3
      }
    },
    watch: {
      text(val){
        if (val) {
          this.getContent()
        }
      }
    },
    created () {
      this.getContent()
    },
    methods: {
      getContent () {
        let arr = this.splitString()
        const len = arr.length
        if (typeof arr === 'undefined' || len === 0) {
          return false
        }

        if (arr[len - 1].length === 1) {
          arr[len - 2].concat(arr[len - 1])
          arr[len - 2] = arr[len - 2].concat(arr[len - 1])
          arr.length = len - 1
        }

        let resultStr = ''
        for (let i = 0; i < arr.length; i++) {
          let str = ''
          for (let j = 0; j < arr[i].length; j++) {
            str = str + arr[i][j]
          }
          let container = `<span class="jfk-text-split__item">${str}</span>`
          resultStr = resultStr + container
        }
        this.content = resultStr
      },
      splitString () {
        let strArray = this.text.split('')
        let result = [];
        for (let i = 0, len = strArray.length; i < len; i += this.split) {
          result.push(strArray.slice(i, i + this.split));
        }
        return result
      }
    }
  }
</script>
