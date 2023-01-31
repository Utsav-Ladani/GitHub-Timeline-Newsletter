<?php
namespace EmailSender;

require_once __DIR__.'/DataFetcher.class.php';
require_once __DIR__.'/DBConnection.class.php';

/**
 * Send email to every subscriber
 */
class EmailSender extends \DBConn\DBConnection {
    private $data = NULL;
    private $gh_template = "";
    private $gh_timeline_html = "";

    /**
     * send email to every subscriber
     */
    public function run_email_sender() {
        // fetch data from github.com/timeline and convert it into json format
        $this->data = $this->fetch_data();
        if(!$this->data) return "Data is not fetched.";

        // fetch main html email template 
        $this->gh_template = $this->get_template(__DIR__."/../template/gh_timeline.html");
        if(!$this->gh_template) return "Can't be able to open template.";

        // embed data in template
        $this->embed_gh_timeline_update();

        // send email to every subscriber
        $result = $this->send_emails();
        if($result) return "Can't be able to send emails.";

        return "";
    }

    /** 
     * fetch data from github.com/timeline and convert it into json format
     */
    private function fetch_data() {
        $data_fetcher = new \DataFetcher\DataFetcher();
        $result = $data_fetcher->getData();

        return $result;
    }

    /** 
     * embed json data into email template
     */
    private function embed_gh_timeline_update() {
        // create a copy of template
        $gh_timeline = $this->gh_template;
        $gh_data = $this->data;
        $gh_cards = "";

        foreach($gh_data as $data) {
            // add html content of data
            $gh_cards .= "<li>".$data['content']."</li>";
        }

        // put all data card into main html template
        $gh_timeline = str_replace('{{content}}', $gh_cards, $gh_timeline);

        $this->gh_timeline_html = $gh_timeline;
    }

    /**
     * Generate message for particular user
     */
    private function generate_message($name, $email, $token) {
        $message = $this->gh_timeline_html;
        
        // replace keywords with respected data
        $message = str_replace('{{name}}', $name, $message);
        $message = str_replace('{{email}}', $email, $message);
        $message = str_replace('{{token}}', $token, $message);

        return $message;
    }

    /**
     * read template into string from filename
     */
    private function get_template($filename) {  
        // open file      
        $file = fopen($filename, "r");
        if(!$file) return NULL;

        // red whole file as a string
        $template = fread($file, filesize($filename));

        fclose($file);

        return $template;
    }

    /**
     * send emails to every user
     */
    private function send_emails() {
        // get subscriber details from database
        $result = parent::getUsersWithSubscription();
        
        $subject = "GitHub timeline update";
        
        // set headers to render contenst as an html
        $headers  = "From: gh.timeline@rtcamp.com\r\n";
        $headers .= "Reply-To: gh.timeline.reply@rtcamp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // run loop on the datat to embed it in email template
        $data = $result->fetch_array();
        while($data) {
            $name = $data['Name'];
            $email = $data['Email'];
            $token = $data['Token'];
            $message = $this->generate_message($name, $email, $token);

            //send an email
            $status = mail($email, $subject, $message, $headers);
            if(!$status) return "Failed to send an email to $email";

            $data = $result->fetch_array();
        }

        return "";
    }
}
