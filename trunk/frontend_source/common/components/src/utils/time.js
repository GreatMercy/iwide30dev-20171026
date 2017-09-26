import stringLengthToTwo from './string-length-to-two.js'
const datesOfMonth = [31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

export function getFirstDateInMonth (y, m) {
  return new Date(y, m - 1, 1)
}

//是否为闰年
export function isLeapYear (y) {
  return !(y % 4) && !!(y % 100) || !(y % 400)
}

export function getDatesInPrevMonth (y, m, firstDay = 0) {
  let firstDayInMonth = getFirstDateInMonth(y, m).getDay()
  let dates = 0
  if (~firstDayInMonth) {
    if (firstDayInMonth > firstDay) {
      dates = firstDayInMonth - firstDay
    } else if (firstDayInMonth === firstDay) {
      dates = 0
    } else {
      dates = 6 - firstDay + 1 + firstDayInMonth
    }
  }
  return dates
}

export function getDatesInNextMonth (y, m, firstDay, weekMode) {
  return weekMode ? 6 : getWeeksInMonth(y, m, firstDay) * 7 - getDatesInPrevMonth(y, m, firstDay) - getDatesInMonth(y, m)
}

export function getDatesInMonth (y, m) {
  --m
  return m === 1 ? isLeapYear(y) ? 29 : 28 : datesOfMonth[m]
}

export function getWeeksInMonth (y, m, firstDay) {
  var datesInMonth = getDatesInMonth(y, m) - 7 + getDatesInPrevMonth(y, m, firstDay)
  return Math.ceil(datesInMonth / 7) + 1 || 0
}

export function getDatesInYear (y, m, d) {
  let _d = 0
  let i = 1
  while (i < m) {
    _d = _d + (i === 2 ? isLeapYear(y) ? 29 : 28 : datesOfMonth[m - 1])
    i++
  }
  _d += d
  return _d
}

export function getWeeksInYear (y, m, d) {
  let _d = getDatesInYear(y, m, d)
  return Math.round(_d / 7)
}

export function cloneDate (date) {
  return new Date(date.getTime())
}

export function cloneAsDate (date) {
  let _clonedDate = cloneDate(date)
  _clonedDate.setHours(0, 0, 0, 0)
  return _clonedDate
}

export function addDays (date, d) {
  const newDate = cloneDate(date)
  newDate.setDate(date.getDate() + d)
  return newDate
}

export function subtractDays(date, d) {
  const newDate = cloneDate(date)
  newDate.setDate(date.getDate() - d)
  return newDate
}

export function isAfterDate(date1, date2) {
  const d1 = cloneAsDate(date1)
  const d2 = cloneAsDate(date2)
  return d1 > d2
}
//Thanks https://github.com/callemall/material-ui/blob/master/src/DatePicker/dateUtils.js#L149-L155
export function monthDiff(d1, d2) {
  let m
  m = (d1.getFullYear() - d2.getFullYear()) * 12
  m += d1.getMonth()
  m -= d2.getMonth()
  return m
}

const reg = /d{1,4}|M{1,4}|yy(?:yy)?/g
const formatFlag = {
  yy: function (o) {
    return o.y.substr(2)
  },
  yyyy: function (o) {
    return o.y
  },
  M: function (o) {
    return o.m
  },
  MM: function (o) {
    return stringLengthToTwo(o.m)
  },
  d: function (o) {
    return o.d
  },
  dd: function (o) {
    return stringLengthToTwo(o.d)
  }
}
export function formatDate (o, format) {
  let result = {}
  if (!o.y) {
    result = {
      y: o.getFullYear(),
      m: o.getMonth() + 1,
      d: o.getDate()
    }
  } else {
    result = o
  }
  return format.replace(reg, function ($0) {
    return $0 in formatFlag ? formatFlag[$0](result) : $0.slice($0.length - 1)
  })
}

export const dateKeyFormat = 'yyyy/MM/dd'
