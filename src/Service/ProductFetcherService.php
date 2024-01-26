<?php

namespace App\Service;

use App\Response\ClientProviderResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Factory\ClientProviderFactory;
use App\Validator\GenericProductProviderValidator;

class ProductFetcherService
{
    public function __construct(
        private GenericProductProviderValidator $validator,
        private ClientProviderFactory $factory,
    )
    {

    }
    public function getSingle(Request $request): ClientProviderResponse
    {
        $id = $request->get('id');
        $marketplace = $request->get('filter')['marketplace'] ?? null;

        $this->validator->validate([
            'item_id' => $id,
            'marketplace' => $marketplace,
        ]);

        $client = $this->factory->create($marketplace);

        return $client->getProduct($id);
    }
}
