<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Ixudra\Curl\Facades\Curl;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   	protected function token()
   	{
   		return $_COOKIE['token'];
   	}

   	protected function hit_api($url='', $method='get', array $with_data=array())
   	{
   		$data = Curl::to(env('API_ENDPOINT').$url)
            ->withHeaders([
                'Content-type: application/json',
                'Authorization: Bearer '.$this->token()
            ]);

        if ($with_data) {
        	$data = $data->withData($with_data);
        }

   		switch ($method) {
   			case 'get':
   				$data = $data->asJson()->get();
   				break;
   			case 'post':
   				$data = $data->asJson()->post();
   				break;
   			case 'put':
   				$data = $data->asJson()->put();
   				break;
   			case 'delete':
   				break;
   			
   			default:
   				$data = $data->asJson()->delete();
   				break;
   		}

   		return $data;
   	}
}
