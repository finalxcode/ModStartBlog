# 数据库表: `admin_manager_user`

| 字段名称       | 数据类型    | 是否可空 | 备注/说明  |
| -------------- | ----------- | -------- | ---------- |
| id             | increments  | 否       | 主键       |
| created_at     | timestamp   | 是       | 创建时间   |
| updated_at     | timestamp   | 是       | 更新时间   |
| username       | string(50)  | 是       | 用户名     |
| password       | char(32)    | 是       | 密码       |
| password_salt  | char(16)    | 是       | 密码盐     |
| nickname       | string(50)  | 是       | 昵称       |
| avatar         | string(200) | 是       | 头像       |
| department_id  | integer     | 是       | 部门ID     |
| is_super       | boolean     | 是       | 是否超级管理员|
| roles          | string(200) | 是       | 角色列表   |
| latest_login_ip| string(20)  | 是       | 最新登录IP |

**索引:**

*   `username` 