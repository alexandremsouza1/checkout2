<?php

namespace App\Contracts;

interface Product
{
    public function getPrice();

    public function getName();

    public function hasImage();

    public function getImageUrl();
}
