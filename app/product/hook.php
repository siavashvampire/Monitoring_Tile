<?php

namespace App\product;

use app;
use App\product\model\carton_size;
use App\product\model\carton_theme;
use App\product\model\pallet_size;
use App\product\model\product_body;
use App\product\model\product_brand;
use App\product\model\product_carton;
use App\product\model\product_color;
use App\product\model\product_complementary_printing_after_digital;
use App\product\model\product_complementary_printing_before_digital;
use App\product\model\product_cylinder;
use App\product\model\product_decor;
use App\product\model\product_degree;
use App\product\model\product_effect;
use App\product\model\product_engobe;
use App\product\model\product_glaze;
use App\product\model\product_glue;
use App\product\model\product_kind;
use App\product\model\product_pallet;
use App\product\model\product_plastic;
use App\product\model\product_size;
use App\product\model\product_punch;
use App\product\model\product_strap;
use App\product\model\product_technique;
use App\product\model\product_template;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    private $appName = 'product';
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->addChild('configurationLine', 'product', 'کاشی‌ها', app::getBaseAppLink('product/list', 'admin'), 'fa fa-delicious', '', 'admin/product/list/product');
        $this->menu->addChild('configurationLine', 'product_size', 'سایز کاشی‌ها', app::getBaseAppLink('product_size', 'admin'), 'fa fa-compress', '', 'admin/product_size/index/product');
        $this->menu->addChild('configurationLine', 'product_glaze', 'لعاب ‌ها', app::getBaseAppLink('product_glaze', 'admin'), 'fa fa-file-image-o', '', 'admin/product_glaze/index/product');
        $this->menu->addChild('configurationLine', 'product_brand', 'برند ‌ها', app::getBaseAppLink('product_brand', 'admin'), 'fa fa-bold', '', 'admin/product_brand/index/product');
        $this->menu->addChild('configurationLine', 'product_punch', 'پانچ ‌ها', app::getBaseAppLink('product_punch', 'admin'), 'fa fa-chain-broken', '', 'admin/product_punch/index/product');
        $this->menu->addChild('configurationLine', 'product_color', 'رنگ ‌ها', app::getBaseAppLink('product_color', 'admin'), 'fa fa-paint-brush', '', 'admin/product_color/index/product');
        $this->menu->addChild('configurationLine', 'product_digitalPrint_color', 'رنگ های چاپ دیجیتال', app::getBaseAppLink('product_digitalPrint_color', 'admin'), 'fa fa-paint-brush', '', 'admin/product_digitalPrint_color/index/product');
        $this->menu->addChild('configurationLine', 'product_kind', 'نوع محصول', app::getBaseAppLink('product_kind', 'admin'), 'fa fa-tag', '', 'admin/product_kind/index/product');
        $this->menu->addChild('configurationLine', 'product_technique', 'تکنیک تولید', app::getBaseAppLink('product_technique', 'admin'), 'fa fa-cog', '', 'admin/product_technique/index/product');
        $this->menu->addChild('configurationLine', 'product_effect', 'افکت ها', app::getBaseAppLink('product_effect', 'admin'), 'fa fa-file-image-o', '', 'admin/product_effect/index/product');
        $this->menu->addChild('configurationLine', 'product_decor', 'دکور ها', app::getBaseAppLink('product_decor', 'admin'), 'fa fa-photo', '', 'admin/product_decor/index/product');
        $this->menu->addChild('configurationLine', 'product_degree', 'درجه ها', app::getBaseAppLink('product_degree', 'admin'), 'fa fa-sort-numeric-asc', '', 'admin/product_degree/index/product');
        $this->menu->addChild('configurationLine', 'product_template', 'قالب ها', app::getBaseAppLink('product_template', 'admin'), 'fa fa-object-ungroup', '', 'admin/product_template/index/product');
        $this->menu->addChild('configurationLine', 'product_glue', 'چسب ها', app::getBaseAppLink('product_glue', 'admin'), 'fa fa-flask', '', 'admin/product_glue/index/product');
        $this->menu->addChild('configurationLine', 'product_strap', 'تسمه ها', app::getBaseAppLink('product_strap', 'admin'), 'fa fa-link', '', 'admin/product_strap/index/product');
        $this->menu->addChild('configurationLine', 'product_engobe', 'انگوب ها', app::getBaseAppLink('product_engobe', 'admin'), 'fa fa-delicious', '', 'admin/product_engobe/index/product');
        $this->menu->addChild('configurationLine', 'product_body', 'بدنه ها', app::getBaseAppLink('product_body', 'admin'), 'fa fa-cube', '', 'admin/product_body/index/product');
        $this->menu->addChild('configurationLine', 'product_cylinder', 'سیلندر ها', app::getBaseAppLink('product_cylinder', 'admin'), 'fa fa-cube', '', 'admin/product_cylinder/index/product');
        $this->menu->addChild('configurationLine', 'product_complementary_printing_before_digital', 'چاپ مکمل قبل از دیجیتال', app::getBaseAppLink('product_complementary_printing_before_digital', 'admin'), 'fa fa-cube', '', 'admin/product_complementary_printing_before_digital/index/product');
        $this->menu->addChild('configurationLine', 'product_complementary_printing_after_digital', 'چاپ مکمل بعد از دیجیتال', app::getBaseAppLink('product_complementary_printing_after_digital', 'admin'), 'fa fa-cube', '', 'admin/product_complementary_printing_after_digital/index/product');
        $this->menu->addChild('configurationLine', 'product_plastic', 'پلاستیک ها', app::getBaseAppLink('product_plastic', 'admin'), 'fa fa-cube', '', 'admin/product_plastic/index/product');
        $this->menu->addChild('configurationLine', 'product_pallet', 'پالت ها', app::getBaseAppLink('product_pallet', 'admin'), 'fa fa-cube', '', 'admin/product_pallet/index/product');
        $this->menu->addChild('configurationLine', 'carton_theme', 'تم کارتون ها', app::getBaseAppLink('carton_theme', 'admin'), 'fa fa-cube', '', 'admin/carton_theme/index/product');
        $this->menu->addChild('configurationLine', 'carton_size', 'سایز کارتون ها', app::getBaseAppLink('carton_size', 'admin'), 'fa fa-cube', '', 'admin/carton_size/index/product');
        $this->menu->addChild('configurationLine', 'pallet_size', 'سایز پالت ها', app::getBaseAppLink('pallet_size', 'admin'), 'fa fa-cube', '', 'admin/pallet_size/index/product');
        $this->menu->addChild('configurationLine', 'product_carton', ' کارتون ها', app::getBaseAppLink('product_carton', 'admin'), 'fa fa-cube', '', 'admin/product_carton/index/product');
    }

    public function _fieldService_listOfTypes($vars2): array
    {
        return [
            ['type' => 'productSize', 'name' => 'سایز کاشی'],
            ['type' => 'productGlaze', 'name' => 'لعاب کاشی'],
            ['type' => 'productPunch', 'name' => 'پانچ کاشی'],
            ['type' => 'productBrand', 'name' => 'برند کاشی'],
            ['type' => 'productColor', 'name' => 'رنگ کاشی'],
            ['type' => 'productKind', 'name' => 'نوع محصول'],
            ['type' => 'productTemplate', 'name' => 'نوع محصول'],
        ];
    }

    public function _fieldService_showToFillOut_productSize($vars2)
    {
        $modelName = 'product_size';

        /* @var product_size $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();
        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productSize($fieldInformation = null)
    {
        $modelName = 'product_size';

        /** @var product_size $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productGlaze($vars2)
    {
        $modelName = 'product_glaze';

        /* @var product_glaze $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productGlaze($fieldInformation = null)
    {
        $modelName = 'product_glaze';

        /** @var product_glaze $model */
        $model = $this->model([$this->appName,$modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productPunch($vars2)
    {
        $modelName = 'product_punch';

        /* @var product_punch $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productPunch($fieldInformation = null)
    {
        $modelName = 'product_punch';

        /** @var product_punch $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productBrand($vars2)
    {
        $modelName = 'product_brand';
        /* @var product_brand $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productBrand($fieldInformation = null)
    {
        $modelName = 'product_brand';
        /** @var product_brand $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productColor($vars2)
    {
        $modelName = 'product_color';
        /* @var product_color $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productColor($fieldInformation = null)
    {
        $modelName = 'product_color';
        /** @var product_color $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productKind($vars2)
    {
        $modelName = 'product_kind';
        /* @var product_kind $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productKind($fieldInformation = null)
    {
        $modelName = 'product_kind';
        /** @var product_kind $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productTechnique($vars2)
    {
        $modelName = 'product_technique';
        /* @var product_technique $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productTechnique($fieldInformation = null)
    {
        $modelName = 'product_technique';
        /** @var product_technique $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productEffect($vars2)
    {
        $modelName = 'product_effect';
        /* @var product_effect $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productEffect($fieldInformation = null)
    {
        $modelName = 'product_effect';
        /** @var product_effect $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productDecor($vars2)
    {
        $modelName = 'product_decor';
        /* @var product_decor $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productDecor($fieldInformation = null)
    {
        $modelName = 'product_decor';
        /** @var product_decor $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productDegree($vars2)
    {
        $modelName = 'product_degree';
        /* @var product_degree $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productDegree($fieldInformation = null)
    {
        $modelName = 'product_degree';
        /** @var product_degree $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productTemplate($vars2)
    {
        $modelName = 'product_template';
        /* @var product_template $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productTemplate($fieldInformation = null)
    {
        $modelName = 'product_template';
        /** @var product_template $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productGlue($vars2)
    {
        $modelName = 'product_glue';
        /* @var product_glue $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productGlue($fieldInformation = null)
    {
        $modelName = 'product_glue';
        /** @var product_glue $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productStrap($vars2)
    {
        $modelName = 'product_strap';
        /* @var product_strap $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productStrap($fieldInformation = null)
    {
        $modelName = 'product_strap';
        /** @var product_strap $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productEngobe($vars2)
    {
        $modelName = 'product_engobe';
        /* @var product_engobe $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productEngobe($fieldInformation = null)
    {
        $modelName = 'product_engobe';
        /** @var product_engobe $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productBody($vars2)
    {
        $modelName = 'product_body';
        /* @var product_body $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productBody($fieldInformation = null)
    {
        $modelName = 'product_body';
        /** @var product_body $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productCylinder($vars2)
    {
        $modelName = 'product_cylinder';
        /* @var product_cylinder $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productCylinder($fieldInformation = null)
    {
        $modelName = 'product_cylinder';
        /** @var product_cylinder $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productComplementaryPrintingBeforeDigital($vars2)
    {
        $modelName = 'product_complementary_printing_before_digital';
        /* @var product_complementary_printing_before_digital $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productComplementaryPrintingBeforeDigital($fieldInformation = null)
    {
        $modelName = 'product_complementary_printing_before_digital';
        /** @var product_complementary_printing_before_digital $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productComplementaryPrintingAfterDigital($vars2)
    {
        $modelName = 'product_complementary_printing_after_digital';
        /* @var product_complementary_printing_after_digital $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productComplementaryPrintingAfterDigital($fieldInformation = null)
    {
        $modelName = 'product_complementary_printing_after_digital';
        /** @var product_complementary_printing_after_digital $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productPlastic($vars2)
    {
        $modelName = 'product_plastic';
        /* @var product_plastic $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productPlastic($fieldInformation = null)
    {
        $modelName = 'product_plastic';
        /** @var product_plastic $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productPallet($vars2)
    {
        $modelName = 'product_pallet';
        /* @var product_pallet $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productPallet($fieldInformation = null)
    {
        $modelName = 'product_pallet';
        /** @var product_pallet $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_cartonTheme($vars2)
    {
        $modelName = 'carton_theme';
        /* @var carton_theme $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_cartonTheme($fieldInformation = null)
    {
        $modelName = 'carton_theme';
        /** @var carton_theme $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_cartonSize($vars2)
    {
        $modelName = 'carton_size';
        /* @var carton_size $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_cartonSize($fieldInformation = null)
    {
        $modelName = 'carton_size';
        /** @var carton_size $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_palletSize($vars2)
    {
        $modelName = 'pallet_size';
        /* @var pallet_size $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_palletSize($fieldInformation = null)
    {
        $modelName = 'pallet_size';
        /** @var pallet_size $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productCarton($vars2)
    {
        $modelName = 'product_carton';
        /* @var product_carton $model */
        $model = $this->model([$this->appName, $modelName]);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';
        return $html;
    }

    public function _fieldService_showValue_productCarton($fieldInformation = null)
    {
        $modelName = 'product_carton';
        /** @var product_carton $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _logField(): array
    {
        return [["value" => "product", "label" => "تغییرات کاشی ها"],
            ["value" => "product_punch", "label" => "تغییرات پانچ ها"],
            ["value" => "product_punch", "label" => "تغییرات پانچ ها"],
            ["value" => "product_glaze", "label" => "تغییرات لعاب ها"],
            ["value" => "product_brand", "label" => "تغییرات برند ها"],
            ["value" => "product_color", "label" => "تغییرات رنگ ها"],
            ["value" => "product_kind", "label" => "تغییرات نوع محصول"],
            ["value" => "product_technique", "label" => "تغییرات تکنیک تولید"],
            ["value" => "product_effect", "label" => "تغییرات افکت ها"],
            ["value" => "product_decor", "label" => "تغییرات دکور ها"],
            ["value" => "product_degree", "label" => "تغییرات درجه ها"],
            ["value" => "product_template", "label" => "تغییرات قالب ها"],
            ["value" => "product_glue", "label" => "تغییرات چسب ها"],
            ["value" => "product_strap", "label" => "تغییرات تسمه ها"],
            ["value" => "product_engobe", "label" => "تغییرات انگوب ها"],
            ["value" => "product_body", "label" => "تغییرات بدنه ها"],
            ["value" => "product_digitalPrint_color", "label" => "تغییرات رنگ چاپ دیجیتال"],
            ["value" => "product_cylinder", "label" => "تغییرات سیلندر ها"],
            ["value" => "product_complementary_printing_before_digital", "label" => "تغییرات چاپ مکمل قبل از دیجیتال"],
            ["value" => "product_complementary_printing_after_digital", "label" => "تغییرات چاپ مکمل بعد از دیجیتال"],
            ["value" => "product_plastic", "label" => "تغییرات پلاستیک ها"],
            ["value" => "product_pallet", "label" => "تغییرات پالت ها"],
            ["value" => "carton_theme", "label" => "تغییرات تم کارتون ها"],
            ["value" => "carton_size", "label" => "تغییرات سایز کارتون ها"],
            ["value" => "pallet_size", "label" => "تغییرات سایز پالت ها"],
            ["value" => "product_carton", "label" => "تغییرات کارتون ها"],
        ];
    }
}