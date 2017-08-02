## 相关资源
    - [官网](http://postcss.org/)
    - [w3cplus postcss教程](https://www.w3cplus.com/blog/tags/516.html)

## 本项目中使用的postcss插件,相关插件说明请到npmjs上搜索对应插件
    - `postcss-import`
    - `postcss-at-rules-variables`
    - `postcss-custom-media`
    - `postcss-mixins`
    - `postcss-functions`
    - `postcss-each`
    - `postcss-for`
    - `postcss-conditionals`
    - `postcss-media-minmax`
    - `postcss-nested-props`
    - `postcss-nesting`
    - `postcss-nested`
    - `postcss-atroot`
    - `postcss-extend`
    - `postcss-css-variables`
    - `postcss-color-function`
    - `postcss-calc`
    - `autoprefixer`

## 已集成功能简介
    - 自定义变量
        ```css
            :root{ /*全局变量*/
                --color: blue
            }
            body {
                color: var(--color) /* color: blue */
            }
            h1 {
                --color: green /* 局部变量*/
                color: var(--color) /* color:green  */
            }
        ```
    - 嵌套写法及继承属于
        ```css
            .test{
                &--a{
                    color: green;
                }
                &--b {
                    padding: {
                        left: 5px;
                        right: 5px;
                    }
                    &:before{
                        color: red;
                    }
                }
            }
            /*
            .test--a{color:green};
            .test--b{padding-left:5px;padding-right: 5px;}
            .test--b:before{color:red}
             */
        ```
    - 定义mixin
        ```css
            @define-mixin test $color:blue {
                color: $(color);
            }
            .test1{
                @mixin test  /* color: blue  */
            }
            .test2 {
                @mixin test red /* color: red */
            }

            /* 高级用法  */
            @define-mixin icon $network, $color: blue {
                .icon.is-$(network) {
                    color: $color;
                    @mixin-content;
                }
                .icon.is-$(network):hover {
                    color: white;
                    background: $color;
                }
            }

            @mixin icon twitter {
                background: url(twt.png);
            }
            @mixin icon youtube, red {
                background: url(youtube.png);
            }
            /**
                .icon.is-twitter {
                    color: blue;
                    background: url(twt.png);
                }
                .icon.is-twitter:hover {
                    color: white;
                    background: blue;
                }
                .icon.is-youtube {
                    color: red;
                    background: url(youtube.png);
                }
                .icon.is-youtube:hover {
                    color: white;
                    background: red;
                }
             */
        ```
    - 定义placeholder
        ```css
        @define-placeholder tofle {
            text-overflow: ellipsis;
        }
        .a{
            @extend tofle;
            color: red;
        }
        .b {
            @extend tofle;
            color: yellow;
        }
        /**
          .a,.b{text-overflow: ellipsis}
          .a {color:red}
          .b{color: yellow}
         */
        ```
    - if for each的使用
        ```css
            @define-mixin hide-font $type: 1{
                @if $type === 1 {
                    font: 0/0 'a'
                } @else {
                    text-indent: -9999rem;
                }
            }
            .a {
                @mixin hide-font /*font: 0/0 'a'*/
            }
            .b {
                @mixin hide-font 2 /*text-indent: -9999rem*/
            }

            @each $icon in foo, bar, baz {
              .icon-$(icon) {
                background: url('icons/$(icon).png');
              }
            }
            /**
                .icon-foo {
                  background: url('icons/foo.png');
                }

                .icon-bar {
                  background: url('icons/bar.png');
                }

                .icon-baz {
                  background: url('icons/baz.png');
                }
             */
        ```
    - calc自动计算
        ```css
            body{
                width: calc(100 / 1000 * 100%) /*width: 10%*/
            }
        ```
    - 其他
        - 通过import引入其他文件
        - 通过autoprefixer自动补前缀
        - 颜色函数
        - 自定义函数
