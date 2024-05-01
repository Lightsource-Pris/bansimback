<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class Responses extends Controller
{
    public function Four00($message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 400
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Two00($data, $message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 200,
                'data' => $data
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Two01($data, $message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 201,
                'data' => $data
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Four01($message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 401,
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Four03($message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 403,
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Four42($message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 442
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Four04($message)
    {
        $res = array();
        try {
            $res = [
                'message' => $message,
                'code' => 404
            ];
        } catch (\Exception $e) {
            $res = $this->FiveHundred($e);
        }
        return $res;
    }

    public function Five00($e)
    {
        try {
            $res = [
                'message' => 'Something is wrong, please try again later',
                'error' => $e->getMessage(),
                'code' => 500
            ];
        } catch (\Exception $e) {
            $res = [
                'message' => 'Something is wrong, please try again later',
                'error' => $e->getMessage(),
                'code' => 500
            ];
        }
        return $res;
    }
}
