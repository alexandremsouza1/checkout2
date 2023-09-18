<?php


namespace App\Trait;


trait DateTrait
{
  private function treat_birth($dt)
  {
      if ($dt != '') {
          $dt = str_replace(',','',$dt);
          $dt = explode(" ", $dt);
          $dt = explode("/", $dt[0]);
          $dt = array_reverse($dt);
          $dt = implode("-", $dt);
          return $dt;
      }
      return false;
  }
}