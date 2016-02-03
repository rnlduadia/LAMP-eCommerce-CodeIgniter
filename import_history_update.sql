ALTER TABLE `import_result` CHANGE `results` `results` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE  `import_history` ADD  `deleted` INT NOT NULL DEFAULT  '0' AFTER  `updated` ;