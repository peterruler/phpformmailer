<?php
namespace ch\keepitnative\formmailer\src\response;

require_once 'Response.php';

class HttpResponse implements Response {
    private $status = '200 OK';
    private $headers = array();
    private $body = null;

    public function setStatus($status) {
        $this->status = $status;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function write($data) {
        $this->body .= $data;
    }

    public function flush() {
        header("HTTP/1.0 {$this->status}");
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        print $this->body;
        $this->headers = array();
        $this->body = null;
    }
}
?>