<?php

function getCategory() {
    $categorySelection = file("category.txt");
    $category_nummer = rand(0, count($categorySelection)-1);
    $value = array(true, 0, true, $categorySelection[$category_nummer]);
    $category = new Category($value);
}


