# 数据库表: `nav`\n\n| 字段名称   | 数据类型   | 是否可空 | 备注/说明 |\n| ---------- | ---------- | -------- | --------- |\
| id         | increments | 否       | 主键      |\
| created_at | timestamp  | 是       | 创建时间  |\
| updated_at | timestamp  | 是       | 更新时间  |\
| pid        | integer    | 是       | 父级ID    |\
| title      | string(50) | 是       | 标题      |\
| url        | string(200)| 是       | 链接      |\
| target     | string(20) | 是       | 目标      |\
| icon       | string(50) | 是       | 图标      |\
| sort       | integer    | 是       | 排序      |\
| is_show    | boolean    | 是       | 是否显示  |\
\n 