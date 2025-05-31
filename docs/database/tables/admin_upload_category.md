## Table: admin_upload_category

**Description:** 存储管理员上传文件分类的信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `category`: VARCHAR(10) - Nullable, Comment: '大类'
*   `pid`: INTEGER - Nullable, Comment: '上级分类'
*   `sort`: INTEGER - Nullable, Comment: '排序'
*   `title`: VARCHAR(50) - Nullable, Comment: '名称'
*   `userId`: INTEGER - Nullable, Comment: ''

**Indexes:**

*   `userId, category` 