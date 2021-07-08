/*
 Navicat Premium Data Transfer

 Source Server         : shopdb
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost:3306
 Source Schema         : myshop

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : 65001

 Date: 28/12/2020 22:32:54
*/
DROP DATABASE IF EXISTS myshop;
CREATE DATABASE IF NOT EXISTS myshop;
USE myshop;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acount
-- ----------------------------
DROP TABLE IF EXISTS `acount`;
CREATE TABLE `acount`  (
  `accout_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `spending` int(11) NULL DEFAULT 0,
  `balance` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`accout_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of acount
-- ----------------------------

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address`  (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`address_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of address
-- ----------------------------

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `psw` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `isaccess` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (0, 'test', 'test', 1, 1);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_grade` tinyint(4) NOT NULL DEFAULT 1,
  `parent_id` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (2, '电子', 1, -1);
INSERT INTO `category` VALUES (1, '食品', 1, -1);
INSERT INTO `category` VALUES (3, '穿戴', 1, -1);
INSERT INTO `category` VALUES (4, '个护', 1, -1);
INSERT INTO `category` VALUES (5, '水果', 2, 1);
INSERT INTO `category` VALUES (6, '零食', 2, 1);
INSERT INTO `category` VALUES (7, '电脑', 2, 2);
INSERT INTO `category` VALUES (8, '平板', 2, 2);
INSERT INTO `category` VALUES (9, '手机', 2, 2);
INSERT INTO `category` VALUES (10, '衣服', 2, 3);
INSERT INTO `category` VALUES (11, '帽子', 2, 3);
INSERT INTO `category` VALUES (12, '洗发水', 2, 4);
INSERT INTO `category` VALUES (13, '饮料', 2, 1);
INSERT INTO `category` VALUES (14, '医药', 1, -1);
INSERT INTO `category` VALUES (15, '硬盘', 2, 2);
INSERT INTO `category` VALUES (16, '沐浴露', 2, 4);
INSERT INTO `category` VALUES (17, '化妆品', 2, 4);
INSERT INTO `category` VALUES (18, '鞋子', 2, 3);
INSERT INTO `category` VALUES (19, '肉类', 2, 1);
INSERT INTO `category` VALUES (20, '蔬菜', 2, 1);
INSERT INTO `category` VALUES (21, '显示器', 2, 2);
INSERT INTO `category` VALUES (22, '图书', 1, -1);
INSERT INTO `category` VALUES (23, '虚幻图书', 2, 22);
INSERT INTO `category` VALUES (24, '未命名', 3, 10);
INSERT INTO `category` VALUES (25, '家电', 1, -1);
INSERT INTO `category` VALUES (26, '冰箱', 2, 25);
INSERT INTO `category` VALUES (27, '空调', 2, 25);
INSERT INTO `category` VALUES (28, '洗衣机', 2, 25);
INSERT INTO `category` VALUES (29, '电视', 2, 25);
INSERT INTO `category` VALUES (30, '音响', 2, 25);

-- ----------------------------
-- Table structure for express_type
-- ----------------------------
DROP TABLE IF EXISTS `express_type`;
CREATE TABLE `express_type`  (
  `express_id` int(11) NOT NULL,
  `express_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `express_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `price` smallint(6) NULL DEFAULT NULL,
  PRIMARY KEY (`express_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of express_type
-- ----------------------------

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods`  (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `shop_price` decimal(10, 2) NOT NULL,
  `sale_price` decimal(10, 2) NOT NULL,
  `goods_price` decimal(10, 2) NOT NULL,
  `sale_num` int(11) NOT NULL,
  `inventor` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT 1,
  `modtime` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`goods_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES (1, 7, 'modtest2222', '/upload/goods_img/default.jpg', '111', '0', 10.00, 15.00, 5.00, 4, 10, 3, '1609069334');
INSERT INTO `goods` VALUES (2, 7, 't2', '/upload/goods_img/default.jpg', 'test2', '', 20.00, 15.00, 10.00, 4, 11, 2, '1608954162');
INSERT INTO `goods` VALUES (3, 7, 'test11', '/upload/goods_img/default.jpg', '123', '', 15.00, 10.00, 5.00, 6, 10, 1, NULL);
INSERT INTO `goods` VALUES (4, 7, 'testpos', '/upload/goods_img/default.jpg', '111', ' ', 10.00, 15.00, 5.00, 3, 10, 1, NULL);
INSERT INTO `goods` VALUES (5, 7, 'testpos2', '/upload/goods_img/default.jpg', '111', ' ', 10.00, 15.00, 5.00, 5, 10, 1, NULL);
INSERT INTO `goods` VALUES (6, 7, 'testpos3', '/upload/goods_img/default.jpg', '111', ' ', 10.00, 15.00, 5.00, 8, 10, 1, NULL);
INSERT INTO `goods` VALUES (7, 7, 'modtest', '/upload/goods_img/default.jpg', '111', '', 10.00, 15.00, 5.00, 0, 10, 1, '1608452477');
INSERT INTO `goods` VALUES (8, 7, 'modtest', '/upload/goods_img/default.jpg', '111', '', 10.00, 15.00, 5.00, 0, 10, 1, '1608900845');
INSERT INTO `goods` VALUES (9, 7, '123', '/upload/goods_img/default.jpg', '12', '22', 12.00, 12.00, 12.00, 0, 12, 1, '1608960479');
INSERT INTO `goods` VALUES (10, 5, '香蕉', '/upload/goods_img/20201225/20201225213126mq5hrt.jpg', '11', '11', 3.00, 2.00, 1.00, 0, 10, 1, '1609049794');
INSERT INTO `goods` VALUES (11, 5, '苹果', '/upload/goods_img/20201225/20201225213325qadsk6.jpg', '111', '111', 10.00, 8.00, 3.00, 0, 10, 1, '1608903225');
INSERT INTO `goods` VALUES (12, 5, 'apple', '/upload/goods_img/20201225/20201225214131b854sn.jpg', '10', '10', 10.00, 10.00, 10.00, 0, 10, 1, '1608903704');
INSERT INTO `goods` VALUES (13, 5, 'apple', '/upload/goods_img/20201225/20201225214131b854sn.jpg', '10', '10', 10.00, 10.00, 10.00, 0, 10, 1, '1608903721');
INSERT INTO `goods` VALUES (14, 9, 'phone 12', '/upload/goods_img/20201225/202012252142543j8m95.jpg', '111', '111', 10000.00, 9000.00, 8000.00, 0, 10, 1, '1608903804');
INSERT INTO `goods` VALUES (15, 9, 'phone 12', '/upload/goods_img/20201225/202012252142543j8m95.jpg', '111', '111', 10000.00, 9000.00, 8000.00, 0, 10, 1, '1608903821');
INSERT INTO `goods` VALUES (16, 9, 'Mate40Pro', '/upload/goods_img/20201225/202012252148229psmti.jpg', 'Mate40Pro', 'Mate40Pro', 12000.00, 10000.00, 8000.00, 0, 10, 1, '1608904118');
INSERT INTO `goods` VALUES (17, 9, '华为nova7', '/upload/goods_img/20201225/202012252152055t8eic.jpg', '华为nova7', '华为nova7', 8000.00, 6000.00, 5000.00, 0, 10, 1, '1608904345');
INSERT INTO `goods` VALUES (18, 9, ' Redmi K30 至尊纪念版', '/upload/goods_img/20201225/20201225215502j28ei4.jpg', ' Redmi K30 至尊纪念版', ' Redmi K30 至尊纪念版', 2200.00, 2100.00, 1900.00, 0, 10, 1, '1608904524');
INSERT INTO `goods` VALUES (19, 8, 'ipad air 4', '/upload/goods_img/20201225/20201225215904ajs7rn.png', 'a3', 'a5', 8000.00, 6000.00, 5000.00, 11, 3, 1, '1608904778');
INSERT INTO `goods` VALUES (20, 8, 'Apple/苹果 11 英寸 iPad Pro', '/upload/goods_img/20201225/202012252200226hidb7.png', 'Apple/苹果 11 英寸 iPad Pro', 'Apple/苹果 11 英寸 iPad Pro', 9000.00, 8000.00, 6800.00, 0, 2, 1, '1608904843');
INSERT INTO `goods` VALUES (21, 8, 'Apple/苹果 11 英寸 iPad Pro', '/upload/goods_img/20201225/20201225220116deq7ck.png', 'Apple/苹果 11 英寸 iPad Pro', 'Apple/苹果 11 英寸 iPad Pro', 8000.00, 7900.00, 6900.00, 0, 1, 1, '1609070677');
INSERT INTO `goods` VALUES (22, 8, 'ipad pro 12', '/upload/goods_img/20201225/20201225220152jtiq3r.png', '11', '11', 9500.00, 9000.00, 6900.00, 0, 2, 1, '1608904946');
INSERT INTO `goods` VALUES (23, 10, '棉衣男士秋冬季外套潮牌棉袄2020年新款羽绒棉服加绒加厚冬装衣服', '/upload/goods_img/20201225/2020122522073332qtjh.jpg', '11', '11', 150.00, 120.00, 80.00, 0, 1, 1, '1609049825');
INSERT INTO `goods` VALUES (24, 10, 'A21秋冬季2019新款男装运动棉衣 彩色字母冬装男士棉服外套短款男', '/upload/goods_img/20201225/20201225220905cnmkij.jpg', '111', '111', 210.00, 180.00, 100.00, 0, 1, 1, '1608905363');
INSERT INTO `goods` VALUES (25, 7, 'testframe', '/upload/goods_img/20201225/20201225223114395iq6.jpg', '1', '1', 1.00, 1.00, 1.00, 0, 1, 3, '1608906685');
INSERT INTO `goods` VALUES (26, 29, '海尔(Haier) 65R5 65英寸4K超清AI全面屏智能语音液晶平板电视机', '/upload/goods_img/20201227/202012271944233aq7te.jpg', '海尔(Haier) 65R5 65英寸4K超清AI全面屏智能语音液晶平板电视机', '海尔(Haier) 65R5 65英寸4K超清AI全面屏智能语音液晶平板电视机', 5100.00, 4800.00, 4000.00, 2, 19, 1, '1609069504');

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NULL DEFAULT NULL,
  `goods_num` int(11) NULL DEFAULT NULL,
  `sale_price` int(11) NULL DEFAULT NULL,
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`detail_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of order_detail
-- ----------------------------
INSERT INTO `order_detail` VALUES (1, 1, 1, 10, 1);
INSERT INTO `order_detail` VALUES (1, 2, 1, 15, 2);
INSERT INTO `order_detail` VALUES (3, 26, 1, 4800, 6);
INSERT INTO `order_detail` VALUES (12, 26, 1, 4800, 16);
INSERT INTO `order_detail` VALUES (2, 3, 1, 10, 5);
INSERT INTO `order_detail` VALUES (4, 1, 2, 1, 7);
INSERT INTO `order_detail` VALUES (5, 19, 1, 5000, 8);
INSERT INTO `order_detail` VALUES (6, 19, 1, 5000, 9);
INSERT INTO `order_detail` VALUES (7, 19, 1, 5000, 10);
INSERT INTO `order_detail` VALUES (8, 19, 1, 5000, 11);
INSERT INTO `order_detail` VALUES (9, 19, 1, 4000, 12);
INSERT INTO `order_detail` VALUES (10, 19, 2, 5000, 13);
INSERT INTO `order_detail` VALUES (11, 19, 1, 5000, 14);
INSERT INTO `order_detail` VALUES (12, 19, 1, 5000, 15);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `express_number` int(11) NULL DEFAULT NULL,
  `express_date` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `state` tinyint(255) NOT NULL DEFAULT 0,
  `order_date` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 1, 25.00, '广东省中山市火炬职业技术学院', 1234567891, 138123456, '1609049510', 1, '1608721000');
INSERT INTO `orders` VALUES (2, 1, 10.00, 'test', 1234567891, 1234566666, '1608994087', 6, '1608720000');
INSERT INTO `orders` VALUES (3, 2, 4800.00, 'w', 2147483647, 0, NULL, 3, '1608721000');
INSERT INTO `orders` VALUES (4, 2, 1.00, '广东省广州市天河区', 2147483647, 421769334, '1609071144', 2, '1608722000');
INSERT INTO `orders` VALUES (5, 3, 5000.00, '广东省中山市', 0, 2147483647, '1609071217', 1, '1608723000');
INSERT INTO `orders` VALUES (6, 4, 5000.00, '广东省深圳市', 0, NULL, NULL, 0, '1608724000');
INSERT INTO `orders` VALUES (7, 5, 5000.00, '广东省深圳市', 0, 0, NULL, 5, '1608732000');
INSERT INTO `orders` VALUES (8, 6, 5000.00, '广东省珠海市', 0, NULL, NULL, 0, '1608742000');
INSERT INTO `orders` VALUES (9, 7, 4000.00, '广东省汕头市', 0, NULL, NULL, 0, '1608752000');
INSERT INTO `orders` VALUES (10, 8, 10000.00, '广东省汕尾市', 0, NULL, NULL, 0, '1608762000');
INSERT INTO `orders` VALUES (11, 9, 5000.00, '广东省江门市', 0, NULL, NULL, 0, '1608772000');
INSERT INTO `orders` VALUES (12, 10, 9800.00, '广东省湛江市', 0, NULL, NULL, 0, '1608822000');

-- ----------------------------
-- Table structure for user_analyse
-- ----------------------------
DROP TABLE IF EXISTS `user_analyse`;
CREATE TABLE `user_analyse`  (
  `user_id` int(11) NOT NULL,
  `visit_times` int(11) NOT NULL DEFAULT 1,
  `order_quantity` int(11) NOT NULL DEFAULT 0,
  `fail_order` int(11) NOT NULL DEFAULT 0
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of user_analyse
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `psw` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT 1,
  `phone` int(11) NOT NULL,
  `grade` tinyint(4) NOT NULL DEFAULT 0,
  `headimg` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '/public/asset/img/headimg',
  `resgister_date` int(11) NOT NULL,
  `load_date` int(11) NOT NULL,
  `isaccess` tinyint(4) NOT NULL DEFAULT 1,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '123', 1, 2147483647, 0, '/public/asset/img/headimg', 1609066681, 0, 1, 'test1');
INSERT INTO `users` VALUES (2, '123', 1, 0, 0, '/public/asset/img/headimg', 1609066600, 0, 1, 'test2');
INSERT INTO `users` VALUES (3, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test3');
INSERT INTO `users` VALUES (4, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test4');
INSERT INTO `users` VALUES (5, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test5');
INSERT INTO `users` VALUES (6, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test6');
INSERT INTO `users` VALUES (7, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test7');
INSERT INTO `users` VALUES (8, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test8');
INSERT INTO `users` VALUES (9, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test9');
INSERT INTO `users` VALUES (10, '123', 1, 0, 0, '/public/asset/img/headimg', 0, 0, 1, 'test10');

-- ----------------------------
-- Triggers structure for table order_detail
-- ----------------------------
DROP TRIGGER IF EXISTS `tq3`;
delimiter ;;
CREATE TRIGGER `tq3` AFTER INSERT ON `order_detail` FOR EACH ROW begin 
update goods set inventor =inventor-new.goods_num,sale_num=sale_num+new.goods_num  where goods_id =new.goods_id;
update orders set price =price+(new.sale_price*new.goods_num)  where order_id =new.order_id;
end
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table order_detail
-- ----------------------------
DROP TRIGGER IF EXISTS `tq2`;
delimiter ;;
CREATE TRIGGER `tq2` AFTER UPDATE ON `order_detail` FOR EACH ROW begin 
update goods set inventor =inventor+(old.goods_num-new.goods_num),sale_num=sale_num-(old.goods_num-new.goods_num)  where goods_id =old.goods_id;
update orders set price =price - (old.sale_price*old.goods_num-new.sale_price*new.goods_num)  where order_id =old.order_id;
end
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table order_detail
-- ----------------------------
DROP TRIGGER IF EXISTS `tq1`;
delimiter ;;
CREATE TRIGGER `tq1` AFTER DELETE ON `order_detail` FOR EACH ROW begin 
update goods set inventor =inventor+old.goods_num,sale_num=sale_num-old.goods_num  where goods_id =old.goods_id;
update orders set price =price-(old.sale_price*old.goods_num)  where order_id =old.order_id;
end
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
