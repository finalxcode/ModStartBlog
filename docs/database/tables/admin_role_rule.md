## Table: admin_role_rule

**Description:** 存储后台管理角色与权限规则的关联信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `roleId`: UNSIGNED INTEGER - Nullable, Comment: '角色ID'
*   `rule`: VARCHAR(200) - Nullable, Comment: '角色'

**Indexes:**

*   `roleId` 