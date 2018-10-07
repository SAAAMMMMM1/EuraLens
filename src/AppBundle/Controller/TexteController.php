<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Content;
use AppBundle\Entity\Texte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Content controller.
 *
 * @Route("content")
 */
class TexteController extends Controller
{

  /**
   * Displays a form to edit an existing content entity.
   *
   * @Route("/texte/{id}/edit", name="texte_edit")
   * @Method({"GET", "POST"})
   */
  public function editTexteAction(Request $request, Content $content, Texte $texte)
  {
      $deleteForm = $this->createDeleteForm($texte);
      $editForm = $this->createForm('AppBundle\Form\ContentType', $texte);
      $editForm->handleRequest($request);

      if ($editForm->isSubmitted() && $editForm->isValid()) {
          $this->getDoctrine()->getManager()->flush();

          return $this->redirectToRoute('texte_edit', array('id' => $texte->getId()));
      }

      return $this->render('content/edit.html.twig', array(
          'content' => $content,
          'texte' => $texte,
          'edit_form' => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
      ));
  }

}
