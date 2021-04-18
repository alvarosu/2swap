CREATE TABLE IF NOT EXISTS `wallets` (
    `id` varchar(35) NOT NULL UNIQUE,
    `fk_user_email` varchar(250) NOT NULL,
    `currency` varchar(3) NOT NULL,
    `amount` decimal NOT NULL,
    `create_datetime` datetime NOT NULL,
    PRIMARY KEY `id`,
    FOREIGN KEY `fk_user_email` REFERENCES users(`id`)
);