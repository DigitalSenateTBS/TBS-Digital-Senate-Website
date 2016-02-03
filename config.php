<?php

/**

* Holds configuration variables.

*/

class config {
		
		public static function root_directory () {
			return __DIR__;
		}
			
		public static function url () {
			return "http://localhost/sv";
		}
			
		public static function site_title () {
			return "Student Vanguard";
		}
		
		public static function debug_mode () {
			return true;
		}
	
}

?>