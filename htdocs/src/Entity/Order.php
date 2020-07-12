<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks()
 */
class Order implements JsonSerializable
{

    use HasTimestamps;

    public const ORDER_STATUS_NEW = 'NEW';

    public const ORDER_STATUS_PAID = 'PAID';

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="order_products",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->status = self::ORDER_STATUS_NEW;
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'order_id' => $this->id,
            'total' => $this->getTotal(),
            'status' => $this->getStatus(),
            'items' => $this->getProducts()->toArray(),
        ];
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param array $products
     *
     * @return self
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }

}
