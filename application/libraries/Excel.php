<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 12/4/18
 * Time: 1:49 PM
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/Classes/PHPExcel.php";
require_once APPPATH."/third_party/Classes/PHPExcel/IOFactory.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}