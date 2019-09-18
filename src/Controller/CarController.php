<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CarController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(CarRepository $carRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'title' => "Bienvenue chez votre concessionnaire",
        ]);
    }

    /**
     * @Route("/car", name="car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository): Response
    {
        $brands = $carRepository->findBrandData();
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findAll(),
            'brands' => $brands
        ]);
    }

    /**
     * @Route("/car/new", name="car_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/car/{id}", name="car_show", methods={"GET"})
     */
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/car/{id}/edit", name="car_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Car $car): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/car/{id}", name="car_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Car $car): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_index');
    }
}
