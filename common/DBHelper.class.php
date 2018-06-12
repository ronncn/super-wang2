<?php
/*数据库助手*/
class DBHelper
{
	private $_dbms;				//数据库类型（默认mysql）
	private $_host;				//主机地址
	private $_port;				//端口号
	private $_user;				//用户名
	private $_password;			//密码
	private $_dbname;			//数据库
	private $db;			//数据库对象（PDO）
	private $error = '';		//最近的错误信息
	
	
	/*构造函数*/
	public function __construct($host,$user,$pwd,$dbname,$port=3306)
	{
		$this->set_db($host,$user,$pwd,$dbname,$port);
	}
	
	//获得数据库连接的PDO对象
	public function get_db()
	{
		//判断是否设置$db
        return self::$db;
	}
	
	//设置数据库连接的PDO对象
	public function set_db($host,$user,$pwd,$dbname,$port=3306)
	{
		if(!isset($host)||!isset($user)||!isset($pwd)||!isset($dbname))
		{
			return false;
		}
		else
		{
			$this->_dbms = "mysql";
			$this->_host = $host;
			$this->_port = $port;
			$this->_user = $user;
			$this->_password = $pwd;
			$this->_dbname = $dbname;
			$dsn = "$this->_dbms:host=$this->_host;dbname=$this->_dbname";//数据源
			try
			{
				$this->db = new PDO($dsn, $this->_user, $this->_password);//初始化一个PDO对象
				$this->db->exec("set names utf8");
			}
			catch(PDOException $e)
			{
				//输出错误
				$this->error = "Conntect Faile:".$e->getMessage();
			}
		}
	}
	
	// 执行sql
    public function query($sqlstr){
        $sth = $this->db->prepare($sqlstr);
		if($sth->execute())
		{
			return $sth;
		}
		else
		{
            $this->error = "SQL Query Failed.";
			return false;
		}
    }
	
	// 查询操作（返回全部的数据）
	public function select_all($table, $where = '', $field = '*')
	{
		$sql = "select {$field} from {$table} {$where}";
		$sth = $this->query($sql);
		if($sth)
		{
			$arr = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $arr;
		}
		else
		{
			return false;
		}
	}
	
	// 查询操作（返回第一条数据）
	public function select_one($table, $where = '', $field = '*')
	{
		$sql = "select {$field} from {$table} {$where} limit 1";
		$sth = $this->query($sql);
		if($sth)
		{
			$arr = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $arr[0];
		}
		else
		{
			return false;
		}
	}
	
	// 插入操作
	public function insert($table, $data)
	{
		$sqlset = $this->_doset($data);
		$sql = "insert into {$table} {$sqlset}";
		if(!$this->query($sql))
		{
			$id = -1;
		}
		else
		{
			$id = $this->db->lastInsertId();
		}
		return $id;
	}
	
	// 更新操作
	public function update($table, $data, $where = '')
	{
		$sqlset = $this->_doset($data);
		$sql = "update {$table} {$sqlset} {$where}";
		if($this->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// 删除操作
	public function deleted($table, $where)
	{
		if(is_null($where))
		{
			return;
		}
		$sql = "delete from {$table} {$where}";
		if($this->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// 查询数据的数量
	public function number($table, $where = '')
	{
		return count($this->select_all($table,$where));
	}
	
	/* ====================== 仅供内部调用 ====================== */
	//处理条件语句
	protected function _dowhere($where)
	{
		if (is_array($where)) {
			foreach ($where as $k => $v) {
				$k = str_ireplace('`', '', $k);
				if (is_array($v)) {
					$where_arr[] = "`{$k}` in('".implode("','", $v)."')";			
				}
				else {
					in_array($k, array('order by', 'group by')) ? ($sqlby = " {$k} {$v}") : ($where_arr[] = "`{$k}` = '{$v}'");
				}
			}
			$sqlwhere = is_array($where_arr) ? 'where '.implode($where_arr, ' and ').$sqlby : $sqlby;
		}
		else {
			$where && $sqlwhere = (stripos(trim($where), 'order by') === 0 or stripos(trim($where), 'group by') === 0) ? "{$where}" : "where 1 {$where}";
		}
		return $sqlwhere;
	}
	
	//处理设置语句
	protected function _doset($set)
	{
		//仅针对insert插入多条数据
		if (is_array($set) && count($set, 1) > count($set))
		{
			foreach ($set as $set_one) {
				$key_arr = $val_arr = array();
				foreach ($set_one as $k => $v) {
					$key_arr[] = str_ireplace('`', '', $k);
					$val_arr[] = "'{$v}'";
				}
				$val_str[] = "(" . implode($val_arr, ', ') . ")";
			}
			$key_str = "(" . implode($key_arr, ', ') . ")";
			$sqlset = "{$key_str}  values ".implode($val_str, ', ');
		}
		elseif (is_array($set) && count($set, 1) == count($set))
		{	
			foreach ($set as $k => $v) {
				$k = str_ireplace('`', '', $k);
				$set_arr[] = "`{$k}` = '{$v}'";
			}
			$sqlset = 'set '.implode($set_arr, ' , ');
		}
		else {
			$sqlset = "set {$set}";
		}
		return $sqlset;
	}
	
	
}