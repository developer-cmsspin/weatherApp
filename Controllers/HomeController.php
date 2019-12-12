<?php

Class Home extends Controller{
    public function indexAction(){
        $ciudadModel = new Model\CitiesModel($this->db);
        $ciudades = $ciudadModel->getCiudades();
        yield $this->render("layouts/header");
        yield $this->render("home/index",["ciudades"=>$ciudades]);
        yield $this->render("layouts/footer");
    }

    public function historialAction(){
        $historialModel = new Model\HistorialModel($this->db);
        $h = $historialModel->getHistorial();
        yield $this->render("layouts/header");
        yield $this->render("home/historial",["historial"=>$h]);
        yield $this->render("layouts/footer");
    }

    public function getweatherAction(){
        $query = array(
            "lat"=>$this->postParams->latitude,
            "lon"=>$this->postParams->longitude,
            'format' => 'json',
        );
        $url = WEATHER_API;
        $app_id = WEATHER_APPID;
        $consumer_key = WEATHER_CONSUMERKEY;
        $consumer_secret = WEATHER_SECRETKEY;
        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => uniqid(mt_rand(1, 1000)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        $base_info = $this->buildBaseString($url, 'GET', array_merge($query, $oauth));
        $composite_key = rawurlencode($consumer_secret) . '&';
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;
        $header = array(
            $this->buildAuthorizationHeader($oauth),
            'X-Yahoo-App-Id: ' . $app_id
        );
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url . '?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        $return_data = json_decode($response);
        $historialModel = new Model\HistorialModel($this->db);
        $historialModel->setHistorico($this->postParams->ciudad_id,$return_data->current_observation->atmosphere->humidity,$return_data->current_observation->condition->temperature);
        yield $this->render("json",['data'=>$return_data,'error'=>null],"json");
    }

    protected function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }
    protected function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key=>$value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $r .= implode(', ', $values);
        return $r;
    }
}