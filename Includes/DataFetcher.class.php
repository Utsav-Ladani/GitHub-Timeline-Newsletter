<?php

class DataFetcher {

    const URL = "https://github.com/timeline";

    public function __construct() {}
    
    private function fetchData() {
        $content = file_get_contents(self::URL);
        if(!$content) return NULL;

        $xml = simplexml_load_string($content);
        $encoded_json = json_encode($xml, JSON_PRETTY_PRINT);
        $json_data = json_decode($encoded_json, true);

        return $json_data;
    }
    
    public function formatData() {
        $json_data = $this->fetchData();
        if(!$json_data) return NULL;
        
        if(!isset($json_data['entry'])) return NULL;
        $json_data_arr = $json_data['entry'];

        $data_array = [];

        foreach ($json_data_arr as $data) {
            $reconstructed_data = $this->reconstructData($data);

            if($reconstructed_data) array_push($data_array, $reconstructed_data);
        }

        return $data_array;
    }

    public function reconstructData($json_data) {
        $data["id"] = $json_data["id"];
        $data["published"] = $json_data["published"];
        $data["updated"] = $json_data["updated"];
        $data["href"] = $json_data["link"]["@attributes"]["href"];
        $data["title"] = $json_data["title"];
        $data["author_name"] = $json_data["author"]["name"];
        $data["author_uri"] = $json_data["author"]["uri"];

        return $data;
    }
    
    public function getData() {
        return $this->formatData();
    }

}

?>