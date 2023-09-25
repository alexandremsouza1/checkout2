<?php


namespace App\Trait;

use Illuminate\Support\Str;


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

  public function convertToSnakeCase($data)
  {
      $result = [];
      if(!is_array($data)) {
          return $result;
      }
      foreach ($data as $key => $value) {
          $snakeCaseKey = Str::snake($key);
          $result[$snakeCaseKey] = $value;
      }
  
      return $result;
  }

}