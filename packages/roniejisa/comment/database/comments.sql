/*
 Navicat Premium Data Transfer

 Source Server         : thienhuong_db
 Source Server Type    : MySQL
 Source Server Version : 50505
 Source Host           : localhost:3306
 Source Schema         : thienhuong_db

 Target Server Type    : MySQL
 Target Server Version : 50505
 File Encoding         : 65001

 Date: 31/03/2022 17:03:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL COMMENT 'ID user',
  `map_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Bảng map bình luận',
  `map_id` int(11) NULL DEFAULT NULL COMMENT 'ID map bình luận',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Nội dung bình luận',
  `parent` int(11) NULL DEFAULT NULL COMMENT 'Comment cha',
  `is_admin` tinyint(4) NULL DEFAULT NULL COMMENT 'Có phải admin',
  `act` tinyint(4) NULL DEFAULT 0 COMMENT 'Kích hoạt',
  `created_at` datetime NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` datetime NULL DEFAULT NULL COMMENT 'Ngày cập nhật',
  `imgs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Ảnh bình luận',
  `order_id` int(11) NULL DEFAULT NULL COMMENT 'Đơn hàng',
  `is_fake` tinyint(4) NULL DEFAULT NULL COMMENT 'Fake order',
  `is_read` tinyint(4) NULL DEFAULT NULL COMMENT 'Đã đọc',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `act`(`act`) USING BTREE,
  INDEX `map_table`(`map_table`) USING BTREE,
  INDEX `map_id`(`map_id`) USING BTREE,
  INDEX `parent`(`parent`) USING BTREE,
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1702 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for like_comments
-- ----------------------------
DROP TABLE IF EXISTS `like_comments`;
CREATE TABLE `like_comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NULL DEFAULT NULL COMMENT 'Commnet',
  `user_id` int(11) NULL DEFAULT NULL COMMENT 'Tài khoản',
  `created_at` datetime NULL DEFAULT NULL COMMENT 'Ngày cập nhật',
  `updated_at` datetime NULL DEFAULT NULL COMMENT 'Ngày tạo',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comment_id`(`comment_id`) USING BTREE,
  CONSTRAINT `like_comments_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ratings
-- ----------------------------
DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NULL DEFAULT NULL,
  `rating` tinyint(1) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` datetime NULL DEFAULT NULL COMMENT 'Ngày cập nhật',
  `map_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Bảng sản phẩm',
  `map_id` int(11) NULL DEFAULT NULL COMMENT 'Mã sản phẩm',
  `user_id` int(11) NULL DEFAULT NULL COMMENT 'Nguời đánh giá',
  `order_id` int(11) NULL DEFAULT NULL COMMENT 'Mã đơn hàng',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comment_id`(`comment_id`) USING BTREE,
  CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1415 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
