# 这是公用模块目录
    - postcss为css公共模块
        - fonts为字体图标公用模块
            - number为新版价格所用字体图标及人民币符号
        - functions 为postcss-functions中所用函数目录，其中文件名就是postcss中使用的function名
        - mixins 为postcss-mixins所用的源文件
        - variables为共用的variables文件

    - components 为公用模块目录，基本都是从[mintUI](https://mint-ui.github.io/#!/zh-cn)、[vux](https://vux.li/#/)的组件中修改而来
        - 所有组件分为黑白两种主题，引用组件时，需要引入对应的common.postcss及theme.postcss和dark[light].postcss文件
        - 所有组件采用bem方法命名，全部以jfk为命名空间，如加载更多组件为jfk-loadmore jfk-loadmore__content