<?php

namespace App\Controller;

use App\Controller\Validators\CreateProductValidator;
use App\Memory\ProductCollection;
use App\Services\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

class ProductsController extends AbstractController
{
    public function __construct(
        public Products $service,
        public ProductCollection $productCollection,
    ){
    }

    #[Route('/products', name: 'products', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $data = $request->toArray();

            $validator = (new CreateProductValidator())
                ->name($data['name'])
                ->description($data['description'])
                ->price($data['price']);

            $product = $this->service->create($request->toArray());

            return new JsonResponse([
                'message' => 'Product created successfully',
                'code' => 201,
                'data' => $product,
            ]);

        } catch (Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], 500);
        }
    }

    #[Route('/products/{id}', name: 'product', methods: ['GET'])]
    public function get(string $id): JsonResponse
    {
        try {
            $product = $this->productCollection->getProduct($id);
            $this->productCollection->addProduct($product);

            return new JsonResponse([
                'message' => 'Product retrieved successfully',
                'code' => 200,
                'data' => $product,
            ]);
        } catch (ResourceNotFoundException) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }  catch (Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], 500);
        }
    }

    #[Route('/products/{id}', name: 'product', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $product = $this->productCollection->getProduct($id);

            $this->service->update($product, $request->toArray());
            $this->productCollection->update($product);

            return new JsonResponse([
                'message' => 'Product updated successfully',
                'code' => 200,
                'data' => $product,
            ]);
        } catch (ResourceNotFoundException) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }  catch (Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], 500);
        }
    }

    #[Route('/products', name: 'products', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            $list = $this->productCollection->list();

            return new JsonResponse([
                'message' => 'Products list',
                'data' => $list,
                'code' => 200,
            ]);
        } catch (Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], 500);
        }
    }

    #[Route('/products/{id}', name: 'product', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->productCollection->delete($id);
            return new JsonResponse([
                'message' => 'Product deleted successfully',
                'code' => 200,
            ]);
        } catch (Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], 500);
        }
    }
}