# 数据库表: `blog_category`

| 字段名称    | 数据类型    | 是否可空 | 备注/说明      |
| ----------- | ----------- | -------- | -------------- |
| id          | increments  | 否       | 主键           |
| created_at  | timestamp   | 是       | 创建时间       |
| updated_at  | timestamp   | 是       | 更新时间       |
| pid         | integer     | 是       |                |
| sort        | integer     | 是       |                |
| title       | string(200) | 是       |                |
| blogCount   | integer     | 是       | 博客数         |
| cover       | string(200) | 是       |                |
| keywords    | string(200) | 是       |                |
| description | string(400) | 是       |                |
| templateView| string(50)  | 是       |                | 