<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostStudentController
{
    private StudentRepository $studentRepository;

    private ValidatorInterface $validator;

    public function __construct(StudentRepository $studentRepository, ValidatorInterface $validator)
    {
        $this->studentRepository = $studentRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/students", name="post_student", methods={"post"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $student = (new Student())
            ->setFirstname($request->get('firstname', ''))
            ->setLastname($request->get('lastname', ''))
            ->setBirthday(new \DateTime($request->get('birthday', '')))
        ;

        $errors = $this->validator->validate($student);

        if (count($errors) > 0) {
            return new JsonResponse([], 400);
        }

        $this->studentRepository->save($student);

        return new JsonResponse([
            'id' => $student->getId(),
            'firstname' => $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'birthday' => $student->getBirthday()->format('Y-m-d'),
        ], 201);
    }
}
