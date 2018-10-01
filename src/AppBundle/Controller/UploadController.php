<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Upload;
use AppBundle\Form\UploadType;
use AppBundle\Repository\UploadRepository;


class UploadController extends Controller
{
    /**
     * Creates a new Upload entity.
     *
     * @Route("/", name="homepage")
     * @param Request $request
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\UploadType');

        return $this->render('upload/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/upload", name="upload")
     * @param Request $request
     * @return JsonResponse
     * @Method({"POST"})
     */
    public function uploadAction(Request $request) {
        $upload = new Upload();
        $form = $this->createForm('AppBundle\Form\UploadType', $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->saveUpload($upload);

            return new JsonResponse(['success' => true], 200);
        }

        return new JsonResponse(['success' => false],  200);
    }

    /**
     * Lists all Upload entities.
     * @Route("/list", name="upload_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $uploads = $em->getRepository('AppBundle:Upload')->findAll();

        return $this->render('upload/list.html.twig', array(
            'uploads' => $uploads,
        ));
    }

    /**
     * Finds and displays a Upload entity.
     *
     * @Route("/{id}", name="upload_show")
     * @Method("GET")
     * @param Upload $upload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Upload $upload)
    {
        return $this->render('upload/show.html.twig', array(
            'upload' => $upload,
        ));
    }

    /**
     * @param $image
     * @return string
     */
    private function uniqueImageName($image)
    {
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        return $imageName;
    }

    /**
     * @param $image
     * @param $imageName
     */
    private function saveImageToFolder($image, $imageName)
    {
        $image->move(
            $this->getParameter('image_directory'), $imageName
        );
    }

    /**
     * @param $upload
     */
    private function saveToDatabase($upload)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($upload);
        $em->flush();
    }

    /**
     * @param $upload
     */
    private function saveUpload($upload)
    {
        $image = $upload->getImage();

        $imageName = $this->uniqueImageName($image);

        $this->saveImageToFolder($image, $imageName);

        $upload->setImage($imageName);

        $this->saveToDatabase($upload);
    }
}
