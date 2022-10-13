<?php

namespace Core\Usecase\DTO\Category\DeleteCategory;


class CategoryDeleteOutputDto
{
    public function __construct(public bool $sucess)
    {
    }
}