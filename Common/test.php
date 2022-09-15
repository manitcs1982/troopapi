<?php

	
	echo "   ".date('m-d-y G:i:s', time());
	
	echo "   ".date('10:10');
	
if(date('H:i', time())<date('10:10')){
	echo "if";
}else{
	echo "else";
}

?>