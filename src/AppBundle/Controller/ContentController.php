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
class ContentController extends Controller
{
    /**
     * Lists all content entities.
     *
     * @Route("/", name="content_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contents = $em->getRepository('AppBundle:Content')->findAll();
        $texte = $em->getRepository('AppBundle:Texte')->findAll();

        return $this->render('content/index.html.twig', array(
            'contents' => $contents,
            'texte' => $texte,
        ));
    }

    /**
     * Creates a new content entity.
     *
     * @Route("/new", name="content_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $content = new Content();
        $form = $this->createForm('AppBundle\Form\ContentType', $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($content);
            $em->flush();

            return $this->redirectToRoute('admin_page');
        }

        return $this->render('content/new.html.twig', array(
            'content' => $content,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a content entity.
     *
     * @Route("/{id}", name="content_show")
     * @Method("GET")
     */
    public function showAction(Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);

        return $this->render('content/show.html.twig', array(
            'content' => $content,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing content entity.
     *
     * @Route("/{id}/edit", name="content_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);
        $editForm = $this->createForm('AppBundle\Form\ContentType', $content);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('content_edit', array('id' => $content->getId()));
        }

        return $this->render('content/edit.html.twig', array(
            'content' => $content,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a content entity.
     *
     * @Route("/{id}", name="content_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Content $content)
    {
        $form = $this->createDeleteForm($content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($content);
            $em->flush();
        }

        return $this->redirectToRoute('content_index');
    }

    /**
     * Creates a form to delete a content entity.
     *
     * @param Content $content The content entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Content $content)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('content_delete', array('id' => $content->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
