# 数据库表: `member_card`

| 字段名称     | 数据类型      | 是否可空 | 备注/说明 |
| ------------ | ------------- | -------- | --------- |
| id           | bigIncrements | 否       | 主键      |
| created_at   | timestamp     | 是       | 创建时间  |
| updated_at   | timestamp     | 是       | 更新时间  |
| memberUserId | bigInteger    | 是       | 用户ID    |
| biz          | string(20)    | 是       | 业务      |
| expire       | dateTime      | 是       | 到期时间  |
| quotaUsed    | bigInteger    | 是       | 使用额度  |
| quotaTotal   | bigInteger    | 是       | 总额度    |

**索引:**

*   `memberUserId`, `biz` 