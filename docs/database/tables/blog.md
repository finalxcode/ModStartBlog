# 数据库表: `blog`

| 字段名称       | 数据类型              | 是否可空 | 备注/说明          |
| -------------- | --------------------- | -------- | ------------------ |
| id             | bigIncrements         | 否       | 主键               |
| created_at     | timestamp             | 是       | 创建时间           |
| updated_at     | timestamp             | 是       | 更新时间           |
| title          | string(200)           | 是       | 标题               |
| tag            | string(200)           | 是       | 标签               |
| summary        | string(400)           | 是       | 摘要               |
| images         | string(2000)          | 是       | 图片               |
| content        | text                  | 是       | 内容               |
| seoKeywords    | string(200)           | 是       | SEO关键词          |
| seoDescription | string(400)           | 是       | SEO描述            |
| isPublished    | tinyInteger           | 是       | 发布               |
| postTime       | timestamp             | 是       | 发布时间           |
| clickCount     | integer               | 是       | 点击数             |
| memberUserId   | integer               | 是       | 会员ID             |
| templateView   | string(50)            | 是       |                    |
| isHot          | tinyInteger           | 是       | 热门               |
| isRecommend    | tinyInteger           | 是       | 推荐               |
| visitMode      | tinyInteger           | 是       | 访问模式           |
| visitPassword  | string(20)            | 是       | 密码               |
| likeCount      | integer               | 是       | 点赞               |
| favCount       | integer               | 是       | 收藏               |
| isTop          | tinyInteger           | 是       | 置顶               |
| commentCount   | integer               | 是       | 评论数量           |

**索引:**

*   `created_at`
*   `memberUserId`

</rewritten_file> 