<?php

class Exception_MyException extends BaseException {
	function getMyTrace(){
        return '';
    }
    function collectBasicData($func,$shift,$code){
    }
    function getHTML($message=null){
        $html='';
        $html.= '<h2>'.get_class($this).(isset($message)?': '.$message:'').'</h2>';
        $html.= '<p><font color=red>' . $this->getMessage() . '</font></p>';
        $html.= '<p><font color=blue>' . $this->getMyFile() . ':' . $this->getMyLine() . '</font></p>';
        $html.=$this->getDetailedHTML();
        // $html.= backtrace($this->shift+1,$this->getMyTrace());
        return $html;
    }
}