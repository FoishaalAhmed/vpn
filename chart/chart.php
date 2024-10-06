<?php

require_once("Rest.inc.php");

class API extends REST {

    public $data = "";
    const demo_version = false;

    private $db = NULL;
    private $mysqli = NULL;

    public function __construct() {
        // Init parent constructor
        parent::__construct();
        // Initiate Database connection
        $this->dbConnect();
        date_default_timezone_set('Asia/Kolkata');
    }

    /*
     *  Connect to Database
     */
    private function dbConnect() {
        include "../includes/config.php";
        $this->mysqli = new mysqli($host, $user, $pass, $database);
        $this->mysqli->query('SET CHARACTER SET utf8');
    }

    /*
     * Dynamically call the method based on the query string
     */
    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['x'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else {
            $response = array('status' => FAIL, 'message' => MSG_NO_METHOD_FOUND);
            $this->response($this->json($response), 404);    // If the method not exist within this class "Page not found".
        }
    }

    private function getDonutChartData() {
        include "../includes/config.php";

        if ($this->get_request_method() != "GET") $this->response('', 406);

        $query = "SELECT 'Total' AS title, COUNT(isPaid) AS 'value' FROM tbl_servers
                    UNION
                    SELECT 'Paid', COUNT(isPaid) FROM tbl_servers
                    WHERE isPaid = 1
                    UNION
                    SELECT 'Free', COUNT(isPaid) FROM tbl_servers
                    WHERE isPaid = 0
                    ";

        $result = ($this->get_list_result($query));

        $response = array('status' => SUCCESS, 'data' => $result);

        $this->response($this->json($response), 200);
    }

    private function getTotalHitCountData() {
        include "../includes/config.php";

        if ($this->get_request_method() != "GET") $this->response('', 406);

        $query = "SELECT serverName, hit_count FROM tbl_servers ORDER BY hit_count DESC LIMIT 5;";

        $result = ($this->get_list_result($query));

        $response = array('status' => SUCCESS, 'data' => $result);

        $this->response($this->json($response), 200);
    }

    private function get_list_result($query) {
        $result = array();
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
        }
        return $result;
    }

    /* Encode array into JSON */
    private function json($data) {
        if (is_array($data)) {
            return json_encode($data, JSON_NUMERIC_CHECK);
        }
    }

}

// Initiate Library
$api = new API;
$api->processApi();

?>
