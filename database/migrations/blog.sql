-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-06-08 22:05:58
-- 服务器版本： 5.7.44-log
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `adminUserId` int(11) DEFAULT NULL COMMENT '用户ID',
  `type` tinyint(4) DEFAULT NULL COMMENT '类型',
  `summary` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '摘要'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_log`
--

INSERT INTO `admin_log` (`id`, `created_at`, `updated_at`, `adminUserId`, `type`, `summary`) VALUES
(1, '2025-04-22 15:19:19', '2025-04-22 15:19:19', 1, 1, '登录成功'),
(2, '2025-04-24 14:11:53', '2025-04-24 14:11:53', 0, 2, '登录失败'),
(3, '2025-04-24 14:12:02', '2025-04-24 14:12:02', 0, 2, '登录失败'),
(4, '2025-04-24 14:12:25', '2025-04-24 14:12:25', 0, 2, '登录失败'),
(5, '2025-04-24 14:12:57', '2025-04-24 14:12:57', 1, 1, '登录成功'),
(6, '2025-04-25 08:27:10', '2025-04-25 08:27:10', 1, 1, '登录成功'),
(7, '2025-04-25 08:34:21', '2025-04-25 08:34:21', 1, 1, '登录成功'),
(8, '2025-04-26 00:46:03', '2025-04-26 00:46:03', 1, 1, '登录成功'),
(9, '2025-04-26 10:52:06', '2025-04-26 10:52:06', 1, 1, '登录成功'),
(10, '2025-04-27 14:58:02', '2025-04-27 14:58:02', 0, 2, '登录失败'),
(11, '2025-04-27 14:58:13', '2025-04-27 14:58:13', 0, 2, '登录失败'),
(12, '2025-04-27 14:58:23', '2025-04-27 14:58:23', 0, 2, '登录失败'),
(13, '2025-04-27 14:58:38', '2025-04-27 14:58:38', 1, 1, '登录成功'),
(14, '2025-04-27 15:26:17', '2025-04-27 15:26:17', 0, 2, '登录失败'),
(15, '2025-04-27 15:26:40', '2025-04-27 15:26:40', 1, 1, '登录成功'),
(16, '2025-04-27 21:39:36', '2025-04-27 21:39:36', 1, 1, '登录成功'),
(17, '2025-04-28 07:01:42', '2025-04-28 07:01:42', 1, 1, '登录成功'),
(18, '2025-04-28 07:31:56', '2025-04-28 07:31:56', 1, 1, '登录成功'),
(19, '2025-04-28 08:08:12', '2025-04-28 08:08:12', 1, 1, '清除缓存');

-- --------------------------------------------------------

--
-- 表的结构 `admin_log_data`
--

CREATE TABLE `admin_log_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_log_data`
--

INSERT INTO `admin_log_data` (`id`, `created_at`, `updated_at`, `content`) VALUES
(1, '2025-04-22 15:19:19', '2025-04-22 15:19:19', '{\"IP\":\"103.172.41.197\"}'),
(2, '2025-04-24 14:11:53', '2025-04-24 14:11:53', '{\"IP\":\"15.204.16.69\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(3, '2025-04-24 14:12:02', '2025-04-24 14:12:02', '{\"IP\":\"15.204.16.69\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(4, '2025-04-24 14:12:25', '2025-04-24 14:12:25', '{\"IP\":\"15.204.16.69\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(5, '2025-04-24 14:12:57', '2025-04-24 14:12:57', '{\"IP\":\"15.204.16.69\"}'),
(6, '2025-04-25 08:27:10', '2025-04-25 08:27:10', '{\"IP\":\"51.81.198.52\"}'),
(7, '2025-04-25 08:34:21', '2025-04-25 08:34:21', '{\"IP\":\"222.70.40.249\"}'),
(8, '2025-04-26 00:46:03', '2025-04-26 00:46:03', '{\"IP\":\"103.172.41.201\"}'),
(9, '2025-04-26 10:52:06', '2025-04-26 10:52:06', '{\"IP\":\"15.204.16.67\"}'),
(10, '2025-04-27 14:58:02', '2025-04-27 14:58:02', '{\"IP\":\"15.204.16.67\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(11, '2025-04-27 14:58:13', '2025-04-27 14:58:13', '{\"IP\":\"15.204.16.67\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(12, '2025-04-27 14:58:23', '2025-04-27 14:58:23', '{\"IP\":\"15.204.16.67\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(13, '2025-04-27 14:58:38', '2025-04-27 14:58:38', '{\"IP\":\"15.204.16.67\"}'),
(14, '2025-04-27 15:26:17', '2025-04-27 15:26:17', '{\"IP\":\"51.81.198.55\",\"用户名\":\"stardust\",\"密码\":\"******\"}'),
(15, '2025-04-27 15:26:40', '2025-04-27 15:26:40', '{\"IP\":\"51.81.198.55\"}'),
(16, '2025-04-27 21:39:36', '2025-04-27 21:39:36', '{\"IP\":\"222.70.40.249\"}'),
(17, '2025-04-28 07:01:42', '2025-04-28 07:01:42', '{\"IP\":\"222.70.40.249\"}'),
(18, '2025-04-28 07:31:56', '2025-04-28 07:31:56', '{\"IP\":\"222.70.40.249\"}');

-- --------------------------------------------------------

--
-- 表的结构 `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_rule`
--

CREATE TABLE `admin_role_rule` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `roleId` int(10) UNSIGNED DEFAULT NULL,
  `rule` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_upload`
--

CREATE TABLE `admin_upload` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(11) DEFAULT NULL COMMENT '用户ID',
  `category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '大类',
  `dataId` int(11) DEFAULT NULL COMMENT '文件ID',
  `uploadCategoryId` int(11) DEFAULT NULL COMMENT '分类ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_upload`
--

INSERT INTO `admin_upload` (`id`, `created_at`, `updated_at`, `userId`, `category`, `dataId`, `uploadCategoryId`) VALUES
(1, '2025-04-24 14:32:36', '2025-04-24 14:32:36', 1, 'image', 1, 0),
(2, '2025-04-24 14:39:38', '2025-04-24 14:39:38', 1, 'image', 2, 0),
(3, '2025-04-24 14:47:57', '2025-04-24 14:47:57', 1, 'image', 3, 0),
(4, '2025-04-24 14:48:21', '2025-04-24 14:48:21', 1, 'image', 4, 0),
(5, '2025-04-24 14:48:44', '2025-04-24 14:48:44', 1, 'image', 5, 0),
(6, '2025-04-24 14:49:02', '2025-04-24 14:49:02', 1, 'image', 6, 0),
(7, '2025-04-24 14:49:18', '2025-04-24 14:49:18', 1, 'image', 7, 0),
(8, '2025-04-24 14:49:35', '2025-04-24 14:49:35', 1, 'image', 8, 0),
(9, '2025-04-24 14:49:52', '2025-04-24 14:49:52', 1, 'image', 9, 0),
(10, '2025-04-28 07:59:37', '2025-04-28 07:59:37', 1, 'video', 10, 0);

-- --------------------------------------------------------

--
-- 表的结构 `admin_upload_category`
--

CREATE TABLE `admin_upload_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(11) DEFAULT NULL COMMENT '用户ID',
  `category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '大类',
  `pid` int(11) DEFAULT NULL COMMENT '上级分类',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_upload_category`
--

INSERT INTO `admin_upload_category` (`id`, `created_at`, `updated_at`, `userId`, `category`, `pid`, `sort`, `title`) VALUES
(1, '2025-04-28 08:00:49', '2025-04-28 08:00:49', 1, 'video', 0, NULL, '沈阳老张滑冰');

-- --------------------------------------------------------

--
-- 表的结构 `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passwordSalt` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruleChanged` tinyint(1) DEFAULT NULL,
  `lastLoginTime` timestamp NULL DEFAULT NULL,
  `lastLoginIp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastChangePwdTime` timestamp NULL DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_user`
--

INSERT INTO `admin_user` (`id`, `created_at`, `updated_at`, `username`, `password`, `passwordSalt`, `ruleChanged`, `lastLoginTime`, `lastLoginIp`, `lastChangePwdTime`, `phone`, `email`) VALUES
(1, '2025-04-22 15:18:50', '2025-04-28 07:31:56', 'admin', '53b80b9ba5903084bcfe24dd99749cfd', 'Spdsjoq4Ak03PD2F', NULL, '2025-04-28 07:31:56', '222.70.40.249', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_user_role`
--

CREATE TABLE `admin_user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `roleId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `aigc_key_pool`
--

CREATE TABLE `aigc_key_pool` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `param` text COLLATE utf8mb4_unicode_ci,
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastCallTime` datetime DEFAULT NULL,
  `callCount` bigint(20) DEFAULT NULL,
  `successCount` bigint(20) DEFAULT NULL,
  `failCount` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `aigc_task`
--

CREATE TABLE `aigc_task` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `memberUserId` bigint(20) DEFAULT NULL,
  `biz` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `statusRemark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `modelConfig` text COLLATE utf8mb4_unicode_ci,
  `result` text COLLATE utf8mb4_unicode_ci,
  `creditCost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `aigc_work`
--

CREATE TABLE `aigc_work` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `biz` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `statusRemark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `param` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '位置',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `sort` int(11) DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `atomic`
--

CREATE TABLE `atomic` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `expire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE `banner` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '位置',
  `sort` int(11) DEFAULT NULL COMMENT '顺序',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `link` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '链接',
  `type` tinyint(4) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slogan` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkText` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colorReverse` tinyint(4) DEFAULT NULL,
  `video` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backgroundColor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '背景色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`id`, `created_at`, `updated_at`, `position`, `sort`, `image`, `link`, `type`, `title`, `slogan`, `linkText`, `colorReverse`, `video`, `backgroundColor`) VALUES
(4, '2025-04-24 14:48:03', '2025-04-24 14:51:23', 'Blog', 1, 'http://chengyujielong.xyz/data/image/2025/04/24/53276_m8ns_4356.jpg', '', 1, NULL, NULL, NULL, 0, NULL, ''),
(5, '2025-04-24 14:48:21', '2025-04-24 14:51:23', 'Blog', 2, 'http://chengyujielong.xyz/data/image/2025/04/24/53324_jp71_7540.jpg', '', 1, NULL, NULL, NULL, 0, NULL, ''),
(6, '2025-04-24 14:49:04', '2025-04-24 14:51:23', 'Blog', 3, 'http://chengyujielong.xyz/data/image/2025/04/24/53342_91u6_7864.jpg', '', 1, NULL, NULL, NULL, 0, NULL, ''),
(7, '2025-04-24 14:49:18', '2025-04-24 14:51:23', 'Blog', 4, 'http://chengyujielong.xyz/data/image/2025/04/24/53375_xls0_8191.jpg', '', 1, NULL, NULL, NULL, 0, NULL, ''),
(8, '2025-04-24 14:50:02', '2025-04-24 14:51:23', 'Blog', 5, 'http://chengyujielong.xyz/data/image/2025/04/24/53392_qvab_4360.jpg', '', 1, NULL, NULL, NULL, 0, NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `tag` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标签',
  `summary` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '摘要',
  `images` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `seoKeywords` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO关键词',
  `seoDescription` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO描述',
  `isPublished` tinyint(4) DEFAULT NULL COMMENT '发布',
  `postTime` timestamp NULL DEFAULT NULL COMMENT '发布时间',
  `clickCount` int(11) DEFAULT NULL COMMENT '点击数',
  `isTop` tinyint(4) DEFAULT NULL COMMENT '置顶',
  `commentCount` int(11) DEFAULT NULL COMMENT '评论数量',
  `categoryId` int(11) DEFAULT NULL,
  `templateView` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isHot` tinyint(4) DEFAULT NULL COMMENT '热门',
  `isRecommend` tinyint(4) DEFAULT NULL COMMENT '推荐',
  `visitMode` tinyint(4) DEFAULT NULL COMMENT '访问模式',
  `visitPassword` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `likeCount` int(11) DEFAULT NULL COMMENT '点赞',
  `favCount` int(11) DEFAULT NULL COMMENT '收藏'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `blog`
--

INSERT INTO `blog` (`id`, `created_at`, `updated_at`, `title`, `tag`, `summary`, `images`, `content`, `seoKeywords`, `seoDescription`, `isPublished`, `postTime`, `clickCount`, `isTop`, `commentCount`, `categoryId`, `templateView`, `isHot`, `isRecommend`, `visitMode`, `visitPassword`, `likeCount`, `favCount`) VALUES
(7, '2017-06-30 08:01:55', '2025-06-07 10:35:48', '心中向往的地方', ':博客系统::小墨::魔众:', '总有那么一个地方是心中向往的~~', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-2.jpg\"]', '<p>这个世界上,总有那么一个地方,能让你心生向往。 也许是风光旖旎的西方,也许是...</p>', '', '', 1, '2017-06-30 08:00:53', 27608, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2017-06-30 08:04:29', '2025-06-07 23:57:44', '世界那么大，值得去转转', ':旅行::自然::露宿::沙漠:', '这途中有艰辛，有危险，由于预算紧张，他在很多机场，公园外露宿，经常食物中毒，在智利遭抢劫，在乌干达相机浸水，甚至在纳米比亚的沙漠中翻车，差点丧命。然而陌生人总会伸出援手，当导游，安排食宿，Walter一直觉得得到的比给予的多太多。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-3.jpg\"]', '<p style=\"text-align:left;\">3年，60个国家。Walter程疲倦了自己非专业的工作，决定背上行囊去旅行。他变卖了自己大部分的东西，踏上了间隔年旅程。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:left;\">这途中有艰辛，有危险，由于预算紧张，他在很多机场，公园外露宿，经常食物中毒，在智利遭抢劫，在乌干达相机浸水，甚至在纳米比亚的沙漠中翻车，差点丧命。然而陌生人总会伸出援手，当导游，安排食宿，Walter一直觉得得到的比给予的多太多。他将照片po在网上，鼓励更多的人开始旅行，因为长途的旅行能够让人感受到不同的文化和风俗，观赏自然万物的神奇，打开封闭的思路。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30571_qztn_8306.jpg\" alt=\"30571_qztn_8306.jpg\" /></p>\n\n<p><br /></p>', '这途中有艰辛，有危险，由于预算紧张，他在很多机场，公园外露宿，经常食物中毒，在智利遭抢劫，在乌干达相机浸水，甚至在纳米比亚的沙漠中翻车，差点丧命。然而陌生人总会伸出援手，当导游，安排食宿，Walter一直觉得得到的比给予的多太多。', '3年，60个国家。Walter程疲倦了自己非专业的工作，决定背上行囊去旅行。他变卖了自己大部分的东西，踏上了间隔年旅程。\n这途中有艰辛，有危险，由于预算紧张，他在很多机场，公园外露宿，经常食物中毒，在智利遭抢劫，在乌干达相机浸水，甚至在纳米比亚的沙漠中翻车，差点丧命。然而陌生人总会伸出援手，当导游，安排食宿，Walter一直觉得得到的比给予的多太多。他将照片po在网上，鼓励更多的人开始旅行，因为长途的旅行能够让人感受到不同的文化和风俗，观赏自然万物的神奇，打开封闭的思路。', 1, '2017-06-30 08:04:36', 31020, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2017-06-30 08:06:17', '2025-06-07 23:08:01', '拉市海丽江的马尔代夫', ':博客系统::小墨::魔众:', '每个人心中都有一个丽江，安静而孤独。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-2.jpg\"]', '<p>每个人心中都有一个丽江，安静而孤独。</p>\n\n<p>在丽江，遇人，遇城，遇心。</p>\n\n<p>有些人，从这里开始流浪，也有人，在这里找到故乡。</p>\n\n<p>除了文艺青年喜欢这座城市，资深驴友也同样爱着这里。</p>\n\n<p>因为这里不仅仅有小城故事，还有深山另一端的海阔天空...</p>\n\n<p><br /></p>\n\n<p>每个人心中都有一个丽江，安静而孤独。</p>\n\n<p>在丽江，遇人，遇城，遇心。</p>\n\n<p>有些人，从这里开始流浪，也有人，在这里找到故乡。</p>\n\n<p>除了文艺青年喜欢这座城市，资深驴友也同样爱着这里。</p>\n\n<p>因为这里不仅仅有小城故事，还有深山另一端的海阔天空...</p>\n\n<p><br /></p>', '', '', 1, '2017-06-30 08:05:35', 27092, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '2017-06-30 08:12:56', '2025-06-07 10:35:35', '云端 ', ':博客系统::魔众:', '丽江是一个来了就不想离开的地方，很多人离开了，心却还在丽江。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-1.jpg\"]', '<p>丽江是一个来了就不想离开的地方，很多人离开了，心却还在丽江。</p>', '', '', 1, '2017-06-30 08:12:53', 46085, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2017-12-20 08:18:25', '2025-06-07 10:35:40', '在云南那些风花雪月的日子里', ':博客系统::魔众系统::云南::旅行:', '旅行是心灵的远行，挣脱藩篱的狂欢。说白了，旅行就是一剂毒药。\n一到放暑假，我这颗不安份的心就嗷嗷待哺起来。我想像一只侯鸟一样自由飞翔。自从去年夏天和孩子成功完成山东济南、曲阜自助游以后，我们发誓不跟团游，我们不想把自己宝贵的时间花在无谓的购物上，也不想被赶鸭子上架，疲于奔命，失去旅行的趣味。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-3.jpg\"]', '<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">缘起 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">旅行是心灵的远行，挣脱藩篱的狂欢。说白了，旅行就是一剂毒药。</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">一到放暑假，我这颗不安份的心就嗷嗷待哺起来。我想像一只侯鸟一样自由飞翔。自从去年夏天和孩子成功完成山东济南、曲阜自助游以后，我们发誓不跟团游，我们不想把自己宝贵的时间花在无谓的购物上，也不想被赶鸭子上架，疲于奔命，失去旅行的趣味。</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">自助游呢，还是需要提前做些功课滴。订旅行攻略、机票、宾馆等等，这些是必不可少的。听路上的驴友说马蜂窝网站有许多不错的游记，不过“去哪网”订机票和宾馆是不二的选择。我从丽江飞昆明的五折机票就是从“去哪儿”订的，非常方便。</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">去云南的想法纯属巧合，本来八月初想和孩子去广州长龙玩的，但另一家朋友迟迟没有订下行程，纠结中，得知广州的文友孤独之王带孩子去了丽江，便有与他去会会的想法。当然云南还有好几个要见的文友。我想让孩子知道，平时老妈披头散发，为文字痴狂，不是白狂的，必竟还是通过文字，神交到几个知心朋友。</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">说走就走，我的心提前就狂奔而去，一连三、四天都兴奋得没有睡好，我都担心自己踏上云南地界，是否还有力气游玩？ </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">要么读书，要么旅行，我们的身体和灵魂总有一个要在路上，我是个贪婪的女人，于是书和身体一起陪着我上路,百家讲坛讲辛弃疾的。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">云南这边，有朋友在倒计时，也许不只一个……殊不知，我就这样踏上神奇的风花雪月之途….</span></p>\n\n<p><br /></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">一个江南女人和四个风花雪月男人的故事</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">自从今年三月广州之行写了白色情人节蓝天上的艳遇故事后，我俨然就是写香艳文字的写手，特别是到了七彩云南这样充满风花雪月的艳遇之地，不写点有颜色的文字，还真对不起伸长脖子观战的看客。好吧，明雨在40度的高温下，发扬一不怕热，二不怕苦的精神，把艳情路线，坚持到底。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">也许是天意，这十天的云南之旅，站站有帅哥迎候。26号到昆明都是晚上11点了，大理文友青青的高中同学杨亮在机场A出处的哈鲜亭等侯多时，他个子不高，戴着眼镜，透着厚道又不失干练的味道。青青是个爱操心的家伙，不断地在我和杨亮之间打电话，生怕我和他同学联系不上。杨给我们安排在一个富有诗意的宾馆“云上四季“，又请我们吃夜宵，拉我们夜游滇池，我和孩子到宾馆入睡都凌晨两时多了。第二天，杨又把我们送到汽车站，对于他的盛情，我觉得非常过意不去，因为他自己有家公司在做，三年前白手起家，现在资产上千万，非常忙碌。尽管还没有见到青青，但我从青青的同学杨亮身上感觉出大理人的质朴。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">27号上午9点，青青发来短信问：“什么情况？”后来我才知道是他的口头禅。“睡觉啊！还有啥情况？”我有点生气：“还让不让御姐睡美容觉了？我总不能黑着眼圈，披头散发，像包身工一样去见青青吧？孩子也正在睡梦里呢。”“我已包好车，打算和师傅一起上路了！”青青在短信中回复。我终于按捺不住怒火，掏起电话就冲青青叫喊着，早顾不上淑女的风范，“我昨天不是和你说好下午来大理的么？你心这样急让我情何以堪啊？”青青在电话里不恼，带着嘶哑的声音说：“我不就是盼星星、盼月亮，盼姐姐来吗？你睡你的，我等我的…..””好吧,出发上车我给你电话.” 我的口气也软下来。这时孩子被我的大嗓门吵醒了，这个小男人非常愤怒地看着我，惹得我只叹气。真的有种被架在火上烤的味道，我肉多而白嫩，最适合做烤乳猪这道名菜。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">在网上查得昆明南窑汽车站有私人的帕萨特轿车开往大理，150元每位，比高快略贵些，但方便路上停车，是孩子喜欢的这种。运气不错，根据网上提供的电话约到一辆，一个五十开外的男司机，两个单身男加上我们一对母子，快乐地向大理出发。一路上蓝天白云，风景迷人，20多度的气温让人神清气爽，路上经过恐龙谷、充满火把节气氛的楚雄彝族自治州，云南好玩的地方实在太多了。青青一如原来着急热情的性格，一个小时不到就询问下路程，好比十二道金牌催岳飞班师回京。老司机笑着说：“祥云人是这个性子呢！他是你的男朋友啊？”我的脸一下红了，低下头头说：“师傅真会吃我的豆腐啊。你看我的孩子都这样大了，哪来这样小的男友啊？我朋友是八O后啊。”师傅笑了，不再开玩笑。“像我朋友这样的人以后肯定会生女儿呢。我们宁波有句方言：心急生囡呢。”我自我解嘲，车上另外两个男人也笑了。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">就这样一路说说笑笑，三个小时以后到了大理下关。下关的风好大，我撩拨了被风吹乱的头发，在下关出口处看到四个帅哥在向我招手，我傻眼了。好在我看到过青青的照相，认出比较瘦小，戴墨镜的那个。“车子小了点，委屈雨姐姐和小弟。”青青一边说着，一边把我们和行李塞进一辆小长安面包车。</span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\"> “总算把你们盼来了，我们一边喝酒，一边说话，一边等你们，就这样在路边等啊，等啊，等到你们了。”青青的话让我非常不安，他们已等了五六个小时。青青没等我说话，他又继续滔滔不绝道：“这三位都是我的高中同学，高个子的白脸哥是我们的同行，姓余；开车的这个帅哥刚从浙江平湖回来，打算在家乡定居；我边上的这个帅哥姓杨，因为他家住在杨亮家的东面，所以叫杨亮东。”孩子听了直乐。我从反光镜后面看到青青布满血丝的眼睛闪闪发光…..“前面的这位就是千呼万唤始出来的浙江美女作家清明雨。”青青哑着喉咙，但像一个发烫的小火球四处滚动，我猜，哪怕是冰雪做的心也会被他的火热融化。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">就这样，我被五个帅哥幸福地簇拥下，先在大理古城边上一处别致的庭院安排住下。稍事休息后，大伙去酒店对面的陈式海稍鱼古城店吃晚饭。饮食男女，吃饭是头等大事。听广州的大耒说过，大理多美食，他让我点汽锅鸡，遗憾今晚只有鱼。店门古色古香的建筑引起我的注意，这和宾馆一样，是典型的三房一照壁的白族民居，院子里来来往往的金花和葫芦丝音乐，充满白族风情，墙上让人眼花瞭乱的招牌菜和如云的食客，让我口水直流三千尺。我是典型的吃货，要不也不会吃得这样白白胖胖啦。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">约摸二十分钟后，菜上齐了，美味清口的海稍鱼肯定是放在主打位，云南十八怪之一的烤乳扇也上来了，其实就是用牛奶做的奶酪啦，和我单位内蒙古同事赵姐带来过的奶酪味道差不多呢。还有一道叫虫子相会的菜引起我们足够的好奇。原来是竹虫、蚱蜢、水蜻蜓的蛹油炸放在一起的。以前没吃过这玩艺，听说还是高蛋白，血脂偏高的我顾不上了，借着青稞的酒力闭着眼睛吃了一个竹虫，嘿，挺香脆啊！坤开始不想吃，但在几个大哥哥的怂恿下，渐渐大胆地尝了几个虫子。我们都忘记吃包虫子的薄荷叶，听宁波的姐妹说味不错。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">边吃着美食边喝着香醇的青稞酒，男人们唱起了白族的情歌，他们唱了许多，少数民族能歌善舞，早有耳闻，但我的这两个可爱的JC同行唱起原生态的火辣辣的情歌，这是我始料不及的。他们唱了许多，高个白面的，我直接喊他情歌王子。因为酒过三巡，不太记得他们唱的了，只记得一句：白菜心，青菜心，表哥好良心；白菜苔，青菜苔，表妹好人材…..这首优美的山歌用比兴的手法道出青年男女彼此的爱慕之情，这种表达方式我们在《诗经》里并不陌生。“关关雎鸠，在河之洲；窈窕淑女，君子好逑。”情歌王子还给我讲起家乡祥云的来历，他说云南的称呼就来自祥云，传说是玉皇大帝得道升天路过此地，留下祥云朵朵，他还讲了云南驿、罗浮山和茶马古道，给我感觉情歌王子根本不象JC，活脱脱一个历史学者加上多情的歌者。在晚宴上，青青的话明显没有王子多了，我们频频举杯，我费力地记住了下关风、上关花、苍山雪、洱海月。我觉得眼前的四个男人分别代表大理的风花雪月，青青是风，热情急促；王子是花，华丽如锦；司机帅哥是雪，纯真安静，亮东是月，如洱海般深沉。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">一半是清醒，一半是微勳。我们一行人慢慢地往大理古城走，洋人街上酒吧此起彼伏，非常热闹，几颗被酒精撩拨得驿动的心不去酒吧过过门定是不行的。考虑坤还是孩子，就让喝得比较少的司机帅哥把坤送回宾馆休息，当时约摸晚上十点，后来听孩子说大哥哥还请他吃饵丝呢。我记不清那晚喝了多少酒，只记得酒吧里跳动的烛火把每个年青人的脸印得通红，我拍下青青侧面抽烟思考的脸，还有那大红印花桌布上一打风花雪月的啤酒。对，就是这种风花雪月的感觉，可以哭，可以笑，可以抽烟，可以喝酒，让性别、职业、烦恼、忧愁统统都靠边站，在这样的夜里，可以不想，也可以想，自由万岁！ </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">我对每个人微笑，对每个人敬酒，和每个人说话，因为我不只是青青的雨姐姐，我是大家的雨姐姐。 </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">又一次酒后，我们就这样一边唱歌，一边勾肩搭背，感受着各自身体的温度，摇头晃脑地走在大理古城的路上，想必影子也是歪歪斜斜的……对,那是青春的影子，还可以拉得很长很长…… </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">那天晚上，大家都回酒店后，情歌王子又打了我很多电话，发了我许多短信，让我去楼下走走，我没接……他就住在我隔壁。第二天清晨,我有事找青青，敲门，王子睡眼惺忪地出来,搂了下我，啥都没说，又进去了……我低低地说了声：SORRY。不知他听见否？ </span></p>\n\n<p style=\"text-align:left;text-indent:0em;\"><span style=\"font-size:14px;\">风花雪月，刻骨铭心！没想到来云南的第二天就领略到了…</span></p>\n\n<p><br /></p>', '在云南那些风花雪月的日子里', '缘起 \n旅行是心灵的远行，挣脱藩篱的狂欢。说白了，旅行就是一剂毒药。\n一到放暑假，我这颗不安份的心就嗷嗷待哺起来。我想像一只侯鸟一样自由飞翔。自从去年夏天和孩子成功完成山东济南、曲阜自助游以后，我们发誓不跟团游，我们不想把自己宝贵的时间花在无谓的购物上，也不想被赶鸭子上架，疲于奔命，失去旅行的趣味。', 1, '2017-12-20 08:16:08', 34466, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2017-12-20 08:22:31', '2025-06-07 10:35:37', '带着爷爷去旅行之邮轮澎湖湾', ':博客系统::魔众系统::旅行::澎湖湾:', '自从朋友开了旅行社之后，每天都被她的各种行程刷的哪儿都想去。迫于生活现实，也不是想去的都能去。月初她又发了一个周末行的澎湖邮轮之旅，咬咬牙还是决定任性一回。旅行前的各种证件办理都丢给好朋友，我带着爷爷，爷爷带着相机，准备出发。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-1.jpg\"]', '<p style=\"text-align:left;\">自从朋友开了旅行社之后，每天都被她的各种行程刷的哪儿都想去。迫于生活现实，也不是想去的都能去。月初她又发了一个周末行的澎湖邮轮之旅，咬咬牙还是决定任性一回。旅行前的各种证件办理都丢给好朋友，我带着爷爷，爷爷带着相机，准备出发。</p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30118_na8p_9618.jpg\" alt=\"30118_na8p_9618.jpg\" /></p>\n\n<p>周五日落时分到达邮轮码头，领队小姑娘很给力，没等多久一行人就登船了，到了房间赶紧放下东西拉着爷爷上10楼甲板，感受下“大世面”。天秤星号邮轮挺有名的，服务员基本都是东南亚人，很有礼貌也很可爱。吃完自助，吹吹海风，看看夜景，就溜达回房休息，准备第二天早起看看日出。</p>\n\n<p><br /></p>\n\n<p>第二天的天气很给力，5点多来到甲板上时，太阳已经露出了一点点小脸蛋。爷爷兴奋的拿起他的武器开拍，我也是第一次真正意义上看到海上日出，无奈风有点大，没拍到生吞鸡蛋黄之类的好照片。</p>\n\n<p><br /></p>\n\n<p>简单吃完早餐准备下船，蓝天白云真的是好心情的催化剂，感觉这一天会非常开心。事实之后也证明了这趟旅程很完美。9点多下船之后，澎湖的导游非常实在的带着我们开玩，争分夺秒一点儿也不浪费时间。第一站是中央老街。味道有点像鼓浪屿，但是人流量却很少，大部分店铺没有开张，但是每家小店都布置的很有滋味，我们边拍边看，体验到古厝里几十年不变的老味道。</p>\n\n<p><br /></p>\n\n<p>走过老街，我们来到了澎湖湾的重头戏，潘安邦的外婆家。不知道大家是不是都有听过“外婆的澎湖湾”，小时候的回忆立马就能跟着哼起来，晚风轻拂澎湖湾，白浪逐沙滩。没有椰林缀斜阳，只是一片海蓝蓝。阳光，沙滩，海浪，仙人掌，还有一群老船长……</p>\n\n<p><br /></p>\n\n<p>哈哈，有点跑题耶。不过这里真的是，和歌里唱的一样，天高海蓝，还有美味的仙人掌果。</p>\n\n<p><br /></p>\n\n<p>走过外婆家，顺道经过了张雨生纪念馆，没有拍照，但是也大概了解了这位音乐家的一生。真是天妒英才，他送给了世人那么多好的作品。感恩一下。<br />上午的行程大部分就结束了，之后到了一家大酒楼吃午饭，新鲜的各种海鲜也是吃的好嗨皮。然后，我们要去海上烤生蚝咯！</p>\n\n<p><br /></p>\n\n<p><br /></p>\n\n<p>南海旅行中心码头出发，大概10分钟船程就来到了海中心的渔排，一盘盘刚挖下来的生蚝已经摆好了在等我们，烤架也都上了火，就等我们动手啦~ 大家都好开心的玩起了挖海蛎的游戏，这时候又开始了童年记忆的涌现哪，小时候走在菜市场，就会有可爱的叔叔阿姨挖一颗新鲜的海蛎往我嘴里丢，导致我现在钟爱的就是生海蛎，熟的反而不爱吃。这时候对于自己是海边长大的孩子表示幸运，哈哈哈哈。</p>\n\n<p><br /></p>\n\n<p>不知不觉恍恍惚惚也不晓得吃了多少，三点多准备离开渔排，开始大巴环岛之旅。许多地方都是导游介绍完，大家下车看个几分钟，再往下走。每个有意义的景点都</p>\n\n<p><br /></p>', '带着爷爷去旅行之邮轮澎湖湾', '自从朋友开了旅行社之后，每天都被她的各种行程刷的哪儿都想去。迫于生活现实，也不是想去的都能去。月初她又发了一个周末行的澎湖邮轮之旅，咬咬牙还是决定任性一回。旅行前的各种证件办理都丢给好朋友，我带着爷爷，爷爷带着相机，准备出发。\n周五日落时分到达邮轮码头，领队小姑娘很给力，没等多久一行人就登船了，到了房间赶紧放下东西拉着爷爷上10楼甲板，感受下“大世面”。天秤星号邮轮挺有名的，服务员基本都是东南亚人，很有礼貌也很可爱。吃完自助，吹吹海风，看看夜景，就溜达回房休息，准备第二天早起看看日出。', 1, '2017-12-20 08:21:01', 156318, NULL, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '2017-12-20 08:23:17', '2025-06-07 22:57:41', '晚霞', ':博客系统::魔众系统::晚霞:', '', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-3.jpg\"]', '<p>1</p>', '', '', 1, '2017-12-20 08:22:54', 88750, NULL, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2017-12-20 08:25:59', '2025-06-07 22:00:24', '人生是一辆行动的列车', ':博客系统::魔众系统::旅行:', '阳光明媚，微风和煦。\n我在这个城市最高的大楼里的一间小格子里盯着电脑屏幕，恩，今天我值班。QQ群是公司群发布的一些信息和业绩播报；我盯着内网客户，在考虑跟谁电话催单。\n已经在这样的环境里浸泡几年了：我走路变得很快；说话会事先思考；偶尔为自己的心软自责，因为我想要“像一个厉害销售”。要说这几年的成长，可能用“训练”要来的准确；我总是觉得人越大，接触的社会规则越多，天生的触角会失去灵敏。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-2.jpg\"]', '<p style=\"text-align:left;\">阳光明媚，微风和煦。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:left;\">我在这个城市最高的大楼里的一间小格子里盯着电脑屏幕，恩，今天我值班。QQ群是公司群发布的一些信息和业绩播报；我盯着内网客户，在考虑跟谁电话催单。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:left;\">已经在这样的环境里浸泡几年了：我走路变得很快；说话会事先思考；偶尔为自己的心软自责，因为我想要“像一个厉害销售”。要说这几年的成长，可能用“训练”要来的准确；我总是觉得人越大，接触的社会规则越多，天生的触角会失去灵敏。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img alt=\"人生是一辆行动的列车\" src=\"http://heezhi.com/\" /></p>\n\n<p><br /></p>\n\n<p>我记得小时候，小脚踩在疏松泥土上的感觉，记得蚯蚓松动泥土时身体柔软和专注，记得泥土的奇特香味，记得太阳光穿过葡萄树架，留下的斑驳光影；记得房顶的片瓦，墙边的小狗眯着眼睛，外婆摇晃着蒲扇，我在小小的院子里上串下跳，觉得世界美好极了，自己法力无边。</p>\n\n<p><br /></p>\n\n<p>塞着耳机，我听到了QQ和微信消息的提醒声，久违了感觉；为了保证工作效率，我很久没有在工作的时候听歌了；我已经想不起那个会抄写歌词，听到喜爱音乐时的激动的跟朋友尖叫分享的小女孩，和那段抱着随声听，在一个个安静的夜晚，偶尔甜蜜偶尔忧伤的岁月。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30327_83b1_8637.png\" alt=\"30327_83b1_8637.png\" /></p>\n\n<p><br /></p>\n\n<p>收获了，失去了；体会过酸甜苦辣，最终还是觉得自己幸运，也许，这就是意义。</p>\n\n<p><br /></p>\n\n<p>我曾经很欣赏的姐姐告诉我：人生是一辆行动的列车，你会看到很多人上车，下车，有的人陪你坐了很长的一段路又离开；唯一不会离开你的只有自己脑袋里的知识，阅历和感受。</p>\n\n<p><br /></p>\n\n<p>这句话我深深的刻在脑袋里，我默认所有人的离开，想拼命珍惜喜爱又有缘分的人；但有时有懒得经营，这种有点悲观的态度让我更想好好体验这趟旅程；有的人活着很较真，会去思考对错，总结经验教训；有的人活着会很随性，不计较得失，只求当下的无悔；而我是第一种，我学着在两者间找一个平衡。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30328_crwr_3420.jpg\" alt=\"30328_crwr_3420.jpg\" /></p>\n\n<p><br /></p>\n\n<p>我相信每一个人都属于一条轨迹，从出生开始，就有分配的角色和使命；只不过在成长的过程中，有的人完成了，有的人没有完成；在不同轨迹交错的空间里，有无数的小黑洞，它会让人迷路，而我坚信空间中存在很多的魔法，也许是朋友，也许是音乐，又或者，是文字……总有一些平凡又惊人的方法，让我们看似重复衰败的人生跌宕起伏，在殊途同归中又各自精彩。</p>\n\n<p><br /></p>\n\n<p>就像，听了一场小型温暖的演唱会，旋律让脑海里的故事鲜活，有了血肉；让感受更加立体，但曲终人散，始终要回到“钢筋和泥土”的世界。</p>\n\n<p><br /></p>', '人生是一辆行动的列车', '阳光明媚，微风和煦。\n我在这个城市最高的大楼里的一间小格子里盯着电脑屏幕，恩，今天我值班。QQ群是公司群发布的一些信息和业绩播报；我盯着内网客户，在考虑跟谁电话催单。\n已经在这样的环境里浸泡几年了：我走路变得很快；说话会事先思考；偶尔为自己的心软自责，因为我想要“像一个厉害销售”。要说这几年的成长，可能用“训练”要来的准确；我总是觉得人越大，接触的社会规则越多，天生的触角会失去灵敏。', 1, '2017-12-20 08:24:07', 113283, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '2017-12-20 08:28:18', '2025-06-07 22:30:41', '既是生活，也是旅程', ':博客系统::魔众系统::旅行:', '我们特别爱看访谈，他们身上有太多的精彩。喜欢冒险的人，生活本就会有很多的不一样，尤其是夫妻，生活得久了，就会有相同或者相似的人生态度。喜欢冒险，生活肯定不会波澜不惊。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-1.jpg\"]', '<p style=\"text-align:left;\">我们特别爱看访谈，他们身上有太多的精彩。喜欢冒险的人，生活本就会有很多的不一样，尤其是夫妻，生活得久了，就会有相同或者相似的人生态度。喜欢冒险，生活肯定不会波澜不惊。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img alt=\"既是生活，也是旅程\" src=\"http://heezhi.com/\" /></p>\n\n<p><br /></p>\n\n<p>柏林的这对小夫妻，又开始触动我们的生活观，Jan是一位摄影师，Kathrin则是眼镜设计师，仅仅只是事业上的成就么，当然不。他们在环游美国之后，在乡村找了一处住所，欢快的生活着。</p>\n\n<p><br /></p>\n\n<p>Kathrin用大自然的<a href=\"http://heezhi.com/eadmin/article/www.heezhi.com\">色彩</a>为自己的工作补充灵感，Jan则不断的为自己的生活打造惊喜。像小说故事里的那样，红砖白窗，木质地板，幽居森林，而每一天妻子回家，都会看到居住处发生一点改变，这种感觉实在太梦幻了。</p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30413_yu8z_2783.jpg\" alt=\"30413_yu8z_2783.jpg\" /></p>\n\n<p><br /></p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30414_yex9_1884.jpg\" alt=\"30414_yex9_1884.jpg\" /></p>\n\n<p><br /></p>\n\n<p><a href=\"http://heezhi.com/eadmin/article/www.heezhi.com\">环游</a>的经历对他们来说非常宝贵，Jan明白了大自然的奇妙与意义。邻居们都是短暂的相处，而这样的关系，让大家不会再纠结你每天穿什么鞋子，赚多少钱，每一次离开，大家都会来看看有什么地方需要帮助。</p>\n\n<p><br /></p>\n\n<p><br /></p>\n\n<p>当然，Jan夫妇并不会长期居住乡村，他们说，住久了就会想念城市的<a href=\"http://heezhi.com/eadmin/article/www.heezhi.com\">风景</a>，反之亦然，与朋友们保持联系也非常重要。</p>\n\n<p style=\"text-align:center;\"><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30418_55ng_6885.jpg\" alt=\"30418_55ng_6885.jpg\" /><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30417_k2pp_6904.jpg\" alt=\"30417_k2pp_6904.jpg\" /><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30417_mvb5_5818.jpg\" alt=\"30417_mvb5_5818.jpg\" /><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30416_xh2n_4229.jpg\" alt=\"30416_xh2n_4229.jpg\" /><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30416_2abl_7538.jpg\" alt=\"30416_2abl_7538.jpg\" /><img src=\"https://mz-demo-assets.tecmz.com/data/image/2017/12/20/30415_2q2b_5268.jpg\" alt=\"30415_2q2b_5268.jpg\" /></p>', '既是生活，也是旅程', '我们特别爱看访谈，他们身上有太多的精彩。喜欢冒险的人，生活本就会有很多的不一样，尤其是夫妻，生活得久了，就会有相同或者相似的人生态度。喜欢冒险，生活肯定不会波澜不惊。', 1, '2017-12-20 08:26:30', 94617, NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2017-12-20 08:35:24', '2025-06-07 10:35:34', '何处才是尽头', ':博客系统::魔众系统::旅行:', '黑夜，多么寒凉又孤独的词。在这浩垠苍茫世上，面对很多事我们都是有心无力，眼泪随之落下，是孤独和愁绪在作祟。其实，曾一度以为自己很强大的我们，却时常与孤独并肩，挣扎，有时在伸手不见五指的黑夜里，唯有抬头仰望微亮的星空，长叹一气，才找到与孤独相向的空间。', '[\"https:\\/\\/mz-assets.tecmz.com\\/data\\/mz-demo\\/travel-3.jpg\"]', '<p style=\"text-align:center;\"><br /></p>\n\n<p style=\"text-indent:2em;\">进入黑夜了，亮着的是城市万家灯火，走着的是形形色色的人们，还有那由机动车发出的鸣声，人们匆忙的步伐，那是家的向往。也许那里有着想见的人，也许那里可以放松些身心，也许那是夜里孤独最好的去处。</p>\n\n<p style=\"text-indent:2em;\">黑夜，多么寒凉又孤独的词。在这浩垠苍茫世上，面对很多事我们都是有心无力，眼泪随之落下，是孤独和愁绪在作祟。其实，曾一度以为自己很强大的我们，却时常与孤独并肩，挣扎，有时在伸手不见五指的黑夜里，唯有抬头仰望微亮的星空，长叹一气，才找到与孤独相向的空间。</p>\n\n<p style=\"text-indent:2em;\">夜里的风微凉，吹着一眉不展的脸，以为隐藏好的心事溢与表，更显多愁善感。看到乐哈哈的情人，看到开心跳广场舞的阿姨们，心里崩溃了，呐喊着：这他妈苦逼的人生，何时才是个头啊！又或者像哲人般委婉安慰自己：每个人生来都有自己要走完的路，没有尽头的路，随时是生命的终点，又何必在意那么多的得与失呢！又或者念叨着让人心静的禅语：得之我幸，失之我命，命里有时终须有，命里无时莫强求！</p>\n\n<p style=\"text-indent:2em;\">一个人独处容易会胡思乱想，好的坏的，都一下子在脑子里过幕，舍不得的，心疼了，心疼的，想着想着流泪了，再加一点遗憾的化学剂，整个人只想嚎啕大哭，亦或赐予我神般的力量与光明，我可以把一切妥妥做好，没有后悔，也没有一丝丝遗憾。看，明明是自己脆弱不堪，只不过孤独感在旁煽风点火而已。这世间哪有那么多神，哪有那么多如果，路一旦踏上了，就注定了无法回头！</p>\n\n<p style=\"text-indent:2em;\">曾几何时，自己散发着别人羡慕不已的光芒，曾几何时，怀揣着希望，光着脚丫奔赴梦想的战场，又曾几何时，自己不会后悔所付出的情和泪。可到最后的一无所有，让你自己心里后怕了，害怕失去，害怕想要的想爱的想要保护的人事一一离你远去。这时的你，像被千万重的孤独感压抑着，无法呼吸，无法求救，等待着的只有恐惧和死亡！</p>\n\n<p style=\"text-indent:2em;\">混沌元世，我们每个人都是赤裸裸来到这世上，同时与这一切的一切有着千丝万缕，喜怒哀乐也好，悲欢离合也罢，终究要走一遭，后悔也好，遗憾也罢，人生终究有了这几味药才会更浓，更有味道。人走茶凉，是一种孤独感，当你突破了孤独重围，又何尝不是个很好的终结。</p>\n\n<p style=\"text-indent:2em;\">你是无法真正跟别人分享你的孤独，而别人也无法真正理解你的孤独存在，我们的每个人心理是独立的，看不见，摸不着，更是想不透，每当你面对与孤独独处时，唯一的救世主唯有自己，而诸神也许在等你的业障未了，好坐收渔翁之利，旁人在等你哭笑不得，狼狈的样子而后开怀大笑。请你相信一个真理：靠自己才是最可靠的。你若是倒了，对不起，谁也给不了你“帮一把”。</p>\n\n<p style=\"text-indent:2em;\">夜里的某一处，也许也有让人如痴如醉的浪漫，长得很清秀诱人，孤独中的你也许很羡慕别人有这一方快乐天堂，可它终究是有毒的内在，侵蚀着人心，拖着躯壳在作秀。也许那浪漫我们都该名为醉生梦死！看似比孤独老去终究好看些，实则狼狈不已。</p>\n\n<p style=\"text-indent:2em;\">心事了了然，无遮掩，呐喊，嚎哭，怎样开心怎样做，岂不是快人心哉！</p>\n\n<p><br /></p>', '何处才是尽头', '黑夜，多么寒凉又孤独的词。在这浩垠苍茫世上，面对很多事我们都是有心无力，眼泪随之落下，是孤独和愁绪在作祟。其实，曾一度以为自己很强大的我们，却时常与孤独并肩，挣扎，有时在伸手不见五指的黑夜里，唯有抬头仰望微亮的星空，长叹一气，才找到与孤独相向的空间。', 1, '2017-12-20 08:34:44', 215074, 0, 16, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '2025-04-25 08:49:33', '2025-06-07 23:19:23', 'test', '', '', '[]', '<p>test</p>', '', '', 1, NULL, 30, 0, NULL, 0, NULL, 0, 0, 1, NULL, NULL, NULL),
(21, '2025-04-27 21:40:39', '2025-06-07 22:20:07', '调整与修改', ':要把经验及感悟分享的所有话题都放上让用户点击选，6个分类6个对应的话题题:', '主要是加注册、大类明确、改标题', '[]', '<p>页楣内容用最新的http://www.cznzz.com/huwai/index.html，页楣右边加上 欢迎访问运动圈，请先 注册 或 登录；发布博客标题改为“我分享”，<span>本页面的“博客文章增加”改为</span><span>“我分享 添加”，</span><span>“后台管理”改为“发视频”，分享前要先注册或登录</span>；标签对应话题的话改为“话题”；“<span>热门博客” 改为“热门文章”；是放到</span>点跑步时下拉<span>栏</span>有经验与感悟分享、品牌故事/企业库、地图库、社团地图、器材与用品店地图、大神库6个分类，6个分类对应的标题放上；6个分类前面要有5大类之一，如-分类 路跑/越野-<span>经验与感悟分享；标题“后台管理”改为“会员后台管理”，里面标题改为我们对应标题。</span></p>', '运动圈', '分享感悟交流', 1, NULL, 32, 1, NULL, 1, NULL, 1, 1, 1, NULL, NULL, NULL),
(22, '2025-04-28 07:56:13', '2025-06-07 22:40:08', '沈阳老张滑雪', ':沈阳老张滑雪:', '沈阳老张滑雪', '[]', '<p><video controls=\"controls\" preload=\"none\" width=\"420\" height=\"280\" src=\"/data/video/2025/04/28/28777_tzue_9954.mp4\"></video></p>', '滑雪', '滑雪，户外运动，运动圈', 1, NULL, 31, 1, NULL, 6, NULL, 1, 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `blog_category`
--

CREATE TABLE `blog_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blogCount` int(11) DEFAULT NULL COMMENT '博客数',
  `cover` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `templateView` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `blog_category`
--

INSERT INTO `blog_category` (`id`, `created_at`, `updated_at`, `pid`, `sort`, `title`, `blogCount`, `cover`, `keywords`, `description`, `templateView`) VALUES
(1, '2022-05-27 06:51:09', '2025-04-27 22:48:16', 0, 1, '经验及感悟分享', 2, '', '', '', ''),
(2, '2022-05-27 06:51:14', '2025-04-24 14:41:05', 0, 2, '品牌故事/企业库', 2, '', '', '', ''),
(3, '2022-05-27 06:51:24', '2025-04-24 14:41:16', 0, 3, '社区地图', 2, '', '', '', ''),
(4, '2022-05-27 06:51:29', '2025-04-24 14:41:37', 0, 4, '器材与用品店地图', 2, '', '', '', ''),
(5, '2022-05-27 06:51:39', '2025-04-24 14:41:57', 0, 5, '路线地图', 1, '', '', '', ''),
(6, '2022-05-27 06:51:44', '2025-04-28 08:03:44', 0, 6, '大神库', 2, '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `blog_comment`
--

CREATE TABLE `blog_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blogId` int(11) DEFAULT NULL COMMENT '博客',
  `username` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '称呼',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `url` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网址',
  `content` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内容',
  `memberUserId` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `blog_message`
--

CREATE TABLE `blog_message` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '称呼',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `url` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网址',
  `content` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内容',
  `upCount` int(11) DEFAULT NULL COMMENT '赞同数',
  `downCount` int(11) DEFAULT NULL COMMENT '反对数',
  `reply` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '作者回复',
  `memberUserId` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `blog_message`
--

INSERT INTO `blog_message` (`id`, `created_at`, `updated_at`, `username`, `email`, `url`, `content`, `upCount`, `downCount`, `reply`, `memberUserId`, `status`) VALUES
(5645, '2022-05-28 03:03:50', '2022-05-28 03:03:54', '小晨晨', '', '', '<p>把简单的事情坚持下去</p>', NULL, NULL, NULL, 0, 2),
(5646, '2022-05-28 03:04:19', '2022-05-28 03:04:43', '静', '', '', '<p>无论你有多喜欢一个男人，不要把时间和尽力全部用到那个男人身上。你要为自己保留一份生活的空间。</p>', NULL, NULL, NULL, 0, 2),
(5647, '2022-05-28 03:04:38', '2022-05-28 03:04:43', '克子', '', '', '<p>你要相信，你会被世界温柔相待，幸福只是迟到了，它不会永远缺席。</p>', NULL, NULL, NULL, 0, 2),
(5648, '2022-05-28 03:05:22', '2022-05-28 03:05:43', '毛毛', '', '', '<p>珍惜自己所拥有的一切，但是千万别放弃去追求自己想要的。</p>', NULL, NULL, NULL, 0, 2),
(5649, '2022-05-28 03:05:39', '2022-05-28 03:05:42', '英英', '', '', '<p>总有一天，你会站在最亮的地方，活成自己曾经渴望的模样。</p>', NULL, NULL, NULL, 0, 2),
(5650, '2022-05-28 03:06:23', '2022-05-28 03:06:28', '我心飞扬', '', '', '<p>或许对于世界，你是一个人；但对于我，你就是全世界。你在时，你是一切，你不在时，一切是你。</p>', NULL, NULL, NULL, 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci COMMENT '内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`id`, `created_at`, `updated_at`, `key`, `value`) VALUES
(1, '2025-04-22 15:18:55', '2025-04-24 14:39:52', 'Blog_CommentEnable', '1'),
(2, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteLogo', 'http://chengyujielong.xyz/data/image/2025/04/24/52356_9zgj_5914.png'),
(3, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteName', '运动圈'),
(4, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteDomain', 'chengyujielong.xyz'),
(5, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteKeywords', ''),
(6, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteDescription', ''),
(7, '2025-04-22 15:18:55', '2025-04-22 15:18:55', 'systemCounter', ''),
(8, '2025-04-22 15:18:55', '2025-04-24 15:01:33', 'siteSlogan', ''),
(9, '2025-04-22 15:18:55', '2025-04-22 15:18:55', 'Blog_AboutContent', '<pre class=\"brush:php;toolbar:false\">我想说 \n这个世界不只有眼前的苟且，还有诗和远方。</pre>\n\n<h4><strong>先来个自我介绍吧</strong></h4>\n\n<p>    在坚硬的世界里，修得一颗温柔心～ 用文字记录生活，把生活写成文字。</p>\n\n<p>    95后程序媛，现工作于西安，误打误撞进入前端开发，既然选择了，我会尽量选择多走一点 </p>\n\n<p>    总是想的多，做的少，偶尔跑步 </p>\n\n<p>    喜欢看剧和综艺（不带思考的那种, 慢慢改善），多看电影和记录片 </p>\n\n<h4>关于工作态度</h4>\n\n<p>    工作是一场马拉松，不是短跑。</p>\n\n<p>    尊重人，而不是头衔。</p>\n\n<p>    工作从白板开始，而不是从键盘。</p>\n\n<p>    产出的是价值，而不是代码。</p>\n\n<p>    热爱生活，而不是工作。</p>\n\n<p>    学会享受过程。</p>\n\n<p><br /></p>\n\n<p><strong>一个人成长的快慢，主要取决于他在工作之外的 8 小时做什么。</strong></p>\n\n<p><strong>把简单的事情坚持下去。</strong></p>\n\n<p><strong>业余时间用在哪，回报就在哪。</strong></p>\n\n<p><strong>企业里的老员工的优势不在于具备更强的业务能力，而在于对内部流程有较高的熟悉程度。这种在同一个环境中久待而形成的思维定式，可能因为符合既定环境而让人一时受益，但长久看来，却是阻碍创新的掣肘。</strong></p>\n\n<p><strong>互联网行业从来没有“稳定之说”。</strong></p>'),
(10, '2025-04-22 15:18:55', '2025-04-24 14:39:52', 'Blog_Name', ''),
(11, '2025-04-22 15:18:55', '2025-04-24 14:39:52', 'Blog_Slogan', ''),
(12, '2025-04-22 15:18:55', '2025-04-24 14:39:52', 'Blog_Avatar', 'http://chengyujielong.xyz/data/image/2025/04/24/52778_qcgs_7819.jpg'),
(13, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteUrl', ''),
(14, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteFavIco', ''),
(15, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'sitePrimaryColor', ''),
(16, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteTemplate', 'default'),
(17, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteBeian', ''),
(18, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteBeianGonganText', ''),
(19, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'siteBeianGonganLink', ''),
(20, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_CopyrightOthers', ''),
(21, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_ContactEmail', ''),
(22, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_ContactPhone', ''),
(23, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_ContactAddress', ''),
(24, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_ContactQrcode', ''),
(25, '2025-04-22 15:27:50', '2025-04-24 15:01:33', 'Site_PublicInternalUrlMap', '[]'),
(26, '2025-04-24 14:25:41', '2025-04-24 14:25:41', 'ModuleList', '{\"Article\":{\"enable\":true,\"config\":[]}}'),
(27, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_SeoTitle', ''),
(28, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_SeoKeywords', ''),
(29, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_SeoDescription', ''),
(30, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_ContactQQ', ''),
(31, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_ContactWeibo', ''),
(32, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_ContactWechat', ''),
(33, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_PanelTagLimit', '0'),
(34, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_DarkModeEnable', '0'),
(35, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_DarkModeType', NULL),
(36, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_DarkModeStart', NULL),
(37, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_DarkModeEnd', NULL),
(38, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_BlogSuperSearchProvider', ''),
(39, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_ContentNavEnable', '0'),
(40, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_BlogCaptchaProvider', 'default'),
(41, '2025-04-24 14:39:52', '2025-04-24 14:39:52', 'Blog_MessageCaptchaProvider', 'default');

-- --------------------------------------------------------

--
-- 表的结构 `data`
--

CREATE TABLE `data` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '大类',
  `path` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路径',
  `filename` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '原始文件名',
  `size` int(10) UNSIGNED NOT NULL,
  `driver` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '大类',
  `domain` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '域名',
  `md5` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `data`
--

INSERT INTO `data` (`id`, `created_at`, `updated_at`, `category`, `path`, `filename`, `size`, `driver`, `domain`, `md5`) VALUES
(1, '2025-04-24 14:32:36', '2025-04-24 14:32:36', 'image', '2025/04/24/52356_9zgj_5914.png', 'logo.png', 3517, NULL, NULL, 'addd8a1196a2639246fb9e22aded0116'),
(2, '2025-04-24 14:39:38', '2025-04-24 14:39:38', 'image', '2025/04/24/52778_qcgs_7819.jpg', 'gzh.jpg', 28422, NULL, NULL, '5ed631db12d0cf984e6ca6130c46cf43'),
(3, '2025-04-24 14:47:56', '2025-04-24 14:47:56', 'image', '2025/04/24/53276_m8ns_4356.jpg', 'banner1.jpg', 59672, NULL, NULL, '78021ffd1ea2d19f397a1b0e94fef863'),
(4, '2025-04-24 14:48:21', '2025-04-24 14:48:21', 'image', '2025/04/24/53301_t7gb_5808.jpg', 'banner2.jpg', 37339, NULL, NULL, '9857e82f5d1a7031c315321db9f0deca'),
(5, '2025-04-24 14:48:44', '2025-04-24 14:48:44', 'image', '2025/04/24/53324_jp71_7540.jpg', 'banner2.jpg', 37339, NULL, NULL, '9857e82f5d1a7031c315321db9f0deca'),
(6, '2025-04-24 14:49:02', '2025-04-24 14:49:02', 'image', '2025/04/24/53342_91u6_7864.jpg', 'banner3.jpg', 60937, NULL, NULL, 'bd0ff1db4e75c2456e2bf5b045c12a14'),
(7, '2025-04-24 14:49:18', '2025-04-24 14:49:18', 'image', '2025/04/24/53358_0qyq_5017.jpg', 'banner4.jpg', 48541, NULL, NULL, '9e0b7a2039c312a0d8997a668f3e9c3e'),
(8, '2025-04-24 14:49:35', '2025-04-24 14:49:35', 'image', '2025/04/24/53375_xls0_8191.jpg', 'banner4.jpg', 48541, NULL, NULL, '9e0b7a2039c312a0d8997a668f3e9c3e'),
(9, '2025-04-24 14:49:52', '2025-04-24 14:49:52', 'image', '2025/04/24/53392_qvab_4360.jpg', 'banner5.jpg', 44913, NULL, NULL, '3b99c58e6265104a457ec9f3d63235cd'),
(10, '2025-04-28 07:59:37', '2025-04-28 07:59:37', 'video', '2025/04/28/28777_tzue_9954.mp4', '沈阳老张滑雪.mp4', 2445736, NULL, NULL, '3819cd79fdb2545ea1da858465bb2347');

-- --------------------------------------------------------

--
-- 表的结构 `data_temp`
--

CREATE TABLE `data_temp` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '大类',
  `path` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路径',
  `filename` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '原始文件名',
  `size` int(10) UNSIGNED DEFAULT NULL COMMENT '文件大小',
  `md5` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `lazy_value`
--

CREATE TABLE `lazy_value` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '业务标识',
  `param` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '参数JSON',
  `expire` int(11) DEFAULT NULL,
  `lifeExpire` int(11) DEFAULT NULL,
  `cacheSeconds` int(11) DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2015_12_22_213911_create_config', 1),
(2, '2015_12_22_215956_create_data', 1),
(3, '2015_12_22_215956_create_data_temp', 1),
(4, '2018_05_07_000000_modify_data_driver', 1),
(5, '2021_01_01_000000_create_admin', 1),
(6, '2021_01_01_000000_create_admin_upload', 1),
(7, '2018_10_24_000000_create_lazy_value', 2),
(8, '2020_01_00_000000_create_atomic', 2),
(9, '2020_01_00_000000_create_schedule_run', 2),
(10, '2022_03_13_000000_data_add_md5', 2),
(11, '2022_09_27_000000_data_add_index', 2),
(12, '2021_12_12_000000_modify_admin_user_add_phone_email', 3),
(13, '2022_08_09_000000_modify_admin_role_add_remark', 3),
(14, '2022_08_10_000000_upgrade_admin_upload_category_id', 3),
(15, '2017_01_01_000000_create_nav', 4),
(16, '2021_09_17_000000_modify_nav_add_open_type', 4),
(17, '2022_01_05_000000_nav_nav_add_pid', 4),
(18, '2022_04_12_000000_nav_nav_enable', 4),
(19, '2022_10_13_000000_nav_nav_icon', 4),
(20, '2016_07_23_000000_create_partner', 5),
(21, '2023_02_17_000000_partner_enable', 5),
(22, '2023_03_21_000000_visit_statistic_daily_report_create', 6),
(23, '2023_03_21_000000_visit_statistic_item_create', 6),
(24, '2017_01_01_000000_create_banner', 7),
(25, '2021_04_15_000000_modify_banner_add_type', 7),
(26, '2021_08_16_000000_modify_banner_add_video', 7),
(27, '2023_04_03_000000_modify_banner_add_background_color', 7),
(28, '2024_02_28_000000_aigc_key_pool_create', 8),
(29, '2025_02_27_000000_aigc_task_create', 8),
(30, '2025_03_20_000000_aigc_work_create', 8),
(31, '2017_01_01_000000_create_blog', 9),
(32, '2017_01_01_000000_create_message', 9),
(33, '2017_07_31_000000_create_blog_comment', 9),
(34, '2022_05_26_000000_blog_comment_fields_modify', 9),
(35, '2022_05_26_000000_blog_fields_modify', 9),
(36, '2022_05_26_000000_create_blog_category', 9),
(37, '2022_05_27_000000_create_blog_message', 9),
(38, '2022_09_26_000000_modify_blog_category_keywords', 9),
(39, '2022_10_17_000000_modify_blog_dynamic_template', 9),
(40, '2023_03_15_000000_blog_fields_recommend_hot_modify', 9),
(41, '2023_08_23_000000_blog_password_modify', 9),
(42, '2023_10_19_000000_blog_fav_like_count', 9),
(43, '2023_11_08_000001_blog_comment_enable', 9),
(44, '2017_01_01_000000_create_article', 10),
(45, '2017_01_01_000000_modify_article_add_sort', 10),
(46, '2021_05_01_000000_modify_article_add_alias', 10);

-- --------------------------------------------------------

--
-- 表的结构 `nav`
--

CREATE TABLE `nav` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '位置',
  `sort` int(11) DEFAULT NULL COMMENT '顺序',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `link` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '链接',
  `openType` tinyint(4) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL COMMENT '上级ID',
  `enable` tinyint(4) DEFAULT NULL COMMENT '启用',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图标'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `nav`
--

INSERT INTO `nav` (`id`, `created_at`, `updated_at`, `position`, `sort`, `name`, `link`, `openType`, `pid`, `enable`, `icon`) VALUES
(1, '2022-05-27 06:55:26', '2025-04-24 14:35:54', 'head', 5, '冰雪运动', '', 2, 0, 1, ''),
(2, '2022-05-27 06:55:37', '2022-05-27 06:59:09', 'head', 1, '后台管理', 'https://blog.demo.tecmz.com/admin', 2, 1, 1, NULL),
(3, '2022-05-27 06:55:47', '2022-05-27 06:59:09', 'head', 2, '模块市场', 'https://modstart.com/store', 2, 1, 1, NULL),
(4, '2022-05-27 06:56:12', '2025-04-24 14:31:18', 'head', 1, '跑步/越野', '/', 1, 0, 1, ''),
(5, '2022-05-27 06:56:42', '2022-05-28 03:54:32', 'foot', 3, '关于博主', '/blog/about', 1, 0, 1, NULL),
(6, '2022-05-27 06:56:47', '2022-05-28 03:54:44', 'foot', 4, '博客留言', '/blog/message', 1, 0, 1, NULL),
(12, '2022-05-27 06:58:25', '2025-04-24 14:35:38', 'head', 4, '水上运动', '/blog/about', 1, 0, 1, ''),
(13, '2022-05-27 06:59:04', '2025-04-24 14:29:16', 'head', 2, '骑行与速度运动', '/blogs', 1, 0, 1, ''),
(14, '2022-05-27 07:00:41', '2025-04-24 14:35:38', 'head', 3, '登山运动', '/blog/message', 1, 0, 1, ''),
(15, '2025-04-24 14:31:35', '2025-04-24 14:31:35', 'head', 8, '跑步首页', '', 1, 4, 1, ''),
(16, '2025-04-24 14:35:29', '2025-04-24 14:35:54', 'head', 6, '大神风采', '', 1, 0, 1, ''),
(17, '2025-04-24 14:53:55', '2025-04-24 14:53:55', 'head', 9, '经验与感悟分享', '', 1, 4, 1, ''),
(18, '2025-04-24 14:55:46', '2025-04-24 14:55:46', 'head', 10, '速度首页', '/', 1, 13, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `partner`
--

CREATE TABLE `partner` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '位置',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `title` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `logo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Logo',
  `link` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '链接',
  `enable` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `partner`
--

INSERT INTO `partner` (`id`, `created_at`, `updated_at`, `position`, `sort`, `title`, `logo`, `link`, `enable`) VALUES
(1, '2022-05-27 06:53:55', '2022-05-27 06:54:08', 'Blog', 1, 'ModStart', 'https://mz-assets.tecmz.com/data/image/2021/12/13/34505_8eqz_2907.png', '', NULL),
(3, '2022-05-27 06:54:40', '2022-05-27 06:54:40', 'Blog', 3, '百度', '', '', NULL),
(4, '2022-05-27 06:54:47', '2022-05-27 06:54:47', 'Blog', 4, '魔众', '', '', NULL),
(5, '2022-05-28 02:45:06', '2022-05-28 02:45:06', 'Blog', 5, 'Turing', '', '', NULL),
(6, '2022-05-28 02:45:47', '2022-05-28 02:45:47', 'Blog', 6, '宁静的小屋', '', '', NULL),
(7, '2022-05-28 02:47:18', '2022-05-28 02:47:18', 'Blog', 7, 'April的记录册', '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `schedule_run`
--

CREATE TABLE `schedule_run` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `result` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `visit_statistic_daily_report`
--

CREATE TABLE `visit_statistic_daily_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `day` date DEFAULT NULL,
  `uv` int(11) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `visit_statistic_daily_report`
--

INSERT INTO `visit_statistic_daily_report` (`id`, `created_at`, `updated_at`, `day`, `uv`, `pv`) VALUES
(1, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-07', 0, 0),
(2, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-08', 0, 0),
(3, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-09', 0, 0),
(4, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-10', 0, 0),
(5, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-11', 0, 0),
(6, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-12', 0, 0),
(7, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-13', 0, 0),
(8, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-14', 0, 0),
(9, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-15', 0, 0),
(10, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-16', 0, 0),
(11, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-17', 0, 0),
(12, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-18', 0, 0),
(13, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-19', 0, 0),
(14, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-20', 0, 0),
(15, '2025-04-22 15:28:35', '2025-04-22 15:28:35', '2025-04-21', 0, 0),
(16, '2025-04-24 14:58:46', '2025-04-24 14:58:46', '2025-04-22', 0, 0),
(17, '2025-04-24 14:58:46', '2025-04-24 14:58:46', '2025-04-23', 0, 0),
(18, '2025-04-28 07:05:30', '2025-04-28 07:05:30', '2025-04-24', 0, 0),
(19, '2025-04-28 07:05:30', '2025-04-28 07:05:30', '2025-04-25', 0, 0),
(20, '2025-04-28 07:05:30', '2025-04-28 07:05:30', '2025-04-26', 0, 0),
(21, '2025-04-28 07:05:30', '2025-04-28 07:05:30', '2025-04-27', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `visit_statistic_item`
--

CREATE TABLE `visit_statistic_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` tinyint(4) DEFAULT NULL,
  `ua` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `admin_log_data`
--
ALTER TABLE `admin_log_data`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `admin_role_rule`
--
ALTER TABLE `admin_role_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_role_rule_roleid_index` (`roleId`);

--
-- 表的索引 `admin_upload`
--
ALTER TABLE `admin_upload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_upload_uploadcategoryid_index` (`uploadCategoryId`),
  ADD KEY `admin_upload_userid_category_index` (`userId`,`category`);

--
-- 表的索引 `admin_upload_category`
--
ALTER TABLE `admin_upload_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_upload_category_userid_category_index` (`userId`,`category`);

--
-- 表的索引 `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_user_username_unique` (`username`),
  ADD UNIQUE KEY `admin_user_phone_unique` (`phone`),
  ADD UNIQUE KEY `admin_user_email_unique` (`email`);

--
-- 表的索引 `admin_user_role`
--
ALTER TABLE `admin_user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_role_userid_index` (`userId`),
  ADD KEY `admin_user_role_roleid_index` (`roleId`);

--
-- 表的索引 `aigc_key_pool`
--
ALTER TABLE `aigc_key_pool`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `aigc_task`
--
ALTER TABLE `aigc_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aigc_task_memberuserid_biz_index` (`memberUserId`,`biz`);

--
-- 表的索引 `aigc_work`
--
ALTER TABLE `aigc_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aigc_work_biz_index` (`biz`);

--
-- 表的索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_alias_index` (`alias`);

--
-- 表的索引 `atomic`
--
ALTER TABLE `atomic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `atomic_name_unique` (`name`),
  ADD KEY `atomic_expire_index` (`expire`);

--
-- 表的索引 `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_created_at_index` (`created_at`),
  ADD KEY `blog_categoryid_index` (`categoryId`);

--
-- 表的索引 `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_comment_blogid_index` (`blogId`);

--
-- 表的索引 `blog_message`
--
ALTER TABLE `blog_message`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `config_key_index` (`key`);

--
-- 表的索引 `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_md5_index` (`md5`),
  ADD KEY `data_category_path_index` (`category`,`path`);

--
-- 表的索引 `data_temp`
--
ALTER TABLE `data_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_temp_category_path_index` (`category`,`path`),
  ADD KEY `data_temp_md5_index` (`md5`);

--
-- 表的索引 `lazy_value`
--
ALTER TABLE `lazy_value`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lazy_value_key_param_unique` (`key`,`param`),
  ADD KEY `lazy_value_expire_index` (`expire`),
  ADD KEY `lazy_value_lifeexpire_index` (`lifeExpire`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `schedule_run`
--
ALTER TABLE `schedule_run`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_run_created_at_index` (`created_at`);

--
-- 表的索引 `visit_statistic_daily_report`
--
ALTER TABLE `visit_statistic_daily_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_statistic_daily_report_day_unique` (`day`);

--
-- 表的索引 `visit_statistic_item`
--
ALTER TABLE `visit_statistic_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visit_statistic_item_created_at_index` (`created_at`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `admin_log_data`
--
ALTER TABLE `admin_log_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `admin_role_rule`
--
ALTER TABLE `admin_role_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `admin_upload`
--
ALTER TABLE `admin_upload`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `admin_upload_category`
--
ALTER TABLE `admin_upload_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_user_role`
--
ALTER TABLE `admin_user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `aigc_key_pool`
--
ALTER TABLE `aigc_key_pool`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `aigc_task`
--
ALTER TABLE `aigc_task`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `aigc_work`
--
ALTER TABLE `aigc_work`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `atomic`
--
ALTER TABLE `atomic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `blog_message`
--
ALTER TABLE `blog_message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5651;

--
-- 使用表AUTO_INCREMENT `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用表AUTO_INCREMENT `data`
--
ALTER TABLE `data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `data_temp`
--
ALTER TABLE `data_temp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `lazy_value`
--
ALTER TABLE `lazy_value`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- 使用表AUTO_INCREMENT `nav`
--
ALTER TABLE `nav`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `schedule_run`
--
ALTER TABLE `schedule_run`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `visit_statistic_daily_report`
--
ALTER TABLE `visit_statistic_daily_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `visit_statistic_item`
--
ALTER TABLE `visit_statistic_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
