# 数据库表: `member_login_log`

| 字段名称     | 数据类型   | 是否可空 | 备注/说明   |
| ------------ | ---------- | -------- | ----------- |
| id           | bigIncrements| 否       | 主键        |
| created_at   | timestamp  | 是       | 创建时间    |
| updated_at   | timestamp  | 是       | 更新时间    |
| memberUserId | bigInteger | 是       | 用户ID      |
| deviceType   | tinyInteger| 是       | 用户名      |
| ip           | string(20) | 是       | 用户名      |
| userAgent    | string(400)| 是       | 用户名      |
| ipLocation   | string(100)| 是       | IP地址信息  |

**索引:**

*   `memberUserId`
*   `created_at`

</rewritten_file> 