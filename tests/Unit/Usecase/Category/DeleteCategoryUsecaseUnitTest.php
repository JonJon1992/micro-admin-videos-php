<?php

namespace Tests\Unit\Usecase\Category;

use Core\Domain\Repositories\CategoryRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\Usecase\Category\DeleteCategoryUsecase;
use Core\Usecase\DTO\Category\CategoryInputDto;
use Core\Usecase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class DeleteCategoryUsecaseUnitTest extends TestCase
{
    public function testDelete()
    {
        $uuid = (string)Uuid::random();
        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $this->mockRepository->shouldReceive('delete')->andReturn(true);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

        $usecase = new DeleteCategoryUsecase($this->mockRepository);
        $response = $usecase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $response);
        $this->assertTrue($response->sucess);

        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);
        $usecase = new DeleteCategoryUsecase($this->spy);
        $response = $usecase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse()
    {
        $uuid = (string)Uuid::random();
        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $this->mockRepository->shouldReceive('delete')->andReturn(false);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

        $usecase = new DeleteCategoryUsecase($this->mockRepository);
        $response = $usecase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $response);
        $this->assertFalse($response->sucess);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}