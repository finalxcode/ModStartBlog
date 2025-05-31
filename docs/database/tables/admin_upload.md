## Table: admin_upload

**Description:** 存储管理员上传文件的信息。

**Columns:**

*   `id`: INTEGER - Primary Key, Auto-Increment
*   `created_at`: TIMESTAMP - Stores creation timestamp
*   `updated_at`: TIMESTAMP - Stores last update timestamp
*   `category`: VARCHAR(10) - Nullable, Comment: '大类'
*   `dataId`: INTEGER - Nullable, Comment: '文件ID'
*   `adminUploadCategoryId`: INTEGER - Nullable, Comment: '分类ID'
*   `userId`: INTEGER - Nullable, Comment: ''
*   `uploadCategoryId`: INTEGER - Nullable, Comment: ''

**Indexes:**

*   `adminUploadCategoryId`
*   `userId, uploadCategoryId` 