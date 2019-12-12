<?php 
namespace Model;

class HistorialModel extends Model{

    const TABLA = "historico";
    
    public function setHistorico($city_id,$humedad,$temperatura){
        $historico = [];
        $historico['ciudad_id']=$city_id;
        $historico['humedad']=$humedad;
        $historico['temperatura']=$temperatura;
        $historico['fecha_toma']=date("Y-m-d H:i:s");
        return $this->insert(self::TABLA,$historico);
    }

    public function getHistorial(){
        $order="historico.id  desc";
        $cities = $this->select(self::TABLA,
        [
            "l.ciudad","historico.humedad","historico.temperatura","historico.fecha_toma"
        ],
        null,$order,
        [
            ["tabla"=>"locations","tipo"=>"INNER","alias"=>"l","relaciones"=>"historico.ciudad_id = l.id"]
        ],
        null,[
            "qty"=>100
        ]);
        if(!empty($cities) && sizeof($cities)>0){
            return $cities;
        }else{
            return null;
        }
    }
}
