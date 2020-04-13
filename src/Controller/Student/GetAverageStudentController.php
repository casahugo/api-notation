<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetAverageStudentController
{
    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * @Route("/students/{id}/average", name="get_student_average", methods={"get"})
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $result = $this->noteRepository->getAverageByStudentId($id);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['average' => $result], 200);
    }
}
