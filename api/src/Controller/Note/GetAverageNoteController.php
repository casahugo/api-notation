<?php

declare(strict_types=1);

namespace App\Controller\Note;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAverageNoteController extends AbstractController
{
    /**
     * @Route("/notes/average", name="get_notes_average", methods={"get"})
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return new Response(null, 200);
    }
}
