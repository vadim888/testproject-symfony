<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthorController
 * @package App\Controller
 *
 * @Rest\Route("/api/author")
 */
class AuthorController extends AbstractFOSRestController
{
    private EntityManagerInterface $em;

    /**
     * AuthorController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Post("/create", name="app_author_create")
     */
    public function create(Request $request): Response
    {
        $requestData = $request->toArray();

        /** @var Form $form */
        $form = $this->createForm(AuthorType::class);
        $form->submit($requestData);

        if (!$form->isValid()) {
            $view = $this->view($form);

            return $this->handleView($view);
        }

        /** @var Author $author */
        $author = $form->getData();
        $this->em->getRepository(Author::class)->add($author, true);

        $view = $this->view($author, Response::HTTP_CREATED);
        return $this->handleView($view);
    }
}
