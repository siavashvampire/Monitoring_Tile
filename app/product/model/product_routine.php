<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class product_routine extends model implements modelInterFace
{
    private $tableName = 'product_routine';

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $product;
    private $routine_date;
    private $shift;
    private $controller;
    private $length_min;
    private $length_max;
    private $width_min;
    private $width_max;
    private $thickness_min;
    private $thickness_max;
    private $resistance;
    private $wrap_diameter_min;
    private $wrap_diameter_max;
    private $wrap_center_min;
    private $wrap_center_max;
    private $wrap_edge_min;
    private $wrap_edge_max;
    private $oblique;
    private $straight;
    private $mean_water_attraction;
    private $temperature_min;
    private $temperature_max;
    private $cycle;
    private $specific_pressure;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->product = $result['product'];
        $this->routine_date = $result['routine_date'];
        $this->shift = $result['shift'];
        $this->controller = $result['controller'];
        $this->length_min = $result['length_min'];
        $this->length_max = $result['length_max'];
        $this->width_min = $result['width_min'];
        $this->width_max = $result['width_max'];
        $this->thickness_min = $result['thickness_min'];
        $this->thickness_max = $result['thickness_max'];
        $this->resistance = $result['resistance'];
        $this->wrap_diameter_min = $result['wrap_diameter_min'];
        $this->wrap_diameter_max = $result['wrap_diameter_max'];
        $this->wrap_center_min = $result['wrap_center_min'];
        $this->wrap_center_max = $result['wrap_center_max'];
        $this->wrap_edge_min = $result['wrap_edge_min'];
        $this->wrap_edge_max = $result['wrap_edge_max'];
        $this->oblique = $result['oblique'];
        $this->straight = $result['straight'];
        $this->mean_water_attraction = $result['mean_water_attraction'];
        $this->temperature_min = $result['temperature_min'];
        $this->temperature_max = $result['temperature_max'];
        $this->cycle = $result['cycle'];
        $this->specific_pressure = $result['specific_pressure'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['product'] = $this->product;
        $array['routine_date'] = $this->routine_date;
        $array['shift'] = $this->shift;
        $array['controller'] = $this->controller;
        $array['length_min'] = $this->length_min;
        $array['length_max'] = $this->length_max;
        $array['width_min'] = $this->width_min;
        $array['width_max'] = $this->width_max;
        $array['thickness_min'] = $this->thickness_min;
        $array['thickness_max'] = $this->thickness_max;
        $array['resistance'] = $this->resistance;
        $array['wrap_diameter_min'] = $this->resistance;
        $array['wrap_diameter_max'] = $this->resistance;
        $array['wrap_center_min'] = $this->resistance;
        $array['wrap_center_max'] = $this->resistance;
        $array['wrap_edge_min'] = $this->wrap_edge_min;
        $array['wrap_edge_max'] = $this->wrap_edge_max;
        $array['oblique'] = $this->oblique;
        $array['straight'] = $this->straight;
        $array['mean_water_attraction'] = $this->mean_water_attraction;
        $array['temperature_min'] = $this->temperature_min;
        $array['temperature_max'] = $this->temperature_max;
        $array['cycle'] = $this->cycle;
        $array['specific_pressure'] = $this->specific_pressure;
        return $array;
    }

    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate()
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getProductLabel()
    {
        return parent::search([$this->product], 'item.id = ?', 'product' . ' item', 'item.label')[0]['label'];
    }

    public function getSizeLabel()
    {
        model::join('product_size  size', 'item.size = size.id');
        return parent::search([$this->product], 'item.id = ?', 'product' . ' item', 'CONCAT(size.length,"×", size.width) as size')[0]['size'];
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getRoutineDate()
    {
        return $this->routine_date;
    }

    /**
     * @param mixed $routine_date
     */
    public function setRoutineDate($routine_date): void
    {
        $this->routine_date = $routine_date;
    }

    /**
     * @return mixed
     */
    public function getShift()
    {
        return $this->shift;
    }

    /**
     * @param mixed $shift
     */
    public function setShift($shift): void
    {
        $this->shift = $shift;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getLengthMin()
    {
        return $this->length_min;
    }

    /**
     * @param mixed $length_min
     */
    public function setLengthMin($length_min): void
    {
        $this->length_min = $length_min;
    }

    /**
     * @return mixed
     */
    public function getLengthMax()
    {
        return $this->length_max;
    }

    /**
     * @param mixed $length_max
     */
    public function setLengthMax($length_max): void
    {
        $this->length_max = $length_max;
    }

    /**
     * @return mixed
     */
    public function getWidthMin()
    {
        return $this->width_min;
    }

    /**
     * @param mixed $width_min
     */
    public function setWidthMin($width_min): void
    {
        $this->width_min = $width_min;
    }

    /**
     * @return mixed
     */
    public function getWidthMax()
    {
        return $this->width_max;
    }

    /**
     * @param mixed $width_max
     */
    public function setWidthMax($width_max): void
    {
        $this->width_max = $width_max;
    }

    /**
     * @return mixed
     */
    public function getThicknessMin()
    {
        return $this->thickness_min;
    }

    /**
     * @param mixed $thickness_min
     */
    public function setThicknessMin($thickness_min): void
    {
        $this->thickness_min = $thickness_min;
    }

    /**
     * @return mixed
     */
    public function getThicknessMax()
    {
        return $this->thickness_max;
    }

    /**
     * @param mixed $thickness_max
     */
    public function setThicknessMax($thickness_max): void
    {
        $this->thickness_max = $thickness_max;
    }

    /**
     * @return mixed
     */
    public function getResistance()
    {
        return $this->resistance;
    }

    /**
     * @param mixed $Resistance
     */
    public function setResistance($Resistance): void
    {
        $this->resistance = $Resistance;
    }

    /**
     * @return mixed
     */
    public function getWrapDiameterMin()
    {
        return $this->wrap_diameter_min;
    }

    /**
     * @param mixed $wrap_diameter_min
     */
    public function setWrapDiameterMin($wrap_diameter_min): void
    {
        $this->wrap_diameter_min = $wrap_diameter_min;
    }

    /**
     * @return mixed
     */
    public function getWrapDiameterMax()
    {
        return $this->wrap_diameter_max;
    }

    /**
     * @param mixed $wrap_diameter_max
     */
    public function setWrapDiameterMax($wrap_diameter_max): void
    {
        $this->wrap_diameter_max = $wrap_diameter_max;
    }

    /**
     * @return mixed
     */
    public function getWrapCenterMin()
    {
        return $this->wrap_center_min;
    }

    /**
     * @param mixed $wrap_center_min
     */
    public function setWrapCenterMin($wrap_center_min): void
    {
        $this->wrap_center_min = $wrap_center_min;
    }

    /**
     * @return mixed
     */
    public function getWrapCenterMax()
    {
        return $this->wrap_center_max;
    }

    /**
     * @param mixed $wrap_center_max
     */
    public function setWrapCenterMax($wrap_center_max): void
    {
        $this->wrap_center_max = $wrap_center_max;
    }

    /**
     * @return mixed
     */
    public function getWrapEdgeMin()
    {
        return $this->wrap_edge_min;
    }

    /**
     * @param mixed $wrap_edge_min
     */
    public function setWrapEdgeMin($wrap_edge_min): void
    {
        $this->wrap_edge_min = $wrap_edge_min;
    }

    /**
     * @return mixed
     */
    public function getWrapEdgeMax()
    {
        return $this->wrap_edge_max;
    }

    /**
     * @param mixed $wrap_edge_max
     */
    public function setWrapEdgeMax($wrap_edge_max): void
    {
        $this->wrap_edge_max = $wrap_edge_max;
    }

    /**
     * @return mixed
     */
    public function getOblique()
    {
        return $this->oblique;
    }

    /**
     * @param mixed $oblique
     */
    public function setOblique($oblique): void
    {
        $this->oblique = $oblique;
    }

    /**
     * @return mixed
     */
    public function getStraight()
    {
        return $this->straight;
    }

    /**
     * @param mixed $straight
     */
    public function setStraight($straight): void
    {
        $this->straight = $straight;
    }

    /**
     * @return mixed
     */
    public function getMeanWaterAttraction()
    {
        return $this->mean_water_attraction;
    }

    /**
     * @param mixed $mean_water_attraction
     */
    public function setMeanWaterAttraction($mean_water_attraction): void
    {
        $this->mean_water_attraction = $mean_water_attraction;
    }

    /**
     * @return mixed
     */
    public function getTemperatureMin()
    {
        return $this->temperature_min;
    }

    /**
     * @param mixed $temperature_min
     */
    public function setTemperatureMin($temperature_min): void
    {
        $this->temperature_min = $temperature_min;
    }

    /**
     * @return mixed
     */
    public function getTemperatureMax()
    {
        return $this->temperature_max;
    }

    /**
     * @param mixed $temperature_max
     */
    public function setTemperatureMax($temperature_max): void
    {
        $this->temperature_max = $temperature_max;
    }

    /**
     * @return mixed
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param mixed $cycle
     */
    public function setCycle($cycle): void
    {
        $this->cycle = $cycle;
    }

    /**
     * @return mixed
     */
    public function getSpecificPressure()
    {
        return $this->specific_pressure;
    }

    /**
     * @param mixed $specific_pressure
     */
    public function setSpecificPressure($specific_pressure): void
    {
        $this->specific_pressure = $specific_pressure;
    }


    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.product) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.product', 'type' => 'asc'], $pagination = [0, 9999])
    {
        model::join('user controller', 'item.controller = controller.userId');

        $field = array();
        $field[] = 'item.id';
        $field[] = 'item.product';
        $field[] = 'DATE_FORMAT(jdate(item.routine_date), "%Y-%m-%d") as date';
//        $field[] = 'item.code';
//        $field[] = 'item.file_code';
        $field[] = 'concat(controller.fname," ",controller.lname) as controllerUser';
//        $field[] = 'engobe.label as engobeLabel';
//        $field[] = 'glaze.label as glazeLabel';
//        $field[] = 'sub_engobe.label as sub_engobeLabel';
//        $field[] = 'item.description';

        $field = implode(',', $field);

        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', $field, $sortWith, $pagination);
    }

    public function getItemsForExport($value = array(), $variable = array(), $sortWith = ['column' => 'item.id', 'type' => 'asc'], $pagination = [0, 9999])
    {

        model::join('product product', 'product.id = item.product');
        model::join('phases  phase', 'phase.id = product.phase');
        model::join('product_size  size', 'size.id = product.size');
        model::join('product_body  body', 'body.id = item.body');
        model::join('product_novanc  novanc', 'novanc.id = item.novanc');
        model::join('product_engobe  engobe', 'engobe.id = item.engobe');
        model::join('product_sub_engobe  sub_engobe', 'sub_engobe.id = item.sub_engobe');
        model::join('product_glaze  glaze', 'glaze.id = item.glaze');

        model::join('user controller', 'item.controller = controller.userId');

        $field = array();
        $field[] = 'item.id';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%d")';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%m")';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%Y")';
        $field[] = 'phase.label as phaseLabel';
        $field[] = 'size.label as sizeLabel';
        $field[] = 'body.label as bodyeLabel';
        $field[] = 'item.thickness';
        $field[] = 'product.label';
        $field[] = 'novanc.label as novancLabel';
        $field[] = 'item.code';
        $field[] = 'item.file_code';
        $field[] = 'concat(controller.fname," ",controller.lname) as controllerUser';
        $field[] = 'engobe.label as engobeLabel';
        $field[] = 'glaze.label as glazeLabel';
        $field[] = 'sub_engobe.label as sub_engobeLabel';
        $field[] = 'item.description';

        $field = implode(',', $field);

        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', $field, $sortWith, $pagination);
    }
}
