CREATE TABLE `prize_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '-1',
  `credits` int(11) NOT NULL DEFAULT '0',
  `diamonds` int(11) NOT NULL DEFAULT '0',
  `duckets` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `points_type` int(11) NOT NULL DEFAULT '0',
  `badge` varchar(255) DEFAULT NULL,
  `furni_id` int(11) NOT NULL DEFAULT '0',
  `furni_amount` int(11) NOT NULL DEFAULT '1',
  `kick_user` enum('0','1') NOT NULL DEFAULT '0',
  `bubble_alert` enum('0','1') NOT NULL DEFAULT '1',
  `enabled` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir prêmio padrão para nível -1 (prêmio padrão quando não há prêmio específico para o nível do usuário)
INSERT INTO `prize_plugin` (`level`, `credits`, `diamonds`, `duckets`, `points`, `points_type`, `badge`, `furni_id`, `furni_amount`, `kick_user`, `bubble_alert`, `enabled`) 
VALUES (-1, 100, 5, 50, 0, 0, NULL, 0, 1, '0', '1', '1');