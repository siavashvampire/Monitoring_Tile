<?php


namespace paymentCms\component\menu;


/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/25/2019
 * Time: 11:14 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/25/2019 - 11:14 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class menu {

	private static $menu = [] ;
	private static $checkAccess = true ;
	private static $menuKeys = [];
	private static $menuFatherKeys = [];
	private $menuTitle = [];
	public function __construct($title) {
		$this->menuTitle = $title ;
	}

	public static function checkAccess(){
		self::$checkAccess  = true ;
	}

	public static function forceStopCheckAccess(){
		self::$checkAccess  = false ;
	}

	/**
	 * @param $title
	 *
	 * @return array
	 */
	public function getMenu($title) {
		if ( ! self::$checkAccess )
			return self::$menu[$title];

		return array_filter(
			self::$menu[$title] ,
			function ($e) use (&$searchedValue) {
                /* @var \paymentCms\component\menu\menuItem $e*/
			    if ( $e->getChild() != null ) {
                    $allMenu = self::getMenu($e->getChild());
                    if ( $allMenu != null or count($allMenu) > 0)
                        return  true;
                    return false;
                } else
				return $e->isHasAccess() == true;
			}
		);
	}

	public function add($key , $title,$link = '#',$icon = null,$target = '' , $fatherKey = null , $accessSpace = null){
		if ( $fatherKey == null )
			$fatherKey = $this->menuTitle ;
		else
			$fatherKey = $this->generateChildName($fatherKey);

		if ( isset(self::$menuKeys[$fatherKey][$key]))
			return ;

		$hasAccess = $this->hasAccess($accessSpace);
		$menuItem = $this->creatMenuItem($key,$title,$link,$icon ,$target,$hasAccess);
		self::$menu[$fatherKey][] = $menuItem ;
		self::$menuFatherKeys[$key] = $fatherKey ;
		self::$menuKeys[$fatherKey][$key] = count(self::$menu[$fatherKey]) - 1 ;
	}

	public function after($afterKey ,$key , $title,$link = '#',$icon = null,$target = '', $fatherKey = null,$accessSpace=null){
		if ( $fatherKey == null )
			$fatherKey = $this->menuTitle ;
		else
			$fatherKey = $this->generateChildName ($fatherKey) ;

		if ( ! isset(self::$menuKeys[$fatherKey][$afterKey]))
			return ;

		$hasAccess = $this->hasAccess($accessSpace);
		$menuItem = $this->creatMenuItem($key,$title,$link,$icon ,$target,$hasAccess);
		array_splice(self::$menu[$fatherKey] ,self::$menuKeys[$fatherKey][$afterKey]+1 , 0 , [$menuItem] );
		foreach ( self::$menuKeys[$fatherKey] as $menuKey => $value )
			if ( $value > self::$menuKeys[$fatherKey][$afterKey] )
				self::$menuKeys[$fatherKey][$menuKey]++;
		self::$menuKeys[$fatherKey][$key] = self::$menuKeys[$fatherKey][$afterKey]+ 1 ;
		self::$menuFatherKeys[$key] = $fatherKey ;
	}

	public function before($beforeKey ,$key , $title,$link = '#',$icon = null,$target = '', $fatherKey = null,$accessSpace=null){
		if ( $fatherKey == null )
			$fatherKey = $this->menuTitle ;
		else
			$fatherKey = $this->generateChildName ($fatherKey) ;

		if ( ! isset(self::$menuKeys[$fatherKey][$beforeKey]))
			return ;

		$hasAccess = $this->hasAccess($accessSpace);
		$menuItem = $this->creatMenuItem($key,$title,$link,$icon ,$target,$hasAccess);
		array_splice(self::$menu[$fatherKey] ,self::$menuKeys[$fatherKey][$beforeKey]  , 0 , [$menuItem] );
		self::$menuKeys[$fatherKey][$key] = self::$menuKeys[$fatherKey][$beforeKey] ;
		self::$menuFatherKeys[$key] = $fatherKey ;
		foreach ( self::$menuKeys[$fatherKey] as $menuKey => $value )
			if ( $value >= self::$menuKeys[$fatherKey][$beforeKey] )
				self::$menuKeys[$fatherKey][$menuKey]++;

	}

	public function addChild($fatherKey , $key , $title,$link = '#',$icon = null,$target = '',$accessSpace=null){

	    if ( ! isset(self::$menuFatherKeys[$fatherKey]))
			return ;
		$fatherKeyOfFather = self::$menuFatherKeys[$fatherKey] ;
        $fatherKeyObject = $this->generateChildName ($fatherKey) ;

        self::$menuFatherKeys[$key] = $fatherKeyObject ;

		$hasAccess = $this->hasAccess($accessSpace);

		$menuItem = $this->creatMenuItem($key,$title,$link,$icon ,$target,$hasAccess);
		$childKeyName = $this->generateChildName ($fatherKey) ;
		if ( isset(self::$menuKeys[$childKeyName][$key]))
			return ;
		self::$menu[$childKeyName][] = $menuItem ;

		if (  self::$menu[$fatherKeyOfFather][ self::$menuKeys[$fatherKeyOfFather][$fatherKey] ] != null )
            self::$menu[$fatherKeyOfFather][ self::$menuKeys[$fatherKeyOfFather][$fatherKey] ] ->setChild($childKeyName) ;
		self::$menuKeys[$childKeyName][$key] = count(self::$menu[$childKeyName]) - 1 ;
	}

	private function creatMenuItem($key , $title,$link = '#',$icon = null,$target = '',$hasAccess=true){
	    $menuItem = new menuItem();
		$menuItem->setKey($key);
		$menuItem->setTitle($title);
		$menuItem->setLink($link);
		$menuItem->setIcon($icon);
		$menuItem->setTarget($target);
		$menuItem->setHasAccess($hasAccess);
		return $menuItem ;
	}

	private function generateChildName ($fatherKey) {
		return 'Temp_'.md5($fatherKey) ;
	}

	private  function hasAccess($accessSpace){
		$hasAccess = true ;
		if ( $accessSpace !== null and (\App::appsListWithConfig('user'))['user']['status'] == 'active'){
			if ( is_string($accessSpace) and ! is_array($accessSpace) ){
				$accessSpace = explode('/', $accessSpace);
			}
			if ( ! isset($accessSpace[0]) )
				$accessSpace[0] = null ;
			if ( ! isset($accessSpace[1]) )
				$accessSpace[1] = null ;
			if ( ! isset($accessSpace[2]) )
				$accessSpace[2] = null ;
			if ( ! isset($accessSpace[3]) )
				$accessSpace[3] = null ;
			$hasAccess = \App\user\app_provider\api\checkAccess::forMenu($accessSpace[0],$accessSpace[1],$accessSpace[2],$accessSpace[3]);
		}
		return $hasAccess ;
	}
}