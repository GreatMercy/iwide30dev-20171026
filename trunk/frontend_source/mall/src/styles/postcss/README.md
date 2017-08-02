### 主题构成说明
    - 每份主题分成与主题无关的common样式、与主题有关但可以根据变量值的变化来自动变更的theme样式、不同主题特殊化的样式三部分构成，这份主题又会被细分成mixins placeholder modules pages等子模块
    - 举例说明
        ```css
            /*common.postcss*/
            .clock {font-size: 1em; border: solid 1px #fff}
            /*theme.postcss 其中变量clock-color与clock-border-radius在variable文件夹下的dark.postcss与light.postcss都有定义*/
            .clock {color: var(--clock-color); border-radius: var(--clock-border-radius)}
            /*dark.postcss*/
            .clock {line-height: 1.2}
            /*light.postcss*/
            .clock {padding-bottom: 1.2em;}
        ```

### 文件命名说明
    - common.postcss 是公用的样式，与主题无任何关联，这一部分不会随着变量值的改变而变化
    - theme.postcss 与主题有关的公用样式，这一部分样式会随着导入不同的变量配置文件进行变化
    - dark.postcss 为黑色主题相关样式配置文件
    - light.postcss 为亮色主题相关样式配置文件

### 文件夹说明
    - mixins mixins文件夹
    - placeholder placeholder文件夹
    - modules css模块文件夹
    - pages 页面级的样式文件夹
    - theme 主题相关文件夹
    - variable 变量相关文件夹

### 文件导入说明
    - 所有common.postcss 文件最终都会被导入 styles/postcss/common.postcss文件中
    - 所有theme.postcss  文件最终都会被导入 styles/postcss/theme/theme.postcss文件夹中
    - 除theme以外所有文件夹下dark.postcss和light.postcss文件都会被分别导入styles/postcss/theme下对应的dark.postcss与light.postcss文件中
    - theme最终会通过styles/postcss/theme/dark[light].postcss导入到页面中
    - 关于所有postcss文件能自动使用variable mixin placeholder的说明
        - common文件
            - mixins/common.postcss能自动使用variable/placeholder的common.postcss文件
            - placeholder/common.postcss能自动使用到variable的common.postcss文件
            - 除mixins/common.postcss placeholder/common.postcss variable/common.postcss 三种文件以外所有的common.postcss都能自动使用variable/common.postcss placeholder/common.postcss variable/common.postcss文件
        - theme文件
            所有theme文件能自动使用variable/common.postcss placeholder/common.postcss mixins/common.postcss及最终这个theme被导入到主题文件对应的variable placeholder mixin下的主题文件
        - dark[light]文件
            所有dark[light]文件能自动使用variable/common.postcss placeholder/common.postcss mixins/common.postcss及对应的variable placeholder mixin下的dark[light]文件

### 使用说明
    - 在main.js中导入common.postcss 及 postcss/theme/dark[light].postcss导入页面中，通过配置webpack的entry入口，最终打包成两份common.css及theme.css文件
    - 在开发环境中默认使用dark主题，可以动态传入参数theme=1切换到light主题

