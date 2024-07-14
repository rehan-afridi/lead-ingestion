<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LeadService;

class LeadController extends AbstractController
{
    private $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    #[Route('/leads', name: 'app_lead')]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $lead = $this->leadService->createLead($data);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['status' => 'error', 'fields' => json_decode($e->getMessage())], JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['status' => 'error', 'message' => 'Failed to create lead: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['status' => 'success', 'leadid' => $lead->getId(), 'status' => $lead->getStatus()], JsonResponse::HTTP_CREATED);
    }
}
