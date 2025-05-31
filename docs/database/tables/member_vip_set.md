# 数据库表: `member_vip_set`

| 字段名称            | 数据类型      | 是否可空 | 备注/说明      |
| ------------------- | ------------- | -------- | -------------- |
| id                  | increments    | 否       | 主键           |
| created_at          | timestamp     | 是       | 创建时间       |
| updated_at          | timestamp     | 是       | 更新时间       |
| title               | string(50)    | 是       | 名称           |
| flag                | string(50)    | 是       | 标识           |
| pid                 | integer       | 是       | 排序           |
| sort                | integer       | 是       | 排序           |
| isDefault           | tinyInteger   | 是       | 默认           |
| icon                | string(100)   | 是       | 图标           |
| price               | decimal(20,2) | 是       |                |
| vipDays             | integer       | 是       |                |
| content             | text          | 是       | 说明           |
| creditPresentEnable | tinyInteger   | 是       |                |
| creditPresentValue  | integer       | 是       |                |
| desc                | string(200)   | 是       |                |
| visible             | tinyInteger   | 是       |                |
| priceMarket         | decimal(20,2) | 是       | 划线价         | 