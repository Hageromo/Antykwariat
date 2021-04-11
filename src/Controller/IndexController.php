<?php

namespace App\Controller;

use App\Entity\CategoryTranslation;
use App\Entity\MyCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $collectionRepository;
    private ObjectRepository $categoryTranslationRepository;
    private RequestStack $requestStack;

    public function __construct
    (
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        PaginatorInterface $paginator
    )
    {
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
        $this->collectionRepository = $this->entityManager->getRepository(MyCollection::class);
        $this->categoryTranslationRepository = $this->entityManager->getRepository(CategoryTranslation::class);
    }

    /**
     * @Route("/")
     */
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('index', ['_locale' => 'pl']);
    }

    /**
     * @Route(
     *     "/{_locale}",
     *     name="index",
     *     methods={"GET"},
     *     requirements={
     *         "_locale": "%app_locales%",
     *     }
     * )
     */
    public function index(): Response
    {
        $myCollections = $this->collectionRepository->findAll();
        $categories = $this->categoryTranslationRepository->findBy(['locale' => $this->requestStack->getCurrentRequest()->getLocale()]);

        $paginatedMyCollections = $this->paginator->paginate(
            $myCollections,
            $this->requestStack->getCurrentRequest()->query->getInt('page', 1),
            $this->requestStack->getCurrentRequest()->query->getInt('limit', 12)
        );

        return $this->render('index/index.html.twig', [
            'myCollections' => $paginatedMyCollections,
            'categories' => $categories
        ]);
    }
}
