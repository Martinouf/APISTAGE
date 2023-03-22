<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Service\ApiKeyService;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiStudentController extends AbstractController
{
    /**
     * @Route(
     * "/api/student",
     *  name="api_student",
     * methods={"GET"}
     * )
     */
    public function index( StudentRepository $studentRepository, NormalizerInterface $normalizer, ApiKeyService $apiKeyService, Request $request): JsonResponse
    {
        //
        $authorized = $apiKeyService->checkApiKey($request);

        dd($authorized);

        //Récup tout les étudiants
        $student = $studentRepository->findAll();

        $json = json_encode($student);

        $studentNormalised = $normalizer->normalize(
            $student,
            'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]
        );

        dd($student, $json, $studentNormalised);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiStudentController.php',
        ]);
    }

    /**
     * @Route(
     * "/api/student",
     * name ="api_student_post",
     * methods={"POST"}
     * )
     */
    public function add( Request $request, EntityManagerInterface $entityManager ): JsonResponse
    {

        //On attend un requete au format json (Content-Type application/json)
        //TODO: Verifier le Content-Type

        //Récup du body (les infos)
        //dd($request->toArray());

        //On stock le body de la requete dans $dataFromRequest
        $dataFromRequest = $request->toArray();

        //*****************************************
        //Ici les données ont été vérif, on peut créer une nouvelle instance de Student
        $student = new Student();
        $student->setName($dataFromRequest['name']);
        $student->setFirstname($dataFromRequest['firstname']);
        $student->setDateOfBirth(new DateTime($dataFromRequest['date_of_birth']));
        $student->setPicture($dataFromRequest['picture']);
        $student->setGrade($dataFromRequest['grade']);
        
        //dd($student);

        //Insertion en base de l'instance student
        $entityManager->persist($student);
        $entityManager->flush();

        return $this->json([
            'status'=>'ok'
        ]);
    }
}
