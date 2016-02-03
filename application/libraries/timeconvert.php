<?php

class timeconvert
{
    const fieldnamePrefix = 'temp_';
    protected $tableName = '';
    protected $columnName = '';
    protected $keyColumnName = '';
    protected $temp_columnName = '';
    protected $this_ci;
    protected $rowsWorked= 0;
    protected $skipppedRowsCount= 0;
    protected $skipppedWithWrongFormatRowsCount= 0;


    public function __construct($tableName, $columnName, $keyColumnName)  // $timeConvert= new timeconvert('inventory', 'i_time', 'i_id');
    {
        $this->tableName = $tableName;
        $this->columnName = $columnName;
        $this->keyColumnName = $keyColumnName;
        $this->temp_columnName = self::fieldnamePrefix . '' . $this->columnName;
        $this->this_ci = & get_instance();
        $this->this_ci->load->dbforge();  // https://ellislab.com/codeigniter/user-guide/database/forge.html
    }

    public function addTempColumn()
    {
        $this->this_ci->dbforge->add_column($this->tableName, array( $this->temp_columnName => array('type' => 'datetime',) ) );
    }

    public function copyRows($skipInvalidFormat= false)
    {
        $this->this_ci->db->select('*')->from($this->tableName);
        $rowsList = $this->this_ci->db->get()->result('array');  // get all data as array
        $this->rowsWorked= 0;
        $this->skipppedRowsCount= 0;
        $this->skipppedWithWrongFormatRowsCount= 0;
        foreach( $rowsList as $nextRow ) {
            $updateRow= true;
            if ( $skipInvalidFormat ) {           // skip strings in invalid format
                if( empty($nextRow[$this->columnName]) or !preg_match('/^\d+$/',$nextRow[$this->columnName])) {
                    $this->skipppedWithWrongFormatRowsCount++;
                    $updateRow= false;
                    continue;
                }
            }
            $newVal= apputils::ConvertUnStampToMysqlDateTime($nextRow[$this->columnName]); // get and convert value from string field
            if ( empty($nextRow[$this->columnName]) ) {
                $this->skipppedRowsCount++;
                $updateRow= false;
                continue;
            }
            if ( $updateRow ) {
                $this->this_ci->db->where($this->keyColumnName, $nextRow[$this->keyColumnName]); // update temp field with datetime stamp
                $this->this_ci->db->update($this->tableName, array($this->temp_columnName=>$newVal));
                $this->rowsWorked++;
            }
        }
    }

    public function dropSourceColumn() {
        $this->this_ci->dbforge->drop_column($this->tableName, $this->columnName);
    }

    public function dropRenameTmpColumn() {
        $this->this_ci->dbforge->modify_column($this->tableName, array( $this->temp_columnName=>array('name' => $this->columnName, 'type' => 'datetime') )  );
    }

    public function getRowsWorked() {
        return $this->rowsWorked;
    }

    public function getSkipppedRowsCount() {
        return $this->skipppedRowsCount;
    }

    public function getSkipppedWithWrongFormatRowsCount() {
        return $this->skipppedWithWrongFormatRowsCount;
    }

}