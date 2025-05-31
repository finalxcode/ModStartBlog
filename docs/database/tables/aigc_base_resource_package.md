# 数据库表: `aigc_base_resource_package`

| 字段名称   | 数据类型      | 是否可空 | 备注/说明 |
| ---------- | ------------- | -------- | --------- |
| id         | bigIncrements | 否       | 主键      |
| created_at | timestamp     | 是       | 创建时间  |
| updated_at | timestamp     | 是       | 更新时间  |
| title      | string(50)    | 是       | 名称      |
| image      | string(100)   | 是       | 图片      |
| price      | decimal(20,2) | 是       | 价格      |
| biz        | string(20)    | 是       | 业务类型  |
| value      | bigInteger    | 是       | 资源数量  |
| visible    | tinyInteger   | 是       | 是否显示  |
| sort       | integer       | 是       | 排序      |
| status     | tinyInteger   | 是       | 状态      |
| desc       | string(200)   | 是       | 描述      |


</rewritten_file> 