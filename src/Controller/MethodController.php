<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MethodController
 * @Route("/method", name="method_")
 */
class MethodController extends AbstractController
{
    /**
     * @Route("/", name="show")
     */
    public function show() : Response
    {
        return $this->render('method/show.html.twig');
    }
}