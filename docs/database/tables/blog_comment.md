# 数据库表: `blog_comment`

| 字段名称     | 数据类型      | 是否可空 | 备注/说明      |
| ------------ | ------------- | -------- | -------------- |
| id           | increments    | 否       | 主键           |
| created_at   | timestamp     | 是       | 创建时间       |
| updated_at   | timestamp     | 是       | 更新时间       |
| blogId       | integer       | 是       | 博客           |
| username     | string(200)   | 是       | 称呼           |
| email        | string(200)   | 是       | 邮箱           |
| url          | string(400)   | 是       | 网址           |
| content      | string(2000)  | 是       | 内容           |
| memberUserId | integer       | 是       |                |
| status       | tinyInteger   | 是       |                |

**索引:**

*   `blogId` 