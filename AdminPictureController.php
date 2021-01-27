<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPictureController extends AbstractController
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
     * @Route("/admin/property/{id}", name="admin_property.delete",methods="DELETE")
     */
    public function delete(Picture $picture, Request $request)
    {
        $data=\json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete'. $picture->getId(), $data['_token'])) {
            $this->em->remove($property);
            $this->em->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalid'], 400);
        }
    }
}
