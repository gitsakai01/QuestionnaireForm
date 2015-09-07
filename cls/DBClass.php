<?php

//-----------------------------------------//
//	クラス名	:DBClass
//	機能		:DB接続/切断/SQL発行etc
//-----------------------------------------//
class DBClass {

	private $_DSN = "mysql:host=localhost;dbname=recruit_db";
	private $_USR = "root";
	private $_PWD = "";
	private $_PDO;

	public function __construct(){
		try {
			$this->_PDO = new PDO($this->_DSN, $this->_USR, $this->_PWD);
			$this->_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	//Exception有効化
			$this->_PDO->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);	//MySQL
			$this->_PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} catch (PDOException $e) {
			throw new Exception("データベース接続エラー");
		}
	}

	public function Close() {
		$this->_PDO = null;
	}

	public function prepare($sql){
		return $this->_PDO->prepare($sql);
	}

	public function query($sql){
		return $this->_PDO->query($sql);
	}

	public function BeginTran() {

		if(!$this->_PDO->beginTransaction()){
			throw new Exception("トランザクション開始失敗。");
		}
	}

	public function CommitTran() {
		
		if(!$this->_PDO->commit()){
			throw new Exception("トランザクション終了失敗。");
		}
	}

	public function RollbackTran() {
		if(!$this->_PDO->rollBack()){
			throw new Exception("ロールバック失敗。");	
		}
	}
}

?>