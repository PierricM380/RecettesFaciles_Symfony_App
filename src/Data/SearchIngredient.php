<?php

namespace App\Data;

use App\Entity\Ingredient;

class SearchIngredient
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