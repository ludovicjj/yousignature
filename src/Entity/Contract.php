<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateStartAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateEndAt = null;

    #[ORM\Column(length: 255)]
    private ?string $rent = null;

    #[ORM\Column(length: 255)]
    private ?string $caution = null;

    // ID de la demande de signature
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $signatureId = null;

    // ID du document
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $documentId = null;

    // ID du signataire (ici pseudo locataire)
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $signerId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unsignedPdfName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDateStartAt(): ?\DateTimeImmutable
    {
        return $this->dateStartAt;
    }

    public function setDateStartAt(\DateTimeImmutable $dateStartAt): static
    {
        $this->dateStartAt = $dateStartAt;

        return $this;
    }

    public function getDateEndAt(): ?\DateTimeImmutable
    {
        return $this->dateEndAt;
    }

    public function setDateEndAt(\DateTimeImmutable $dateEndAt): static
    {
        $this->dateEndAt = $dateEndAt;

        return $this;
    }

    public function getRent(): ?string
    {
        return $this->rent;
    }

    public function setRent(string $rent): static
    {
        $this->rent = $rent;

        return $this;
    }

    public function getCaution(): ?string
    {
        return $this->caution;
    }

    public function setCaution(string $caution): static
    {
        $this->caution = $caution;

        return $this;
    }

    public function getSignatureId(): ?string
    {
        return $this->signatureId;
    }

    public function setSignatureId(?string $signatureId): static
    {
        $this->signatureId = $signatureId;

        return $this;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function setDocumentId(?string $documentId): static
    {
        $this->documentId = $documentId;

        return $this;
    }

    public function getSignerId(): ?string
    {
        return $this->signerId;
    }

    public function setSignerId(?string $signerId): static
    {
        $this->signerId = $signerId;

        return $this;
    }

    public function getUnsignedPdfName(): ?string
    {
        return $this->unsignedPdfName;
    }

    public function setUnsignedPdfName(?string $unsignedPdfName): static
    {
        $this->unsignedPdfName = $unsignedPdfName;

        return $this;
    }
}
