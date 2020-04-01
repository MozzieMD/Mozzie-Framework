<?php

namespace App;
class View
{
	private static $viewLocation;
	private static $cacheLocation;
	private static $viewName;
	static $tags = [
		'/@layout\((.*?)\)/' => '',
		'/{{(.*?)}}/' => '<?php echo $1; ?>',
		'/@dd(?<match>\((?:\g<match>|[^()]++)*\))/' => '<?php dd$1; ?>',
		'/@if(?<match>\((?:\g<match>|[^()]++)*\))/' => '<?php if$1: ?>',
		'/@foreach(?<match>\((?:\g<match>|[^()]++)*\))/' => '<?php foreach$1: ?>',
		'/@elseif(?<match>\((?:\g<match>|[^()]++)*\))/' => '<?php elseif$1: ?>',
		'/@else/' => '<?php else: ?>',
		'/@endif/' => '<?php endif; ?>',
		'/@endforeach/' => '<?php endforeach; ?>',
		'/@auth/' => '<?php if(App\Auth::check()): ?>',
		'/@endauth/' => '<?php endif; ?>',
		'/@input-token/' => '<input type="hidden" name="token" value="<?php echo App\Session::get("token"); ?>">'
	];
	
	public static function render( $viewname, $args = [] )
	{
		self::$viewName = $viewname;
		self::$viewLocation = __DIR__ . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR;
		self::$cacheLocation = self::$viewLocation . DIRECTORY_SEPARATOR . "cache";

		if (!empty($args)) {
			extract($args);
		}
		
		include self::cache(self::prepare());
		
		return true;
			
	}
	
	private static function cache($replaced){
		$hash = hash("ripemd160", $replaced);
		
		$filename = self::$cacheLocation .
			DIRECTORY_SEPARATOR . self::$viewName . $hash. ".php";
		
		if(!file_exists($filename)) {
			$file = self::$cacheLocation . DIRECTORY_SEPARATOR . self::$viewName . "*.php";
			foreach (glob($file) as $f) {
				unlink($f);
			}
			
			file_put_contents($filename, $replaced);
		}
		
		return $filename;
	}
	
	private static function prepare(){
		$view = file_get_contents(self::$viewLocation . self::$viewName . ".tpl");
		
		if (preg_match('/@layout\((.*?)\)/', $view, $matches)) {
			
			$layoutLocation = self::$viewLocation . "layouts" . DIRECTORY_SEPARATOR . $matches[ 1 ] . ".tpl";
			$layout = file_get_contents($layoutLocation);
			
			$vr = preg_replace(
				array_keys(self::$tags),
				array_values(self::$tags),
				$view
			);
			
			self::$tags[ "/@content/" ] = $vr;
			
			return preg_replace(
				array_keys(self::$tags),
				array_values(self::$tags),
				$layout
			);
		} else {
			return preg_replace(
				array_keys(self::$tags),
				array_values(self::$tags),
				$view
			);
		}
	}
}