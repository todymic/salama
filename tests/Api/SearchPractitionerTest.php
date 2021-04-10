<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Availability;
use App\Entity\User\Practitioner;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class SearchPractitionerTest.
 */
class SearchPractitionerTest extends ApiTestCase
{
    use FixturesTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->loadFixtures(
            [
                "App\DataFixtures\PractitionerFixture",
            ]
        );

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /** @test */
    public function getListPractioners(): void
    {
        $response = static::createClient()->request('GET', '/api/practitioners');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains(['@id' => '/api/practitioners']);
        $this->assertMatchesResourceCollectionJsonSchema(Practitioner::class);
    }

    /** @test */
    public function getOnePractioner(): void
    {
        $response = static::createClient()->request('GET', '/api/practitioners/1');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/practitioners/1']);
        $this->assertMatchesResourceItemJsonSchema(Practitioner::class);
    }

    /**
     * @test
     * @dataProvider specialityProvider
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function searchBySpeciality(int $specialityId)
    {
        $response = static::createClient()
            ->request('GET', '/api/specialities/'.$specialityId.'/practitioners');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonContains(['hydra:member' => [['@id' => '/api/practitioners/1']]]);
        $this->assertMatchesResourceCollectionJsonSchema(Practitioner::class);
    }

    public function specialityProvider(): array
    {
        return [
            [1],
        ];
    }

    /**
     * @test
     * @dataProvider practitionerProvider
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function searchAvailabilities(int $practitionerId)
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\AvailabilityFixture",
            ]
        );
        $response = static::createClient()
            ->request('GET', '/api/practitioners/'.$practitionerId.'/availabilities');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonContains(['hydra:member' => [['@id' => '/api/availabilities/1']]]);
        $this->assertMatchesResourceCollectionJsonSchema(Availability::class);
    }

    /**
     * @return int[][]
     */
    public function practitionerProvider(): array
    {
        return [
            [1],
        ];
    }

    public function languageProvider(): array
    {
        return [
            [1],
        ];
    }

    /**
     * @test
     * @dataProvider languageProvider
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getPractitionerLanguages(int $languageId): void
    {
        $response = static::createClient()
            ->request('GET', '/api/languages/'.$languageId.'/practitioners');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonContains(['hydra:member' => [['@id' => '/api/practitioners/1']]]);
        $this->assertMatchesResourceCollectionJsonSchema(Practitioner::class);
    }
}
