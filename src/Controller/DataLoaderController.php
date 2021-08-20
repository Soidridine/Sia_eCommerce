<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Categories;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataLoaderController extends AbstractController
{
    /**
     * @Route("/data", name="data_loader")
     */
    public function index(EntityManagerInterface $manager, UserRepository $repoUser): Response
    {
        $file_products = "../../products.json";
        $data_products = json_decode(file_get_contents($file_products))[0]->rows;

        $file_categories = "../../categories.json";
        $data_categories = json_decode(file_get_contents($file_categories))[0]->rows; // on reçoit un tableau qui a la clé 0 et les données sont dans rows
        
        $categories = [];

        foreach ($data_categories as $data_category)
        {
            $category = new Categories();
            $category->setName($data_category[1])
                     ->setImage($data_category[3]); // pour recuperer l'image qui est a la position 3
            
           // $manager->persist($category);
            $categories[] = $category;
        }

        $products = [];
        
        foreach ($data_products as $data_product) {
            
            $product = new Product();
            
            $product->setName($data_product[1])
                    ->setDescription($data_product[2])
                    ->setPrice($data_product[4])
                    ->setIsBestSeller($data_product[5])
                    ->setIsNewArrival($data_product[6])
                    ->setIsFeatured($data_product[7])
                    ->setIsSpecialOffer($data_product[8])
                    ->setImage($data_product[9])
                    ->setQuantity($data_product[10])
                    ->setTags($data_product[12])
                    ->setSlug($data_product[13])
                    ->setCreatedAt( new \DateTime());
                    
           // $manager->persist($product);
            $products[] = $product;
        }
        // $user = $repoUser->find(1);
        // $user->setRoles(['ROLE_ADMIN']);
       // $manager->flush();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataLoaderController.php',
        ]);
    }
}