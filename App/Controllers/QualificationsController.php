<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class QualificationsController extends BaseController
{
    public function __construct()
    {
        parent::__construct('qualification');
    }
}
