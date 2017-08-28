const isNativeStringType = function (type) {
  return type === 'string' ||
    type === 'url' ||
    type === 'hex' ||
    type === 'email' ||
    type === 'pattern'
}

const isEmptyValue = function (value, type) {
  if (value === undefined || value === null) {
    return true
  }
  if (type === 'array' && Array.isArray(value) && !value.length) {
    return true
  }
  if (isNativeStringType(type) && typeof value === 'string' && !value) {
    return true
  }
  return false
}
let defaultRules = {
  phone: function (val) {
    return /1\d{10}/.test(val)
  },
  required: function (val, type = 'string') {
    return !isEmptyValue(val, type)
  },
  range: function (val, type = 'string', min, max, len) {
    let _v = val
    if (type === 'string' || type === 'array') {
      _v = val.length
    }
    if (len) {
      return _v === len
    } else if (min !== undefined && max === undefined) {
      return _v >= min
    } else if (min === undefined && max !== undefined) {
      return _v <= max
    } else if (min !== undefined && max !== undefined) {
      return _v >= min && _v <= max
    }
    return true
  }
}
const check = function (rule, val) {
  if (rule.required) {
    return defaultRules.required(val, rule.type)
  }
  if (rule.type && defaultRules[rule.type]) {
    return defaultRules[rule.type](val)
  }
  if (rule.length) {
    return defaultRules.range(val, rule.type, rule.min, rule.max, rule.len)
  }
  if (rule.validator) {
    return rule.validator(val, rule)
  }
}
export default function validator (val, rules) {
  let i = 0
  let len = rules.length
  while (i < len) {
    let rule = rules[i]
    let passed = check(rule, val)
    if (!passed) {
      return {
        passed: false,
        message: rule.message,
        index: i
      }
    }
    i++
  }
  return {
    passed: true
  }
}
