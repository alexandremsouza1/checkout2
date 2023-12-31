<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Contracts\Customer as CustomerContract;

class Customer extends BaseModel implements CustomerContract
{
    protected $table = 'customers';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'email_confirmed' => 'boolean',
        'password_migrated' => 'boolean',
    ];
    public $timestamps = true;

    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getClientId()
    {
        return $this->client_id;
    }
}
