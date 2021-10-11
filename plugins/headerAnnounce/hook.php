<?php


namespace plugin\headerAnnounce;


use App\invoice\app_provider\api\invoice;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\model\configuration;
use pluginController;
use function Sodium\increment;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/26/2019
 * Time: 3:20 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/26/2019 - 3:20 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {


	public function _controllerStartToRun(){
		$link = $this->setting('link' , 'headerAnnounce');
		$bgImage = $this->setting('bgImage' , 'headerAnnounce');
		$title = $this->setting('title' , 'headerAnnounce');
		$height = $this->setting('height' , 'headerAnnounce');
		if ( $bgImage != '' ){
			$this->mold->set('linkAnnounce' , $link);
			$this->mold->set('bgImageAnnounce' , $bgImage);
			$this->mold->set('titleAnnounce' , $title);
			$this->mold->set('heightAnnounce' , $height);
			$this->mold->view('headet.headerAnnounce.mold.html');
		}
		return true ;
	}

}