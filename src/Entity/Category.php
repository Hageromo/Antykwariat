<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=MyCollection::class, mappedBy="category")
     */
    private $myCollections;

    public function __construct()
    {
        $this->collections = new ArrayCollection();
        $this->myCollections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MyCollection[]
     */
    public function getMyCollections(): Collection
    {
        return $this->myCollections;
    }

    public function addMyCollection(MyCollection $myCollection): self
    {
        if (!$this->myCollections->contains($myCollection)) {
            $this->myCollections[] = $myCollection;
            $myCollection->setCategory($this);
        }

        return $this;
    }

    public function removeMyCollection(MyCollection $myCollection): self
    {
        if ($this->myCollections->removeElement($myCollection)) {
            // set the owning side to null (unless already changed)
            if ($myCollection->getCategory() === $this) {
                $myCollection->setCategory(null);
            }
        }

        return $this;
    }
}
