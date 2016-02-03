<?php
class news {
	
	const leftPosValue = 1;
	const centerPosValue = 2;
	const rightPosValue = 3;
	const bottomPosValue = 4;
	
	private $id = NULL;
	private $audience = NULL;
	private $title = NULL;
	private $text = NULL;
	private $picture = NULL;
	private $picture_position = NULL;
	private $status = "active";
	private $author = NULL;	
	private $created_on = NULL;
	private $ordering = NULL;
	private $position = self::centerPosValue;
	private $last_modified = NULL;
	
	
	public static function getActiveArticles($position) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE position = " . $position . " AND status = 'active'
        			ORDER BY ordering ASC;";
		
		$result = $db->query ( $query );
		
		return $result;
	}
	
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
	
	private static function getAllArticles($position) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE position = " . $position . " AND (status = 'active' OR status = 'hidden')
        			ORDER BY ordering ASC;";
		
		$result = $db->query ( $query ); 
		
		return $result;
	}
	
	public static function createArticle($position, $audience, $title = null, $text = null, $status = "active") {
		$db = svdb::getInstance ();
		
		$ordering = ($db->maxValue ( "ordering", "sv_news" )) + 1;
		// $audience=
		// $title=
		// $text=
		$author_id = 1;
		// $status=
		$now = new DateTime ();
		$nowStr = $now->format ( 'Y-m-d H:i:s' );
		
		$cmd = "	INSERT INTO sv_news (position,ordering,audience,title,text,author_id,status,created_on,last_modified) values
					(" . $position . "," . $ordering . "," . $audience . ",'" . $title . "','" . $text . "'," . $author_id . ",'" . $status . "','" . $nowStr . "','" . $nowStr . "')";
		
		$result = $db->execSQLCmd ( $cmd );
	}
	
	public static function reviewArticlesTable ($position) {
		$tablestring = "";
		
		$tablestring .= "<div class='panel-group all-article-review' id='accordion" . $position . "'>";
		
		$result = self::getAllArticles($position);
		
		$num = $result->numRows();
		
		$previousid = null;
		
		while ($row = $result->fetchAssoc()){
		
			$id = $row ['id'];
			$title = $row['title'];
			$text = $row ['text'];
			$status = $row ['status'];
			
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
							<span class='pull-right'>
							<a onclick=\"buttonClick('moveUp', " . $id . ");\" title='Move up'><span class='glyphicon glyphicon-arrow-up'></span></a>
							<a onclick=\"buttonClick('moveDown', " . $id . ");\" title='Move down'><span class='glyphicon glyphicon-arrow-down'></span></a>
							<a onclick=\"buttonClick('edit', " . $id . ");\" title='Edit'><span class='glyphicon glyphicon-pencil'></span></a>
							<a onclick=\"buttonClick('toggleHide', " . $id . ");\" title='" . $statustitle . "'><span class='glyphicon " . $statuscircle . "'></span></a>
							<a onclick=\"buttonClick('delete', " . $id . ");\" title='Delete'><span class='glyphicon glyphicon-remove-circle'></span></a>
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
			
		}
		
		$tablestring .= "</div>";
		
		return $tablestring;
	}
	
	public static function readArticle ($id) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.position,
					u.ordering,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE id = " . $id . ";";
		
		$result = $db->query ( $query );
		
		$row = $result->fetchAssoc();
		
		$article = new news();
		
		$article->setId($row['id']);
		
		$article->setPosition($row['position']);

		$article->setOrdering($row['ordering']);
		
		$article->setAudience($row['audience']);
		
		$article->setTitle($row['title']);
		
		$article->setText($row['text']);
		
		$article->setPicture($row['picture']);
		
		$article->setPicturePosition($row['picture_position']);
		
		$article->setStatus($row['status']);
		
		$article->setAuthor($row['author_id']);
		
		$article->setCreatedOn($row['created_on']);
		
		$article->setLastModified($row['last_modified']);
		
		return $article;
	}
	
	public function setId ($id) {
		$this->id = $id;
	}
	
	public function getId () {
		return $this->id;
	}
	
	public function setAudience ($audience) {
		$this->audience = $audience;
	}
	
	public function getAudience () {
		return $this->audience;
	}
	
	public function setPosition ($position) {
		$this->position = $position;
	}
	
	public function getPosition () {
		return $this->position;
	}
	
	public function setOrdering ($ordering) {
		$this->ordering = $ordering;
	}
	
	public function getOrdering () {
		return $this->ordering;
	}
	
	public function setTitle ($title) {
		$this->title = $title;
	}
	
	public function getTitle () {
		return $this->title;
	}
	
	public function setText ($text) {
		$this->text = $text;
	}
	
	public function getText () {
		return $this->text;
	}
	
	public function setCreatedOn ($created_on) {
		$this->created_on = $created_on;
	}
	
	public function getCreatedOn () {
		return $this->created_on;
	}
	
	public function setStatus ($status) {
		$this->status = $status;
	}
	
	public function getStatus () {
		return $this->status;
	}
	
	public function setAuthor ($author) {
		$this->author = $author;
	}
	
	public function getAuthor () {
		return $this->author;
	}
	
	public function setLastModified ($lastmodified) {
		$this->lastmodified = $lastmodified;
	}
	
	public function getLastModified () {
		return $this->lastmodified;
	}
	
	public function setPicture ($picture) {
		$this->picture = $picture;
	}
	
	public function getPicture () {
		return $this->picture;
	}
	
	public function setPicturePosition ($picture_position) {
		$this->picture_position = $picture_position;
	}
	
	public function getPicturePosition () {
		return $this->picture_position;
	}
	
	public static function findOrdering ($id) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.ordering
					FROM sv_news u
        			WHERE id = " . $id . ";";
		
		$result = $db->query ( $query );
		
		$row = $result->fetchAssoc();
		 
		$ordering = $row['ordering'];
		 
		return $ordering;
		
	}
	
	public static function findStatus ($id) {
		$db = svdb::getInstance ();
	
		$query = "	SELECT
        			u.status
					FROM sv_news u
        			WHERE id = " . $id . ";";
	
		$result = $db->query ( $query );
	
		$row = $result->fetchAssoc();
			
		$status = $row['status'];
			
		return $status;
	
	}
	
	public static function findPosition ($id) {
		$db = svdb::getInstance ();
	
		$query = "	SELECT
        			u.position
					FROM sv_news u
        			WHERE id = " . $id . ";";
	
		$result = $db->query ( $query );
	
		$row = $result->fetchAssoc();
			
		$position = $row['position'];
			
		return $position;
	
	}
	
	public static function findArticleAbove ($ordering, $position) {
		$db = svdb::getInstance ();
		
	/*	$query = "	SELECT
        			u.id,
					u.position,
					u.ordering,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
					WHERE u.position = " . $position . " u.ordering = (SELECT MIN(u1.ordering)
										FROM sv_news u1
										WHERE ordering > " . $ordering . " AND position = " . $position . ";";
		*/
		$query = "SELECT MAX(ordering) FROM sv_news WHERE ordering < " . $ordering . " AND position = " . $position . ";";
		
		$result = $db->query ( $query );
		
		$row = $result->fetchAssoc();
			
		$ordering = $row['MAX(ordering)'];
			
		return $ordering;
	}
	
	public function findArticleBelow ($ordering, $position) {
			$db = svdb::getInstance ();
		
	/*	$query = "	SELECT
        			u.id,
					u.position,
					u.ordering,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
					WHERE u.position = " . $position . " u.ordering = (SELECT MIN(u1.ordering)
										FROM sv_news u1
										WHERE ordering > " . $ordering . " AND position = " . $position . ";";
		*/
		$query = "SELECT MIN(ordering) FROM sv_news WHERE ordering > " . $ordering . " AND position = " . $position . ";";
		
		$result = $db->query ( $query );
		
		$row = $result->fetchAssoc();
			
		$ordering = $row['MIN(ordering)'];
			
		return $ordering;
		
	}
	
	public static function moveArticle ($id,$direction) {
		$db = svdb::getInstance ();
		
		$query = "	SELECT
        			u.id,
					u.position,
					u.ordering,
					u.audience,
					u.title,
					u.text,
					u.picture,
					u.picture_position,
					u.author_id,
					u.status,
					u.created_on,
					u.last_modified
					FROM sv_news u
        			WHERE id = " . $id . ";";
		
		$db->startTrans();
		
		try{
			
			$result = $db->query($query);
			
			$row = $result->fetchAssoc();
			
			$orderingOriginal = $row['ordering'];
			
			if ($direction == "up"){
				$orderingNew = self::findArticleAbove($orderingOriginal, $row['position']);
			} else if ($direction == "down"){
				$orderingNew = self::findArticleBelow($orderingOriginal, $row['position']);
			} else{
				throw new Exception ('No direction given');
			}
			
			$query2 = "	UPDATE sv_news
	        			SET ordering = '" . $orderingOriginal . "'
	        			WHERE ordering = " . $orderingNew . ";";
			
			$db->execSQLCmd($query2);
			
			$query3 = "	UPDATE sv_news
	        			SET ordering = '" . $orderingNew . "'
	        			WHERE id = " . $id;
			
			$db->execSQLCmd($query3);
			
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
        			WHERE id = " . $id . ";";
		
		$db->execSQLCmd($query);
	}
	
	public static function toggleHide ($id) {
		$db = svdb::getInstance ();
	
		if (self::findStatus($id)== "active"){
			$query = "	UPDATE sv_news
        			SET status = 'hidden'
        			WHERE id = " . $id . ";";
		} else {
			$query = "	UPDATE sv_news
        			SET status = 'active'
        			WHERE id = " . $id . ";";
		}
	
		$db->execSQLCmd($query);
	}
	
	private static function ajustOrdering ($gap) {
		$db = svdb::getInstance ();
		
		$query = "	UPDATE sv_news
        			SET	ordering = ordering + 1,
        			WHERE ordering > " . $gap . ";";
		
		$db->execSQLCmd($query);
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
					position = " . $position . ",
					ordering = " . $ordering . ",
					audience = " . $audience . ",
					title = '" . $title . "',
					text = '" . $text . "',
					status = '" . $status . "',
					last_modified = '" . $last_modified . "'
        			WHERE id = " . $id . ";";
		
		$db->execSQLCmd($query);
		
		if ($oldpos != $position){
				self::ajustOrdering($oldorder);
		}
	}
}