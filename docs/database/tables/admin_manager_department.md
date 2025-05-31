# 数据库表: `admin_manager_department`

| 字段名称   | 数据类型   | 是否可空 | 备注/说明 |
| ---------- | ---------- | -------- | --------- |
| id         | increments | 否       | 主键      |
| created_at | timestamp  | 是       | 创建时间  |
| updated_at | timestamp  | 是       | 更新时间  |
| pid        | integer    | 是       | 父级ID    |
| title      | string(50) | 是       | 名称      |
| sort       | integer    | 是       | 排序      | 