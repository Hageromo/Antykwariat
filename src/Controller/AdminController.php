<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\MyCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private string $getRequestLocale;
    private ObjectRepository $categoryRepository;
    private RequestStack $requestStack;

    public function __construct
    (
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    )
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->getRequestLocale = $this->requestStack->getCurrentRequest()->getLocale();
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
    }
    /**
     * @Route(
     *     "/admin/manage/collections/",
     *     name="admin_manage_collections",
     *     methods={"GET"}
     * )
     */
    public function manage_collections(): Response
    {
        return $this->render('admin/manageCollections.html.twig', [
            'categories' => $this->categoryRepository->findAll()
        ]);
    }
}
