<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class Home
{
    #[Route('')]
    public function homePage(): Response
    {
        return new Response(
        '<html><body><a href="recipes"></body></html>'
    );
    }
}