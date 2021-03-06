<?php
/**
 * @copyright 2015 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Tests\Unit\Delivery\Synchronization;

use Contentful\Delivery\ContentType;
use Contentful\Delivery\Synchronization\DeletedEntry;
use Contentful\Delivery\Synchronization\DeletedResource;
use Contentful\Delivery\Space;
use Contentful\Delivery\SystemProperties;

class DeletedResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetter()
    {
        $space = $this->getMockBuilder(Space::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new ConcreteDeletedResource(new SystemProperties(
            '4rPdazIwWkuuKEAQgemSmO',
            'DeletedEntry',
            $space,
            null,
            1,
            new \DateTimeImmutable('2014-08-11T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-12T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-13T08:30:42.559Z')
        ));

        $this->assertEquals('4rPdazIwWkuuKEAQgemSmO', $resource->getId());
        $this->assertEquals($space, $resource->getSpace());
        $this->assertEquals(1, $resource->getRevision());
        $this->assertEquals(new \DateTimeImmutable('2014-08-11T08:30:42.559Z'), $resource->getCreatedAt());
        $this->assertEquals(new \DateTimeImmutable('2014-08-12T08:30:42.559Z'), $resource->getUpdatedAt());
        $this->assertEquals(new \DateTimeImmutable('2014-08-13T08:30:42.559Z'), $resource->getDeletedAt());
    }

    public function testContentTypeDeletedEntry()
    {
        $space = $this->getMockBuilder(Space::class)
            ->disableOriginalConstructor()
            ->getMock();

        $deletedEntry = new DeletedEntry(new SystemProperties(
            '4rPdazIwWkuuKEAQgemSmO',
            'DeletedEntry',
            $space,
            null,
            1,
            new \DateTimeImmutable('2014-08-11T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-12T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-13T08:30:42.559Z')
        ));

        $this->assertNull($deletedEntry->getContentType());

        $ct = $this->getMockBuilder(ContentType::class)
            ->disableOriginalConstructor()
            ->getMock();

        $deletedEntry = new DeletedEntry(new SystemProperties(
            '4rPdazIwWkuuKEAQgemSmO',
            'DeletedEntry',
            $space,
            $ct,
            1,
            new \DateTimeImmutable('2014-08-11T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-12T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-13T08:30:42.559Z')
        ));

        $this->assertEquals($ct, $deletedEntry->getContentType());
    }

    public function testJsonSerialize()
    {
        $space = $this->getMockBuilder(Space::class)
            ->disableOriginalConstructor()
            ->getMock();

        $space->method('getId')
            ->willReturn('cfexampleapi');

        $resource = new ConcreteDeletedResource(new SystemProperties(
            '4rPdazIwWkuuKEAQgemSmO',
            'DeletedEntry',
            $space,
            null,
            1,
            new \DateTimeImmutable('2014-08-11T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-12T08:30:42.559Z'),
            new \DateTimeImmutable('2014-08-13T08:30:42.559Z')
        ));

        $this->assertJsonStringEqualsJsonString(
            '{"sys": {"type": "DeletedEntry","id": "4rPdazIwWkuuKEAQgemSmO","space": {"sys": {"type": "Link","linkType": "Space","id": "cfexampleapi"}},"revision": 1,"createdAt": "2014-08-11T08:30:42.559Z","updatedAt": "2014-08-12T08:30:42.559Z","deletedAt": "2014-08-13T08:30:42.559Z"}}',
            json_encode($resource));
    }
}

class ConcreteDeletedResource extends DeletedResource
{
}
