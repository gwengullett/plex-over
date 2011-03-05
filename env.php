<?php
//  Check environnement

class Environnement {
	
	public $php_vmin = 5.2;	
	/**
	 * __construct function.
	 */
	public function __construct()
	{
		$this->methods = array_slice(get_class_methods(__CLASS__), 3);
	}
	
	/**
	 * check function.
	 */
	public function check_all()
	{
		foreach ($this->methods as $method)
		{
			$valid->$method = $this->$method();
		}
		return $valid;
	}
	
	/**
	 * mreturn function.
	 */
	private function mreturn($msg = '', $bool = '')
	{
		$return->msg = $msg;
		$return->sta = $bool;
		
		return $return;
	}
	
	/**
	 * php_version function.
	 */
	public function php_version()
	{
		$this->php_v = phpversion();
		if ((float)$this->php_v < $this->php_vmin)
		{
			$output = 'Your php version is '.$this->php_v.', but minimum requirement is '.$this->php_vmin;
			$bool		= false;
		}
		else
		{
			$output = 'current is '.$this->php_v;
			$bool		= true;
		}
		return $this->mreturn($output, $bool);
	}
	
	/**
	 * mod_rewrite function.
	 */
	public function mod_rewrite()
	{
		$apache_v = apache_get_version();
		if (! $apache_v)
		{
			return $this->mreturn("Apache not installed: can't check mod_rewrite", 2);
		}
		$this->rewrite = in_array('mod_rewrite', apache_get_modules());
		$output = 'rewrite engine is ';
		$output .= ($this->rewrite) ? 'enabled' : 'disabled';
		
		return $this->mreturn($output, $this->rewrite);
	}
	
	/**
	 * short_tags function.
	 */
	public function short_open_tag()
	{
		$this->has_sot = ini_get('short_open_tag');
		$output = ($this->has_sot) ? "enabled" : "disabled";
		
		return $this->mreturn($output, $this->has_sot);
	}
	
	/**
	 * curl_ext function.
	 */
	public function php_curl()
	{
		$this->has_curl = function_exists('curl_init');
		
		if ($this->has_curl)
		{
			$version = curl_version();
			$output = "version ".$version['version'];
		}
		else
		{
			$output = "not";
		}
		
		return $this->mreturn($output.' installed', $this->has_curl);
	}

}
$env = new Environnement();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Plex over environnement checker</title>
		<style type="text/css">
			body {
			  text-shadow: 1px 1px 1px white;
			  background-color: #e1e1e1;
			  color: #666;
			 }
			div {
			  height: 300px;
			}
			.st span {
				color: red;
			}
			.st1 span {
				color: green;
			}
			</style>
	</head>
	<body>
		<h2>Plex over environnement checker</h2>
		<div id="results">
			<ul>
			<?php foreach ($env->check_all() as $key => $req): ?>
				<li class="st<?php echo $req->sta ?>">
					<strong><?php echo $key ?>:</strong>
					<span><?php echo $req->msg ?></span>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</body>
</html>


