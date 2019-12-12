<?php 
namespace Model;

class CitiesModel extends Model{

    const TABLA = "locations";
    
    public function getCiudades(){
        $order="id asc";
        $cities = $this->select(self::TABLA,
        [
            "*"
        ],
        null,$order,null,null,null);
        if(!empty($cities) && sizeof($cities)>0){
            return $cities;
        }else{
            return null;
        }
    }
}
