<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

/**
 * Class Base
 * @package App\Models
 * @property string $_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
abstract class BaseModel extends Model
{
    const PRIMARY_KEY       = 'id';


    /**
     * @param $data
     * @return bool
     */
    public function validate()
    {
        $validator = app('validator')->make($this->toArray(), $this->rules());
  
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return true;
    }

}
