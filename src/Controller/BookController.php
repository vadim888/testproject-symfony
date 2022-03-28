<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Translation\BookTranslation;
use App\Form\AuthorType;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/api")
 *
 * Class BookController
 * @package App\Controller
 */
class BookController extends AbstractFOSRestController
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
     * @param Request $request
     * @return Response
     *
     * @Rest\Post("/book/create", name="app_book_create")
     */
    public function create(Request $request): Response
    {
        $requestData = $request->toArray();

        /** @var Form $form */
        $form = $this->createForm(BookType::class);
        $form->submit($requestData);

        if (!$form->isValid()) {
            $view = $this->view($form);

            return $this->handleView($view);
        }

        /** @var Book $book */
        $book = $form->getData();
        $book->addTranslation(new BookTranslation('en', 'name', "{$book->getName()} translated"));

        $this->em->getRepository(Book::class)->add($book, true);
        $this->em->refresh($book);

        $view = $this->view($book, 200);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Rest\Get("/book/search", name="app_book_search")
     */
    public function search(Request $request, PaginatorInterface $paginator): Response
    {
        $booksQb = $this->em->getRepository(Book::class)->findByNameQb($request->get('q', null));

        $pagination = $paginator->paginate(
            $booksQb,
            $request->query->getInt('page', 1),
            10
        );

        $view = $this->view([
            'items' => $pagination->getItems(),
            'pagination' => $pagination->getPaginationData(),
        ]);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{_locale}/book/{id}", name="app_book_show", requirements={"_locale": "ru|en"})
     *
     * @param int $bookId
     * @return Response
     */
    public function show(int $id, Request $request): Response
    {
        /** @var Book $book */
        $book = $this->em->find(Book::class, $id);
        if (!$book) {
            throw $this->createNotFoundException();
        }

        $book->setTranslatableLocale($request->getLocale());
        $this->em->refresh($book);

        $view = $this->view($book);

        return $this->handleView($view);
    }
}
