<?php
function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
function removeTags($string){
	return filter_var($string, FILTER_SANITIZE_STRING);
}
?>