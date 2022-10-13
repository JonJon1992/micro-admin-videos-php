<?php

namespace Core\Usecase\Category;

use Core\Domain\Repositories\CategoryRepositoryInterface;
use Core\Usecase\DTO\Category\{CategoryInputDto, DeleteCategory\CategoryDeleteOutputDto};


class DeleteCategoryUsecase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDto $inputDto): CategoryDeleteOutputDto
    {
        $response = $this->repository->delete($inputDto->id);
        return new CategoryDeleteOutputDto(sucess: $response);
    }
}