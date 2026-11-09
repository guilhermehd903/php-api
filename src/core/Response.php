<?php

namespace Service\Api\core;

class Response
{
    private $response;

    public function json(){
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($this->response);
        exit;
    }

    public function error($error = ""): Response {
        $this->response["error"] = true;
        $this->response["message"] = $error;

        return $this;
    }

    public function response($msg = ""): Response {
        $this->response["error"] = false;
        $this->response["message"] = $msg;

        return $this;
    }

    public function data($data): Response {
        $this->response["data"] = $data;

        return $this;
    }
}
