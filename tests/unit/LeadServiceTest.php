<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Lead;
use App\Service\LeadService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LeadRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ReflectionClass;

class LeadServiceTest extends TestCase
{
    public function testTagLead(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $leadRepository = $this->createMock(LeadRepository::class);
        $validator = $this->createMock(ValidatorInterface::class);

        $leadService = new LeadService($entityManager, $leadRepository, $validator);
        $reflection = new ReflectionClass($leadService);
        $tagResultMethod = $reflection->getMethod('tagLead');
        $tagResultMethod->setAccessible(true);

        $lead = new Lead();
        $lead->setRegYear(2000);
        
        $tagResult = $tagResultMethod->invoke($leadService, $lead);
        $this->assertEquals('salvage', $tagResult);

        $lead->setRegYear(2010);
        $tagResult = $tagResultMethod->invoke($leadService, $lead);
        $this->assertEquals('salvage', $tagResult);

        $lead->setRegYear(1999);
        $tagResult = $tagResultMethod->invoke($leadService, $lead);
        $this->assertEquals('scrape', $tagResult);
    }
}
