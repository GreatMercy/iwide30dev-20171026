let SECONDMILLSECONDS = 1000
let MINUTEMILLSECONDS = 60000
let HOURMILLSECONDS = 60 * MINUTEMILLSECONDS
let DATEMILLISECONDS = 24 * HOURMILLSECONDS
// 将一个毫秒转换成天时分秒
export default function millsecondsToDHMS (millseconds) {
  let dates = parseInt(millseconds / DATEMILLISECONDS)
  let _d = dates * DATEMILLISECONDS
  let hours = parseInt((millseconds - _d) / HOURMILLSECONDS)
  let _h = hours * HOURMILLSECONDS
  let minutes = parseInt((millseconds - _d - _h) / MINUTEMILLSECONDS)
  let seconds = parseInt((millseconds - _d - _h - minutes * MINUTEMILLSECONDS) / SECONDMILLSECONDS)
  return {
    dates,
    hours,
    minutes,
    seconds
  }
}
