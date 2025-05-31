## Table: data_temp

**Description:** 存储临时文件上传信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `category`: VARCHAR(10) - Nullable, Comment: '大类'
*   `path`: VARCHAR(40) - Nullable, Comment: '路径'
*   `filename`: VARCHAR(200) - Nullable, Comment: '原始文件名'
*   `size`: UNSIGNED INTEGER - Nullable, Comment: '文件大小'

**Indexes:**

*   `category, path` 