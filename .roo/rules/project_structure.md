---
description: 
globs: 
alwaysApply: false
---
项目的入口在[public/index.php](mdc:public/index.php)文件

### 模块说明

#### Blog 模块

负责博客相关的核心功能，包括：

*   博客文章管理（发布、编辑、删除，支持图文、分类、标签、归档）
*   博客评论和留言管理
*   博客分类管理
*   博客设置（包括关于博主信息）
*   前台博客展示（列表、详情、分页、搜索、热门等）
*   后台管理界面
*   可能还包括友情链接、主题切换、批量导入等功能。

#### Member 模块

通用用户系统，提供基础的用户管理功能，包括：

*   用户注册（用户名、手机、邮箱）
*   用户登录（用户名密码、手机验证码）
*   找回密码（邮箱、手机）
*   绑定信息（手机、邮箱）
*   授权登录（开放式授权登录接口）
*   用户资产（钱包、积分）
*   用户分组和VIP管理
*   后台管理界面
*   可能还包括单点登录 (SSO)、OAuth 登录、消息发送等功能。

#### VisitStatistic 模块

提供网站访问记录和统计功能，包括：

*   记录网站访问的 URL、IP、设备和 UserAgent
*   生成每日访问量 (PV) 和访客数 (UV) 统计报告
*   在后台仪表盘展示访问统计图表
*   提供详细访问记录和统计报告的后台界面
*   可配置是否启用、历史数据保留天数、是否记录 UserAgent、是否忽略搜索引擎等。

#### Vendor 模块

提供各种通用功能和服务的集合，供其他模块使用。包括：

*   服务提供者框架
*   通用工具类（如缓存）
*   抽象接口和基础实现
*   集成外部服务（如 OCR、邮件、短信）
*   后台组件扩展点

#### Site 模块

网站基础信息配置模块，用于配置网站的基本信息，包括：

*   网站信息（Logo、名称、域名、关键词、描述等）
*   主题设置（主色调、主题选择、主题自定义设置）
*   备案信息（ICP、公安备案等）
*   联系信息（邮箱、电话、地址、二维码等）
*   其他配置（如存储节流映射）
*   联系客服页面
*   后台管理界面

#### Partner 模块

友情链接管理模块，提供基于位置的友情链接管理功能，包括：

*   友情链接管理（添加、编辑、删除、排序）
*   多位置支持
*   独立页面展示
*   多种展示形式（文字、图片）
*   提供便捷调用代码
*   后台管理界面和功能设置
*   支持位置注册

#### ShareJS 模块

一键分享模块，提供网页内容分享到社交媒体的功能，包括：

*   支持多种社交媒体分享
*   提供便捷的 Blade 模板调用方式
*   可指定分享平台

#### ModuleStore 模块

模块市场模块，负责 ModStart 模块的管理和发现，包括：

*   模块安装、升级、卸载、启用和禁用
*   连接 ModStart 官方模块市场
*   处理模块下载和本地文件操作
*   版本兼容性检查
*   提供模块配置界面
*   后台管理界面

#### Banner 模块

通用轮播管理模块，提供多位置的轮播图片管理功能，支持图片、图文组合和视频轮播，包括：

*   轮播管理（添加、编辑、删除、排序）
*   多位置支持
*   多种内容类型（图片、图文、视频）
*   样式控制（背景色、圆角、容器等）
*   提供便捷调用代码
*   后台管理界面
*   支持位置注册

#### AigcBase 模块

AIGC 基础包，提供 AIGC 相关的基础框架和功能，包括：

*   AIGC 提供者框架（对话、图片、声音、视频）
*   支持集成不同的 AI 平台（智谱 AI, OpenAI 等）
*   AIGC 任务管理（同步/异步任务）
*   密钥池管理
*   配额管理集成
*   应用提供者框架
*   后台管理界面

#### AdminManager 模块

后台管理配置模块，提供后台管理角色、管理员、管理日志等功能，包括：

*   管理员管理
*   管理角色和权限
*   管理日志
*   系统升级功能
*   模块授权相关功能
*   服务器信息展示
*   后台管理界面

### 视图文件说明（resources/views）

**resources/views/theme/default/pc:** 默认主题在 PC 端使用的视图文件。

*   `dialogPage.blade.php`: 用于在对话框中显示页面的 Blade 模板文件。
*   `frame.blade.php`: 定义了页面基本框架或布局的 Blade 模板文件。
*   **resources/views/theme/default/pc/share:** 存放默认主题 PC 端共享视图片段。
    *   `header.blade.php`: 定义页面头部的 Blade 模板片段。
    *   `footer.blade.php`: 定义页面底部的 Blade 模板片段。
*   **resources/views/theme/default/pc/member:** 存放默认主题 PC 端会员中心相关的视图文件。
    *   `frame.blade.php`: 默认主题在 PC 端使用的会员中心主体布局文件。它定义了页面的整体结构，包括侧边导航（动态加载会员菜单）和主内容区域，具体的会员页面内容会插入到主内容区域。

**resources/views/errors:** 存放错误页面视图文件。

*   `404.blade.php`: 用于显示"404 页面未找到"错误。
*   `500.blade.php`: 用于显示"500 服务器内部错误"。

### 路由说明 (routes)

`routes` 目录用于定义应用程序的路由，将不同的 URL 请求映射到处理代码。

*   `web.php`: 定义处理 Web 请求的路由，通常经过 `web` 中间件组，提供会话和 CSRF 保护等。

### 会员模块视图文件说明 (module/Member/view)

`module/Member/view` 目录存放会员模块相关的视图文件。

**module/Member/view/pc:** 会员模块在 PC 端使用的视图文件，包括注册、登录、找回密码、OAuth 授权以及会员中心不同功能的页面。

*   `register.blade.php`: 用户注册页面。
*   `loginPhone.blade.php`: 使用手机号登录页面。
*   `registerPhoneDialog.blade.php`: 手机号注册的对话框模板。
*   `retrieve.blade.php`: 找回密码的入口页面。
*   `retrieveEmail.blade.php`: 通过邮箱找回密码的页面。
*   `retrievePhone.blade.php`: 通过手机号找回密码的页面。
*   `retrieveReset.blade.php`: 重设密码的页面。
*   `oauthBackAndClose.blade.php`: OAuth 授权后返回并关闭页面的模板。
*   `oauthBind.blade.php`: OAuth 账号绑定页面。
*   `oauthButtons.blade.php`: OAuth 登录按钮的视图片段。
*   `oauthProxy.blade.php`: OAuth 授权代理页面。
*   `registerDialog.blade.php`: 用户注册对话框模板。
*   `registerPhone.blade.php`: 手机号注册页面（可能是完整页面）。
*   `login.blade.php`: 用户名密码登录页面。
*   `loginDialog.blade.php`: 用户名密码登录对话框模板。
*   `loginOther.blade.php`: 其他登录方式（如 OAuth）的页面。
*   `loginOtherDialog.blade.php`: 其他登录方式的对话框模板。
*   `loginPhoneDialog.blade.php`: 手机号登录对话框模板。

该目录下还有子目录 (`inc`, `memberMoneyCharge`, `memberMoneyCash`, `memberProfile`, `memberMessage`, `memberAddress`, `memberCredit`, `memberMoney`, `memberData`, `memberVip`, `member`) 存放具体会员功能区域的视图文件。

**module/Member/view/pc/inc:** 存放会员模块在 PC 端使用的可重用视图片段。

*   `registerCaptcha.blade.php`: 注册页面中用于显示和处理验证码的 Blade 模板片段。
*   `loginPanel.blade.php`: 登录表单面板的 Blade 模板片段，可能包含用户名/密码或其他登录方式的输入框。
*   `registerPhonePanel.blade.php`: 手机号注册表单面板的 Blade 模板片段。
*   `registerPhoneScript.blade.php`: 手机号注册相关的 JavaScript 脚本。
*   `retrieveNav.blade.php`: 找回密码流程中导航部分的 Blade 模板片段。

**module/Member/view/pc/memberMoneyCharge:** 存放会员充值相关的视图文件。

*   `index.blade.php`: 会员充值页面的主视图文件。

**module/Member/view/pc/memberMoneyCash:** 存放会员提现相关的视图文件。

*   `index.blade.php`: 会员提现功能的主视图文件。
*   `log.blade.php`: 显示会员提现记录或历史的视图文件。
*   `logItem.blade.php`: 用于显示提现记录列表中单个条目的 Blade 模板片段。

**module/Member/view/pc/memberProfile:** 存放会员个人资料和安全设置相关的视图文件。

*   `email.blade.php`: 管理或修改会员邮箱的页面。
*   `nickname.blade.php`: 修改会员昵称的页面。
*   `oauth.blade.php`: 管理会员绑定的 OAuth（第三方）账号的页面。
*   `password.blade.php`: 修改会员登录密码的页面。
*   `phone.blade.php`: 管理或修改会员手机号的页面。
*   `profileNav.blade.php`: 个人资料相关页面的导航片段。
*   `securityNav.blade.php`: 安全设置相关页面的导航片段。
*   `avatar.blade.php`: 管理或上传会员头像的页面。
*   `delete.blade.php`: 会员账号注销/删除的页面。

**module/Member/view/pc/memberMessage:** 存放会员消息相关的视图文件。

*   `item.blade.php`: 用于显示会员消息列表中单个消息条目的 Blade 模板片段。

**module/Member/view/pc/memberAddress:** 存放会员地址管理相关的视图文件。

*   `index.blade.php`: 会员地址管理页面的主视图文件，可能用于展示地址列表。
*   `item.blade.php`: 用于显示会员地址列表中单个地址条目的 Blade 模板片段。

**module/Member/view/pc/memberCredit:** 存放会员积分相关的视图文件。

*   `index.blade.php`: 会员积分页面的主视图文件，可能用于展示积分余额和积分变动记录列表。
*   `item.blade.php`: 用于显示积分变动记录列表中单个条目的 Blade 模板片段。

**module/Member/view/pc/memberMoney:** 存放会员资金相关的视图文件。

*   `index.blade.php`: 会员资金页面的主视图文件，可能用于展示资金余额和资金变动记录列表。
*   `item.blade.php`: 用于显示资金变动记录列表中单个条目的 Blade 模板片段。

**module/Member/view/pc/memberData:** 存放会员数据相关的视图文件。

*   `fileManager.blade.php`: 会员文件管理功能的视图文件。

**module/Member/view/field:** 存放会员模块中用于表单字段或选择器相关的视图文件。

*   `adminUserSelector.blade.php`: 用于在后台或其他需要选择管理员用户的场景下的 Blade 模板片段。
*   `memberUsers.blade.php`: 用于在表单字段或其他需要显示或选择会员用户列表的场景下的 Blade 模板片段。

**module/Member/view/admin:** 存放会员模块后台相关的视图文件。

*   **module/Member/view/admin/memberUser:** 存放会员用户管理相关的后台视图文件。
    *   `show.blade.php`: 用于在后台显示单个会员用户详细信息的 Blade 模板文件。
*   **module/Member/view/admin/config:** 存放会员模块后台配置相关的视图文件。
    *   `param.blade.php`: 用于在后台配置会员模块参数的 Blade 模板文件。

**module/Member/view/inc:** 存放会员模块可重用的视图片段。

*   `memberNavMenu.blade.php`: 用于会员导航菜单的 Blade 模板片段。

### 数据库说明 (database)

`database` 目录主要存放与数据库相关的定义和管理文件，例如迁移、填充和工厂。

*   `.gitignore`: Git 忽略文件配置。
*   `migrations/`: 存放数据库迁移文件。这些文件用于通过代码定义和修改数据库结构（创建、修改或删除表、列等），并进行版本控制。

### 数据库表字段定义文档 (docs/database/tables)

详细的数据库表结构和字段定义文档生成在 `docs/database/tables/` 目录下。每个 Markdown 文件对应一个数据库表。

### 数据库表结构文档

- [blog](mdc:docs/database/tables/blog.md)
- [blog_message](mdc:docs/database/tables/blog_message.md)
- [blog_category](mdc:docs/database/tables/blog_category.md)
- [blog_comment](mdc:docs/database/tables/blog_comment.md)
- [member_vip_set](mdc:docs/database/tables/member_vip_set.md)
- [member_meta](mdc:docs/database/tables/member_meta.md)
- [member_user](mdc:docs/database/tables/member_user.md)
- [member_login_log](mdc:docs/database/tables/member_login_log.md)
- [member_data_statistic](mdc:docs/database/tables/member_data_statistic.md)
- [member_vip_right](mdc:docs/database/tables/member_vip_right.md)
- [member_card](mdc:docs/database/tables/member_card.md)
- [visit_statistic](mdc:docs/database/tables/visit_statistic.md)
- [vendor](mdc:docs/database/tables/vendor.md)
- [partner](mdc:docs/database/tables/partner.md)
- [nav](mdc:docs/database/tables/nav.md)
- [banner](mdc:docs/database/tables/banner.md)
- [aigc_base_user_resource](mdc:docs/database/tables/aigc_base_user_resource.md)
- [aigc_base_resource_package](mdc:docs/database/tables/aigc_base_resource_package.md)
- [admin_manager_department](mdc:docs/database/tables/admin_manager_department.md)
- [admin_manager_user](mdc:docs/database/tables/admin_manager_user.md)

### 应用程序核心说明 (app)

`app`