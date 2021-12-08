<?php

namespace App\product\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\fieldService;
use App\product\model\carton_size;
use App\product\model\carton_theme;
use App\product\model\pallet_size;
use App\product\model\product_body;
use App\product\model\product_carton;
use App\product\model\product_color;
use App\product\model\product_complementary_printing_after_digital;
use App\product\model\product_complementary_printing_before_digital;
use App\product\model\product_cylinder;
use App\product\model\product_decor;
use App\product\model\product_degree;
use App\product\model\product_digitalPrint_color;
use App\product\model\product_effect;
use App\product\model\product_engobe;
use App\product\model\product_glaze;
use App\product\model\product_kind;
use App\product\model\product_pallet;
use App\product\model\product_plastic;
use App\product\model\product_punch;
use App\product\model\product_size;
use App\product\model\product_technique;
use App\product\model\product_template;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product extends innerController
{
    public static function size(): array
    {
        /** @var product_size $model */
        $model = parent::model(['product', 'product_size']);
        return self::json($model->getItems());
    }

    public static function color(): array
    {
        /** @var product_color $model */
        $model = parent::model(['product', 'product_color']);
        return self::json($model->getItems());
    }

    public static function digitalPrint_color(): array
    {
        /** @var product_digitalPrint_color $model */
        $model = parent::model(['product', 'product_digitalPrint_color']);
        return self::json($model->getItems());
    }

    public static function digitalPrint_color_with_value($id = null): array
    {
        $_SERVER['JsonOff'] = true;
        $allField = fieldService::showFilledOutForm(1, 'product_digitalPrint_color', $id, 'color_data')["result"];
        unset($_SERVER['JsonOff']);
        $temp = array();
        foreach ($allField as $key => $field) {
            $temp[$key]['label'] = $field["title"];
            if ($field["value"])
                $temp[$key]['value'] = $field["value"];
            else
                $temp[$key]['value'] = 0.00;
        }
        return self::json($temp);
    }

    public static function digitalPrint_color_insert($id, $colors_weight)
    {
        $_SERVER['JsonOff'] = true;
        $resultUpdateField = fieldService::getFieldsToEdit(1, 'product_digitalPrint_color');
        unset($_SERVER['JsonOff']);

        $temp = array();
        foreach ($resultUpdateField as $key => $field) {
            $temp[$field['fieldId']] = (string)$colors_weight[$key];
        }
        fieldService::updateFillOutForm(1, 'product_digitalPrint_color', $temp, $id, 'color_data');

    }

    public static function body(): array
    {
        /** @var product_body $model */
        $model = parent::model(['product', 'product_body']);
        return self::json($model->getItems());
    }

    public static function decor(): array
    {
        /** @var product_decor $model */
        $model = parent::model(['product', 'product_decor']);
        return self::json($model->getItems());
    }

    public static function degree(): array
    {
        /** @var product_degree $model */
        $model = parent::model(['product', 'product_degree']);
        return self::json($model->getItems());
    }

    public static function degree_with_value($id = null): array
    {
        $_SERVER['JsonOff'] = true;
        $allField = fieldService::showFilledOutForm(1, 'product_degree', $id, 'degree_data')["result"];
        unset($_SERVER['JsonOff']);
        $temp = array();
        foreach ($allField as $key => $field) {
            $temp[$key]['label'] = $field["title"];
            if (isset($field["value"]))
                $temp[$key]['value'] = $field["value"];
            else
                $temp[$key]['value'] = 0.00;
        }
        return self::json($temp);
    }

    public static function degree_insert($id, $colors_weight)
    {
        $_SERVER['JsonOff'] = true;
        $resultUpdateField = fieldService::getFieldsToEdit(1, 'product_degree');
        unset($_SERVER['JsonOff']);

        $temp = array();
        foreach ($resultUpdateField as $key => $field) {
            $temp[$field['fieldId']] = (string)$colors_weight[$key];
        }
        fieldService::updateFillOutForm(1, 'product_degree', $temp, $id, 'degree_data');
    }

    public static function effect(): array
    {
        /** @var product_effect $model */
        $model = parent::model(['product', 'product_effect']);
        return self::json($model->getItems());
    }

    public static function glaze(): array
    {
        /** @var product_glaze $model */
        $model = parent::model(['product', 'product_glaze']);
        return self::json($model->getItems());
    }

    public static function glazeChild(): array
    {
        /** @var product_glaze $model */
        $model = parent::model(['product', 'product_glaze']);
        $value = array();
        $variable = array();
        $value[] = 1;
        $variable[] = '?';
        $variable[] = 'item.parent is not NULL';
        return self::json($model->getItems($value, $variable));
    }

    public static function glazeByParent($parent): array
    {
        /** @var product_glaze $model */
        $model = parent::model(['product', 'product_glaze']);
        $value = array();
        $variable = array();
        $value[] = $parent;
        $variable[] = 'item.parent = ?';
        return self::json($model->getItems($value, $variable));
    }

    public static function glazeParents(): array
    {
        /** @var product_glaze $model */
        $model = parent::model(['product', 'product_glaze']);

        $value = array();
        $variable = array();
        $value[] = '1';
        $variable[] = '?';
        $variable[] = 'item.parent is Null';
        return self::json($model->getItems($value, $variable));
    }

    public static function glazeGroupList($id): array
    {
        /** @var product_glaze $model */
        $model = parent::model(['product', 'product_glaze'], $id);
        $value = array();
        $variable = array();
        $value[] = $model->getParent();
        $variable[] = 'item.parent = ?';
        return self::json($model->getItems($value, $variable));
    }

    public static function kind(): array
    {
        /** @var product_kind $model */
        $model = parent::model(['product', 'product_kind']);
        return self::json($model->getItems());
    }

    public static function punch(): array
    {
        /** @var product_punch $model */
        $model = parent::model(['product', 'product_punch']);
        return self::json($model->getItems());
    }

    public static function technique(): array
    {
        /** @var product_technique $model */
        $model = parent::model(['product', 'product_technique']);
        return self::json($model->getItems());
    }

    public static function template(): array
    {
        /** @var product_template $model */
        $model = parent::model(['product', 'product_template']);
        return self::json($model->getItems());
    }

    public static function engobe(): array
    {
        /** @var product_engobe $model */
        $model = parent::model(['product', 'product_engobe']);
        return self::json($model->getItems());
    }
    public static function cylinder(): array
    {
        /** @var product_cylinder $model */
        $model = parent::model(['product', 'product_cylinder']);
        return self::json($model->getItems());
    }
    public static function complementary_printing_before_digital(): array
    {
        /** @var product_complementary_printing_before_digital $model */
        $model = parent::model(['product', 'product_complementary_printing_before_digital']);
        return self::json($model->getItems());
    }
    public static function complementary_printing_after_digital(): array
    {
        /** @var product_complementary_printing_after_digital $model */
        $model = parent::model(['product', 'product_complementary_printing_after_digital']);
        return self::json($model->getItems());
    }
    public static function plastic(): array
    {
        /** @var product_plastic $model */
        $model = parent::model(['product', 'product_plastic']);
        return self::json($model->getItems());
    }
    public static function pallet(): array
    {
        /** @var product_pallet $model */
        $model = parent::model(['product', 'product_pallet']);
        return self::json($model->getItems());
    }
    public static function carton(): array
    {
        /** @var product_carton $model */
        $model = parent::model(['product', 'product_carton']);
        return self::json($model->getItems());
    }
    public static function carton_theme(): array
    {
        /** @var carton_theme $model */
        $model = parent::model(['product', 'carton_theme']);
        return self::json($model->getItems());
    }
    public static function carton_size(): array
    {
        /** @var carton_size $model */
        $model = parent::model(['product', 'carton_size']);
        return self::json($model->getItems());
    }
    public static function pallet_size(): array
    {
        /** @var pallet_size $model */
        $model = parent::model(['product', 'pallet_size']);
        return self::json($model->getItems());
    }
}