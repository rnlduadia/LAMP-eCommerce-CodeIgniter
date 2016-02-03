

alter TABLE `inventory`
  add column `status`  enum('active','deleted') not null default 'active' after `i_id`;