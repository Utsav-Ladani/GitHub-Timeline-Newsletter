<?php

class XMLHandler {
    public function __construct() {
        $URL = "https://github.com/timeline";
        $content = file_get_contents($URL);
        $xml = simplexml_load_string($content);
        $encoded_json = json_encode($xml);
        $json = json_decode($encoded_json);

        $data=[];

        foreach ($xml as $element) {
            $html_data = $element->content;
            $encoded_json_data = json_encode($html_data);
            $json_data = json_decode($encoded_json_data);

            if(isset($json_data->{'0'}))
                array_push($data, $json_data->{'0'});
        }

        foreach($data as $d) {
            echo htmlspecialchars($d);
            echo $d;
        }
    }
}

$xml_handler = new XMLHandler();


?>