<?php
final class svdb extends dbsql {
	private static $server = 'localhost';
	private static $user = 'sv';
	private static $pwd = 'british123';
	private static $schema = 'sv';
	private static $charset = 'utf8';
	private static $db = null;
	
	/**
	 * Gets an instance of svdb. It will allow only one instance to be created and will return it always.
	 * @return svdb
	 */
	public static function getInstance() {
		if (! is_null ( self::$db )) {
			return self::$db;
		}
		
		self::$db = new svdb ( self::$user, self::$pwd, self::$server, self::$schema, self::$charset, config::debug_mode () );
		return self::$db;
	}
}

?>