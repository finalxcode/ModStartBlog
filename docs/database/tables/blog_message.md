# 数据库表: `blog_message` (原 `message`)

| 字段名称     | 数据类型          | 是否可空 | 备注/说明      |
| ------------ | ----------------- | -------- | -------------- |
| id           | bigIncrements     | 否       | 主键           |
| created_at   | timestamp         | 是       | 创建时间       |
| updated_at   | timestamp         | 是       | 更新时间       |
| userId       | unsignedBigInteger| 是       | 用户ID         |
| status       | tinyInteger       | 是       | 1未读 2已读    |
| fromId       | unsignedBigInteger| 是       | 来源用户ID     |
| content      | text              | 是       | 消息内容(html) |
| memberUserId | integer           | 是       |                |

**索引:**

*   `userId`, `status` 