<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class DefaultController extends Controller
{
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);

        return $this->render(
            'index.html.twig',
            array(
                'parameter' => $this->container->getParameter('psql_database_host'),
                'products' => $repository->findAll(),
            )
        );
    }

    public function number()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    public function formProduct()
    {
        return $this->render(
            'form.html.twig',
            array(
            )
        );
    }
}