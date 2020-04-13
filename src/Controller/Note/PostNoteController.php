<?php

declare(strict_types=1);

namespace App\Controller\Note;

use App\Entity\Note;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostNoteController
{
    private StudentRepository $studentRepository;

    private ValidatorInterface $validator;

    public function __construct(StudentRepository $studentRepository, ValidatorInterface $validator)
    {
        $this->studentRepository = $studentRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/students/{id}/notes", name="post_notes", methods={"post"})
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {
        $student = $this->studentRepository->find($id);

        if (\is_null($student)) {
            return new JsonResponse('Student not found', 404);
        }

        $note = (new Note())
            ->setValue($request->get('value', null))
            ->setCategory($request->get('category', ''))
        ;

        $errors = $this->validator->validate($note);

        if (count($errors) > 0) {
            return new JsonResponse([], 400);
        }

        $student->saveNote($note);

        $this->studentRepository->save($student);

        return new JsonResponse([
            'id' => $note->getId(),
            'value' => $note->getValue(),
            'category' => $note->getCategory(),
        ], 201);
    }
}
