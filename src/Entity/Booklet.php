<?php

namespace App\Entity;

use App\Repository\BookletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BookletRepository::class)]
class Booklet {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getBooklet", "getCurrentAccount"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getBooklet", "getCurrentAccount"])]
    #[Assert\NotNull(message: "Un livret doit avoir un nom.")]
    #[Assert\Length(min: 2, max: 150, minMessage: "Le nom du livret doit comporter au moins {{ limit }} caractères.",
                    maxMessage: "Le nom du livret doit contenir maximum {{ limit }} caractères.")]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["getBooklet", "getCurrentAccount"])]
    #[Assert\NotNull(message: "Un livret doit avoir de l'argent.")]
    #[Assert\PositiveOrZero(message: "Un livret dois contenir un nombre d'argent positif (ou égal à zéro).")]
    private ?float $money = null;

    #[ORM\ManyToOne(inversedBy: 'booklets')]
    #[Groups(["getBooklet", "getCurrentAccount"])]
    #[Assert\NotNull(message: "Un livret doit contenir un certain pourcentage d'intéret.")]
    #[Assert\Type(BookletPercent::class)]
    private ?BookletPercent $bookletPercent = null;

    #[ORM\ManyToOne(inversedBy: 'booklets')]
    #[Groups(["getBooklet"])]
    #[Assert\NotNull(message: "Un livret doit contenir un compte courrant.")]
    #[Assert\Type(CurrentAccount::class)]
    private ?CurrentAccount $currentAccount = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le livret doit avoir un statut.")]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[ORM\ManyToOne(inversedBy: 'booklets')]
    #[Assert\NotNull(message: "Le livret doit avoir une date de création.")]
    #[Assert\DateTime(format: "Y-m-d H:i:s")]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getMoney(): ?float {
        return $this->money;
    }

    public function setMoney(float $money): self {
        $this->money = $money;

        return $this;
    }

    public function getBookletPercent(): ?BookletPercent {
        return $this->bookletPercent;
    }

    public function setBookletPercent(?BookletPercent $bookletPercent): self {
        $this->bookletPercent = $bookletPercent;

        return $this;
    }

    public function getCurrentAccount(): ?CurrentAccount {
        return $this->currentAccount;
    }

    public function setCurrentAccount(?CurrentAccount $currentAccount): self {
        $this->currentAccount = $currentAccount;

        return $this;
    }

    public function isStatus(): ?bool {
        return $this->status;
    }

    public function setStatus(bool $status): self {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
