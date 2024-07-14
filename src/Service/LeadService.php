<?php

namespace App\Service;

use App\Entity\Lead;
use App\Entity\KeeperHistory;
use App\Repository\LeadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LeadService
{
    private $entityManager;
    private $leadRepository;
    private $validator;


    public function __construct(EntityManagerInterface $entityManager, LeadRepository $leadRepository, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->leadRepository = $leadRepository;
        $this->validator = $validator;
    }

    public function createLead(array $data): Lead
    {
        $lead = new Lead();
        $lead->setId($data['leadid']);
        $lead->setPostcode($data['postcode']);
        $lead->setReg($data['reg']);
        $lead->setModel($data['model']);
        $lead->setRegYear($data['date']);
        $lead->setCylinderCapacity($data['cylinder']);
        $lead->setColour($data['colour']);
        $lead->setContact($data['contact']);
        $lead->setEmail($data['email']);
        $lead->setFuel($data['fuel']);
        $lead->setTransmission($data['trans']);
        $lead->setDoors($data['doors']);
        $motDue = \DateTime::createFromFormat('d/m/Y', $data['mot_due']);
        $lead->setMotDue($motDue);
        $lead->setVin($data['vin']);
        $lead->setKeepersCount(count($data['keepers']));

        // Tag the lead based on certain criteria as scrape or salvage
        $leadStatus = $this->tagLead($lead);
        $lead->setStatus($leadStatus);

        // Validate the lead, error out if invalid
        $this->validateLead($lead);
        
        // Persist the lead
        $this->entityManager->persist($lead);

        // Process keepers history
        foreach ($data['keepers'] as $keeperData) {
            $keeperHistory = new KeeperHistory();
            $keeperHistory->setLead($lead);
            $keeperHistory->setKeeperName($keeperData);
            $this->entityManager->persist($keeperHistory);
        }

        $this->entityManager->flush();

        return $lead;
    }

    private function validateLead($lead): void
    {
        $violations = $this->validator->validate($lead);

        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new \InvalidArgumentException(json_encode($errors));
        }
    }

    private function tagLead($lead): string
    {
        // This function will tag leads based on certain criteria as scrape or salvage
        // For now, we will just look at registration year and tag leads with reg year before 2000 as scrape
        if ($lead->getRegYear() < 2000) {
            return 'scrape';
        } else {
            return 'salvage';
        }
    }

    // Other methods for lead management (update, delete, fetch by ID, etc.) can go here
}
