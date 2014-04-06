<?php
class BindParam{

    private $values = array(), $types = '';
   
    public function add( &$value ){
        $this->values[] = $value;
        $this->types .= $this->dataType($value);
    }
   
    public function get(){
        return $this->refValues(array_merge(array($this->types), $this->values));
    }

    public function dataType($val){
		if(is_int($val))
			return 'i';
		return 's';
	}

	public function refValues($arr){
	    if (strnatcmp(phpversion(),'5.3') >= 0){
	        $refs = array();
	        foreach($arr as $key => $value)
	            $refs[$key] = &$arr[$key];
	        return $refs;
	    }
	    return $arr;
	}

	public function SanitizeDateTime($field,$val,$fields){
		if($fields[$field] == 'date')
			return date('Y-m-d',strtotime($val));
		else if($fields[$field] == 'time')
			return date('H:i',strtotime($val));
		return $val;
	}

}