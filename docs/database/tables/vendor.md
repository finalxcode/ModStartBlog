# 数据库表: `vendor`\n\n| 字段名称   | 数据类型          | 是否可空 | 备注/说明      |\
| ---------- | ----------------- | -------- | -------------- |\
| id         | bigIncrements     | 否       | 主键           |\
| created_at | timestamp         | 是       | 创建时间       |\
| updated_at | timestamp         | 是       | 更新时间       |\
| deleted_at | timestamp         | 是       | 删除时间       |\
| name       | string(100)       | 否       | 供应商名称     |\
| code       | string(50)        | 否       | 供应商编码     |\
| contact    | string(50)        | 是       | 联系人         |\
| phone      | string(20)        | 是       | 联系电话       |\
| address    | string(200)       | 是       | 联系地址       |\
| remark     | text              | 是       | 备注           |\
| is_enabled | boolean           | 否       | 是否启用       |\
\n 