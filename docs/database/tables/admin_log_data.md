## Table: admin_log_data

**Description:** 存储后台管理操作日志的详细内容。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `content`: TEXT - Nullable, Comment: '内容' 