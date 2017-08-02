## 重要说明
前端资源项目，请无关人员勿动，动之前详细阅读本说明文档


### 项目依赖
  - 依赖`nodejs`，请先安装nodejs包
  - 安装全局`webpack2`
  - 前端技术架构
    - 主框架为vue
    - ajax框架为axios

### 工程目录说明


### 开发说明
  - `npm install`
  - 此目录为公共目录，将所有的npm包集中放在顶层，不用每个项目都重新拉取npm包
  - 禁止提交`node_modules`目录到远程仓库

### npm脚本命令列表{#npmScriptLists}
  - `dev` 开发环境，此命令下会有调试log及warn信息，并且数据为mock数据
  - `build` 打包静态资源，去除调试log及warn信息，去除mock信息
  - `unit` 前端单元测试
  - `lint` javascript风格检测

