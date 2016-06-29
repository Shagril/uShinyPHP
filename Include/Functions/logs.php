<?php
	
	class Logs{
		
		public static function init(){
			error_log("", 3, './Logs/info.log');
			error_log("", 3, './Logs/error.log');
		}
		
		public static function info($message){
			error_log('['.Date('d-M-Y H:i:s e').'] - Info: '.$message."\n", 3, './Logs/info.log');
		}
		
		public static function error($message){
			error_log('['.Date('d-M-Y H:i:s e').'] - Error: '.$message."\n", 3, './Logs/error.log');
		}
	}
?>