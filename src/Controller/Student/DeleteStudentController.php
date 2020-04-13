<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteStudentController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/students/{id}", name="remove_student", methods={"delete"})
     */
    public function __invoke(int $id, Request $request): Response
    {
        $student = $this->studentRepository->find($id);

        if (\is_null($student)) {
            return new Response('Student not found', 404);
        }

        try {
            $this->studentRepository->delete($student);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), 400);
        }

        return new Response(null, 204);
    }
}
