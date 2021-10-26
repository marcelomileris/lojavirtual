<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    header('Content-Type: application/json');

    require_once 'vendor/autoload.php';

    if ($_GET['url']) {
        $url = explode('/', $_GET['url']);

        if ($url[0] === 'user') {
            $service = 'App\Services\\'.ucfirst($url[0]).'Service';
            array_shift($url);

            $method = strtolower($_SERVER['REQUEST_METHOD']);
            try {
                $response = call_user_func_array(array(new $service, $method), $url);
                http_response_code(200);
                echo json_encode(array('status' => 'sucess', 'data' => $response), JSON_UNESCAPED_UNICODE);
                exit;
            } catch (\Exception $e) {
                http_response_code(200);
                echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
    }
    