<?php

namespace Tests\Unit\Domain\Entity;


use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New Cat',
            description: 'New Desc',
            isActive: true
        );

        $this->assertNotEmpty($category->createdAt());
        $this->assertNotEmpty($category->id());
        $this->assertEquals('New Cat', $category->name);
        $this->assertEquals('New Desc', $category->description);
        $this->assertEquals(true, $category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(name: 'New Category', isActive: false);
        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);

    }

    public function testDisabled()
    {
        $category = new Category(name: 'New Category',);
        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);

    }

    /**
     * @throws Exception
     */
    public function testUpdate()
    {
        $uuid = (string)RamseyUuid::uuid4()->toString();
        $category = new Category(id: $uuid, name: 'New Category',
            description: 'New Description',
            isActive: true,
            createdAt: '2024-01-01 10:14:14');

        $category->update(name: 'new_name', description: 'new_desc');

        $this->assertEquals($uuid, $category->id());
        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_desc', $category->description);
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'Na', description: 'New Description'
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(name: 'New Category', description: random_bytes(999999));
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}