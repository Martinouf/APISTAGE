<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiCompanyController extends AbstractController
{
    /**
     * @Route(
     * "/api/company",
     *  name="api_company",
     * methods={"GET"}
     * )
     */
    public function index( CompanyRepository $CompanyRepository, NormalizerInterface $normalizer ): JsonResponse
    {

        //Récup tout les étudiants
        $company = $CompanyRepository->findAll();

        $json = json_encode($company);

        $companyNormalised = $normalizer->normalize(
            $company,
            'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]
        );

        dd($company, $json, $companyNormalised);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiStudentController.php',
        ]);
    }

    /**
     * @Route(
     * "/api/company",
     * name ="api_company_post",
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
        $company = new Company();
        $company->setName($dataFromRequest['name']);
        $company->setStreet($dataFromRequest['street']);
        $company->setzipcode($dataFromRequest['zipcode']);
        $company->setCity($dataFromRequest['city']);
        $company->setwebsite($dataFromRequest['website']);
        
        //dd($student);

        //Insertion en base de l'instance student
        $entityManager->persist($company);
        $entityManager->flush();

        return $this->json([
            'status'=>'ok'
        ]);
    }
}
