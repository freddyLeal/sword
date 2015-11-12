<?php

    class SystemUtils {

        public function init(){}
        
        public function getSystemVariable($variableName){
        	$variable = SystemVariable::model()->find("sv_name = '$variableName'");
        	return $variable;
        }

        public function setSystemVariable($variableName, $isNumeric, $value){
        	$variable = SystemVariable::model()->find("sv_name = '$variableName'");
        	if($isNumeric)
        		$variable->value_numeric = $value;
        	else 
        		$variable->sv_value_text = $value;
        	$variable->save();
        }

     

    }

?>