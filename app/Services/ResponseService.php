<?php

namespace App\Services;

class ResponseService
{

    private $message = 'OK';
    private $status = 200;
    private $data = [];
    private $errors = [];

    public function message($message): ResponseService
    {
        $this->message = $message;
        return $this;
    }

    public function status($status): ResponseService
    {
        $this->status = $status;
        return $this;
    }

    public function data($data): ResponseService
    {
        $this->data = is_array($data) ? $data : [$data];
        return $this;
    }

    public function errors($errors): ResponseService
    {
        $this->errors = is_array($errors) ? $errors : [$errors];
        return $this;
    }

    public function send()
    {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors,
        ], $this->status);
    }
}
