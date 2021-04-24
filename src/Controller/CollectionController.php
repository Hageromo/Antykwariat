<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\MyCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    private ObjectRepository $collectionRepository;
    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;
    private ObjectRepository $categoryRepository;

    public function __construct
    (
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->collectionRepository = $this->entityManager->getRepository(MyCollection::class);
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
    }
    /**
     * @Route(
     *     "/{_locale}/collection/{slug}/",
     *     name="collection",
     *     methods={"GET"},
     *     requirements={
     *         "_locale": "%app_locales%",
     *     }
     * )
     */
    public function index(string $slug): Response
    {
        $collection = $this->collectionRepository->findOneBy(['slug' => $slug]);
        $category = $collection->getCategory()->translate($this->requestStack->getCurrentRequest()->getLocale())->getName();
        $categoryId = $collection->getCategory()->getId();
        $similarCollections = $this->categoryRepository->findOneBy(['id' => $categoryId])->getMyCollections();
        foreach($similarCollections as $k => $item) {
            if ($item->getSlug() == $slug) {
                unset($similarCollections[$k]);
                break;
            }
        }
        $similarCollections = $similarCollections->toArray();
        shuffle($similarCollections);
        return $this->render('collection/index.html.twig', [
            'collection' => $collection,
            'category' => $category,
            'similarCollections' => $similarCollections
        ]);
    }
}
