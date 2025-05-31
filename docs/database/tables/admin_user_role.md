## Table: admin_user_role

**Description:** 存储后台管理用户与角色的关联信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `userId`: UNSIGNED INTEGER - Nullable
*   `roleId`: UNSIGNED INTEGER - Nullable

**Indexes:**

*   `userId`
*   `roleId` 