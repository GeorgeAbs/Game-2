<?php
class Db
{
	private $db;
	function __construct()
	{
		$this->db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
		mysqli_set_charset($this->db, "utf8");
	}
	public function returnFetchAll($query)
	{
		return mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC);
	}
	public function returnQuery($query)
	{
		return mysqli_query($this->db, $query);
	}
	public function noReturnQuery($query)
	{
		mysqli_query($this->db, $query);
	}
	public function returnJsonQuery($query)
	{
		return json_encode(mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC));
	}
}