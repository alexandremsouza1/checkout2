<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum PaymentMethods {
  case bankSlip;
  case pix;
  case credit;
  case debit;
  // case Financing;
  // case NonAuthenticatedDebit;
  
  public static function getValue(string $method) {
      return match ($method) {
          'A' => self::bankSlip,
          'N' => self::pix,
          'X' => self::credit,
          'Y' => self::debit,
          // 'I' => self::Financing,
          // 'Z' => self::NonAuthenticatedDebit,
          default => null,
      };
  }
}
