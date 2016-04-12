<?php

/**
 * Represents a user.
 */
class User {
	
	// private properties
	private $id = null;
	private $name = null;
	private $username = null;
	private $status = null;
	private $profile_id = null;
	private $site = null;
	private static $db = null;
	
	/**
	 *
	 * Returns the user with the given id.
	 *
	 * @throws Exception if there is no user with such id.
	 *        
	 */
	public static function get($id) {
		$u = null;
		
		// read user from database
		if (! is_null ( $id )) {
			$u = static::readSingle ( "u.id = ? ", array (
					$id 
			) );
		}
		
		// throws exception if there is no user with such id
		if (is_null ( $u )) {
			throw new Exception ( 'User not found' );
		}
		
		// return user
		return $u;
	}
	
	/**
	 *
	 * Returns the user with the given password.
	 * If there is no such user, throws Exception.
	 *
	 * @param string $pwd
	 *        	password
	 *        	
	 * @return User
	 *
	 * @throws Exception when there is no user with this password.
	 *        
	 */
	public static function login($pwd) {
		$db = svdb::getInstance ();
		
		$query = "select u.username, u.pwd
					from sv_users u
					where status = 1";
		
		$result = $db->query ($query);
		
		$num = $result->numRows();
		
		$match = false;
		
		for($i = 0; $i < $num; $i++){
			$row = $result->fetchAssoc();
			
			$username = $row['username'];
			$hash = $row ["pwd"];
			if (password_verify ( $pwd, $hash )) {
				// the password hashing algorithms evolve in time. Check if there is a new
				// one available and, if so, re-hash the password - while we have it plain text!
				if (password_needs_rehash ( $hash, PASSWORD_DEFAULT )) {
					try {
						$hash = password_hash ( $pwd, PASSWORD_DEFAULT );
						$cmd = "UPDATE sv_users SET pwd = ? where username = ?";
						$params = array ($hash, $username);
						$db->execSQLCmd( $cmd, $params );
					} catch ( Exception $e ) {
						// ignore: can update next time...
					}
				}
				$match = true;
				break;
			}	
		}
		
		if (!$match){
			throw new Exception ( 'Invalid password' );
		}
		
		// read the user from the database
		$where = " u.username = ?";
		$params = array($username);
		
		$u = User::readSingle ( $where,$params );
		
		// check for invalid password.
		if (is_null ( $u )) {
			throw new Exception ( 'Invalid password' );
		}
		
		// return user
		return ($u);
	}
	
	/**
	 * Fill this object with the data from the result set.
	 *
	 * @param array $row        	
	 *
	 */
	public function fillObject($row) {
		if (isset ( $row ['id'] )) {
			$this->id = $row ["id"];
		}
		if (isset ( $row ['name'] )) {
			$this->setName ( $row ["name"] );
		}
		if (isset ( $row ['username'] )) {
			$this->setUsername ( $row ["username"] );
		}
		if (isset ( $row ['status'] )) {
			$this->setStatus ( $row ["status"] );
		}
		if (isset ( $row ['profile_id'] )) {
			$this->setProfileId ( $row ["profile_id"] );
		}
		if (isset ( $row ['site'] )) {
			$this->setSite( $row ["site"] );
		}
	}
	
	public static function changePassword ($id,$new_pwd){
		$db = svdb::getInstance ();
		
		$query = "	UPDATE sv_users u
	        		SET pwd = ?
	        		WHERE id = ?;";
			
		$params = array();
		$params[] = password_hash($new_pwd, PASSWORD_DEFAULT);
		$params[] = $id;
		
		$db->execSQLCmd($query,$params);
	}
	
	public static function changeUsername ($id,$new_username){
		$db = svdb::getInstance ();
	
		$query = "	UPDATE sv_users u
	        		SET username = ?
	        		WHERE id = ?;";
			
		$params = array();
		$params[] = $new_username;
		$params[] = $id;
	
		$db->execSQLCmd($query,$params);
	}
	
	public static function changeProfileId ($id,$new_profile_id){
		$db = svdb::getInstance ();
	
		$query = "	UPDATE sv_users u
	        		SET profile_id = ?
	        		WHERE id = ?;";
			
		$params = array();
		$params[] = $new_profile_id;
		$params[] = $id;
	
		$db->execSQLCmd($query,$params);
	}
		
	
	/**
	 *
	 * Reads a single user from the database.
	 *
	 * @param string $where        	
	 * @param array $params        	
	 * @return User
	 *
	 */
	private static function readSingle($where = null, $params = null) {
		$db = svdb::getInstance ();
		
		// query
		$query = "select u.id, u.username, u.name, u.profile_id, u.status, u.site
					from sv_users u";
		
		if (! is_null ( $where )) {
			$query .= " where " . $where;
		}
		$result = $db->query ( $query, $params );
		
		if (! $result->hasRows ()) {
			// no user found
			return null;
		}
		
		// fills the User object
		$u = new User ();
		$u->fillObject ( $result->fetchAssoc () );
		
		// free result set
		$result->free ();

		return $u;
	}
	
	/**
	 *
	 * Return id
	 *
	 * @return integer
	 *
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Get name
	 *
	 * @return string
	 *
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * Set name
	 *
	 * @param string $name        	
	 *
	 */
	public function setName($name) {
		$this->name = trim ( $name );
	}
	
	/**
	 *
	 * Get username
	 *
	 * @return string
	 *
	 */
	public function getUsername() {
		return $this->username;
	}
	
	/**
	 * Set username
	 *
	 * @param string $username        	
	 */
	public function setUsername($username) {
		$this->username = $username;
	}
	
	/**
	 *
	 * Return user status
	 *
	 * @return integer
	 *
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 *
	 * Set user status
	 *
	 * @param integer $status        	
	 *
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 *
	 * Return user profile id
	 *
	 * @return integer
	 *
	 */
	public function getProfileId() {
		return $this->profile_id;
	}
	
	/**
	 *
	 * Set user profile id
	 *
	 * @param integer $status
	 *
	 */
	public function setprofileId($profile_id) {
		$this->profile_id = $profile_id;
	}
	
	/**
	 *
	 * Return user site
	 *
	 * @return integer
	 *
	 */
	public function getSite() {
		return $this->site;
	}
	
	/**
	 *
	 * Set user site
	 *
	 * @param integer $status
	 *
	 */
	public function setSite($site) {
		$this->site = $site;
	}
	
	public static function checkPermission ($profile_id,$permission) {		
		if ($permission == 0){
			return true;
		}
		
		$db = svdb::getInstance ();
		
		$query = "	SELECT u.allow
					from sv_profiles_permissions u
        			WHERE u.profile_id = ? AND u.permission_id = ?;";
		
		$params = array();
		$params[] = $profile_id;
		$params[] = $permission;
		
		$result = $db->query($query,$params);
		
		if (! $result->hasRows ()) {
			// no user found
			return false;
		}
		
		$row = $result->fetchAssoc ();
		
		$allow = $row ['allow'];
		
		if ($allow == 1) {
			return true;
		}
		
		if ($allow == 0) {
			return false;
		}
		
		return false;
	}
	
	public static function checkPermissionByPage ($page_name,$profile_id){
		$db = svdb::getInstance ();
		
		$query = "SELECT DISTINCT pg.page_display_name, pg.page_path
				FROM sv_profiles_permissions p
				JOIN sv_pages pg on (pg.page_permission = p.permission_id or pg.page_permission = 0)
				WHERE pg.page_name = ? and p.profile_id = ? and (p.allow = 1 or pg.page_permission = 0);";
		
		$params = array();
		$params[] = $page_name;
		$params[] = $profile_id;
		
		$result = $db->query($query,$params);
		
		if($result->hasRows()) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public static function getLinks ($position, $profile_id){
		$db = svdb::getInstance ();
		
		$query = "SELECT DISTINCT pg.page_display_name displayname, pg.page_path path
				FROM sv_profiles_permissions p
				JOIN sv_pages pg on (pg.page_permission = p.permission_id or pg.page_permission = 0)
				WHERE pg.position = ? and p.profile_id = ? and (p.allow = 1 or pg.page_permission = 0);";
		
		$params = array();
		$params[] = $position;
		$params[] = $profile_id;
		
		$result = $db->query($query,$params);
		
		$num = $result->numRows();
			
		for($i = 0; $i < $num; $i++){
			$row = $result->fetchAssoc();
		
			echo"<li><a href=" . config::url(). $row['path'] . ">" . $row ['displayname'] . "</a></li>";
		}
	}
	
	public static function getLinkPath ($page_name){
		$db = svdb::getInstance ();
	
		$query = "SELECT DISTINCT pg.page_path path
				FROM sv_pages pg
				WHERE pg.page_name = ?;";
	
		$params = array();
		$params[] = $page_name;
		
		$result = $db->query($query,$params);
		
		$row = $result->fetchAssoc();
		
		return $row['path'];
	
	}
	
	public static function togglePermission ($permission,$profile) {
		$db = svdb::getInstance ();
		
		$new_permission = null;
				
		if (self::checkPermission($profile, $permission)){
			$query = "	UPDATE sv_profiles_permissions p
        			SET p.allow = 0
        			WHERE p.profile_id = ? AND p.permission_id = ?;";
			$new_permission = false;
		} else {
			$query = "	UPDATE sv_profiles_permissions p
        			SET p.allow = 1
        			WHERE p.profile_id = ? AND p.permission_id = ?;";
			$new_permission = true;
		}
	
		$params = array();
		$params[] = $profile;
		$params[] = $permission;
	
		$db->execSQLCmd($query,$params);
		
		return $new_permission;
	}
	
	public static function HomePageLink () {
		$db = svdb::getInstance ();
		
		$query = "SELECT DISTINCT pr.home_page
				FROM sv_profiles pr
				WHERE pr.id = ?;";
		
		$params = array();
		$params[] = $_SESSION['sv_user']->getProfileId();
		
		$result = $db->query($query,$params);
		
		$row = $result->fetchAssoc();
		
		return $row['home_page'];
	}
}