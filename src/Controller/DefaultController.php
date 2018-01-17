<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        $response = '<html><body>';
        $response .= '<div>Index</div>';
        $response .= '<div>' . $this->container->getParameter('psql_database_host') . '</div>';
        $response .= '<html></body></html>';

        return new Response($response);
    }

    public function number()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}