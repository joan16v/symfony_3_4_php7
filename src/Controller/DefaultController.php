<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);

        return $this->render(
            'index.html.twig',
            array(
                'parameter' => $this->container->getParameter('psql_database_host'),
                'products' => $repository->findBy(array(), array('name' => 'ASC')),
            )
        );
    }

    public function number()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>The Lucky number: ' . $number . '</body></html>'
        );
    }

    public function formProduct(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('price', NumberType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render(
            'form.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function editProduct(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findOneById($id);

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('price', NumberType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render(
            'form.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function deleteProduct($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
