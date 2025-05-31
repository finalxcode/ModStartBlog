# 数据库表: `banner`

| 字段名称   | 数据类型   | 是否可空 | 备注/说明 |
| ---------- | ---------- | -------- | --------- |
| id         | increments | 否       | 主键      |
| created_at | timestamp  | 是       | 创建时间  |
| updated_at | timestamp  | 是       | 更新时间  |
| title      | string(50) | 是       | 标题      |
| image      | string(200)| 是       | 图片      |
| url        | string(200)| 是       | 链接      |
| sort       | integer    | 是       | 排序      | 