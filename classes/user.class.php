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
		
		// read the user from the database
		$where = " u.pwd = '" . $pwd . "'";
		$u = User::readSingle ( $where );
		
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
		$query = "select u.id, u.username, u.name, u.profile_id, u.status
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
	 * Return user status
	 *
	 * @return integer
	 *
	 */
	public function getProfileId() {
		return $this->profile_id;
	}
	
	/**
	 *
	 * Set user status
	 *
	 * @param integer $status
	 *
	 */
	public function setprofileId($profile_id) {
		$this->profile_id = $profile_id;
	}
}