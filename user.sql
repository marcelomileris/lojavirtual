create database if not exists `lojavirtual`;
use `lojavirtual`;
create table if not exists `users` (  
	`id` 		int(11) not null auto_increment, 
	`name` 		varchar(100) not null,
	`email` 	varchar(100) not null,
	`birth` 	date,
	`phone`  	varchar(20) not null,
	`document` 	varchar(20) not null,
	`zip_code` 	varchar(20) not null,	
	`address` 	varchar(100) not null,
	`number` 	varchar(20) not null,
	`district` 	varchar(100) not null,
	`city` 		varchar(20) not null,
	`estate` 	varchar(02) not null,
	`created` 	timestamp not null default current_timestamp,
	`updated` 	timestamp null on update current_timestamp,
	primary key (`id`) using btree
) engine=myisam default charset=latin1;  