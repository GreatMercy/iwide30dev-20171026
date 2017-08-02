export default {
  getCodeInfos (state) {
    return {
      price_code: state.priceCode,
      price_name: state.priceName,
      type: state.type,
      related_code: state.relatedCode,
      des: state.des,
      is_package: state.isPackage,
      status: state.status,
      [state.csrfToken]: state.csrfValue
    }
  }
}
