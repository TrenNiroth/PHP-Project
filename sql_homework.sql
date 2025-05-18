create database db_sms
character set utf8mb4
collate utf8mb4_unicode_ci;

use db_homework_five;

create table students (
    id 			bigint			unsigned		auto_increment,
    first_name 	varchar(255) 	not null,
    last_name 	varchar(255) 	not null,
    gender 		tinyint			not null 		default 0 COMMENT '0 unknown, 1 male, 2 female',
    dob 		datetime 		not null,
    register_at datetime		not null,
    primary key (id)
);
