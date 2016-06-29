<?php
	
	function generate_tooken(){
		$tooken['tooken'] = uniqid(rand(), true);
		$tooken['time'] = time();
		$_SESSION['tooken'] = $tooken;
		
		destroy_tooken();
		
		setCookie("Rx6SCc8RHz8dSS4J",$tooken['tooken'], time()+Config::$tookenValidity);
		setCookie("lRkIXRVovWmrS8jj",$tooken['time'], time()+Config::$tookenValidity);
		
		return $tooken;
	}
	
	function validate_tooken($tooken = null){
		if($tooken == null){
			if(isset($_COOKIE['Rx6SCc8RHz8dSS4J']) && !empty($_COOKIE['Rx6SCc8RHz8dSS4J']) && (isset($_COOKIE['lRkIXRVovWmrS8jj']) && !empty($_COOKIE['lRkIXRVovWmrS8jj']))){
				$tooken['tooken'] = $_COOKIE['Rx6SCc8RHz8dSS4J'];
				$tooken['time'] = $_COOKIE['lRkIXRVovWmrS8jj'];
			}
		}
		
		if(is_array($tooken) && isset($tooken['tooken']) && isset($tooken['time'])){
			if($tooken['time'] >= (time() - Config::$tookenValidity)){
				if($tooken['tooken']==$_SESSION['tooken']['tooken'] && $tooken['time'] == $_SESSION['tooken']['time']){
					return Array(
						"success"=>true,
						"message"=>"Le jeton est valide."
					);
				}else{
					
				}
			}else{
				return Array(
					"success"=>false,
					"message"=>"Le jeton à expiré."
				);
			}
		}else{
			return Array(
				"success"=>false,
				"message"=>"Le jeton n'a pas de forme valide."
			);
		}
	}
	
	function destroy_tooken(){
		if(isset($_COOKIE['Rx6SCc8RHz8dSS4J']) || isset($_COOKIE['lRkIXRVovWmrS8jj'])){
			unset($_SESSION['tooken']);
			unset($_COOKIE["Rx6SCc8RHz8dSS4J"]);
			unset($_COOKIE["lRkIXRVovWmrS8jj"]);
			setcookie('Rx6SCc8RHz8dSS4J', null, -1, '/');
			setcookie('lRkIXRVovWmrS8jj', null, -1, '/');
			return true;
		}else{
			return false;
		}
	}

	
class Session
{
	public $session_time = 7200;//2 heures
	public $session = array();
	private $db;
	
	public function __construct()
	{
		
	}
	
	public function open()
	{
		$this->connect = DAO::connect();
		
		$this->gc();
		return true;
	}
	
	public function read($sid)
	{
		$sql = "SELECT sess_datas FROM session
				WHERE sess_id = :sid";
		
		$query = $this->connect->prepare($sql);
		$query->execute(array(
			"sid"=>$sid
		)) or exit(mysql_error());
		$data = $query->fetch();
		
		if(empty($data))
			return FALSE;
		else
			return $data['sess_datas'];
	}
	
	public function write($sid, $data)
	{
		$expire = intval(time() + $this->session_time);
		
		$sql = "REPLACE INTO session
			VALUES(:uid, :sid, :data, :expire)";
			
		$array = array(
			"uid"=>null,
			"sid"=>$sid,
			"data"=>$data,
			"expire"=>$expire
		);
		
		if(isset($_SESSION['user']))
			$array['uid'] = $_SESSION['user'];
			
		$query = $this->connect->prepare($sql);
		
		$query->execute($array) or exit(mysql_error());
		
		return true;
	}
	
	public function close()
	{
		return true;
	}
	
	public function destroy ($sid)
	{
		$sql = "DELETE FROM session
			WHERE sess_id = :sid ";
			
		$query = $this->connect->prepare($sql);
		
		$query->execute(array(
			"sid"=>$sid
		)) or exit(mysql_error());

		return true;
	}
	
	public function gc()
	{
		$sql = "DELETE FROM session
				WHERE sess_expire < :time";
				
		$query = $this->connect->prepare($sql);
		
		$query->execute(array(
			"time"=>time()
		)) or exit(mysql_error());
		
		return true;
	}
	
}

?>