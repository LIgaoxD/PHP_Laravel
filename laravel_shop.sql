/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : laravel_shop

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 17/11/2023 19:13:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for shop_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `shop_admin_user`;
CREATE TABLE `shop_admin_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '昵称',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1003 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台用户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_admin_user
-- ----------------------------
INSERT INTO `shop_admin_user` VALUES (1001, 'admin', 'gxd', '123456', '2022-09-16 21:06:13', '2022-09-16 22:15:39');
INSERT INTO `shop_admin_user` VALUES (1002, 'gxd6', 'xuedong', '123456', '2023-10-10 16:06:17', '2023-10-10 16:06:24');

-- ----------------------------
-- Table structure for shop_cart
-- ----------------------------
DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE `shop_cart`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `content` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '购物车信息，[{good_id: xxx, num: xxx}, ...]',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1001 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '购物车表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_cart
-- ----------------------------

-- ----------------------------
-- Table structure for shop_config
-- ----------------------------
DROP TABLE IF EXISTS `shop_config`;
CREATE TABLE `shop_config`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置值',
  `value` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置值',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1003 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台配置表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_config
-- ----------------------------
INSERT INTO `shop_config` VALUES (1001, 'theme', 'game', '2022-09-16 09:54:38', '2022-09-16 12:46:43');
INSERT INTO `shop_config` VALUES (1002, 'site_name', '在线商城      GAO.J', '2022-09-16 08:52:38', '2022-09-16 14:52:38');

-- ----------------------------
-- Table structure for shop_good
-- ----------------------------
DROP TABLE IF EXISTS `shop_good`;
CREATE TABLE `shop_good`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `title_sub` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '副标题',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片',
  `amount` decimal(6, 2) UNSIGNED NOT NULL COMMENT '价格',
  `cate` tinyint UNSIGNED NOT NULL COMMENT '类别，1：游戏，2：课程',
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标签，tejiao：特价，rexiao：热销',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0：下架，1：正常',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1120 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_good
-- ----------------------------
INSERT INTO `shop_good` VALUES (1079, 'Air-Jordan-4', '复刻女子运动鞋', '/uploads/img/cover/nyJbFYMKPuTi3i1xJozeplgvKy7pkkOyhatdLqQm.jpg', 11.00, 1, 'tejiao', 1, '2022-09-25 14:06:13', '2022-09-25 14:06:13');
INSERT INTO `shop_good` VALUES (1080, 'The North Face', '羽绒服', '/uploads/img/cover/MQFRXqjfzQEu2UmpIznPzQxitWjj0j9V8u9GvLjQ.png', 320.00, 1, 'rexiao', 1, '2022-09-25 14:13:24', '2022-09-25 14:13:24');
INSERT INTO `shop_good` VALUES (1081, 'Converse', '高帮鞋', '/uploads/img/cover/cVMYzNeTSPqENZqCwvWDJGWsuDy1Sycr00uQwwul.webp', 120.00, 1, 'rexiao', 1, '2022-09-25 14:41:52', '2022-09-25 14:41:52');
INSERT INTO `shop_good` VALUES (1082, 'MLB', '挎包', '/uploads/img/cover/RXtgsVHRIvhaxCxu5qZNdGcNSDymwjvawIVI8CXK.jpg', 66.00, 1, 'rexiao', 1, '2022-09-25 14:42:56', '2022-09-25 14:42:56');
INSERT INTO `shop_good` VALUES (1083, 'Vans', '板鞋', '/uploads/img/cover/siKWfK0nrhGJMoUgyNxgAmNthNBkISHoPlFdH4YX.jpg', 60.00, 1, 'tejiao', 1, '2022-09-25 14:44:35', '2022-09-25 14:44:35');
INSERT INTO `shop_good` VALUES (1084, 'Adidas', '小板鞋', '/uploads/img/cover/KcVjJamWnfABRnzpL9G4CcsYz3mjXCzrTZ4HixqU.jpg', 188.00, 1, 'tejiao', 1, '2022-09-25 14:46:45', '2022-09-25 14:46:45');
INSERT INTO `shop_good` VALUES (1085, 'BOY', '外套', '/uploads/img/cover/TTTx920O4BMcrszAV8eFgG4HUfJlhZoQK65fK6vD.jpg', 80.00, 1, 'rexiao', 1, '2022-09-25 14:53:52', '2022-09-25 14:53:52');
INSERT INTO `shop_good` VALUES (1086, 'MLB', '帽子', '/uploads/img/cover/PBNNGNQu1Vi3QiMcRMZQBDkMJhFXvkzPZyUfqiqb.jpg', 88.00, 1, 'tejiao', 1, '2023-10-10 14:46:37', '2023-10-10 14:46:37');
INSERT INTO `shop_good` VALUES (1088, 'Converse', '高帮限定鞋', '/uploads/img/cover/UogFxtXdgCPXaYFDG3etPLKlw4jNUkOqFipIPlF7.webp', 69.00, 1, 'rexiao', 1, '2023-10-16 22:35:48', '2023-10-16 22:35:48');
INSERT INTO `shop_good` VALUES (1089, 'BOY', '卫衣', '/uploads/img/cover/hfxbNUSHzaFK6n37JtC4vl1Hx4aVlXuOHiWPQ5sZ.jpg', 77.00, 1, 'tejiao', 1, '2023-10-16 22:37:49', '2023-10-16 22:37:49');
INSERT INTO `shop_good` VALUES (1090, 'Air-Jordan-11', '男子运动鞋', '/uploads/img/cover/lPfvel8o8zjrWLQYXPtvR740k9h8gUvf56PPonS9.jpg', 99.00, 1, 'tejiao', 1, '2023-10-16 22:40:04', '2023-10-16 22:40:04');
INSERT INTO `shop_good` VALUES (1091, 'Adidas', '兔年限定鞋', '/uploads/img/cover/wCFMsYSy5gshiSvAJ2ZTTwyjZVIgmouwglTcIwP2.jpg', 199.00, 1, 'rexiao', 1, '2023-10-16 22:40:54', '2023-10-16 22:40:54');
INSERT INTO `shop_good` VALUES (1092, 'The North Face', '冲锋衣', '/uploads/img/cover/sDNbA61qqGM0bQSMNliCp63wCZeL9UxdoelsfqVj.jpg', 299.00, 1, 'tejiao', 1, '2023-10-16 22:41:54', '2023-10-16 22:41:54');
INSERT INTO `shop_good` VALUES (1093, 'Adidas', '经典小白鞋', '/uploads/img/cover/1vyx7prrZuJjex3cCUJioSMK61qpqNvht7qcswyd.jpg', 199.00, 1, 'rexiao', 1, '2023-10-16 22:42:52', '2023-10-16 22:42:52');
INSERT INTO `shop_good` VALUES (1094, 'Converse', '小书包', '/uploads/img/cover/QCYK5c6uNzihMtk5Lu1YIoqnJsuYesp4AKS2M6b3.webp', 299.00, 1, 'rexiao', 1, '2023-10-16 22:44:10', '2023-10-16 22:44:10');
INSERT INTO `shop_good` VALUES (1095, 'Nike Dunk Low', '女子运动鞋复古板鞋', '/uploads/img/cover/j6Mbe3cZBhlzFyakhD3dhTjavuonQ27ga47dH1mr.webp', 266.00, 1, 'tejiao', 1, '2023-10-16 22:47:35', '2023-10-16 22:47:35');
INSERT INTO `shop_good` VALUES (1098, 'BOY', '兔年限定外套', '/uploads/img/cover/BfW56rB4SsrX0DTGkLNZTrOjnGMY51GWKyIT3f0e.jpg', 366.00, 1, 'tejiao', 1, '2023-10-17 09:56:51', '2023-10-17 09:56:51');
INSERT INTO `shop_good` VALUES (1099, 'BOY', '毛衣', '/uploads/img/cover/xFZ4uJrU2o5d2EFZmeptDZ8DDTpsjQ00lWgosl87.jpg', 88.00, 1, 'rexiao', 1, '2023-10-18 21:17:11', '2023-10-18 21:17:11');
INSERT INTO `shop_good` VALUES (1100, 'Adidas', '运动鞋', '/uploads/img/cover/oaSI25wsLnZ2tUzYhj4kiD5CDkHTOKVlnWN4TWK9.jpg', 99.00, 1, 'rexiao', 1, '2023-10-18 21:19:52', '2023-10-18 21:19:52');
INSERT INTO `shop_good` VALUES (1101, 'Adidas', '高帮棉运动鞋', '/uploads/img/cover/6Np859awhLAfPp5b6TUrFco9JAHZN1UBygOVg1J5.jpg', 234.00, 1, 'tejiao', 1, '2023-10-18 21:20:40', '2023-10-18 21:20:40');
INSERT INTO `shop_good` VALUES (1102, 'Converse', '高帮板鞋', '/uploads/img/cover/hoRFUZ3fgwYDISe60HYQLBzFMDUepIKoaTFqR9Pb.webp', 166.00, 1, 'tejiao', 1, '2023-10-18 21:21:32', '2023-10-18 21:21:32');
INSERT INTO `shop_good` VALUES (1103, 'BOY', '羽绒马甲', '/uploads/img/cover/v0aP05d7NMxTaKgtI3DAlIuGLsdOskvYT9UouTMo.jpg', 289.00, 1, 'rexiao', 1, '2023-10-18 21:22:17', '2023-10-18 21:22:17');
INSERT INTO `shop_good` VALUES (1104, 'Jordan-nu-retro-1-low', '复刻男子运动鞋', '/uploads/img/cover/49M2rsasUD6AkbKQxdulWFYkQ1uygSPmlRoUvc1S.jpg', 355.00, 1, 'tejiao', 1, '2023-10-18 21:22:55', '2023-10-18 21:22:55');
INSERT INTO `shop_good` VALUES (1105, 'Nike', '女子运动鞋', '/uploads/img/cover/CVEm7cxUDsuguZ7nrKXR7Mjm3GEyPnmAjlcqUJV8.jpg', 233.00, 1, 'rexiao', 1, '2023-10-18 21:23:33', '2023-10-18 21:23:33');
INSERT INTO `shop_good` VALUES (1106, 'The North Face', '羽绒服-兔年', '/uploads/img/cover/FmFlwzeCDh0dBTUBvpPqUTkqR8YnHllPEUdwulyC.png', 388.00, 1, 'tejiao', 1, '2023-10-18 21:24:48', '2023-10-18 21:24:48');
INSERT INTO `shop_good` VALUES (1107, 'PUMA', '女子针织卫衣【IVE同款】', '/uploads/img/cover/IRGgusqJJQ5pdbCZiCvwKjR4c9EAx35XbsCfW6UC.jpg', 366.00, 1, 'tejiao', 1, '2023-10-18 21:33:59', '2023-10-18 21:33:59');
INSERT INTO `shop_good` VALUES (1108, 'PUMA', '小泡芙男女同款羽绒外套【IVE同款】', '/uploads/img/cover/cPHv42D3ikZNJe2r4XJl5OJz7WFNVSgiUguLEtuN.jpg', 400.00, 1, 'rexiao', 1, '2023-10-18 21:34:49', '2023-10-18 21:34:49');
INSERT INTO `shop_good` VALUES (1109, 'The North Face', '北面抓绒上衣女户外舒适保暖秋季新款', '/uploads/img/cover/A5dPURTxIxFx1g7tylpWNIqJTTYxJhwLPBI40Pcb.jpg', 466.00, 1, 'rexiao', 1, '2023-10-18 21:37:30', '2023-10-18 21:37:30');
INSERT INTO `shop_good` VALUES (1110, 'The North Face', '北面童装羽绒服女童防水保暖抓绒23秋冬新款', '/uploads/img/cover/BTOskIwTMH2HouFJVclPDk78YkaKF9rPwyeR4nZB.jpg', 320.00, 1, 'rexiao', 1, '2023-10-18 21:39:17', '2023-10-18 21:39:17');
INSERT INTO `shop_good` VALUES (1111, 'Adidas', 'BLUE VERSION 手提購物袋', '/uploads/img/cover/4x0UP7PMKlRjP63bNkwxACcCNHAhDuOhkOvx3a0B.jpg', 100.00, 1, 'rexiao', 1, '2023-10-18 21:40:21', '2023-10-18 21:40:21');
INSERT INTO `shop_good` VALUES (1112, 'MLB', '外套 NEW YORK', '/uploads/img/cover/oYL0jViFfVucp6JWCxwbvL8FY8Iu7biARjwARtJ9.jpg', 288.00, 1, 'rexiao', 1, '2023-10-18 21:42:17', '2023-10-18 21:42:17');
INSERT INTO `shop_good` VALUES (1113, 'PUMA', 'FUTURE ULTIMATE MG  男子足球鞋', '/uploads/img/cover/yf66ddqvwGUg9awx7O15LZykRhj120slV9w9OyPs.jpg', 399.00, 1, 'tejiao', 1, '2023-10-18 21:44:28', '2023-10-18 21:44:28');
INSERT INTO `shop_good` VALUES (1114, 'MLB', '女式心形灯羽绒背心纽约洋基队', '/uploads/img/cover/Igl7D493jLzsHO6r0YyIsja4T5qODn4CjWjWX8HA.jpg', 236.00, 1, 'rexiao', 1, '2023-10-18 21:45:51', '2023-10-18 21:45:51');
INSERT INTO `shop_good` VALUES (1115, 'Adidas', 'LONG ZIP DOWN JACKET 运动中长款鸭绒羽绒服', '/uploads/img/cover/eosF1nYPaxoDIZTGYzMJ9gsF8iQwNsmtfgpn42lU.png', 456.00, 1, 'tejiao', 1, '2023-11-16 09:59:03', '2023-11-16 09:59:03');
INSERT INTO `shop_good` VALUES (1116, 'Adidas', 'SWEAT HOODIE 拼接运动连帽套头衫', '/uploads/img/cover/w9MG1QXe3JNQHLGbnSEYoaFgxS0oxF3SLLG04gnu.png', 234.00, 1, 'tejiao', 1, '2023-11-16 10:00:42', '2023-11-16 10:00:42');
INSERT INTO `shop_good` VALUES (1117, 'Adidas', 'THIN FILLED JACKET 运动休闲棉服外套', '/uploads/img/cover/cQqzXrqxeZyJ3ZVxl81DbiSPJUwUN64hNQDOtiR4.png', 123.00, 1, 'tejiao', 1, '2023-11-16 10:01:14', '2023-11-16 10:01:14');
INSERT INTO `shop_good` VALUES (1118, 'Adidas', 'PUFFY DAILY DOWN JACKET   运动休闲600蓬鸭绒羽绒服', '/uploads/img/cover/wABENs7gLyiWeonu3A5CMYtUw0TN0qyxe6N4xoX1.png', 335.00, 1, 'tejiao', 1, '2023-11-16 10:02:06', '2023-11-16 10:02:06');
INSERT INTO `shop_good` VALUES (1119, 'Adidas', 'SPORTSWEAR HALF ZIP JACKET 抗风透湿疏水运动宽松夹克外套', '/uploads/img/cover/gpD2vKGUu7LoWJCP1DxHm5thMvrYb2fSaUyLTpDV.png', 366.00, 1, 'tejiao', 1, '2023-11-16 10:02:44', '2023-11-16 10:02:44');

-- ----------------------------
-- Table structure for shop_good_collect
-- ----------------------------
DROP TABLE IF EXISTS `shop_good_collect`;
CREATE TABLE `shop_good_collect`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `good_id` int UNSIGNED NOT NULL COMMENT '商品ID',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1038 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品收藏表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_good_collect
-- ----------------------------
INSERT INTO `shop_good_collect` VALUES (1031, 1093, 1106, '2023-10-16 22:59:18', '2023-10-16 22:59:18');
INSERT INTO `shop_good_collect` VALUES (1032, 1112, 1105, '2023-10-19 10:24:27', '2023-10-19 10:24:27');
INSERT INTO `shop_good_collect` VALUES (1033, 1098, 1105, '2023-10-19 10:25:10', '2023-10-19 10:25:10');
INSERT INTO `shop_good_collect` VALUES (1034, 1114, 1, '2023-10-19 10:26:48', '2023-10-19 10:26:48');
INSERT INTO `shop_good_collect` VALUES (1035, 1103, 1106, '2023-10-19 10:28:49', '2023-10-19 10:28:49');
INSERT INTO `shop_good_collect` VALUES (1037, 1117, 1106, '2023-11-16 14:44:48', '2023-11-16 14:44:48');

-- ----------------------------
-- Table structure for shop_good_like
-- ----------------------------
DROP TABLE IF EXISTS `shop_good_like`;
CREATE TABLE `shop_good_like`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `good_id` int UNSIGNED NOT NULL COMMENT '商品ID',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1026 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品点赞表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_good_like
-- ----------------------------
INSERT INTO `shop_good_like` VALUES (1020, 1091, 1106, '2023-10-17 08:07:33', '2023-10-17 08:07:33');
INSERT INTO `shop_good_like` VALUES (1021, 1108, 1105, '2023-10-19 10:24:42', '2023-10-19 10:24:42');
INSERT INTO `shop_good_like` VALUES (1022, 1083, 1105, '2023-10-19 10:25:29', '2023-10-19 10:25:29');
INSERT INTO `shop_good_like` VALUES (1023, 1104, 1, '2023-10-19 10:29:52', '2023-10-19 10:29:52');
INSERT INTO `shop_good_like` VALUES (1024, 1111, 1106, '2023-10-24 08:33:20', '2023-10-24 08:33:20');
INSERT INTO `shop_good_like` VALUES (1025, 1098, 1106, '2023-10-24 08:33:41', '2023-10-24 08:33:41');

-- ----------------------------
-- Table structure for shop_order
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `amount_total` decimal(8, 2) UNSIGNED NOT NULL COMMENT '商品总价',
  `num` smallint UNSIGNED NOT NULL COMMENT '商品总数',
  `pay_status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付状态，0：待支付，1：支付成功，2：支付失败',
  `pay_time` timestamp NOT NULL DEFAULT current_timestamp COMMENT '支付时间',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_no`(`order_no` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1047 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_order
-- ----------------------------
INSERT INTO `shop_order` VALUES (1032, 'W231010765188', 1106, 138.00, 2, 1, '2023-10-10 16:19:19', '2023-10-10 16:19:19', '2023-10-10 16:19:19');
INSERT INTO `shop_order` VALUES (1037, 'W231017423084', 1, 310.00, 2, 1, '2023-10-17 09:10:11', '2023-10-17 09:10:11', '2023-10-17 09:10:11');
INSERT INTO `shop_order` VALUES (1038, 'W231017500011', 1106, 519.00, 2, 1, '2023-10-17 19:52:17', '2023-10-17 19:52:17', '2023-10-17 19:52:17');
INSERT INTO `shop_order` VALUES (1039, 'W231019221302', 1105, 688.00, 2, 0, '2023-10-19 10:24:52', '2023-10-19 10:24:52', '2023-10-19 10:24:52');
INSERT INTO `shop_order` VALUES (1040, 'W231019996764', 1105, 426.00, 2, 2, '2023-10-19 10:25:36', '2023-10-19 10:25:36', '2023-10-19 10:25:36');
INSERT INTO `shop_order` VALUES (1041, 'W231019180888', 1, 236.00, 1, 1, '2023-10-19 10:26:57', '2023-10-19 10:26:57', '2023-10-19 10:26:57');
INSERT INTO `shop_order` VALUES (1042, 'W231019756026', 1105, 100.00, 1, 1, '2023-10-19 10:27:59', '2023-10-19 10:27:59', '2023-10-19 10:27:59');
INSERT INTO `shop_order` VALUES (1043, 'W231019521119', 1106, 289.00, 1, 2, '2023-10-19 10:28:57', '2023-10-19 10:28:57', '2023-10-19 10:28:57');
INSERT INTO `shop_order` VALUES (1044, 'W231019905898', 1, 355.00, 1, 2, '2023-10-19 10:29:57', '2023-10-19 10:29:57', '2023-10-19 10:29:57');
INSERT INTO `shop_order` VALUES (1046, 'W231116997352', 1106, 1521.00, 4, 2, '2023-11-16 14:43:35', '2023-11-16 14:43:35', '2023-11-16 14:43:35');

-- ----------------------------
-- Table structure for shop_order_item
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_item`;
CREATE TABLE `shop_order_item`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `good_id` int UNSIGNED NOT NULL COMMENT '商品ID',
  `good_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品标题',
  `good_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品图片',
  `num` smallint UNSIGNED NOT NULL COMMENT '商品数量',
  `amount_unit` decimal(8, 2) UNSIGNED NOT NULL COMMENT '商品单价',
  `amount_sum` decimal(8, 2) UNSIGNED NOT NULL COMMENT '商品总价',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_no`(`order_no` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1116 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单子表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_order_item
-- ----------------------------
INSERT INTO `shop_order_item` VALUES (1091, 'W231010910978', 1106, 1081, '熊猫玩偶', '/uploads/img/cover/mvL5q1wN3I41Ecj9ZCgYKzwGBYErHkY2vUvc2LU9.png', 1, 20.00, 20.00, '2023-10-10 16:04:41', '2023-10-10 16:04:41');
INSERT INTO `shop_order_item` VALUES (1093, 'W231010574704', 1106, 1084, '乒乓球拍', '/uploads/img/cover/wS2Q5nzbxIa0N1OWFMzkSGNg7lDlR0J4RlGRB0wu.png', 3, 18.00, 54.00, '2023-10-10 16:15:09', '2023-10-10 16:15:09');
INSERT INTO `shop_order_item` VALUES (1094, 'W231010765188', 1106, 1085, '轮滑鞋', '/uploads/img/cover/nAJYITcRxL5t6CBnaphpIBjT7CJxbAGchu0hIU62.png', 1, 50.00, 50.00, '2023-10-10 16:19:19', '2023-10-10 16:19:19');
INSERT INTO `shop_order_item` VALUES (1095, 'W231010765188', 1106, 1086, 'MLB', '/uploads/img/cover/wKhOleAFHKrUEjmTFtVZyzrOuMuNvmE6Nj3g5tOk.jpg', 1, 88.00, 88.00, '2023-10-10 16:19:19', '2023-10-10 16:19:19');
INSERT INTO `shop_order_item` VALUES (1096, 'W231010311497', 1106, 1079, '小桌子', '/uploads/img/cover/pv4482BNiZJTlihuQjtmR17y8vYItuaLdkUscof5.png', 1, 11.00, 11.00, '2023-10-10 16:30:46', '2023-10-10 16:30:46');
INSERT INTO `shop_order_item` VALUES (1097, 'W231010915588', 1106, 1084, '乒乓球拍', '/uploads/img/cover/wS2Q5nzbxIa0N1OWFMzkSGNg7lDlR0J4RlGRB0wu.png', 1, 18.00, 18.00, '2023-10-10 16:33:28', '2023-10-10 16:33:28');
INSERT INTO `shop_order_item` VALUES (1098, 'W231015447213', 1107, 1085, '轮滑鞋', '/uploads/img/cover/nAJYITcRxL5t6CBnaphpIBjT7CJxbAGchu0hIU62.png', 1, 50.00, 50.00, '2023-10-15 16:10:37', '2023-10-15 16:10:37');
INSERT INTO `shop_order_item` VALUES (1099, 'W231017243719', 1, 1090, 'Air-Jordan-11', '/uploads/img/cover/lPfvel8o8zjrWLQYXPtvR740k9h8gUvf56PPonS9.jpg', 1, 99.00, 99.00, '2023-10-17 08:12:30', '2023-10-17 08:12:30');
INSERT INTO `shop_order_item` VALUES (1100, 'W231017423084', 1, 1094, 'Converse', '/uploads/img/cover/QCYK5c6uNzihMtk5Lu1YIoqnJsuYesp4AKS2M6b3.webp', 1, 299.00, 299.00, '2023-10-17 09:10:11', '2023-10-17 09:10:11');
INSERT INTO `shop_order_item` VALUES (1101, 'W231017423084', 1, 1079, 'Air-Jordan-4', '/uploads/img/cover/nyJbFYMKPuTi3i1xJozeplgvKy7pkkOyhatdLqQm.jpg', 1, 11.00, 11.00, '2023-10-17 09:10:11', '2023-10-17 09:10:11');
INSERT INTO `shop_order_item` VALUES (1102, 'W231017500011', 1106, 1093, 'Adidas', '/uploads/img/cover/1vyx7prrZuJjex3cCUJioSMK61qpqNvht7qcswyd.jpg', 1, 199.00, 199.00, '2023-10-17 19:52:17', '2023-10-17 19:52:17');
INSERT INTO `shop_order_item` VALUES (1103, 'W231017500011', 1106, 1080, 'The North Face', '/uploads/img/cover/MQFRXqjfzQEu2UmpIznPzQxitWjj0j9V8u9GvLjQ.png', 1, 320.00, 320.00, '2023-10-17 19:52:17', '2023-10-17 19:52:17');
INSERT INTO `shop_order_item` VALUES (1104, 'W231019221302', 1105, 1112, 'MLB', '/uploads/img/cover/oYL0jViFfVucp6JWCxwbvL8FY8Iu7biARjwARtJ9.jpg', 1, 288.00, 288.00, '2023-10-19 10:24:52', '2023-10-19 10:24:52');
INSERT INTO `shop_order_item` VALUES (1105, 'W231019221302', 1105, 1108, 'PUMA', '/uploads/img/cover/cPHv42D3ikZNJe2r4XJl5OJz7WFNVSgiUguLEtuN.jpg', 1, 400.00, 400.00, '2023-10-19 10:24:52', '2023-10-19 10:24:52');
INSERT INTO `shop_order_item` VALUES (1106, 'W231019996764', 1105, 1098, 'BOY', '/uploads/img/cover/BfW56rB4SsrX0DTGkLNZTrOjnGMY51GWKyIT3f0e.jpg', 1, 366.00, 366.00, '2023-10-19 10:25:36', '2023-10-19 10:25:36');
INSERT INTO `shop_order_item` VALUES (1107, 'W231019996764', 1105, 1083, 'Vans', '/uploads/img/cover/siKWfK0nrhGJMoUgyNxgAmNthNBkISHoPlFdH4YX.jpg', 1, 60.00, 60.00, '2023-10-19 10:25:36', '2023-10-19 10:25:36');
INSERT INTO `shop_order_item` VALUES (1108, 'W231019180888', 1, 1114, 'MBL', '/uploads/img/cover/Igl7D493jLzsHO6r0YyIsja4T5qODn4CjWjWX8HA.jpg', 1, 236.00, 236.00, '2023-10-19 10:26:57', '2023-10-19 10:26:57');
INSERT INTO `shop_order_item` VALUES (1109, 'W231019756026', 1105, 1111, 'Adidas', '/uploads/img/cover/4x0UP7PMKlRjP63bNkwxACcCNHAhDuOhkOvx3a0B.jpg', 1, 100.00, 100.00, '2023-10-19 10:27:59', '2023-10-19 10:27:59');
INSERT INTO `shop_order_item` VALUES (1110, 'W231019521119', 1106, 1103, 'BOY', '/uploads/img/cover/v0aP05d7NMxTaKgtI3DAlIuGLsdOskvYT9UouTMo.jpg', 1, 289.00, 289.00, '2023-10-19 10:28:57', '2023-10-19 10:28:57');
INSERT INTO `shop_order_item` VALUES (1111, 'W231019905898', 1, 1104, 'Jordan-nu-retro-1-low', '/uploads/img/cover/49M2rsasUD6AkbKQxdulWFYkQ1uygSPmlRoUvc1S.jpg', 1, 355.00, 355.00, '2023-10-19 10:29:57', '2023-10-19 10:29:57');
INSERT INTO `shop_order_item` VALUES (1112, 'W231116222030', 1109, 1106, 'The North Face', '/uploads/img/cover/FmFlwzeCDh0dBTUBvpPqUTkqR8YnHllPEUdwulyC.png', 1, 388.00, 388.00, '2023-11-16 09:27:09', '2023-11-16 09:27:09');
INSERT INTO `shop_order_item` VALUES (1113, 'W231116997352', 1106, 1115, 'Adidas', '/uploads/img/cover/eosF1nYPaxoDIZTGYzMJ9gsF8iQwNsmtfgpn42lU.png', 2, 456.00, 912.00, '2023-11-16 14:43:35', '2023-11-16 14:43:35');
INSERT INTO `shop_order_item` VALUES (1114, 'W231116997352', 1106, 1103, 'BOY', '/uploads/img/cover/v0aP05d7NMxTaKgtI3DAlIuGLsdOskvYT9UouTMo.jpg', 1, 289.00, 289.00, '2023-11-16 14:43:35', '2023-11-16 14:43:35');
INSERT INTO `shop_order_item` VALUES (1115, 'W231116997352', 1106, 1080, 'The North Face', '/uploads/img/cover/MQFRXqjfzQEu2UmpIznPzQxitWjj0j9V8u9GvLjQ.png', 1, 320.00, 320.00, '2023-11-16 14:43:35', '2023-11-16 14:43:35');

-- ----------------------------
-- Table structure for shop_user
-- ----------------------------
DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE `shop_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '昵称',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `intro` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '描述',
  `sex` tinyint(1) UNSIGNED NOT NULL COMMENT '性别，1：男，2：女',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，0：禁用，1：启用',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1110 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shop_user
-- ----------------------------
INSERT INTO `shop_user` VALUES (1, 'user', '漂亮男孩', '123456', 'BLACKPINk的忠实粉丝', 1, 1, '2022-09-16 16:13:32', '2022-09-19 16:26:42');
INSERT INTO `shop_user` VALUES (1105, 'gxd8', '漂亮女孩', '123456', '最喜欢杰伦的范特西', 1, 0, '2022-09-25 14:52:59', '2022-09-25 14:52:59');
INSERT INTO `shop_user` VALUES (1106, 'admin', '甜甜的笑', '123456', '总是听杰伦的一首歌  反方向的钟', 1, 1, '2023-10-10 13:19:53', '2023-10-10 13:19:53');

SET FOREIGN_KEY_CHECKS = 1;
