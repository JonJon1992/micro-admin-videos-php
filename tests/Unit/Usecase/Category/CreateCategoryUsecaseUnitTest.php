<?php

namespace Tests\Unit\Usecase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repositories\CategoryRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\Usecase\Category\CreateCategoryUsecase;
use Core\Usecase\DTO\Category\CreateCategory\CreateCategoryInputDto;
use Core\Usecase\DTO\Category\CreateCategory\CreateCategoryOuputDto;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateCategoryUsecaseUnitTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateNewCategory()
    {
        $uuid = (string)Uuid::random();

        $categoryName = 'new Category';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid, $categoryName
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepository = Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);

        $this->mockRepository->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CreateCategoryInputDto::class, [$categoryName]);

        $usecase = new CreateCategoryUsecase($this->mockRepository);

        $response = $usecase->execute($this->mockInputDto);

        $this->assertInstanceOf(CreateCategoryOuputDto::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals('', $response->description);

        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $usecase = new CreateCategoryUsecase($this->spy);
        $response = $usecase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('insert');

        Mockery::close();

    }
}

