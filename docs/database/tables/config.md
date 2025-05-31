## Table: config

**Description:** 存储应用程序的配置信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `key`: VARCHAR(100) - Nullable, Comment: '键值'
*   `value`: TEXT - Nullable, Comment: '值'

**Indexes:**

*   `key` 