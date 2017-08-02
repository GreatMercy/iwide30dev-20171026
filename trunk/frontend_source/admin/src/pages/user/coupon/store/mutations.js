import {
  CODE_INFO,
  UPDATE_COUPON_STEP,
  UPDATE_LOADING
} from '@/service/user/types'
/* eslint-disable camelcase */
export default {
  [CODE_INFO] (state, { csrf_token, csrf_value, enum_des, enum_des_selected, input_tag, page_field, page_hint, page_resource, temp_input_group, text_selected }) {
    state.csrf_token = csrf_token
    state.csrf_value = csrf_value
    state.enum_des = enum_des
    state.enum_des_selected = enum_des_selected
    state.input_tag = input_tag
    state.page_field = page_field
    state.page_hint = page_hint
    state.page_resource = page_resource
    state.temp_input_group = temp_input_group
    state.text_selected = text_selected
  },
  [UPDATE_COUPON_STEP] (state, { increment }) {
    if (increment) {
      state.increment = state.increment > 0 ? ++state.increment : 1
    } else {
      state.increment = state.increment < 0 ? --state.increment : -1
    }
  },
  [UPDATE_LOADING] (state, { loading }) {
    state.loading = loading
  }
}
