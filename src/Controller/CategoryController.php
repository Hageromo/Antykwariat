<?php

namespace App\Controller;
// test
use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private RequestStack $requestStack;
    private string $getRequestLocale;
    private EntityManagerInterface $entityManager;
    private ObjectRepository $categoryTranslationRepository;
    /**
     * @var CategoryRepository|ObjectRepository
     */
    private $categoryRepository;
    private $paginator;

    public function __construct
    (
        PaginatorInterface $paginator,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager
    )
    {
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
        $this->getRequestLocale = $this->requestStack->getCurrentRequest()->getLocale();
        $this->entityManager = $entityManager;
        $this->categoryTranslationRepository = $this->entityManager->getRepository(CategoryTranslation::class);
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
    }

    /**
     * @Route(
     *     "/{_locale}/category/{catID}-{catName}",
     *     name="category",
     *     methods={"GET"},
     *     requirements={
     *         "_locale": "%app_locales%",
     *     }
     * )
     * @param int $catID
     * @return Response
     */
    public function index(int $catID): Response
    {
        $category = $this->categoryRepository->findOneBy(['id' => $catID]);
        if(!$category) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $paginatedMyCollections = $this->paginator->paginate(
            $category->getMyCollections(),
            $this->requestStack->getCurrentRequest()->query->getInt('page', 1),
            $this->requestStack->getCurrentRequest()->query->getInt('limit', 12)
        );

        return $this->render('category/index.html.twig', [
            'categories' => $this->categoryTranslationRepository->findBy(['locale' => $this->getRequestLocale]),
            'category' => $category->translate($this->getRequestLocale),
            'myCollections' => $paginatedMyCollections
        ]);
    }
}
