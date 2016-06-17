<?php

namespace App\Providers;

use App\CustomValidator;
use Illuminate\Support\ServiceProvider;

/**
 * Class ValidatorServiceProvider
 * @package Providers
 */
class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Validator::resolver(function($translator, $data, $rules, $messages) {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }
    
    public function register()
    {
        
    }
}