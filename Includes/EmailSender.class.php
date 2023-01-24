<?php

require_once __DIR__.'/DataFetcher.class.php';
require_once __DIR__.'/DBConnection.class.php';

class EmailSender extends DBConnection {
    private $data = NULL;
    private $gh_template = "";
    private $gh_card_template = "";
    private $gh_timeline_html = "";

    public function run_email_sender() {
        $this->data = $this->fetch_data();
        if(!$this->data) return "Data is not fetched.";

        $this->gh_template = $this->get_template(__DIR__."/../template/gh_timeline.html");
        if(!$this->gh_template) return "Can't be able to open template.";

        $this->gh_card_template = $this->get_template(__DIR__."/../template/gh_timeline_card.html");
        if(!$this->gh_card_template) return "Can't be able to open template.";

        $this->embed_gh_timeline_update();

        $result = $this->send_emails();
        if($result) return "Can't be able to send emails.";

        return "";
    }

    private function fetch_data() {
        $data_fetcher = new DataFetcher();
        $result = $data_fetcher->getData();

        return $result;
    }

    private function embed_gh_timeline_update() {
        $gh_timeline = $this->gh_template;
        $gh_data = $this->data;
        $gh_cards = "";

        foreach($gh_data as $data) {
            $gh_card = $this->gh_card_template;

            $gh_card = str_replace('{{published}}', $data['published'], $gh_card);
            $gh_card = str_replace('{{updated}}', $data['updated'], $gh_card);
            $gh_card = str_replace('{{href}}', $data['href'], $gh_card);
            $gh_card = str_replace('{{title}}', $data['title'], $gh_card);
            $gh_card = str_replace('{{author_name}}', $data['author_name'], $gh_card);
            $gh_card = str_replace('{{author_uri}}', $data['author_uri'], $gh_card);

            $gh_cards .= $gh_card;
        }

        $gh_timeline = str_replace('{{content}}', $gh_cards, $gh_timeline);

        $this->gh_timeline_html = $gh_timeline;
    }

    private function generate_message($name, $email, $token) {
        $message = $this->gh_timeline_html;
        
        $message = str_replace('{{name}}', $name, $message);
        $message = str_replace('{{email}}', $email, $message);
        $message = str_replace('{{token}}', $token, $message);

        return $message;
    }

    private function get_template($filename) {        
        $file = fopen($filename, "r");
        if(!$file) return NULL;

        $template = fread($file, filesize($filename));

        fclose($file);

        return $template;
    }

    private function send_emails() {
        $result = parent::getUsersWithSubscription();
        
        $subject = "GitHub timeline update";

        $headers  = "From: gh.timeline@rtcamp.com\r\n";
        $headers .= "Reply-To: gh.timeline.reply@rtcamp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        while($data = $result->fetch_array()) {
            $name = $data['Name'];
            $email = $data['Email'];
            $token = $data['Token'];
            $message = $this->generate_message($name, $email, $token);

            $status = mail($email, $subject, $message, $headers);
            if(!$status) return "Failed to send an email to $email";
        }

        return "";
    }
}

?>