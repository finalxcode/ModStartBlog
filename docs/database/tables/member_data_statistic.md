# 数据库表: `member_data_statistic`

| 字段名称   | 数据类型   | 是否可空 | 备注/说明 |
| ---------- | ---------- | -------- | --------- |
| id         | bigIncrements| 否       | 主键      |
| created_at | timestamp  | 是       | 创建时间  |
| updated_at | timestamp  | 是       | 更新时间  |
| sizeLimit  | bigInteger | 是       |           |
| sizeUsed   | bigInteger | 是       |           | 