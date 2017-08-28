<template>
  <div class="jfk-pages jfk-page__statistics-example">
    <el-tabs v-model="tabIndex" type="card" @tab-click="handleTabClick">
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
  export default {
    name: 'statistics-example',
    components: {
      IEcharts
    },
    data () {
      return {
        tabIndex: 'bar',
        chartOption: {},
        chartLoading: true
      }
    },
    methods: {
      chartReady (inst) {
        this.chartLoading = false
      },
      chartClick (e, inst, echarts) {
        console.log(arguments)
      },
      handleTabClick () {
        console.log(arguments)
      }
    },
    watch: {
      tabIndex (val) {
        this.chartLoading = true
        let result = {}
        if (val === 'line') {
          let dates = new Array(28).fill(0).map(function (val) {
            return '2017-05-' + (val < 10 ? '0' : '') + val
          })
          let datas = function () {
            return new Array(28).fill(0).map(function () {
              return parseInt(Math.random() * 100)
            })
          }
          result = {
            title: '趋势图',
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
            toolbox: {
              feature: {
                saveAsImage: {}
              }
            },
            xAxis: {
              type: 'time',
              boundaryGap: true,
              data: dates
            },
            yAxis: {
              type: 'value'
            },
            series: [
              {
                name: '浏览量',
                type: 'line',
                data: datas()
              },
              {
                name: '访客数',
                type: 'line',
                data: datas()
              },
              {
                name: '订单数',
                type: 'line',
                data: datas()
              },
              {
                name: '订单金额',
                type: 'line',
                data: datas()
              }
            ]
          }
        }
        this.chartOption = result
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
