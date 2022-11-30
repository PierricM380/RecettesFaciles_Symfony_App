<?php

namespace App\Data;

use App\Entity\Recipe;

class SearchRecipe
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