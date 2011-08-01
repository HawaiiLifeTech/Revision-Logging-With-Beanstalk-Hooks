-- RUN THIS SQL
CREATE TABLE `deployments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `revision` int(11) NOT NULL,
  `environment` varchar(255) NOT NULL DEFAULT '',
  `hook` varchar(255) NOT NULL DEFAULT '',
  `post_values` longtext NOT NULL,
  PRIMARY KEY (`id`)
)