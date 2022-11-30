<?php

namespace App\Data;

use App\Entity\Ingredient;

class searchIngredient
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Ingredient[]
     */
    public $name = [];
}