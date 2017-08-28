const reg = /\r\n/g
export default function parseTextareaValue (str) {
  if (str) {
    let str1 = str.replace(/^\r\n|\r\n$/g, '')
    return str1.replace(reg, '<br/>')
  }
}
