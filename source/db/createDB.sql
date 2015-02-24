CREATE DATABASE `fm`

CREATE TABLE `users` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `username` varchar(64) NOT NULL,
 `type` tinyint(4) NOT NULL DEFAULT '10',
 `status` tinyint(4) NOT NULL DEFAULT '10',
 `password` char(128) NOT NULL,
 `salt` char(128) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1

CREATE TABLE `loginattempts` (
 `userId` bigint(20) NOT NULL,
 `time` varchar(32) NOT NULL,
 PRIMARY KEY (`userId`, 'time'),
) ENGINE=InnoDB DEFAULT CHARSET=latin1