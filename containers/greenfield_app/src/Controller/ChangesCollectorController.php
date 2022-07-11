<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class ChangesCollectorController extends AbstractController
{
    #[Route('/api/collector', methods: ['POST'])]
    public function collectChanges(Request $request, LoggerInterface $logger): Response
    {
        $data = $request->toArray();
        $logger->info('Changes collected. ', [
            'data' => $data
        ]);
        return $this->json([
            'message' => 'Changes collected.'
        ]);
    }
}
