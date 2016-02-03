ALTER TABLE  `brand` ADD  `logo` VARCHAR( 255 ) NULL AFTER  `b_name` ,
ADD  `is_top` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `logo` ;