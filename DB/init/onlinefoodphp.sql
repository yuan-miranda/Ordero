-- phpMyAdmin SQL Dumpx
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  time_zone = "+00:00";

CREATE TABLE
  `admin` (
    `adm_id` int (222) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`adm_id`),
    `username` varchar(222) NOT NULL,
    `password` varchar(222) NOT NULL,
    `email` varchar(222) NOT NULL,
    `code` varchar(222) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'admin',
    'CAC29D7A34687EB14B37068EE4708E7B',
    'admin@mail.com',
    '',
    CURRENT_TIMESTAMP
  );




















INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'group1',
    '513772ee53011ad9f4dc374b2d34d0e9',
    'group1@mail.com',
    '',
    CURRENT_TIMESTAMP
  );
INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'group2',
    'f617868bd8c41043dc4bebc7952c7024',
    'group2@mail.com',
    '',
    CURRENT_TIMESTAMP
  );
INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'group3',
    '78733d0dd44e9bbca1d931c569676531',
    'group3@mail.com',
    '',
    CURRENT_TIMESTAMP
  );
INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'group4',
    'baf5d52135cbcd978e0083939e9f3071',
    'group4@mail.com',
    '',
    CURRENT_TIMESTAMP
  );
INSERT INTO
  `admin` (
    `username`,
    `password`,
    `email`,
    `code`,
    `date`
  )
VALUES
  (
    'group5',
    '28f745f0b69377f5f945845a36cce4a1',
    'group5@mail.com',
    '',
    CURRENT_TIMESTAMP
  );





















CREATE TABLE
  `dishes` (
    `d_id` int (222) NOT NULL AUTO_INCREMENT,
    `adm_id` int (222) NOT NULL,
    `rs_id` int (222) NOT NULL,
    PRIMARY KEY (`d_id`),
    `title` varchar(222) NOT NULL,
    `slogan` varchar(222) NOT NULL,
    `price` decimal(10, 2) NOT NULL,
    `quantity` int (222) NOT NULL DEFAULT '0',
    `img` varchar(222) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
  `remark` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`),
    `frm_id` int (11) NOT NULL,
    `status` varchar(255) NOT NULL,
    `remark` mediumtext NOT NULL,
    `remarkDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
  `restaurant` (
    `rs_id` int (222) NOT NULL AUTO_INCREMENT,
    `adm_id` int (222) NOT NULL,
    `c_id` int (222) NOT NULL,
    `title` varchar(222) NOT NULL,
    `email` varchar(222) NOT NULL,
    `phone` varchar(222) NOT NULL,
    `url` varchar(222) NOT NULL,
    `o_hr` varchar(222) NOT NULL,
    `c_hr` varchar(222) NOT NULL,
    `o_days` varchar(222) NOT NULL,
    `address` text NOT NULL,
    `image` text NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`rs_id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
  `res_category` (
    `c_id` int (222) NOT NULL AUTO_INCREMENT,
    `adm_id` int (222) NOT NULL,
    `c_name` varchar(222) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`c_id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
  `users` (
    `u_id` int (222) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`u_id`),
    `username` varchar(222) NOT NULL,
    `f_name` varchar(222) NOT NULL,
    `l_name` varchar(222) NOT NULL,
    `email` varchar(222) NOT NULL,
    `phone` varchar(222) NOT NULL,
    `password` varchar(222) NOT NULL,
    `address` text NOT NULL,
    `status` int (222) NOT NULL DEFAULT '1',
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
  `users_orders` (
    `o_id` int (222) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`o_id`),
    `rs_id` int (222) NOT NULL,
    `d_id` int (222) NOT NULL,
    `u_id` int (222) NOT NULL,
    `title` varchar(222) NOT NULL,
    `quantity` int (222) NOT NULL,
    `price` decimal(10, 2) NOT NULL,
    `status` varchar(222) DEFAULT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `arrive` timestamp NULL DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1;