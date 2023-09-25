<?php

namespace App\Contracts;

interface Customer
{
    public function getId();

    public function getFirstName();

    public function getLastName();

    public function getEmail();
}
