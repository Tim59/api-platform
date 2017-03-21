<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * This is a dummy entity. Remove it!
 *
 * @ApiResource(
 *     attributes=
 *     {"filters"={}},
 *     itemOperations={
 *          "get"={"method"="GET", "normalization_context"={"groups"={"read","read_child"}}},
 *     }
 * )
 * @ORM\Entity
 */
class Foo
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Something else
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Groups({"read"})
     */
    private $bar = '';

    /**
     * @var parentTranslateId[] The translate parent ID of this content
     *
     * @ORM\ManyToOne(targetEntity="Foo")
     * @Groups({"read_child"})
     */
    private $parentTranslateId;

    /**
     * @return parentTranslateId[]
     */
    public function getParentTranslateId()
    {
        return $this->parentTranslateId;
    }

    /**
     * @param parentTranslateId[] $parentTranslateId
     */
    public function setParentTranslateId($parentTranslateId)
    {
        $this->parentTranslateId = $parentTranslateId;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getBar() : string
    {
        return $this->bar;
    }

    public function setBar(string $bar)
    {
        $this->bar = $bar;
    }
}
