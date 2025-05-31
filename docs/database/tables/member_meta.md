# 数据库表: `member_meta`

| 字段名称     | 数据类型      | 是否可空 | 备注/说明 |
| ------------ | ------------- | -------- | --------- |
| id           | bigIncrements | 否       | 主键      |
| created_at   | timestamp     | 是       | 创建时间  |
| updated_at   | timestamp     | 是       | 更新时间  |
| memberUserId | bigInteger    | 是       |           |
| name         | string(30)    | 是       |           |
| value        | string(1000)  | 是       |           |

**索引:**

*   `memberUserId`, `name` (唯一) 