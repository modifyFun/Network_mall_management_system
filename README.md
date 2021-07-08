## 商城后台管理系统

### 运行环境

Apache 2.4.39

MySql 5.5.29 数据库 账号：root 密码：root

Php 7.2.9 nts

Chrome 版本 83.0.4103.106（正式版本） （64 位）

**注意事项：**

1. **网站入口为**  **myshop/view/adlogin/index.html**  **需把网站根目录设置为**  **myshop** ，否则可能发生路径错误
2. 需要登录后才能从后台获取数据 预设登录账号为：test  密码为：test

### 需求分析
![1](https://user-images.githubusercontent.com/58978356/124966811-4edf5300-e056-11eb-9dd5-a07db67ada99.PNG)
![2](https://user-images.githubusercontent.com/58978356/124966830-530b7080-e056-11eb-8f21-784bab4e7149.PNG)
![3](https://user-images.githubusercontent.com/58978356/124966846-56066100-e056-11eb-8fac-e3180fc406e7.PNG)
### 数据库设计

**库名：** **myshop**

用户表users

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| user\_id | int (primary key、auto\_increase) | not null | 用户id |
| Name | varchar | not null | 用户名 |
| psw | varchar | not null | 用户密码 |
| sex | tinyint | default(1) | 用户性别（1为男 0为女） |
| phone | int | not null | 手机号码 |
| grade | tinyint | default (0) | 账户等级 |
| headimg | varchar | default(/public/img/head) | 头像地址 |
| resgister\_date | int | not null | 注册时间 |
| load\_date | int | not null | 最近一次登录时间 |
| isaccess | tinyint | not null | 是否允许登录（1允许 0拒绝） |

用户地址表address

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| addr\_id | int (primary key、auto\_increase) | not null | 地址id |
| user\_id | int | not null | 用户id |
| address | varchar | not null | 用户地址 |

用户钱包表 ccount

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| accout\_id | int (primary key、auto\_increase) | not null | 钱包账户id |
| user\_id | int | not null | 用户id |
| spending | int | default(0) | 消费金额 |
| balance | int | default(0) | 余额 |

用户行为分析表 user\_analyse

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| user\_id | int | not null | 用户id |
| visit\_times | int | default(1) | 访问次数 |
| order\_quantity | int | default(0) | 订单数 |
| fail\_order | int | default(0) | 交易失败订单数 |

管理员表 admins

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| admin\_id | int (primary key、auto\_increase) | not null | 管理员 id |
| name | varchar | null | 管理员昵称 |
| psw | varchar | not null | 密码 |
| type | tinyint | not null | 管理员类型 |
| isaccess | tinyint | not null | 是否允许登录（1允许 -1拒绝） |

商品表 goods

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| goods\_id | int (primary key、auto\_increase) | not null | 商品 id |
| category\_id | int | not null | 商品类别id |
| name | varchar | not null | 商品名称 |
| goods\_img | varchar | not null | 商品图片 |
| intro | varchar | not null | 商品简介 |
| deatail | text | null | 商品详情 |
| shop\_price | decimal | not null | 上架价格 |
| sale\_price | decimal | not null | 促销价格 |
| goods\_price | decimal | null | 进货价格 |
| Sale\_num | int | default(0) | 商品销量 |
| inventor | int | default(0) | 商品库存 |
| state | tinyint | default(1) | 商品状态 1为在售2为缺货 3为下架 |

商品类目表 category

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| category\_id | int (primary key、auto\_increase) | not null | 类别id |
| category\_name | varchar | not null | 类别名称 |
| category\_grade | tinyint | not null default(1) | 类别级数 |
| parent\_id | int | Not null | 父类id |

订单主表 orders

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| order\_id | int (primary key、auto\_increase) | not null | 订单id |
| user\_id | int | not null | 用户id |
| price | decimal | not null | 订单总价 |
| address | varchar | not null | 买家地址 |
| phone | int | not null | 买家电话 |
| express\_number | int | null | 快递单号 |
| express\_date | int | null | 发货日期 |
| sate | tinyint | not null default(0) | 订单状态( 0:未发货 1：已发货 2:已签收 3：退货发起 4：退货中 5：订单取消 6：订单完成) |
| order\_date | int | not null | 下单时间 |

订单详情表 goods\_detail

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| order\_id | int （foreign key） | not null | 订单编号 |
| goods\_id | int | not null | 商品id |
| goods\_num | int | not null | 商品件数 |
| goods\_price | int | not null | 商品单价 |

快递种类表 express

| 字段名 | 类型 | 备注 | 描述 |
| --- | --- | --- | --- |
| express\_id | int | not null | 快递品牌编号 |
| express\_name | varchar | not null | 快递名称 |
| express\_logo | varchar | not null | 快递商标 |
| price | smallint | not null | 快递单价 |

### 项目结构

├─kit //存放工具

│ ├─jq

│ └─layui

│ ├─css

│ │ └─modules

│ │ ├─laydate

│ │ │ └─default

│ │ └─layer

│ │ └─default

│ ├─font

│ ├─images

│ │ └─face

│ └─lay

│ └─modules

├─php //存放后端代码

│ ├─api //存放api接口代码

│ │ ├─adhome

│ │ ├─category

│ │ ├─goods

│ │ ├─login

│ │ ├─order

│ │ └─upload

│ ├─control //存放数据处理控制代码

│ └─model //存放模块代码

├─upload //存放用户上传的资源

│ └─goods\_img

│

└─view //存放视图代码

├─adhome

│ ├─css

│ └─js

├─adlogin

│ ├─css

│ ├─img

│ └─js

├─category

├─goods

├─order

└─public

├─css

└─img

### 功能设计

#### 用户登录

  登录验证

  登录模块

  验证码

#### 商品列表

  搜索

  列表展示

  操作（查看/修改/下架）

  分页

#### 发布商品

  商品信息填写表格

  商品图片上传

#### 修改商品

  与发布商品类似

#### 商品类目

  类目列表展示

  类目名称修改

  类目增加

#### 库存预警

  库存小于2发出预警

#### 订单列表

  展示订单列表

  发货操作

  处理退货等问题

#### 发货管理

  发货操作

  更改订单地址

#### 首页（网站分析）

  订单数量

  用户数量

  总收入

  缺货列表

  账号登出

### Api 接口设计

#### 结构

{

&quot;code&quot;: //状态码

&quot;status&quot;: //状态信息

&quot;message&quot;: //提示信息

&quot;data&quot;:[] //数据

}

#### v1.api.home

功能：获取主页数据

使用：使用 get 请求

参数：

无

#### category/v1.api.add

功能：增加分类

使用：使用 post 请求

参数：

&quot;category\_name&quot;, 类目名

&quot;category\_grade&quot;, 类目等级

&quot;parent\_id&quot; 父类目id

#### category/v1.api.list

功能：获取分类列表

使用：使用 get请求

参数：

无

#### category/v1.api.mod

功能：修改分类

使用：使用 post请求

参数：

&quot;category\_id&quot;, 种类id

&quot;category\_name&quot; 种类名称

#### goods/ v1.api.detail

功能：获取商品详细信息

使用：使用 get请求

参数：

&quot; goods\_id&quot;, 商品id

#### goods/ v1.api. goodsList

功能：获取商品列表信息

使用：使用 get请求

参数：

&#39;type&#39;, 请求的类型 1：商品列表 2：热门商品 3：缺货商品

startPage&#39;,

&#39;pageSize&#39;

#### goods/ v1.api.modgoods

功能：修改商品信息

使用：使用 post请求

参数：

&quot;modType&quot; (1修改全部信息，2修改状态信息, 3修改库存,)

&quot;goods\_id&quot;,

&quot;category\_id&quot;,

&quot;name&quot;,

&quot;goods\_img&quot;,

&quot;intro&quot;,

&quot;shop\_price&quot;,

&quot;sale\_price&quot;,

&quot;goods\_price&quot;,

&quot;inventor&quot;,

&quot;state&quot;&#39;

#### goods/ v1.api.soldout

功能：下架商品

使用：使用 post请求

参数:

&quot;goods\_id&quot;

#### goods/ v1.api.putaway

功能：上架商品

使用：使用 post请求

参数:

&quot;category\_id&quot;,

&quot;name&quot;,

&quot;goods\_img&quot;,

&quot;intro&quot;,

&quot;shop\_price&quot;,

&quot;sale\_price&quot;,

&quot;goods\_price&quot;,

&quot;inventor&quot;

#### goods/ v1.api.search

功能：搜索商品

使用：使用 get 请求

参数:

&quot;search&quot; 查找条件

&quot;type&quot; 查找类型 1:根据id 2:根据名称 3：根据种类 4：根据状态

#### upload/ v1.api.uploadImg

功能：上传照片

使用：使用 post 请求

参数:

file

#### order/ v1.api.detail

功能：获取订单详情

使用：使用 get 请求

参数:

&quot;order\_id&quot;

#### order/ v1.api.list

功能：获取订单列表

使用：使用 get 请求

参数:

无

#### order/ v1.api.mod

功能：修改订单信息

使用：使用 post 请求

参数:

&quot;express\_number&quot;

&quot;order\_id&quot;

&quot;price&quot;

&quot;address&quot;

&quot;phone&quot;

&quot;express\_number&quot;

&quot;state&quot;

type , 1：修改快递 2：修改地址 3：修改状态 4：修改订单 5：修改订单商品列表

6：删除订单商品

#### order/v1.api.search

功能：搜索订单

使用：使用 get 请求

参数:

type, 1：根据id 2：根据用户id 3：根据订单状态

search 搜索内容

#### login/v1.api.adlogin

功能：管理员登录

使用：使用 post 请求

参数:

adaccout

adpsw

captcha 验证码

#### login/ v1.api.adlogout

功能：管理员登出

使用：使用 get 请求

参数:

无

### 页面设计

#### 登录页面
![image](https://user-images.githubusercontent.com/58978356/124966920-68809a80-e056-11eb-9f5f-448b1e3f1ba9.png)

#### 后台首页

![image](https://user-images.githubusercontent.com/58978356/124966954-71716c00-e056-11eb-92be-ec95867020dc.png)

#### 商品列表

![image](https://user-images.githubusercontent.com/58978356/124966976-76362000-e056-11eb-89e8-c38fde76fe46.png)

#### 增加商品

![image](https://user-images.githubusercontent.com/58978356/124966989-7c2c0100-e056-11eb-9149-966725d08bab.png)

#### 搜索商品

![image](https://user-images.githubusercontent.com/58978356/124967019-82ba7880-e056-11eb-8d79-5cec5a693b4c.png)

#### 订单列表
![image](https://user-images.githubusercontent.com/58978356/124967028-864dff80-e056-11eb-8e90-7ca4204faeb7.png)

#### 种类列表

![image](https://user-images.githubusercontent.com/58978356/124967041-8a7a1d00-e056-11eb-886f-a197dfdf2292.png)

Tip: 种类为二级目录，增加操作需要修改新增节点名称方可进行增加
