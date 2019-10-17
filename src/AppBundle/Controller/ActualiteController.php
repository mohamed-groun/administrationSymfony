<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Actualite;
use AppBundle\Form\ActualiteType ;
use Symfony\Component\Filesystem\Filesystem ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile ;


/**
 * Actualite controller.
 *
 * @Route("actualite")
 */
class ActualiteController extends Controller
{
    /**
     * Lists all actualite entities.
     *
     * @Route("/", name="actualite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actualites = $em->getRepository('AppBundle:Actualite')->findAll();

        return $this->render('actualite/index.html.twig', array(
            'actualites' => $actualites,
        ));
    }

    /**
     * Creates a new actualite entity.
     *
     * @Route("/new", name="actualite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $actualite = new Actualite();
        $form = $this->createForm('AppBundle\Form\ActualiteType', $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */

            $file = $form['photo2']->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file-> move(
                $this->getParameter('image_directory'),$fileName
            );



            $actualite->setPhoto($fileName);
            $em =$this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();

            return $this->redirectToRoute('actualite_index');
        }

        return $this->render('actualite/new.html.twig', array(
            'actualite' => $actualite,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     *  * @Route("/delete2/{id}/", name="Delete2")
     */
    public function deleteAct ($id) {

        $em =$this->getDoctrine()->getManager();
        $actualite= $em->getRepository('AppBundle:Actualite')->find($id);
        $actualites = $em->getRepository('AppBundle:Actualite')->findAll();
        $em->remove($actualite);
        $em->flush();
        return $this->redirectToRoute('actualite_index');
        ;
    }

    /**
     * Finds and displays a actualite entity.
     *
     * @Route("/{id}", name="actualite_show")
     * @Method("GET")
     */
    public function showAction(Actualite $actualite)
    {
        $deleteForm = $this->createDeleteForm($actualite);

        return $this->render('actualite/show.html.twig', array(
            'actualite' => $actualite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actualite entity.
     *
     * @Route("/{id}/edit", name="actualite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Actualite $actualite)
    {

        $deleteForm = $this->createDeleteForm($actualite);
        $editForm = $this->createForm('AppBundle\Form\ActualiteType', $actualite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */

       $file = $editForm['photo2']->getData();
      $fileName= md5(uniqid()).'.'.$file->guessExtension();
      $file-> move(
          $this->getParameter('image_directory'),$fileName
      );



            $actualite->setPhoto($fileName);
            $em =$this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();
            $this->addFlash('success', 'Acualité Updated! Inaccuracies squashed!');

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actualite_index');
        }

        return $this->render('actualite/edit.html.twig', array(
            'actualite' => $actualite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @Route("/actualite/test", name="upload_test")
     */
    public function temporaryUploadAction(Request $request)
    {
    }

    /**
     * Deletes a actualite entity.
     *
     * @Route("/{id}", name="actualite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Actualite $actualite)
    {


        $form = $this->createDeleteForm($actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actualite);
            $em->flush();
        }

        return $this->redirectToRoute('actualite_index');
    }

    /**
     * Creates a form to delete a actualite entity.
     *
     * @param Actualite $actualite The actualite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actualite $actualite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actualite_delete', array('id' => $actualite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
