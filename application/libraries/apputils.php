<?php
class apputils {
 //   temp_i_time = appUtils.ConvertUnStampToMysqlDateTime(i_time)
    private static $DateTimeMySqlFormat = '%Y-%m-%d %H:%M:%S';
    private static $COMMON_FORMAT = '%d/%m/%y %l:%M:%S %p %Z';  // '%m/%d/%Y %h:%i:%s %A %T';  // m/d/Y h:i:s A T
    private static $MONTH_AS_TEXT_YEAR_DATE_FORMAT = '%B %Y';
    private static $DateTimeFormat = '%Y-%m-%d %H:%M';
    private static $DateTimeAsTextFormat = '%B %d, %Y %H:%M%p';
    private static $DateAsTextFormat = '%B %d, %Y';


    public function ConvertUnStampToMysqlDateTime($datetimeLabel) {
        return strftime(self::$DateTimeMySqlFormat, $datetimeLabel);
    }

    public static function ShowFormattedDateTime($datetimeValue, $format = '')
    {
        //echo '<pre>$datetimeValue::'.print_r($datetimeValue,true).'</pre>';
        if (empty($datetimeValue) or trim($datetimeValue) == '0000-00-00 00:00:00' ) {
            $datetimeValue= mktime(null, null, null, 1, 1, 2014); // 1/1/2014
        }

        if( !preg_match('/^\d+$/',$datetimeValue)) {
            $datetimeValue = strtotime($datetimeValue);
        }
        if (empty($format)) {
            return strftime(self::$DateTimeFormat, $datetimeValue);
        }

        if (strtoupper($format) == 'COMMON') {
            return strftime(self::$COMMON_FORMAT, $datetimeValue);
        }

        if (strtoupper($format) == "ASTEXT") {
            return strftime(self::$DateTimeAsTextFormat, $datetimeValue);
        }
        if (strtoupper($format) == "DATEASTEXT") {
            return strftime(self::$DateAsTextFormat, $datetimeValue);
        }

        if (strtoupper($format) == "MONTHASTEXTYEAR") {
            return strftime(self::$MONTH_AS_TEXT_YEAR_DATE_FORMAT, $datetimeValue);
        }
        if (strtoupper($format) == "MYSQL") {
            return strftime(self::$DateTimeMySqlFormat, $datetimeValue);
        }
    }

	public static function orderStatus($status = null){
		$statuses = array(
			'0' => 'Pending',
			'-1' => 'Cancelled',
			'-2' => 'Pending buyer\'s consent for new shipping fees',
			'-3' => 'Order Refund',
			'-4' => 'Returned',
			'-100' => 'Awaiting Payment',
			'1' => 'Shipped',
			'2' => 'Completed',
			'10' => 'In Progress',
		);
		return ($status === null)?$statuses:$statuses[$status];
	}
}