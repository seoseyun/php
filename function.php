<?php
/**
	*@author 서세윤
	*@param Array SQL문만들 배열
	*@param String insert || update
	*@param Array 제외시킬 key값이 들어간 array
	*@return Array 해당메뉴의 Array
	*간단한 SQL문 만들기
*/
function makeSimpleSql($inputArr,$type,$notAccess=NULL){
	if(!is_array($inputArr)){
		echo "1param array type please";
		return;
	}
	if(!is_null($notAccess)){
		if(!is_array($notAccess)){
			echo "3param array type please";
			return;
		}
	}else{
		$notAccess = array();
	}

	if($type=="insert"){
		$output1Arr;
		$output2Arr;
		foreach ($inputArr as $key => $value) {
			//제외할 key값은 빼고
			if( !in_array($key , $notAccess) ){
				$output1Arr[] = "{$key}";
				$output2Arr[] = "'{$value}'";
			}
		}
		$output1 = "(".join(",",$output1Arr).")";
		$output2 = "VALUES(".join(",",$output2Arr).")";
		$output = $output1." ".$output2;
		return $output;
	}else if($type=="update"){
		$outputArr;
		foreach ($inputArr as $key => $value) {
			//제외할 key값은 빼고
			if( !in_array($key , $notAccess) ){
				$outputArr[] = "{$key} = '{$value}'";
			}
		}
		return join(",",$outputArr);
	}else{
		echo "2param check please";
		return;
	}
}

//경고창을 보여주고 지정된 페이지로 이동.
function msg_js($msg, $url="") {
	echo "<script language='javascript'>";
	echo "alert('$msg');";
	if ($url) {
		echo "location.replace('$url');";
	} else {
		echo "history.go(-1)";
		//window.history.back();
	}
	echo "</script>";
	exit;
}