<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repo;

    public function __construct(PropertyRepository $repo, EntityManagerInterface $em)
    {
        $this->repo=$repo;
        $this->em=$em;
    }
    /**
     * @Route("/admin", name="admin_property.index")
     */
    public function index(): Response
    {
        $properties=$this->repo->findAll();
        return $this->render('admin_property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/admin/property/create", name="admin_property.new")
     */
    public function new(Request $request): Response
    {
        $property=new Property();
        $form=$this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', "Bien crée avec succés");

            return $this->redirectToRoute('admin_property.index');
        }
        return $this->render('admin_property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin_property.delete",methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', "Bien supprimé avec succés");
        }
        return $this->redirectToRoute('admin_property.index');
    }

    /**
     * @Route("/admin/property/{id}", name="admin_property.edit",methods="GET|POST")
     */
    public function edit(Property $property, Request $request): Response
    {
        $form=$this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Bien modifié avec succés");
            return $this->redirectToRoute('admin_property.index');
        }
        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }
}
