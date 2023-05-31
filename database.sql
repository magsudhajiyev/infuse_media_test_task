CREATE TABLE `visitor_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `view_date` datetime NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `views_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `visitor_data` (`ip_address`, `user_agent`, `view_date`, `page_url`, `views_count`) VALUES ('127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.456.789', '2023-05-31 10:00:00', 'http://localhost/index1.html', 1);
