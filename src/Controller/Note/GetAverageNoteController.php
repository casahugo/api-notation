<?php

declare(strict_types=1);

namespace App\Controller\Note;

use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetAverageNoteController
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * @Route("/notes/average", name="get_notes_average", methods={"get"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['average' => $this->noteRepository->getAverage()], 200);
    }
}
