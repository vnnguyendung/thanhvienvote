CREATE TABLE IF NOT EXISTS `#__thanhvienvote_vote` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`created_by` INT(11)  NOT NULL ,
`art_createdby` INT NOT NULL ,
`art_id` INT NOT NULL ,
`vote` TINYINT NOT NULL ,
`save` TINYINT NOT NULL ,
`time` DATETIME NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;

