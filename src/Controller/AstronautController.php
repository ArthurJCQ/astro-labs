<?php

namespace App\Controller;

use App\Entity\Astronaut;
use App\Form\AstronautType;
use App\Repository\AstronautRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AstronautController extends AbstractFOSRestController
{
    /**
     * Retrieves the list of all Astronauts resource
     * @Rest\Get("/astronauts")
     * @param Request $request
     * @return View
     */
    public function getAstronauts(): View
    {
        // We try to get the list of our astronauts
        $astronauts = $this->getDoctrine()
        ->getRepository(Astronaut::class)
        ->findAll();

        if (!$astronauts) {
            // In case our Get is a failure because there is no astronaut to retrieve
            throw $this->createNotFoundException(
                'No astronauts found.'
            );
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of astronaut object
        return View::create($astronauts, Response::HTTP_OK);
    }

    /**
     * Retrieves one Astronaut resource
     * @Rest\Get("/astronaut/{id}", requirements={"id"="\d+"})
     * @param Request $request
     * @return View
     */
    public function getAstronaut(int $id): View
    {
        // We try to find the astronaut regarding to the given id
        $astronaut = $this->getDoctrine()
        ->getRepository(Astronaut::class)
        ->find($id);

        if (!$astronaut) {
            // In case our Get is a failure because we don't find the relevant astronaut
            throw $this->createNotFoundException(
                'No astronaut found for id '.$id
            );
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the astronaut object
        return View::create($astronaut, Response::HTTP_OK);
    }

    /**
     * Creates an Astronaut resource
     * @Rest\Post("/astronaut")
     * @param Request $request
     * @return View
     */
    public function postAstronaut(Request $request, EntityManagerInterface $em): View
    {
        // We create the new resource and its form
        $astronaut = new Astronaut();
        $form = $this->createForm(AstronautType::class, $astronaut);

        // We deserialize the received datas
        $data = json_decode($request->getContent(), true);

        // We submit the data to the form we created for the astronaut entity
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            // If it's ok, we populate the object and we save it in our DB
            $em->persist($astronaut);
            $em->flush();

            // In case our POST was a success we need to return a 201 HTTP CREATED response
            return View::create($astronaut, Response::HTTP_CREATED);
        }

        throw new BadRequestHttpException(
            'Erreur :' . $form->getErrors()
        );
    }
}
