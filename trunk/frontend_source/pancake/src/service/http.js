import * as apiConfig from './api'
import ajax from '@/utils/http'

const getPancakeGameParam = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_PARAM || apiConfig.v1.GET_PANCAKE_GAME_PARAM
  return ajax.get(url, data, config)
}

const getPancakeGameRoll = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_ROLL || apiConfig.v1.GET_PANCAKE_GAME_ROLL
  return ajax.get(url, data, config)
}

const getPancakeGameShare = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_SHARE || apiConfig.v1.GET_PANCAKE_GAME_SHARE
  return ajax.get(url, data, config)
}

const postPancakeGameReceivePrize = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PANCAKE_GAME_RECEIVE_PRIZE || apiConfig.v1.POST_PANCAKE_GAME_RECEIVE_PRIZE
  return ajax.post(url, data, config)
}

const getPancakeGamePrizeRanking = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_PRIZE_RANKING || apiConfig.v1.GET_PANCAKE_GAME_PRIZE_RANKING
  return ajax.get(url, data, config)
}

const getPancakeGameTimesRanking = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_TIMES_RANKING || apiConfig.v1.GET_PANCAKE_GAME_TIMES_RANKING
  return ajax.get(url, data, config)
}

const getPancakeGameThumbup = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_THUMBUP || apiConfig.v1.GET_PANCAKE_GAME_THUMBUP
  return ajax.get(url, data, config)
}
const getPancakeGameMyPrize = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_MY_PRIZE || apiConfig.v1.GET_PANCAKE_GAME_MY_PRIZE
  return ajax.get(url, data, config)
}
const getPancakeGameCouponList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_GAME_COUPON_LIST || apiConfig.v1.GET_PANCAKE_GAME_COUPON_LIST
  return ajax.get(url, data, config)
}
export {
  getPancakeGameParam,
  getPancakeGameRoll,
  getPancakeGameShare,
  postPancakeGameReceivePrize,
  getPancakeGamePrizeRanking,
  getPancakeGameTimesRanking,
  getPancakeGameThumbup,
  getPancakeGameMyPrize,
  getPancakeGameCouponList
}
