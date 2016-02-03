UPDATE buyer_transaction SET bt_time = DATE_FORMAT(FROM_UNIXTIME(bt_time), '%Y-%m-%d %h:%i:%s') WHERE concat('',bt_time * 1) = bt_time;

UPDATE user SET u_time = DATE_FORMAT(FROM_UNIXTIME(u_time), '%Y-%m-%d %h:%i:%s') WHERE concat('',u_time * 1) = u_time;

UPDATE buyer_supplier_detail SET bsd_feedback_date = DATE_FORMAT(FROM_UNIXTIME(bsd_feedback_date), '%Y-%m-%d %h:%i:%s') WHERE concat('',bsd_feedback_date * 1) = bsd_feedback_date;

UPDATE buyer_supplier_message SET bsm_time = DATE_FORMAT(FROM_UNIXTIME(bsm_time), '%Y-%m-%d %h:%i:%s') WHERE concat('',bsm_time * 1) = bsm_time;
