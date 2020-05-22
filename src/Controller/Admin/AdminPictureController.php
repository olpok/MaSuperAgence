<?php

namespace App\Controller\Admin;

use App\Entity\Picture;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/picture")
 */

class AdminPictureController extends AbstractController{

    /**
     * @Route("/{id}", name="admin_picture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Picture $picture): Response
    {
        $propertyId = $picture->getProperty()->getId();

        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_property_edit', ['id' => $propertyId]);
    }

}