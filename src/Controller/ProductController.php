<?php

namespace App\Controller;

use App\Service\ProductFetcherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products/{id}', name: 'product.get', methods: ['GET'])]
    public function get(Request $request, ProductFetcherService $service): Response
    {
        try {
            $data = $service->getSingle($request);
        } catch(\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->json($data->toArray());
    }
}
