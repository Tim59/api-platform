<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * This is a dummy entity. Remove it!
 *
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(attributes={"filters"={"custom_search"},
 *      "normalization_context"={"groups"={"read"}},
 *      "denormalization_context"={"groups"={"write"}}
 *     })
 * @ORM\Entity
 */
class Foo
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @Assert\Uuid
     * @Groups({"read","write"})
     */
    private $id;

    /**
     * @var string Something else
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Groups({"read","write"})
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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getBar() : string
    {
        return $this->bar;
    }

    public function setBar(string $bar)
    {
        $this->bar = $bar;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist()
    {
        if ($this->id === null) {
            $this->id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
        }
    }
}
