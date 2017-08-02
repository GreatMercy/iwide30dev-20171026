### 目录说明
此目录放置模块相关api接口，http方法及store类型
- api.js  接口地址，用版本号包裹
```js
    const v1 = {
      // 价格码
      GET_HOTEL_PRICES_CODE_INFO: `${API_HOTEL_V1}/prices/code_edit`,
      // 房型
      GET_HOTEL_ROOMS_LIST: `${API_HOTEL_V1}/rooms/get_rooms`,
      // 获取商品
      GET_HOTEL_GOODS_LIST: `${API_HOTEL_V1}/goods/get_list`,
      // 修改商品订房价格 单位
      POST_HOTEL_GOODS_INFO: `${API_HOTEL_V1}/goods/edit_post`,
      // 通过pcode获取价格代码已经设置的酒店和房型
      GET_HOTEL_ROOM_BY_CODE: `${API_HOTEL_V1}/rooms/get_rooms_by_code`,
      // 提交价格代码配置
      POST_HOTEL_PRICES_CODE_INFO: `${API_HOTEL_V1}/prices/edit_code_post`,
      // 邮寄发货
      POST_EXPRESS_DELIVERY: `${API_EXPRESS_V1}/create_shipping_order`
    }

    export {
      v1
    }
```

- http.js 接口请求方法 命名规则为http方法+接口名
    - 请求列表数据  `getListData`
    - 修改列表数据  `postGoodSort`

- types.js store类名常量 命名规则为 动作[INIT/UPDATE/DELETE/ADD/GET/POST/DELETE/PUT等等] + 方法名 + [ACTION如果是action的话]

### 模块命名说明
    - 订房--booking  
    - 会员--user   
    - 商城--mall  
    - 系统--system 
    - 点餐--ordering     
    - 社群客--customer    
    - 分销--distribution   
    - 快乐付--happypay    
    - 预约--reservation       
    - 基础--basic    
    - 数据—data

### 其它常见
