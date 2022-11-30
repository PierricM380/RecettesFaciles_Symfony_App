<?php

namespace App\Data;

use App\Entity\Recipe;

class searchRecipe
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Recipe[]
     */
    public $name = [];
}