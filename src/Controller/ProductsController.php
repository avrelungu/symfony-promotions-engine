<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiryDTO;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(Request $request, int $id, DTOSerializer $serializer): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse([
                'error' => 'Promotions Engine failure message'
            ], $request->headers->get('force_fail'));
        }

        // 1. Deserialize JSON data into EnquiryDTO
        /** @var LowestPriceEnquiryDTO $lowestPriceDTO */
        $lowestPriceDTO = $serializer->deserialize($request->getContent(), LowestPriceEnquiryDTO::class, 'json');

        // 2. Pass the Enquiry into a promotions filter and the appropriate promotion will be applied
        
    
        // 3. Return the modified DTO
        $lowestPriceDTO->setDiscountedPrice(50)
            ->setPrice(100)
            ->setPromotionId(3)
            ->setPromotionName('Black Friday half price sale');

        $responseContent = $serializer->serialize($lowestPriceDTO, 'json');

        return new Response($responseContent, 200);
    }
}
