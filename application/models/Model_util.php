<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_util extends CI_Model {

    public function isLastDayInMonth($day){
        $date = new DateTime('now');
        $date = $date->format('Y-m-d');

        $lastDay = $this->getLastDayInMonth();

        if($date === $lastDay){
            return true;
        }
        return false;
    }

    public function getLastDayInMonth($day){
        $date1 = new DateTime($day);
        $date1->modify('last day of this month');
        return $date1->format('Y-m-d');
    }


}