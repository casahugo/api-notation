<?php

declare(strict_types=1);

namespace App\Controller\Note;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostNoteController extends AbstractController
{
    /**
     * @Route("/students/{id}/notes", name="post_notes", methods={"post"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function __invoke(int $id, Request $request): Response
    {
        return new Response(null, 200);
    }
}
