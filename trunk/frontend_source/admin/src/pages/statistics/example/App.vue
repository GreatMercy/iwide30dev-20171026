<template>
  <div class="jfk-pages jfk-page__statistics-example">
    <el-radio-group v-model="time" class="jfk-mb-20">
      <el-radio-button :label="1">昨天</el-radio-button>
      <el-radio-button :label="7">过去一周</el-radio-button>
      <el-radio-button :label="30">过去一个月</el-radio-button>
    </el-radio-group>
    <el-tabs v-model="tabIndex" type="card">
      <el-tab-pane label="柱图" name="bar"></el-tab-pane>
      <el-tab-pane label="折线图" name="line"></el-tab-pane>
      <el-tab-pane label="饼图" name="pie"></el-tab-pane>
      <el-tab-pane label="漏斗图" name="funnel"></el-tab-pane>
    </el-tabs>
    <div class="charts">
      <IEcharts :option="chartOption" :loading="chartLoading" @ready="chartReady" @click="chartClick"></IEcharts>
    </div>
  </div>
</template>
<script>
  import IEcharts from 'vue-echarts-v3/src/lite'
  import 'echarts/lib/chart/bar'
  import 'echarts/lib/chart/line'
  import 'echarts/lib/chart/pie'
  import 'echarts/lib/chart/funnel'
  import 'echarts/lib/component/legend'
  import 'echarts/lib/component/title'
  export default {
    name: 'statistics-example',
    components: {
      IEcharts
    },
    data () {
      return {
        tabIndex: 'bar',
        chartLoading: true,
        time: 1,
        series1: ['普通购买', '秒杀购买', '拼团购买', '礼品卡券', '大客户购买'],
        chartInst: null
      }
    },
    methods: {
      chartReady (inst) {
        this.chartInst = inst
        console.log('ready')
        this.chartLoading = false
      },
      chartClick (e, inst, echarts) {
        console.log(arguments)
      },
      datas () {
        return new Array(this.time).fill(0).map(function () {
          return parseInt(Math.random() * 100)
        })
      },
      dates () {
        return new Array(this.time).fill(0).map(function (val, index) {
          index = index + 1
          return '2017-05-' + (index < 10 ? '0' : '') + index
        })
      },
      datas2 () {
        return this.series1.map(function (s) {
          return {
            name: s,
            value: parseInt(Math.random() * 100)
          }
        })
      }
    },
    computed: {
      chartOption () {
        let vm = this
        let result = {}
        let tabIndex = vm.tabIndex
        vm.chartLoading = true
        if (tabIndex === 'line') {
          result = {
            title: {
              text: '趋势图'
            },
            tooltip: {
              trigger: 'axis'
            },
            legend: {
              data: ['浏览量', '访客数', '订单数', '订单金额']
            },
            grid: {
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
            },
            xAxis: {
              type: 'category',
              data: vm.dates()
            },
            yAxis: {
              type: 'value'
            },
            series: [
              {
                name: '浏览量',
                type: 'line',
                data: vm.datas()
              },
              {
                name: '访客数',
                type: 'line',
                data: vm.datas()
              },
              {
                name: '订单数',
                type: 'line',
                data: vm.datas()
              },
              {
                name: '订单金额',
                type: 'line',
                data: vm.datas()
              }
            ]
          }
        } else if (tabIndex === 'pie') {
          result = {
            title: {
              text: '购买方式'
            },
            tooltip: {
              trigger: 'item',
              formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
              orient: 'vertical',
              left: 'left',
              data: vm.series1
            },
            series: [
              {
                name: '订单数',
                type: 'pie',
                radius: '23%',
                center: ['25%', '25%'],
                data: vm.datas2()
              },
              {
                name: '购买件数',
                type: 'pie',
                radius: '23%',
                center: ['75%', '25%'],
                data: vm.datas2()
              }
            ],
            itemStyle: {
              emphasis: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
              }
            }
          }
        } else if (tabIndex === 'bar') {
          result = {
            title: {
              text: '购买方式'
            },
            tooltip: {
              trigger: 'axis',
              axisPointer: {
                type: 'shadow'
              }
            },
            legend: {
              data: vm.series1
            },
            grid: {
              left: '3%',
              right: '3%',
              bottom: '3%',
              containLabel: true
            },
            yAxis: {
              type: 'category',
              data: vm.dates()
            },
            xAxis: {
              type: 'value'
            },
            series: [
              {
                name: '普通购买',
                type: 'bar',
                data: vm.datas()
              },
              {
                name: '秒杀购买',
                type: 'bar',
                data: vm.datas()
              },
              {
                name: '拼团购买',
                type: 'bar',
                data: vm.datas()
              },
              {
                name: '礼品卡券',
                type: 'bar',
                data: vm.datas()
              },
              {
                name: '大客户购买',
                type: 'bar',
                data: vm.datas()
              }
            ]
          }
        } else if (tabIndex === 'funnel') {
          result = {
            title: {
              text: '交易概况'
            },
            tooltip: {
              trigger: 'item',
              formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
              data: vm.series1
            },
            calculabel: true,
            series: [
              {
                name: '漏斗图',
                type: 'funnel',
                left: '10%',
                top: 60,
                // x2: 80,
                bottom: 60,
                width: '80%',
                // height: {totalHeight} - y - y2,
                min: 0,
                max: 100,
                minSize: '0%',
                maxSize: '100%',
                sort: 'descending',
                gap: 2,
                label: {
                  normal: {
                    show: true,
                    position: 'inside'
                  },
                  emphasis: {
                    textStyle: {
                      fontSize: 20
                    }
                  }
                },
                labelLine: {
                  normal: {
                    length: 10,
                    lineStyle: {
                      width: 1,
                      type: 'solid'
                    }
                  }
                },
                itemStyle: {
                  normal: {
                    borderColor: '#fff',
                    borderWidth: 1
                  }
                },
                data: vm.datas2()
              }
            ]
          }
        }
        vm.chartLoading = false
        return result
      }
    },
    watch: {
      tabIndex () {
        if (this.chartInst) {
          this.chartInst.clear()
        }
      },
      time (val) {
        if (this.chartInst) {
          this.chartInst.clear()
        }
      }
    }
  }
</script>
<style>
  .charts {
    width: 500px;
    height: 500px;
  }
</style>
