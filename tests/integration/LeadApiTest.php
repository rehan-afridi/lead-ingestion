<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Lead;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class LeadApiTest extends WebTestCase
{
    private $entityManager;
    private static $client;

    public function setUp(): void
    {
        self::$client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        // Ensure the database schema is created
        $this->createSchema();

        parent::setUp();
    }

    public function testCreateLeadSuccess(): void
    {
        $leadData = [
            'postcode' => 'PO10 2EU',
            'reg' => 'lg09eyv',
            'model' => 'VAUXHALL ZAFIRA EXCLUSIV CDTI A',
            'date' => 2009,
            'cylinder' => 1910,
            'colour' => 'blue',
            'keepers' => ['Test User'],
            'contact' => '07222333333',
            'email' => 'testuser@hotmail.com',
            'fuel' => 'DIESEL',
            'trans' => 'Automatic',
            'doors' => 5,
            'mot_due' => "30/03/2025",
            'leadid' => 1484902,
            'vin' => 'W0L0AHM7592067753'
        ];

        self::$client->request('POST', '/leads', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($leadData));

        $response = self::$client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('leadid', $responseData);

        // Fetch the created lead from the database and verify its properties
        $lead = $this->entityManager->getRepository(Lead::class)->find($responseData['leadid']);
        $this->assertNotNull($lead);
        $this->assertEquals('PO10 2EU', $lead->getPostcode());
    }

    public function testCreateLeadEmailValidationFailure(): void
    {
        $leadData = [
            'postcode' => 'PO10 2EU',
            'reg' => 'lg09eyv',
            'model' => 'VAUXHALL ZAFIRA EXCLUSIV CDTI A',
            'date' => 2009,
            'cylinder' => 1910,
            'colour' => 'blue',
            'keepers' => ['Test User'],
            'contact' => '07222333333',
            'email' => 'testuser',
            'fuel' => 'DIESEL',
            'trans' => 'Automatic',
            'doors' => 5,
            'mot_due' => "30/03/2025",
            'leadid' => 1484902,
            'vin' => 'W0L0AHM7592067753'
        ];

        self::$client->request('POST', '/leads', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($leadData));

        $response = self::$client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('fields', $responseData);
        $this->assertArrayHasKey('email', $responseData['fields']);
    }


    private function createSchema(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropDatabase();
        $schemaTool->createSchema($metadata);
    }
}