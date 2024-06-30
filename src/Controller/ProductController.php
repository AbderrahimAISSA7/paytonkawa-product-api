<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route('/products', name: 'product_')]
class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //#[Route('/', name: 'list', methods:['GET'])]
    public function list(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return $this->json($products);
    }

    //#[Route('/{id}', name: 'shox', methods:['GET'])]
    public function show($id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->json($product);
    }

    //#[Route('/', name: 'create', methods:['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description'] ?? null);
        $product->setPrice($data['price']);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->json($product, Response::HTTP_CREATED);
    }

    //#[Route('/{id}', name: 'update', methods:['PUT'])]
    public function update(Request $request, $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $data = json_decode($request->getContent(), true);
        $product->setName($data['name']);
        $product->setDescription($data['description'] ?? null);
        $product->setPrice($data['price']);

        $this->entityManager->flush();

        return $this->json($product);
    }

    //#[Route('/{id}', name: 'delete', methods:['DELETE'])]
    public function delete($id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}

