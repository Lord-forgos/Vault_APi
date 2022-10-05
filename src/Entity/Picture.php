<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
/**
 * @Vich\Uploadable()
 */
class Picture {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPicture"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPicture"])]
    private ?string $realName = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPicture"])]
    private ?string $realPath = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPicture"])]
    private ?string $publicPath = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPicture"])]
    private ?string $mineType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getAllBooklet", "getBooklet"])]
    private ?\DateTimeInterface $uploadDate = null;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="image", fileNameProperty="realPath")
     */
    private $file;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getRealName(): ?string {
        return $this->realName;
    }

    public function setRealName(string $realName): self {
        $this->realName = $realName;

        return $this;
    }

    public function getRealPath(): ?string {
        return $this->realPath;
    }

    public function setRealPath(string $realPath): self {
        $this->realPath = $realPath;

        return $this;
    }

    public function getPublicPath(): ?string {
        return $this->publicPath;
    }

    public function setPublicPath(string $publicPath): self {
        $this->publicPath = $publicPath;

        return $this;
    }

    public function getMineType(): ?string {
        return $this->mineType;
    }

    public function setMineType(string $mineType): self {
        $this->mineType = $mineType;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function isStatus(): ?bool {
        return $this->status;
    }

    public function setStatus(bool $status): self {
        $this->status = $status;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void {
        $this->file = $file;
    }
}
