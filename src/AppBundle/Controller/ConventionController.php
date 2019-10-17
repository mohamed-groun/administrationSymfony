<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Convention;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile ;


/**
 * Convention controller.
 *
 * @Route("convention")
 */
class ConventionController extends Controller
{
    /**
     * Lists all convention entities.
     *
     * @Route("/", name="convention_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('AppBundle:Convention')->findAll();

        return $this->render('convention/index.html.twig', array(
            'conventions' => $conventions,
        ));
    }

    /**
     * Creates a new convention entity.
     *
     * @Route("/new", name="convention_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $convention = new Convention();
        $form = $this->createForm('AppBundle\Form\ConventionType', $convention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */

            $file = $form['photo2']->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file-> move(
                $this->getParameter('image_directory2'),$fileName
            );
            $convention->setPhoto($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($convention);
            $em->flush();

            return $this->redirectToRoute('convention_index');
        }

        return $this->render('convention/new.html.twig', array(
            'convention' => $convention,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a convention entity.
     *
     * @Route("/{id}", name="convention_show")
     * @Method("GET")
     */
    public function showAction(Convention $convention)
    {
        $deleteForm = $this->createDeleteForm($convention);

        return $this->render('convention/show.html.twig', array(
            'convention' => $convention,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing convention entity.
     *
     * @Route("/{id}/edit", name="convention_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Convention $convention)
    {
        $deleteForm = $this->createDeleteForm($convention);
        $editForm = $this->createForm('AppBundle\Form\ConventionType', $convention);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */

            $file = $editForm['photo2']->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file-> move(
                $this->getParameter('image_directory2'),$fileName
            );
            $convention->setPhoto($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('convention_index');
        }

        return $this->render('convention/edit.html.twig', array(
            'convention' => $convention,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     *  * @Route("/delete2/{id}/", name="Delete2")
     */
    public function deleteAct ($id) {

        $em =$this->getDoctrine()->getManager();
        $convention= $em->getRepository('AppBundle:Convention')->find($id);
        $conventions = $em->getRepository('AppBundle:Convention')->findAll();
        $em->remove($convention);
        $em->flush();
        return $this->redirectToRoute('convention_index');
        ;
    }


    /**
     * Deletes a convention entity.
     *
     * @Route("/{id}", name="convention_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Convention $convention)
    {
        $form = $this->createDeleteForm($convention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($convention);
            $em->flush();
        }

        return $this->redirectToRoute('convention_index');
    }

    /**
     * Creates a form to delete a convention entity.
     *
     * @param Convention $convention The convention entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Convention $convention)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('convention_delete', array('id' => $convention->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
