<?php

namespace Core\Usecase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repositories\CategoryRepositoryInterface;
use Core\Usecase\DTO\Category\CreateCategory\{CreateCategoryInputDto, CreateCategoryOuputDto};
use Exception;


class CreateCategoryUsecase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateCategoryInputDto $inputDto): CreateCategoryOuputDto
    {
        $category = new Category(
            name: $inputDto->name, description: $inputDto->description, isActive: $inputDto->isActive
        );
        $newCategory = $this->repository->insert($category);

        return new CreateCategoryOuputDto(id: $newCategory->id(),
            name: $newCategory->name,
            description: $newCategory->description,
            is_active: $category->isActive,
            created_at: $category->createdAt());
    }
}