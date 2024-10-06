<?php

require_once("Rest.inc.php");

class API extends REST {

    public $data = "";
    const demo_version = false;

    private $db = NULL;
    private $mysqli = NULL;

    public function __construct() {
        // Init parent contructor
        parent::__construct();
        // Initiate Database connection
        $this->dbConnect();
        date_default_timezone_set('Asia/Kolkata');
    }

    private function dbConnect() {
        include "../includes/config.php";
        $this->mysqli = new mysqli($host, $user, $pass, $database);
        $this->mysqli->query('SET CHARACTER SET utf8');
    
        // Add API key validation
        $api_key = $this->getApiKey();
        if (!$this->isValidApiKey($api_key)) {
            $this->responseInvalidApiKey();
        }
    }
    
        private function getApiKey() {
            // Retrieve the API key from the request or other sources as needed
            return isset($_REQUEST['api_key']) ? $_REQUEST['api_key'] : '';
        }

    
    private function isValidApiKey($api_key) {
        // Implement logic to validate the API key from the database
        $escaped_api_key = $this->real_escape($api_key);
        $query = "SELECT * FROM tbl_settings WHERE app_api_key = '$escaped_api_key'";
        $result = $this->get_count_result($query);
        return $result > 0;
    }
    
    private function responseInvalidApiKey() {
        $resp = array("status" => 'Failed', "msg" => 'Invalid API Key');
        $this->response($this->json($resp), 401); // Unauthorized
    }
    
   
    /*
     * Dynmically call the method based on the query string
     */
    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['x'])));
        
        // List of methods that require API key
        $methodsRequiringApiKey = ['getServers', 'getAppSettings'];
    
        // Check if API key is required for the current method
        if (in_array($func, $methodsRequiringApiKey) && $func !== 'getDonutChartData') {
            $this->checkApiKey();
        }
    
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else {
            $response = array('status' => FAIL, 'message' => MSG_NO_METHOD_FOUND);
            $this->response($this->json($response), 404); // If the method not exist within this class "Page not found".
        }
    }
    
    private function checkApiKey() {
        $api_key = $this->getApiKey();
        $excludedMethods = ['getDonutChartData'];

        if (empty($api_key) && !in_array($this->getRequestMethod(), $excludedMethods)) {
            $this->responseInvalidApiKey();
        }
    }


    

    /* Api Checker */
    private function checkConnection() {
        if (mysqli_ping($this->mysqli)) {
            $response = array('status' => SUCCESS, 'database' => 'connected');
            $this->response($this->json($response), 200);
        } else {
            $response = array('status' => FAIL, 'database' => 'not connected');
            $this->response($this->json($response), 404);
        }
    }

    private function getServers() {
        include "../includes/config.php";
        if ($this->get_request_method() != "POST") $this->response('', 406);
        $query = "SELECT * FROM tbl_servers";
        $posts = $this->get_list_result($query);
        $baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        foreach ($posts as &$post) {
            $post['flagURL'] = $baseURL . '/assets/flags/' . $post['flagURL'] . '.png';
            unset($post['username']);
            unset($post['password']);
            $post['v2rayConfig'] = $post['ovpnConfig'];
            unset($post['ovpnConfig']);
        }
        $response = array(
            'status' => SUCCESS, 'posts' => $posts
        );
        $this->response($this->json($response), 200);
    }
    

    private function getAppSettings() {
        include "../includes/config.php";
        if ($this->get_request_method() != "POST") $this->response('', 406);
        $jsonData = json_decode(file_get_contents('php://input'));
    
        // Modify the query to include the paid server count
        $query = "SELECT *, CONCAT(app_version, ' ')  as app_version, 
                  (SELECT COUNT(*) FROM tbl_servers WHERE isPaid = 1) AS paidServerCount
                  FROM tbl_settings where id = '1'";
                
        
        $data = $this->get_object_result($query);
            unset($data['onesignal_app_id']);
                   unset($data['onesignal_rest_key']);
            unset($data['app_api_key']);
        
        // Include the paid server count in the response
        $response = array('status' => SUCCESS, 'message' => MSG_RECORD_FOUND, 'data' => $data);
        
        $this->response($this->json($response), 200);
    }
    



    private function getDonutChartData() {
        include "../includes/config.php";

        // No API key validation for this method

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

    /**
     * =========================================================================================================
     * COMMON METHODS  
     * =========================================================================================================
     */
    private function getCurrentDate() {
        return date('Y-m-d H:i:s', time());
    }

    private function getISTDateTime() {
        return $this->getCurrentDate();
    }

    private function getISTDate() {
        return date('Y-m-d', time());
    }

    private function getISTTime() {
        return date('H:i:s', time());
    }

    // Don't edit all the code below
    private function get_list($query) {
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204);    // If no records "No Content" status
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

    private function get_object_result($query) {
        $result = array();
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            while ($row = $r->fetch_assoc()) {
                $result = $row;
            }
        }
        return $result;
    }

    private function get_one($query) {
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            $result = $r->fetch_assoc();
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204);    // If no records "No Content" status
    }

    private function get_count($query) {
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            $result = $r->fetch_row();
            $this->response($result[0], 200);
        }
        $this->response('', 204);    // If no records "No Content" status
    }

    private function get_count_result($query) {
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
        if ($r->num_rows > 0) {
            $result = $r->fetch_row();
            return $result[0];
        }
        return 0;
    }

    private function post_one($obj, $column_names, $table_name) {
        $keys = array_keys($obj);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) {
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $obj[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $this->real_escape($$desired_key) . "',";
        }
        $query = "INSERT INTO " . $table_name . "(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";

        if (!empty($obj)) {

            if ($this->mysqli->query($query)) {
                $status = "success";
                $msg = $table_name . " created successfully";
            } else {
                $status = "failed";
                $msg = $this->mysqli->error . __LINE__;
            }
            $resp = array('status' => $status, "msg" => $msg, "data" => $obj);
            $this->response($this->json($resp), 200);
        } else {
            $this->response('', 204);    //"No Content" status
        }
    }

    private function post_update($id, $obj, $column_names, $table_name) {
        $keys = array_keys($obj[$table_name]);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) {
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $obj[$table_name][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $this->real_escape($$desired_key) . "',";
        }

        $query = "UPDATE " . $table_name . " SET " . trim($columns, ',') . " WHERE id=$id";
        if (!empty($obj)) {
            if ($this->mysqli->query($query)) {
                $status = "success";
                $msg = $table_name . " update successfully";
            } else {
                $status = "failed";
                $msg = $this->mysqli->error . __LINE__;
            }
            $resp = array('status' => $status, "msg" => $msg, "data" => $obj);
            $this->response($this->json($resp), 200);
        } else {
            $this->response('', 204);    // "No Content" status
        }
    }

    private function delete_one($id, $table_name) {
        if ($id > 0) {
            $query = "DELETE FROM " . $table_name . " WHERE id = $id";
            if ($this->mysqli->query($query)) {
                $status = "success";
                $msg = "One record " . $table_name . " successfully deleted";
            } else {
                $status = "failed";
                $msg = $this->mysqli->error . __LINE__;
            }
            $resp = array('status' => $status, "msg" => $msg);
            $this->response($this->json($resp), 200);
        } else {
            $this->response('', 204);    // If no records "No Content" status
        }
    }

    private function responseInvalidParam() {
        $resp = array("status" => 'Failed', "msg" => 'Invalid Parameter');
        $this->response($this->json($resp), 200);
    }


    private function serverHitCount()
    {
        include "../includes/config.php";
        if ($this->get_request_method() != "POST") $this->response('', 406);

        $serverId = $_REQUEST['server_id'];

        $query = "SELECT * FROM tbl_servers WHERE id = $serverId";
        $posts = $this->get_object_result($query);

        $hit = $posts['hit_count'] + 1;


        $updateQuery = "UPDATE tbl_servers SET hit_count = $hit WHERE id = $serverId;";


        if ($this->mysqli->query($updateQuery)) {
            $status = "success";
            $msg = "Hit count update successfully";
        } else {
            $status = "failed";
            $msg = $this->mysqli->error . __LINE__;
        }
        $resp = array('status' => $status, "msg" => $msg);
        $this->response($this->json($resp), 200);

    }
    /* ==================================== End of API utilities ==========================================
     * ====================================================================================================
     */

  /* Encode array into JSON */
    private function json($data) {
        if (is_array($data)) {
            return json_encode($data, JSON_NUMERIC_CHECK);
        }
    }

    /* String mysqli_real_escape_string */
    private function real_escape($s) {
        return mysqli_real_escape_string($this->mysqli, $s);
    }
}

// Initiate Library
$api = new API;
$api->processApi();
?>