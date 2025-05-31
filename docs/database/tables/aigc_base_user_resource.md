# 数据库表: `aigc_base_user_resource`

| 字段名称     | 数据类型      | 是否可空 | 备注/说明 |
| ------------ | ------------- | -------- | --------- |
| id           | bigIncrements | 否       | 主键      |
| created_at   | timestamp     | 是       | 创建时间  |
| updated_at   | timestamp     | 是       | 更新时间  |
| memberUserId | bigInteger    | 是       | 用户ID    |
| biz          | string(20)    | 是       | 业务类型  |
| balance      | bigInteger    | 是       | 资源余额  |

**索引:**

*   `memberUserId` 