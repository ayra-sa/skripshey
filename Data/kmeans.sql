/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : kmeans

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 25/07/2021 10:46:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissionname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menusubmenu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `multilevel` bit(1) NULL DEFAULT NULL,
  `separator` bit(1) NULL DEFAULT NULL,
  `order` int(255) NULL DEFAULT NULL,
  `status` bit(1) NULL DEFAULT NULL,
  `AllowMobile` bit(1) NULL DEFAULT NULL,
  `MobileRoute` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MobileLogo` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (2, 'Daftar Variable', 'data', 'fa-pencil-square-o', '0', b'0', b'0', 2, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (3, 'Daftar Centroid Awal', 'centroidawal', 'fa-pencil-square-o', '0', b'0', b'0', 3, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (5, 'Perhitungan', 'proses', 'fa-spinner', '0', b'0', b'0', 6, b'1', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for permissionrole
-- ----------------------------
DROP TABLE IF EXISTS `permissionrole`;
CREATE TABLE `permissionrole`  (
  `roleid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissionrole
-- ----------------------------
INSERT INTO `permissionrole` VALUES (1, 1);
INSERT INTO `permissionrole` VALUES (1, 2);
INSERT INTO `permissionrole` VALUES (1, 3);
INSERT INTO `permissionrole` VALUES (1, 4);
INSERT INTO `permissionrole` VALUES (1, 5);
INSERT INTO `permissionrole` VALUES (2, 2);
INSERT INTO `permissionrole` VALUES (1, 6);
INSERT INTO `permissionrole` VALUES (2, 6);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin');
INSERT INTO `roles` VALUES (2, 'Operator');

-- ----------------------------
-- Table structure for tcentroid
-- ----------------------------
DROP TABLE IF EXISTS `tcentroid`;
CREATE TABLE `tcentroid`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeData` int(255) NOT NULL,
  `Centroid` int(11) NOT NULL,
  `JmlProduksi` double(16, 4) NOT NULL,
  `JmlPekerja` double(16, 4) NOT NULL,
  `Omset` double(16, 4) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tcentroid
-- ----------------------------
INSERT INTO `tcentroid` VALUES (1, 11, 1, 0.0100, 0.0000, 0.0100);
INSERT INTO `tcentroid` VALUES (2, 15, 2, 0.3000, 0.2000, 0.2000);
INSERT INTO `tcentroid` VALUES (3, 19, 3, 1.0000, 1.0000, 1.0000);

-- ----------------------------
-- Table structure for tdata
-- ----------------------------
DROP TABLE IF EXISTS `tdata`;
CREATE TABLE `tdata`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `JmlProduksi` double(16, 4) NOT NULL,
  `JmlPekerja` double(16, 4) NOT NULL,
  `Omset` double(16, 4) NULL DEFAULT NULL,
  `Koordinat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `JenisUsaha` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tdata
-- ----------------------------
INSERT INTO `tdata` VALUES (51, 'Sibo', '-8.001467877016337, 110.94236324186754', 7405.0000, 0.0000, 10800.0000, '-8.001467877016337, 110.94236324186754', 'Peyek 1');
INSERT INTO `tdata` VALUES (52, 'Purwanto', '-8.000869646143155, 110.94405324394953', 10276.0000, 8.0000, 25000.0000, '-8.000869646143155, 110.94405324394953', 'Tahu');
INSERT INTO `tdata` VALUES (53, 'Entong', '-7.996078013095501, 110.94451458390513', 7455.0000, 2.0000, 10600.0000, '-7.996078013095501, 110.94451458390513', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (54, 'Harti', '-7.996011609804214, 110.94433755810272', 7405.0000, 2.0000, 10800.0000, '-7.996011609804214, 110.94433755810272', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (55, 'Kateno', '-7.995267892178499, 110.94435096916085', 8138.0000, 2.0000, 21000.0000, '-7.995267892178499, 110.94435096916085', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (56, 'Katijem', '-7.9902189789208995, 110.93834394550865', 6776.0000, 2.0000, 15000.0000, '-7.9902189789208995, 110.93834394550865', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (57, 'Situm', '-7.989533686590662, 110.93750441409186', 8138.0000, 2.0000, 27500.0000, '-7.989533686590662, 110.93750441409186', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (58, 'Yati', '-8.001048128587708, 110.94041378403283', 8138.0000, 2.0000, 22400.0000, '-8.001048128587708, 110.94041378403283', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (59, 'Nur', '-8.001558099284578, 110.93927384516027', 3702.0000, 1.0000, 5400.0000, '-8.001558099284578, 110.93927384516027', 'Peyek');
INSERT INTO `tdata` VALUES (60, 'Aris', '-8.000870169905374, 110.93699664969756', 7405.0000, 2.0000, 10800.0000, '-8.000870169905374, 110.93699664969756', 'Rambak');
INSERT INTO `tdata` VALUES (61, 'Karmi', '-7.985997869092734, 110.91997887225902', 54000.0000, 2.0000, 64800.0000, '-7.985997869092734, 110.91997887225902', 'Karak');
INSERT INTO `tdata` VALUES (62, 'Marti', '-7.986115387187872, 110.91906827247006', 81000.0000, 3.0000, 97200.0000, '-7.986115387187872, 110.91906827247006', 'Karak');
INSERT INTO `tdata` VALUES (63, 'Rofiah', '-7.986436048067815, 110.92024585680441', 81000.0000, 3.0000, 97200.0000, '-7.986436048067815, 110.92024585680441', 'Karak');
INSERT INTO `tdata` VALUES (64, 'Karni', '-7.987159860352496, 110.91823151782899', 54000.0000, 2.0000, 64800.0000, '-7.987159860352496, 110.91823151782899', 'Karak');
INSERT INTO `tdata` VALUES (65, 'Suminem', '-7.986574170146446, 110.91843000131381', 54000.0000, 2.0000, 64800.0000, '-7.986574170146446, 110.91843000131381', 'Karak');
INSERT INTO `tdata` VALUES (66, 'Parti', '-7.985659956625658, 110.91724347711232', 81000.0000, 3.0000, 97200.0000, '-7.985659956625658, 110.91724347711232', 'Karak');
INSERT INTO `tdata` VALUES (67, 'Sumini', '-7.9850019386242845, 110.91738393307814', 54000.0000, 2.0000, 64800.0000, '-7.9850019386242845, 110.91738393307814', 'Rengginang');
INSERT INTO `tdata` VALUES (68, 'Waginem', '-7.984168982894617, 110.918084085619', 24000.0000, 2.0000, 27600.0000, '-7.984168982894617, 110.918084085619', 'Rengginang');
INSERT INTO `tdata` VALUES (69, 'Sunarni', '-7.985273856541108, 110.91912503546054', 24000.0000, 2.0000, 27600.0000, '-7.985273856541108, 110.91912503546054', 'Rengginang');
INSERT INTO `tdata` VALUES (70, 'Wagiyem', '-7.986135957831354, 110.9205759407543', 12000.0000, 1.0000, 13800.0000, '-7.986135957831354, 110.9205759407543', 'Rengginang');
INSERT INTO `tdata` VALUES (71, 'Alvin Sarifudin', '-7.981322901924252, 110.93837187918061', 57300.0000, 3.0000, 60000.0000, '-7.981322901924252, 110.93837187918061', 'Krupuk');
INSERT INTO `tdata` VALUES (72, 'Kasinem', '-7.980867519859098, 110.93280275321722', 263700.0000, 9.0000, 324000.0000, '-7.980867519859098, 110.93280275321722', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (73, 'Suyatmi', '-7.980880169367571, 110.93175109105162', 263700.0000, 9.0000, 324000.0000, '-7.980880169367571, 110.93175109105162', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (74, 'Mulyani', '-7.980488034422757, 110.93198100909592', 87900.0000, 3.0000, 135000.0000, '-7.980488034422757, 110.93198100909592', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (75, 'Sutini', '-7.981394582381791, 110.93238975233434', 263700.0000, 9.0000, 324000.0000, '-7.981394582381791, 110.93238975233434', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (76, 'Marwanto', '-7.988724249773187, 110.9335247681388', 10276.0000, 7.0000, 25000.0000, '-7.988724249773187, 110.9335247681388', 'Tahu');
INSERT INTO `tdata` VALUES (77, 'Sehati', '-7.976372875715726, 110.93576486987754', 36000.0000, 5.0000, 108000.0000, '-7.976372875715726, 110.93576486987754', 'Krupuk');
INSERT INTO `tdata` VALUES (78, 'Puspita', '-7.978867731427629, 110.93374605481733', 263700.0000, 4.0000, 324000.0000, '-7.978867731427629, 110.93374605481733', 'Roti');
INSERT INTO `tdata` VALUES (79, 'Yani', '-7.981219044726637, 110.93515480792105', 61250.0000, 3.0000, 131250.0000, '-7.981219044726637, 110.93515480792105', 'Roti');
INSERT INTO `tdata` VALUES (80, 'Tumini', '-7.996296598415712, 110.90570326531265', 7405.0000, 1.0000, 10800.0000, '-7.996296598415712, 110.90570326531265', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (81, 'Dwi Wartono', '-7.977138650872597, 110.90870863661651', 7405.0000, 3.0000, 10800.0000, '-7.977138650872597, 110.90870863661651', 'Jenang');
INSERT INTO `tdata` VALUES (82, 'Fauzi Azmi', '-7.9778221426150555, 110.9084199378385', 7405.0000, 1.0000, 10800.0000, '-7.9778221426150555, 110.9084199378385', 'Roti');
INSERT INTO `tdata` VALUES (83, 'Asikin', '-7.976920094630455, 110.90635337306679', 7405.0000, 2.0000, 10800.0000, '-7.976920094630455, 110.90635337306679', 'Tahu');
INSERT INTO `tdata` VALUES (84, 'Sihino', '-7.9758546190199135, 110.90712923756232', 7405.0000, 2.0000, 10800.0000, '-7.9758546190199135, 110.90712923756232', 'Krupuk');
INSERT INTO `tdata` VALUES (85, 'Hadi Prayitno', '-7.990392425677968, 110.90529165418154', 7405.0000, 2.0000, 10800.0000, '-7.990392425677968, 110.90529165418154', 'Gethuk');
INSERT INTO `tdata` VALUES (86, 'Suwarni', '-7.970931503267594, 110.93771012524785', 9000.0000, 2.0000, 108000.0000, '-7.970931503267594, 110.93771012524785', 'TempeKripik');
INSERT INTO `tdata` VALUES (87, 'Sriyanti', '-7.973586895493739, 110.93807753152988', 5400.0000, 1.0000, 72000.0000, '-7.973586895493739, 110.93807753152988', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (88, 'Edi Iswanto', '-7.974762692087949, 110.94050139683873', 5400.0000, 3.0000, 72000.0000, '-7.974762692087949, 110.94050139683873', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (89, 'Sugiarto', '-7.973481456728313, 110.94958716948618', 4600.0000, 2.0000, 36000.0000, '-7.973481456728313, 110.94958716948618', 'Kripik pisang');
INSERT INTO `tdata` VALUES (90, 'Suni', '-7.974147976741192, 110.94837508271961', 4600.0000, 3.0000, 36000.0000, '-7.974147976741192, 110.94837508271961', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (91, 'Ngadinah', '-7.966700925375672, 110.9378128374468', 21160.0000, 3.0000, 21400.0000, '-7.966700925375672, 110.9378128374468', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (92, 'Sunarti', '-7.967757460316665, 110.93709109023392', 14755.0000, 2.0000, 21600.0000, '-7.967757460316665, 110.93709109023392', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (93, 'Jahit', '-7.968490108761456, 110.93648211603828', 7405.0000, 1.0000, 10800.0000, '-7.968490108761456, 110.93648211603828', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (94, 'Sutiyah', '-7.959708666550694, 110.93086637949864', 21160.0000, 3.0000, 22400.0000, '-7.959708666550694, 110.93086637949864', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (95, 'Amini', '-7.960596082118873, 110.93084299823929', 14755.0000, 2.0000, 21600.0000, '-7.960596082118873, 110.93084299823929', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (96, 'Partini', '-7.948940852498355, 110.92998213551198', 14755.0000, 1.0000, 8750.0000, '-7.948940852498355, 110.92998213551198', 'Onde-onde');
INSERT INTO `tdata` VALUES (97, 'Yatino', '-7.948984765429331, 110.92865476493688', 14755.0000, 1.0000, 22000.0000, '-7.948984765429331, 110.92865476493688', 'Opak');
INSERT INTO `tdata` VALUES (98, 'Witi', '-7.9451401972151485, 110.97079134460492', 74005.0000, 1.0000, 21600.0000, '-7.9451401972151485, 110.97079134460492', 'Krupuk');
INSERT INTO `tdata` VALUES (99, 'Narti', '-7.945110142791096, 110.96956234242903', 14755.0000, 2.0000, 12000.0000, '-7.945110142791096, 110.96956234242903', 'Tempe Kripik');
INSERT INTO `tdata` VALUES (100, 'Endang', '-7.942213369983825, 110.95695576531044', 22160.0000, 2.0000, 21600.0000, '-7.942213369983825, 110.95695576531044', 'Donat');

-- ----------------------------
-- Table structure for thasil
-- ----------------------------
DROP TABLE IF EXISTS `thasil`;
CREATE TABLE `thasil`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeData` int(255) NOT NULL,
  `Keanggotaan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `iterasi` int(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of thasil
-- ----------------------------
INSERT INTO `thasil` VALUES (1, 51, 'C1', 3);
INSERT INTO `thasil` VALUES (2, 52, 'C2', 3);
INSERT INTO `thasil` VALUES (3, 53, 'C1', 3);
INSERT INTO `thasil` VALUES (4, 54, 'C1', 3);
INSERT INTO `thasil` VALUES (5, 55, 'C1', 3);
INSERT INTO `thasil` VALUES (6, 56, 'C1', 3);
INSERT INTO `thasil` VALUES (7, 57, 'C1', 3);
INSERT INTO `thasil` VALUES (8, 58, 'C1', 3);
INSERT INTO `thasil` VALUES (9, 59, 'C1', 3);
INSERT INTO `thasil` VALUES (10, 60, 'C1', 3);
INSERT INTO `thasil` VALUES (11, 61, 'C2', 3);
INSERT INTO `thasil` VALUES (12, 62, 'C2', 3);
INSERT INTO `thasil` VALUES (13, 63, 'C2', 3);
INSERT INTO `thasil` VALUES (14, 64, 'C2', 3);
INSERT INTO `thasil` VALUES (15, 65, 'C2', 3);
INSERT INTO `thasil` VALUES (16, 66, 'C2', 3);
INSERT INTO `thasil` VALUES (17, 67, 'C2', 3);
INSERT INTO `thasil` VALUES (18, 68, 'C1', 3);
INSERT INTO `thasil` VALUES (19, 69, 'C1', 3);
INSERT INTO `thasil` VALUES (20, 70, 'C1', 3);
INSERT INTO `thasil` VALUES (21, 71, 'C2', 3);
INSERT INTO `thasil` VALUES (22, 72, 'C3', 3);
INSERT INTO `thasil` VALUES (23, 73, 'C3', 3);
INSERT INTO `thasil` VALUES (24, 74, 'C2', 3);
INSERT INTO `thasil` VALUES (25, 75, 'C3', 3);
INSERT INTO `thasil` VALUES (26, 76, 'C2', 3);
INSERT INTO `thasil` VALUES (27, 77, 'C2', 3);
INSERT INTO `thasil` VALUES (28, 78, 'C3', 3);
INSERT INTO `thasil` VALUES (29, 79, 'C2', 3);
INSERT INTO `thasil` VALUES (30, 80, 'C1', 3);
INSERT INTO `thasil` VALUES (31, 81, 'C1', 3);
INSERT INTO `thasil` VALUES (32, 82, 'C1', 3);
INSERT INTO `thasil` VALUES (33, 83, 'C1', 3);
INSERT INTO `thasil` VALUES (34, 84, 'C1', 3);
INSERT INTO `thasil` VALUES (35, 85, 'C1', 3);
INSERT INTO `thasil` VALUES (36, 86, 'C2', 3);
INSERT INTO `thasil` VALUES (37, 87, 'C1', 3);
INSERT INTO `thasil` VALUES (38, 88, 'C2', 3);
INSERT INTO `thasil` VALUES (39, 89, 'C1', 3);
INSERT INTO `thasil` VALUES (40, 90, 'C1', 3);
INSERT INTO `thasil` VALUES (41, 91, 'C1', 3);
INSERT INTO `thasil` VALUES (42, 92, 'C1', 3);
INSERT INTO `thasil` VALUES (43, 93, 'C1', 3);
INSERT INTO `thasil` VALUES (44, 94, 'C1', 3);
INSERT INTO `thasil` VALUES (45, 95, 'C1', 3);
INSERT INTO `thasil` VALUES (46, 96, 'C1', 3);
INSERT INTO `thasil` VALUES (47, 97, 'C1', 3);
INSERT INTO `thasil` VALUES (48, 98, 'C1', 3);
INSERT INTO `thasil` VALUES (49, 99, 'C1', 3);
INSERT INTO `thasil` VALUES (50, 100, 'C1', 3);

-- ----------------------------
-- Table structure for userrole
-- ----------------------------
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole`  (
  `userid` int(11) NOT NULL,
  `roleid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userrole
-- ----------------------------
INSERT INTO `userrole` VALUES (14, 1);
INSERT INTO `userrole` VALUES (43, 2);
INSERT INTO `userrole` VALUES (52, 1);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdby` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdon` datetime(0) NULL DEFAULT NULL,
  `HakAkses` int(255) NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `verified` bit(1) NULL DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (14, 'admin', 'admin', 'a9bdd47d7321d4089b3b00561c9c621848bd6f6e2f745a53d54913d613789c23945b66de6ded1eb336a7d526f9349a9d964d6f6c3a40e2ac90b4b16c0121f7895Xg53McbkyQ/NmW60Sf4cu3wJsi/8cyZXxeXV7g6b04=', 'mnl', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (43, 'operator', 'Operator', 'a9bdd47d7321d4089b3b00561c9c621848bd6f6e2f745a53d54913d613789c23945b66de6ded1eb336a7d526f9349a9d964d6f6c3a40e2ac90b4b16c0121f7895Xg53McbkyQ/NmW60Sf4cu3wJsi/8cyZXxeXV7g6b04=', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- View structure for vw_normalisasidata
-- ----------------------------
DROP VIEW IF EXISTS `vw_normalisasidata`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_normalisasidata` AS SELECT 
	a.id, a.Nama,
	((((a.JmlProduksi-(SELECT MIN(JmlProduksi) FROM tdata)))/((SELECT MAX(JmlProduksi) FROM tdata)-(SELECT MIN(JmlProduksi) FROM tdata)))) ND_JmlProduksi,
	((((a.JmlPekerja-(SELECT MIN(JmlPekerja) FROM tdata)))/((SELECT MAX(JmlPekerja) FROM tdata)-(SELECT MIN(JmlPekerja) FROM tdata)))) ND_JmlPekerja,
	((((a.Omset-(SELECT MIN(Omset) FROM tdata)))/((SELECT MAX(Omset) FROM tdata)-(SELECT MIN(Omset) FROM tdata)))) ND_Omset
FROM tdata a ;

SET FOREIGN_KEY_CHECKS = 1;
