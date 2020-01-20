<?php

/*
 * This is our Db_log hook file
 * 
 */

class Logger {

    var $CI;

    function __construct() {
        $this->CI = & get_instance(); // Create instance of CI
    }
    
    function logRequests() {

        $filepath = '/var/log/erp/RequestLog_' . date('Ymd') . '.log'; // Filepath. File is created in logs folder with name QueryLog
        $handle = fopen($filepath, "a+"); // Open the file
        $CI = &get_instance();
        $logString = date("Y-m-d H:i:s")."|".$CI->router->fetch_class()."|".$CI->router->fetch_method()."|GET:" . json_encode($CI->input->get(null)) . "|POST:" . json_encode($CI->input->post(null), true);
        fwrite($handle, $logString . "\r\n");
        fclose($handle); // Close the file
    }
    
    function logQueries() {

        $filepath = '/var/log/erp/QueryLog_' . date('Ymd') . '.log'; // Filepath. File is created in logs folder with name QueryLog
        $handle = fopen($filepath, "a+"); // Open the file

        $times = $this->CI->db->query_times; // We get the array of execution time of each query that got executed by our application(controller)
        $CI = &get_instance();
        foreach ($this->CI->db->queries as $key => $query) { // Loop over all the queries  that are stored in db->queries array
            $sql = date("Y-m-d H:i:s")."|".$CI->router->fetch_class()."|".$CI->router->fetch_method()."|" . trim(preg_replace('/\s+/', ' ', $query)) . "|Execution Time:" . $times[$key]; // Write it along with the execution time
            fwrite($handle, $sql . "\r\n");
        }

        fclose($handle); // Close the file
    }

}

?>
