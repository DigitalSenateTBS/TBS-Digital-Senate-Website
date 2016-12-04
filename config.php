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
			return "TBS Vanguard";
		}
		
		public static function contact_email () {
			$contact_email = "digitalsenatebarra@britishschool.g12.br";
			return "<a href='mailto:" . $contact_email . "' >" . $contact_email . "</a>";
		}
		
		public static function debug_mode () {
			return false;
		}
	
}

?>