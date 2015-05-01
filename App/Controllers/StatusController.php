<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends BaseController
{
    public function __construct()
    {
        parent::__construct('status');
    }
}
