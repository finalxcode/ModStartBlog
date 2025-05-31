## Table: admin_user

**Description:** 存储后台管理用户信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `username`: VARCHAR(100) - Nullable, Comment: '用户名'
*   `password`: CHAR(32) - Nullable, Comment: '密码'
*   `passwordSalt`: CHAR(16) - Nullable, Comment: '密码Salt'
*   `ruleChanged`: BOOLEAN - Nullable, Comment: '权限是否有改变'
*   `lastLoginTime`: TIMESTAMP - Nullable, Comment: '上次登录时间'
*   `lastLoginIp`: VARCHAR(20) - Nullable, Comment: '上次登录IP'
*   `lastChangePwdTime`: TIMESTAMP - Nullable, Comment: '上次密码修改时间'

**Indexes:**

*   `username` 