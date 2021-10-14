<?php
namespace App\LineMonitoring\app_provider\admin;

use app;
use App\LineMonitoring\app_provider\api\sensor;
use App\LineMonitoring\app_provider\api\phases;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\diagrams;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\file;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\strings;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class diagram extends controller {
	public function index( $status = null ) {
		if ( $status == 'insertDone')
			$this->alert('success', '', 'نقشه با موفقیت اضافه شد.');
		elseif ( $status == 'updateDone')
			$this->alert('success', '', 'نقشه با موفقیت ویرایش شد.');

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('listDiagram.mold.html');
		$this->mold->setPageTitle('نقشه کارخانه');
		$this->mold->set('activeMenu' , 'diagramSetting');

		/* @var diagrams $diagram */
		$diagram = parent::model('diagrams');
		$search = $diagram->search( array()  ,  null  , null, '*'  , ['column' => 'diagramId' , 'type' =>'asc'] );
		$this->mold->set('diagrams' , $search);
	}
	public function setup( $diagramID = null ){
		if ( request::isPost('name') ){
			$this->mold->set('sensorSelectPost' , $_POST['sensorSelect']);
			$data = request::post('name,picture,sensorLocation');
			$rules = [
				"name" => ["required", 'نام دیاگرام'],
				"sensorLocation" => ["required", 'سنسوری تنظیم نشده است!'],
				];
			$valid = validate::check($data, $rules);
			if ($valid->isFail()) {
				$this->alert('danger','',$valid->errorsIn());
			} else {
				/* @var diagrams $diagram */
				if ( $diagramID == null )
					$diagram = parent::model('diagrams');
				else
					$diagram = parent::model('diagrams' , $diagramID);

				$diagram->setName($data['name']);
				$diagram->setDiagram($data['sensorLocation']);

				$fileData = request::file('picture') ;
				if ( $fileData['size'] > 0 ) {
					$fileStatus = $this->uploadFile($fileData);
					if ($fileStatus[0]) {
						$diagram->setPictureName($fileStatus[1]);
						if ($diagramID == null) {
							if ($diagram->insertToDataBase()) {
								Response::redirect(app::getBaseAppLink('diagram/insertDone', 'admin'));
								return null;
							}else {
								$this->alert('danger', '', 'در ثبت دیاگرام مشکلی پیش آمده است!');
							}
						} else {
							if ($diagram->upDateDataBase()) {
								Response::redirect(app::getBaseAppLink('diagram/updateDone', 'admin'));
								return null;
							}else {
								$this->alert('danger', '', 'در ویرایش دیاگرام مشکلی پیش آمده است!');
							}
						}
					} else {
						$this->alert('danger', '', $fileStatus[1]);
					}
				} elseif ( $fileData['size'] == 0 and $diagram->getDiagramId() != null ) {
					if ($diagram->upDateDataBase()) {
						Response::redirect(app::getBaseAppLink('diagram/updateDone', 'admin'));
						return null;
					}else {
						$this->alert('danger', '', 'در ویرایش دیاگرام مشکلی پیش آمده است!');
					}
				} else {
					$this->alert('danger', '', 'فایل آپلود شده معتبر نمی باشد!');
				}
			}
		}
		/* @var diagrams $diagram */
        if ( $diagramID == null )
			$diagram = parent::model('diagrams');
		else {
			$diagram = parent::model('diagrams', $diagramID);
			if ( ! request::isPost('sensorSelect') ) {
				$sensors = array_keys($diagram->getDiagram());
				$variable[] = ' item.id IN ( ' . substr(str_repeat('? ,', count($sensors)), 0, -1) . ')';
				$search = sensor::index($sensors,$variable,-1,-1)["result"];
				$this->mold->set('sensorSelectPost' , $search);
			}
			$this->mold->set('diagram' , $diagram);
		}
        
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('setupDiagram.mold.html');
		$this->mold->setPageTitle('نقشه کارخانه');

        $this->mold->set('units' , units::index()["result"]);

        $this->mold->set('phases', phases::index()["result"]);
	}
    public function s($diagramID = null  , $name = null){
		if ( $diagramID == null ){
			/* @var diagrams $diagram */
			$diagram = parent::model('diagrams', $diagramID);
			$search = $diagram->search( array()  ,  null  , null, '*'  , ['column' => 'diagramId' , 'type' =>'asc'] ,[0,1]);
			if ( $search === true ){
				Response::redirect(app::getBaseAppLink('diagram', 'admin'));
				return null;
			} else {
				Response::redirect(app::getBaseAppLink('diagram/s/'.$search[0]['diagramId'].'/' , 'admin').$search[0]['name'] );
				return null;
			}

		}
		/* @var diagrams $diagram */
		$diagram = parent::model('diagrams', $diagramID);
		if ( $diagram->getDiagramId() == null ){
			Response::redirect(app::getBaseAppLink('diagram', 'admin'));
			return null;
		}
		if ( $name != $diagram->getName()) {
			Response::redirect(app::getBaseAppLink('diagram/s/'.$diagramID.'/' , 'admin').$diagram->getName() );
			return null;
		}
        
		$search = $diagram->search( array()  ,  null  , null, '*'  , ['column' => 'name' , 'type' =>'asc'] );
		$this->mold->set('diagrams' , $search);
		$this->mold->set('diagram' , $diagram);
        
        $this->mold->set('RefreshTime' , $this->setting('DiagramRefreshTime'));

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('diagram.mold.html');
		$this->mold->setPageTitle('نقشه ' . $diagram->getName() );
		$this->mold->set('activeMenu' , 'diagrams');
	}
	public function getSensor($phase = 0 , $unitId = 0){
		/* @var data $model */
		$model = parent::model('data');
		$search = $model->search( [intval($phase) , intval($unitId) ]  ,  'phase = ?  and unit = ?'  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );

		$html = '<div class="form-group has-default" id="getSensor">
                                                    <select class="selectpicker" multiple id="sensorId" data-live-search="true" data-size="7" data-style="btn btn-outline-info btn-round text-{$float}" title="نام سنسور">
                                                    ';
		if ( $search !== true  and is_array($search)){
			foreach ($search as $oneSearch){
				$html .= '<option value="'.$oneSearch['id'].'"  >'.$oneSearch['label'].'</option>';
			}
		}
		$html .= '</select>
                                                </div>' ;
		$this->mold->offAutoCompile();
		show($html);
	}
	private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
	private function uploadFile($fileInput){
		$uploadStoragePath = app::getAppPath('storage/diagrams','LineMonitoring');
		file::make_folder($uploadStoragePath);

		$allowed_types = array(
			'image/jpeg', 'image/png'
		);

		if ($fileInput['error']!= UPLOAD_ERR_OK)
			return [false , 'در آپلود فایل مشکلی پیش آمده است! (' . $fileInput['error'] . ')'] ;

		$temporaryName = $fileInput['tmp_name'];
		$extension = file::ext_file($fileInput['name']);
		do {
			$name = strings::generateRandomString();
		} while(file_exists( $uploadStoragePath . DIRECTORY_SEPARATOR . $name . '.' . $extension ));

		if(! in_array($fileInput['type'], $allowed_types) or ! file::isImg($extension,["png", "jpg"]))
			return [false ,'فرمت فایل صحیح نمی باشد! ( '.$fileInput['type'] .' ) '];
		if ( move_uploaded_file($temporaryName, $uploadStoragePath . DIRECTORY_SEPARATOR . $name . '.' . $extension)){
			return [true , $name . '.' . $extension ];
		}

		return [false , 'امکان آپلود فایل نمی باشد!'];
	}
}