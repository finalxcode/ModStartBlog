## Table: admin_log

**Description:** 存储后台管理操作日志。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `adminUserId`: INTEGER - Nullable, Comment: '用户ID'
*   `type`: TINY INTEGER - Nullable, Comment: '类型'
*   `summary`: VARCHAR(400) - Nullable, Comment: '摘要' 