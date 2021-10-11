<?php


namespace App\invoice\app_provider\user;


use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\component\validate;
use paymentCms\model\api;
use paymentCms\model\invoice;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 10:15 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/24/2019 - 10:15 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class invoices extends controller {
	public function index($invoiceId){

		/* @var \App\invoice\model\invoice $invoice */
		$invoice = $this->model('invoice' , $invoiceId);
		if ( $invoice->getInvoiceId() == null or $invoice->getUserId() != user::getUserLogin(true) ){
			$this->mold->offAutoCompile();
			httpErrorHandler::E404();
			return ;
		}
		$servicesId = [];
		$items = $invoice->search($invoice->getInvoiceId(),'invoiceId = ?' ,'items' );
		if ( is_array($items) )
			$servicesId = array_column($items, 'serviceId');

		$transactions = $invoice->search($invoice->getInvoiceId(),'invoiceId = ?' ,'transactions' );

		$allFields['result'] = [];
		foreach ( $servicesId as $servicesIdOne ) {
			$allField = fieldService::showFilledOutForm($servicesIdOne, 'service', $invoice->getInvoiceId(), 'invoice');
			$allFields['result'] = array_merge($allFields['result'] , (array) $allField['result']);
		}

		$module = parent::callHooks('invoiceGateWays') ;
		$client  = user::getUserById($invoice->getUserId());
		$this->mold->set('client' , $client);
		$this->mold->set('invoiceLink' , \App\invoice\app_provider\api\invoice::generateUrlEncode($invoice->getInvoiceId()));
		$this->mold->set('module' , $module);
		$this->mold->set('invoice' , $invoice->returnAsArray());
		$this->mold->set('items' , $items);
		$this->mold->set('transactions' , $transactions);
		$this->mold->set('allFields' , $allFields['result']);
		$this->mold->path('default', 'invoice');
		$this->mold->view('invoiceClient.mold.html');
		$this->mold->setPageTitle(rlang('invoice'));
		$this->mold->set('hideSlideBar' , 1);
	}
	public function lists($status = 'all') {
		$get = request::post('page=1,perEachPage=25' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
		if ($valid->isFail()){
			$get['page'] = 1 ;
			$get['perEachPage'] = 25 ;
		}

		$model = parent::model('invoice');
		$numberOfAll = ($model->search( [user::getUserLogin(true)]  , 'userId = ? ' , null, 'COUNT(invoiceId) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search = $model->search( [user::getUserLogin(true)]  , 'userId = ? '  , null, '*'  , ['column' => 'invoiceId' , 'type' =>'desc'] , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'invoice');
		$this->mold->view('invoiceListClient.mold.html');
		$this->mold->setPageTitle(rlang('invoices'));
		$this->mold->set('activeMenu' , 'invoices');
		$this->mold->set('invoices' , $search);
	}

}