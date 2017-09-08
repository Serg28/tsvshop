# EVO Database Script for New/Upgrade Installations
#
# Each sql command is separated by double lines


#
# Empty tables first
# 

TRUNCATE TABLE `{PREFIX}shop_order`;

TRUNCATE TABLE `{PREFIX}shop_order_detail`;

TRUNCATE TABLE `{PREFIX}shop_numorder`;

TRUNCATE TABLE `{PREFIX}shop_conf`;

