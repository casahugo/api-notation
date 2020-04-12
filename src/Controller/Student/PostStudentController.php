<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostStudentController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(StudentRepository $studentRepository, ValidatorInterface $validator)
    {
        $this->studentRepository = $studentRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/students", name="post_student", methods={"post"})
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $student = (new Student())
            ->setFirstname($request->get('firstname', ''))
            ->setLastname($request->get('lastname', ''))
            ->setBirthday(new \DateTime($request->get('birthday', '')))
        ;

        $errors = $this->validator->validate($student);

        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        //$this->studentRepository->save($student);

        return new Response(null, 201);
    }
}
