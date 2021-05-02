### 通过 vue-cli 创建

```
npm install -g @vue/cli
```

#### 创建uni-app

**使用正式版**（对应HBuilderX最新正式版）

```
vue create -p dcloudio/uni-preset-vue my-project
```

**使用alpha版**（对应HBuilderX最新alpha版）

```
vue create -p dcloudio/uni-preset-vue#alpha my-alpha-project
```

此时，会提示选择项目模板，选择 `hello uni-app` 项目模板，如下所示：

<div>
<img src="https://img.cdn.aliyun.dcloud.net.cn/guide/uniapp/h5-cli-01.png" width="300">
</div>

创建好后，进入项目目录
```
cd my-project
```

执行该命令运行到 h5 端
```
npm run dev:h5
```
