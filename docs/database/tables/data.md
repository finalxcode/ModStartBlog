## Table: data

**Description:** 存储文件上传相关的信息，包括文件路径、原始文件名和大小。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `category`: VARCHAR(10) - Nullable, Comment: '大类'
*   `path`: VARCHAR(40) - Nullable, Comment: '路径'
*   `filename`: VARCHAR(200) - Nullable, Comment: '原始文件名'
*   `size`: UNSIGNED INTEGER
*   `driver`: VARCHAR(16) - Nullable, Comment: '大类'
*   `domain`: VARCHAR(100) - Nullable, Comment: '域名' 