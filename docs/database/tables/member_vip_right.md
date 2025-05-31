# 数据库表: `member_vip_right`

| 字段名称   | 数据类型      | 是否可空 | 备注/说明 |
| ---------- | ------------- | -------- | --------- |
| id         | bigIncrements | 否       | 主键      |
| created_at | timestamp     | 是       | 创建时间  |
| updated_at | timestamp     | 是       | 更新时间  |
| vipIds     | string(200)   | 是       | VIPID     |
| title      | string(200)   | 是       | 标题      |
| desc       | string(200)   | 是       | 描述      |
| image      | string(200)   | 是       | 图标      |
| sort       | integer       | 是       | 排序      | 