<?php
namespace App\product\app_provider\api;

use App\api\controller\innerController;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class product extends innerController {
    public  static function size() {
        /** @var \App\product\model\product_size $model */
        $model = parent::model( ['product', 'product_size'] );
        return self::json( $model->getItems());
    }
    public  static function color() {
        /** @var \App\product\model\product_color $model */
        $model = parent::model( ['product', 'product_color'] );
        return self::json( $model->getItems());
    }
    public  static function body() {
        /** @var \App\product\model\product_body $model */
        $model = parent::model( ['product', 'product_body'] );
        return self::json( $model->getItems());
    }
    public  static function decor() {
        /** @var \App\product\model\product_decor $model */
        $model = parent::model( ['product', 'product_decor'] );
        return self::json( $model->getItems());
    }
    public  static function degree() {
        /** @var \App\product\model\product_degree $model */
        $model = parent::model( ['product', 'product_degree'] );
        return self::json( $model->getItems());
    }
    public  static function effect() {
        /** @var \App\product\model\product_effect $model */
        $model = parent::model( ['product', 'product_effect'] );
        return self::json( $model->getItems());
    }
    public  static function glaze() {
        /** @var \App\product\model\product_glaze $model */
        $model = parent::model( ['product', 'product_glaze'] );

        $value = array();
        $variable = array();
        $value[] = '1';
        $variable[] = 'item.parent is Null';
        return self::json( $model->getItems($value,$variable));
    }
    public  static function glazeByParent($parent) {
        /** @var \App\product\model\product_glaze $model */
        $model = parent::model( ['product', 'product_glaze'] );
        $value = array();
        $variable = array();
        $value[] = $parent;
        $variable[] = 'item.parent = ?';
        return self::json( $model->getItems($value,$variable));
    }
    public  static function glazeGroupList($id) {
        /** @var \App\product\model\product_glaze $model */
        $model = parent::model( ['product', 'product_glaze'] ,$id);
        $value = array();
        $variable = array();
        $value[] = $model->getParent();
        $variable[] = 'item.parent = ?';
        return self::json( $model->getItems($value,$variable));
    }
    public  static function kind() {
        /** @var \App\product\model\product_kind $model */
        $model = parent::model( ['product', 'product_kind'] );
        return self::json( $model->getItems());
    }
    public  static function punch() {
        /** @var \App\product\model\product_punch $model */
        $model = parent::model( ['product', 'product_punch'] );
        return self::json( $model->getItems());
    }
    public  static function technique() {
        /** @var \App\product\model\product_technique $model */
        $model = parent::model( ['product', 'product_technique'] );
        return self::json( $model->getItems());
    }
    public  static function template() {
        /** @var \App\product\model\product_template $model */
        $model = parent::model( ['product', 'product_template'] );
        return self::json( $model->getItems());
    }
    public  static function engobe() {
        /** @var \App\product\model\product_engobe $model */
        $model = parent::model( ['product', 'product_engobe'] );
        return self::json( $model->getItems());
    }
}