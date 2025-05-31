# 数据库表: `member_user`

| 字段名称         | 数据类型          | 是否可空 | 备注/说明      |
| ---------------- | ----------------- | -------- | -------------- |
| id               | bigIncrements     | 否       | 主键           |
| created_at       | timestamp         | 是       | 创建时间       |
| updated_at       | timestamp         | 是       | 更新时间       |
| username         | string(50)        | 是       | 用户名         |
| phone            | string(20)        | 是       | 手机           |
| email            | string(200)       | 是       | 邮箱           |
| password         | char(32)          | 是       | 密码           |
| passwordSalt     | char(16)          | 是       | 密码Salt       |
| lastLoginTime    | timestamp         | 是       | 上次登录时间   |
| lastLoginIp      | string(20)        | 是       | 上次登录Ip     |
| phoneVerified    | boolean           | 是       | 手机已验证     |
| emailVerified    | boolean           | 是       | 邮箱已验证     |
| avatar           | string(100)       | 是       | 头像(小)       |
| avatarMedium     | string(100)       | 是       | 头像(中)       |
| avatarBig        | string(100)       | 是       | 头像(大)       |
| gender           | tinyInteger       | 是       | 性别           |
| realname         | string(20)        | 是       | 真实姓名       |
| signature        | string(200)       | 是       | 个性签名       |
| messageCount     | integer           | 是       | 未读消息数量   |
| registerIp       | string(20)        | 是       | 注册IP         |
| vipId            | integer           | 是       |                |
| vipExpire        | dateTime          | 是       | VIP过期时间    |
| deleteAtTime     | bigInteger        | 是       | 已删除         |
| isDeleted        | tinyInteger       | 是       | 已删除         |
| groupId          | integer           | 是       |                |
| registerIpName   | string(30)        | 是       | 注册IP定位     |
| area             | string(200)       | 是       | 所在地区       |
| contact_info     | string(200)       | 是       | 联系信息       |
| expert_status    | tinyInteger       | 否       | 大神入驻状态 (0:未申请, 1:待审核, 2:已审核, 3:审核失败)|

**索引:**

*   `username`
*   `phone`
*   `email`
*   `deleteAtTime`
*   `nickname`
*   `phone` (唯一)
*   `email` (唯一) 