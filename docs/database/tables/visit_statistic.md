# 数据库表: `visit_statistic`

| 字段名称       | 数据类型      | 是否可空 | 备注/说明 |
| -------------- | ------------- | -------- | --------- |
| id             | bigIncrements | 否       | 主键      |
| created_at     | timestamp     | 是       | 创建时间  |
| updated_at     | timestamp     | 是       | 更新时间  |
| site_id        | integer       | 是       | 站点ID    |
| total_visits   | integer       | 否       | 总访问量  |
| unique_visitors| integer       | 否       | 独立访客  |
| page_views     | integer       | 否       | 页面浏览量|

**索引:**

*   `site_id` 