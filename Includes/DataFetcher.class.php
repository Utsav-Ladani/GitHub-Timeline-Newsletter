<?php
namespace DataFetcher;

/**
 * Fetch data from githic.om/timeline and convert it into json format
 */

class DataFetcher {

    const URL = "https://github.com/timeline";

    /**
     * fetch data from url and convert it into json format
     */
    private function fetchData() {
        /// get data from url
        $content = file_get_contents(self::URL);
        if(!$content) return NULL;

        // load XML
        $xml = simplexml_load_string($content);

        // convert it into json data
        $encoded_json = json_encode($xml, JSON_PRETTY_PRINT);
        $json_data = json_decode($encoded_json, true);

        return $json_data;
    }
    
    /**
     * format expected data
     */
    public function formatData() {
        // fetch data in json format
        $json_data = $this->fetchData();
        if(!$json_data) return NULL;
        
        // check if expected data is exist or not
        if(!isset($json_data['entry'])) return NULL;
        $json_data_arr = $json_data['entry'];

        $data_array = [];

        // run loop over each data element to reconstruct it.
        foreach ($json_data_arr as $data) {
            $reconstructed_data = $this->reconstructData($data);

            // record it in array
            if($reconstructed_data) array_push($data_array, $reconstructed_data);
        }

        return $data_array;
    }

    /**
     * Remove unnecessary data from json data
     */
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
    
    // just function wrapper
    public function getData() {
        return $this->formatData();
    }

}

?>