<?php


namespace App\Trait;


trait StringTrait
{
  private function onlyNumbers($string)
  {
    if($string != '') {
      $string = preg_replace('/[^0-9]/', '', $string);
      return $string;
    }
     return null;
  }

  private function checkOnlyNumbersAndLetters($string) : bool
  {
    $pattern = '/^[a-zA-Z0-9\s]+$/';
    return preg_match($pattern, $string) === 1;
  }
}