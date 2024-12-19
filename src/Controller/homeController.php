<?php 

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class homeController extends AbstractController
{
    #[Route(path:"/")]
    public function index(): Response
    {

        $contents = $this->renderView('home/index.html.twig');

        return new Response($contents);
    }

    
}