<?php
class news {
	
	const leftPosValue = 1;
	const centerPosValue = 2;
	const rightPosValue = 3;
	const bottomPosValue = 4;
	
	private $id = NULL;
	private $audience = 127;
	private $title = NULL;
	private $text = NULL;
	private $status = "active";
	private $author = NULL;	
	private $created_on = NULL;
	private $ordering = NULL;
	private $position = self::centerPosValue;
	private $last_modified = NULL;
	private $site = NULL; //$_SESSION['sv_user']->getSite();
	
	/**
	 * 
	 * Creates a query that returns all active articles from requested position.
	 * 
	 * @param integer $position
	 * @return DbSqlResult
	 */
	public static function getActiveArticles($position) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.audience,
					u.title,
					u.text,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE position = ? AND status = ? AND site = ?
        			ORDER BY ordering ASC;";
		
		$params = array();
		$params[] = $position;
		$params[] = 'active';
		$params[] = $_SESSION['sv_user']->getSite();		
		
		$result = $db->query($query,$params);
		
		return $result;
	}
	/**
	 * 
	 * Processes active articles from requested position and displays them on the page.
	 * 
	 * 
	 * @param integer $position
	 */
	public static function processArticles($position){
		$result = news::getActiveArticles($position);
			
		$num = $result->numRows();
			
		for($i = 0; $i < $num; $i++){
			$row = $result->fetchAssoc();
		
			$title = $row['title'];
			$text = $row ['text'];
			
			echo"<div class='daily_bulletin_article'>";
			echo "<h4>" . $title . "</h4>";
			echo "<p>" . $text . "</p>";
			echo"</div>";
		}
	}
	/**
	 * 
	 * Creates a query that returns active and hidden articles from requested position.
	 * 
	 * @param integer $position
	 * @return DbSqlResult
	 */
	private static function getAllArticles($position) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.audience,
					u.title,
					u.text,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE position = ? AND (status = ? OR status = ?) AND site = ?
        			ORDER BY ordering ASC;";
		
		$params = array();
		$params[] = $position;
		$params[] = 'active';
		$params[] = 'hidden';
		$params[] = $_SESSION['sv_user']->getSite();
		
		$result = $db->query($query,$params);
		
		return $result;
	}
	
	/**
	 * 
	 * Creates a new article in the database with recieved parameters.
	 * 
	 * 
	 * @param integer $position
	 * @param integer $audience
	 * @param string $title
	 * @param string $text
	 * @param string $status
	 * @param string $site
	 */
	public static function createArticle($position, $audience, $title = null, $text = null, $status = "active",$site = null) {
		//TODO Make audience functional
		
		$db = svdb::getInstance ();
		
		$ordering = ($db->maxValue ( "ordering", "sv_news" )) + 1;
		// $audience=
		// $title=
		// $text=
		$author_id = $_SESSION['sv_user']->getId();
		// $status=
		if ($site == null){
			$site = $_SESSION['sv_user']->getSite();
		}
		$now = new DateTime ();
		$nowStr = $now->format ( 'Y-m-d H:i:s' );
		
		$cmd = "	INSERT INTO sv_news (position,ordering,audience,title,text,author_id,status,created_on,last_modified,site) values
					(?,?,?,?,?,?,?,?,?,?);";
		
		$params = array();
		$params[] = $position;
		$params[] = $ordering;
		$params[] = $audience;
		$params[] = $title;
		$params[] = $text;
		$params[] = $author_id;
		$params[] = $status;
		$params[] = $nowStr;
		$params[] = $nowStr;
		$params[] = $site;		
		
		$db->execSQLCmd ($cmd,$params);
	}
	
	/**
	 * 
	 * Returns HTML code for a table to make changes to the database for the recieved position.
	 * 
	 * @param integer $position
	 * @return string
	 */
	public static function reviewArticlesTable ($position) {
		$tablestring = "";
		
		$tablestring .= "<div class='panel-group all-article-review' id='accordion" . $position . "'>";
		
		$result = self::getAllArticles($position);
		
		$num = $result->numRows();
		
		$previousid = null;
		$i = 1;
		
		while ($row = $result->fetchAssoc()){
			$id = $row ['id'];
			$title = $row['title'];
			$text = $row ['text'];
			$status = $row ['status'];
			
			if ($title == ""){
				$title = "*NO TITLE*";
			}
			
			if ($status == "hidden"){
				$statuscircle = "glyphicon-eye-open";
				$statusclass = " style='background-color: rgba(245, 245, 245, 0);'";
				$statustitle = "Unhide";
			}else{
				$statuscircle = "glyphicon-eye-close";
				$statusclass = "";
				$statustitle = "Hide";
			}
				$tablestring .= "<div class='panel panel-default'>
				    				<div class='panel-heading'" . $statusclass . ">
				      					<h4 class='panel-title'>
				        					<a data-toggle='collapse' data-parent='#accordion" . $position . "' href='#" . $id . "'>";
				$tablestring .= $title;
				$tablestring .= "		</a>
								<span class='pull-right'>";
				
								if ($previousid == null){
									$tablestring .= "<a title='Move up'><span class='glyphicon glyphicon-arrow-up disabled-link'></span></a>";
								} else {
									$tablestring .= "<a onclick=\"actionCall('moveUp', " . $id . "," . $position . ");\" title='Move up'><span class='glyphicon glyphicon-arrow-up action-link'></span></a>";
								}
								
								if ($i == $num) {
									$tablestring .=	"<a title='Move down'><span class='glyphicon glyphicon-arrow-down disabled-link'></span></a>";
								} else {
									$tablestring .=	"<a onclick=\"actionCall('moveDown', " . $id . "," . $position . ");\" title='Move down'><span class='glyphicon glyphicon-arrow-down action-link'></span></a>";
								}
								
				$tablestring .=	"<a href=' ". config::url() . user::getLinkPath('news_add') . "?id=" . $id . "' title='Edit'><span class='glyphicon glyphicon-pencil action-link'></span></a>
								<a onclick=\"actionCall('toggleHide', " . $id . "," . $position . ");\" title='" . $statustitle . "'><span class='glyphicon " . $statuscircle . " action-link'></span></a>
								<a onclick=\"confirmDelete(" . $id . "," . $position . ");\" title='Delete'><span class='glyphicon glyphicon-remove action-link'></span></a>
								</span>
								</h4>
				    		</div>
				    		<div id='" . $id . "' class='panel-collapse collapse'>
	    						<div class='panel-body'>";
				$tablestring .= $text;
				$tablestring .="</div>
				    				</div>
				  						</div>
								";
				
				$previousid = $id;
				$i++;
			
		}
		
			$tablestring .= "</div>";
			
			return $tablestring;
	}
	
	
	/**
	 * 
	 * Finds the article with the given id, then creates an object with its values.
	 * 
	 * @param integer $id
	 * @return news
	 */
	public static function readArticle ($id) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.position,
					u.ordering,
					u.audience,
					u.title,
					u.text,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified,
					u.site
					FROM sv_news u
        			WHERE id = ?;";
		
		$params = array();
		$params[] = $id;
		
		$result = $db->query ($query,$params);
		
		$row = $result->fetchAssoc();
		
		$article = new news();
		
		$article->setId($row['id']);
		
		$article->setPosition($row['position']);

		$article->setOrdering($row['ordering']);
		
		$article->setAudience($row['audience']);
		
		$article->setTitle($row['title']);
		
		$article->setText($row['text']);
				
		$article->setStatus($row['status']);
		
		$article->setAuthor($row['author_id']);
		
		$article->setCreatedOn($row['created_on']);
		
		$article->setLastModified($row['last_modified']);
		
		$article->setSite($row['site']);
		
		return $article;
	}
	
	/**
	 * 
	 * Sets the current object`s id
	 * 
	 * @param integer $id
	 */
	public function setId ($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 * Returns current object`s id
	 * 
	 */
	public function getId () {
		return $this->id;
	}
	
	/**
	 *
	 * Sets the current object`s audience
	 *
	 * @param integer $audience
	 */
	public function setAudience ($audience) {
		$this->audience = $audience;
	}
	
	/**
	 *
	 * Returns current object`s audience
	 *
	 */
	public function getAudience () {
		return $this->audience;
	}

	/**
	 *
	 * Sets the current object`s position
	 *
	 * @param integer $position
	 */
	public function setPosition ($position) {
		$this->position = $position;
	}

	/**
	 *
	 * Returns current object`s position
	 *
	 */
	public function getPosition () {
		return $this->position;
	}

	/**
	 *
	 * Sets the current object`s ordering
	 *
	 * @param integer $ordering
	 */
	public function setOrdering ($ordering) {
		$this->ordering = $ordering;
	}

	/**
	 *
	 * Returns current object`s ordering
	 *
	 */
	public function getOrdering () {
		return $this->ordering;
	}

	/**
	 *
	 * Sets the current object`s title
	 *
	 * @param string $title
	 */
	public function setTitle ($title) {
		$this->title = $title;
	}

	/**
	 *
	 * Returns current object`s title
	 *
	 */
	public function getTitle () {
		return $this->title;
	}

	/**
	 *
	 * Sets the current object`s text
	 *
	 * @param string $text
	 */
	public function setText ($text) {
		$this->text = $text;
	}

	/**
	 *
	 * Returns current object`s text
	 *
	 */
	public function getText () {
		return $this->text;
	}

	/**
	 *
	 * Sets the current object`s created_on date
	 *
	 * @param datetime $created_on
	 */
	public function setCreatedOn ($created_on) {
		$this->created_on = $created_on;
	}
	
	/**
	 *
	 * Returns current object`s created on date
	 *
	 */
	public function getCreatedOn () {
		return $this->created_on;
	}

	/**
	 *
	 * Sets the current object`s status
	 *
	 * @param string $status
	 */
	public function setStatus ($status) {
		$this->status = $status;
	}

	/**
	 *
	 * Returns current object`s status
	 *
	 */
	public function getStatus () {
		return $this->status;
	}

	/**
	 *
	 * Sets the current object`s author
	 *
	 * @param integer $author
	 */
	public function setAuthor ($author) {
		$this->author = $author;
	}

	/**
	 *
	 * Returns current object`s author
	 *
	 */
	public function getAuthor () {
		return $this->author;
	}

	/**
	 *
	 * Sets the current object`s last modified date
	 *
	 * @param integer $lastmodified
	 */
	public function setLastModified ($lastmodified) {
		$this->lastmodified = $lastmodified;
	}

	/**
	 *
	 * Returns current object`s last modified date
	 *
	 */
	public function getLastModified () {
		return $this->lastmodified;
	}
	
	/**
	 *
	 * Sets the current object`s site
	 *
	 * @param string $site
	 */
	public function setSite ($site) {
		$this->site= $site;
	}

	/**
	 *
	 * Returns current object`s site
	 *
	 */
	public function getSite () {
		return $this->site;
	}
	
	public static function findOrdering ($id) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			n.ordering ordering
					FROM sv_news n
        			WHERE id = ?;";
		
		$params = array();
		$params[] = $id;
		
		$result = $db->query ($query,$params);
		
		$row = $result->fetchAssoc();
		 
		$ordering = $row['ordering'];
		 
		return $ordering;
		
	}
	
	public static function findStatus ($id) {
		$db = svdb::getInstance ();
	
		$query = "	SELECT
        			n.status status
					FROM sv_news n
        			WHERE id = ?;";
	
		$params = array();
		$params[] = $id;
		
		$result = $db->query ($query,$params);
	
		$row = $result->fetchAssoc();
			
		$status = $row['status'];
			
		return $status;
	
	}
	
	public static function findPosition ($id) {
		$db = svdb::getInstance ();
	
		$query = "	SELECT
        			n.position pos
					FROM sv_news n
        			WHERE id = ?;";
	
		$params = array();
		$params[] = $id;
		
		$result = $db->query ($query,$params);
	
		$row = $result->fetchAssoc();
			
		$position = $row['pos'];
			
		return $position;
	
	}
	
	public static function findArticleAbove ($ordering, $position) {
		$db = svdb::getInstance ();

		$query = "SELECT MAX(ordering) FROM sv_news WHERE ordering < ? AND position = ?;";
		
		$params = array();
		$params[] = $ordering;
		$params[] = $position;
		
		$result = $db->query ($query,$params);
		
		$row = $result->fetchAssoc();
			
		$ordering = $row['MAX(ordering)'];
			
		return $ordering;
	}
	
	public static function findArticleBelow ($ordering, $position) {
		$db = svdb::getInstance ();
		
		$query = "SELECT MIN(ordering) FROM sv_news WHERE ordering > ? AND position = ?;";
		
		$params = array();
		$params[] = $ordering;
		$params[] = $position;
		
		$result = $db->query ($query,$params);
		
		$row = $result->fetchAssoc();
			
		$ordering = $row['MIN(ordering)'];
			
		return $ordering;
		
	}
	
	public static function moveArticle ($id,$direction) {
		$db = svdb::getInstance ();
				
		$db->startTrans();
		
		try{
			
			$orderingOriginal = self::findOrdering($id);
			
			$position = self::findPosition($id);
			
			if ($direction == "up"){
				$orderingNew = self::findArticleAbove($orderingOriginal, $position);
			} else if ($direction == "down"){
				$orderingNew = self::findArticleBelow($orderingOriginal, $position);
			} else{
				throw new Exception ('No direction given');
			}
			
			$query2 = "	UPDATE sv_news
	        			SET ordering = ?
	        			WHERE ordering = ?;";
			
			$params = array();
			$params[] = $orderingOriginal;
			$params[] = $orderingNew;
			
			$db->execSQLCmd($query2,$params);
			
			$query3 = "	UPDATE sv_news
	        			SET ordering = ?
	        			WHERE id = ?;";
			
			$params = array();
			$params[] = $orderingNew;
			$params[] = $id;
			
			$db->execSQLCmd($query3,$params);
			
			$db->commit();
			
		} catch (Exception $e){
			$db->rollback();
			throw $e;
		}
		
				
	}
	
	public static function deleteArticle ($id) {
		$db = svdb::getInstance ();
		
		$query = "	UPDATE sv_news
        			SET status = 'deleted'
        			WHERE id = ?;";
		
		$params = array();
		$params[] = $id;
		
		$db->execSQLCmd($query,$params);
	}
	
	public static function toggleHide ($id) {
		$db = svdb::getInstance ();
	
		if (self::findStatus($id)== "active"){
			$query = "	UPDATE sv_news
        			SET status = 'hidden'
        			WHERE id = ?;";
		} else {
			$query = "	UPDATE sv_news
        			SET status = 'active'
        			WHERE id = ?;";
		}
	
		$params = array();
		$params[] = $id;
		
		$db->execSQLCmd($query,$params);
	}
	
	private static function ajustOrdering ($gap) {
		$db = svdb::getInstance ();
		
		$query = "	UPDATE sv_news
        			SET	ordering = ordering - 1
        			WHERE ordering > ?;";
		
		$params = array();
		$params[] = $gap;
		
		$db->execSQLCmd($query,$params);
	}
	
	public static function editArticle ($id,$position,$audience,$title = null,$text = null,$status) {
		$db = svdb::getInstance ();
		
		$oldpos = self::findPosition($id);
		
		if ($oldpos == $position){
			$ordering = self::findOrdering ($id);
		}else {
			$ordering = ($db->maxValue ( "ordering", "sv_news" )) + 1;
			$oldorder = self::findOrdering ($id);
		}
		
		$now = new DateTime ();
		$last_modified = $now->format ( 'Y-m-d H:i:s' );
		
		$query = "	UPDATE sv_news
        			SET
					position = ?,
					ordering = ?,
					audience = ?,
					title = ?,
					text = ?,
					status = ?,
					last_modified = ?
        			WHERE id = ?;";
		
		$params = array();
		$params[] = $position;
		$params[] = $ordering;
		$params[] = $audience;
		$params[] = $title;
		$params[] = $text;
		$params[] = $status;
		$params[] = $last_modified;
		$params[] = $id;
		
		$db->execSQLCmd($query,$params);
		
		if ($oldpos != $position){
				self::ajustOrdering($oldorder);
		}
	}
}