<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampableTrait
{

	#[Gedmo\Timestampable(on: "create")]
	#[ORM\Column(nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
	#[Groups(["order:detail"])]
	private ?\DateTimeImmutable $createdAt = null;

	#[Gedmo\Timestampable(on: "update")]
	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $updatedAt = null;

	#[ORM\Column(type: "datetime_immutable", nullable: true)]
	private ?\DateTimeImmutable $deletedAt = null;

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTimeImmutable $createdAt
	 * @return self
	 */
	public function setCreatedAt(\DateTimeImmutable $createdAt): self
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getUpdatedAt(): \DateTimeImmutable
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTimeImmutable $updatedAt
	 * @return self
	 */
	public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @return \DateTimeImmutable|null
	 */
	public function getDeletedAt(): ?\DateTimeImmutable
	{
		return $this->deletedAt;
	}

	/**
	 * @param \DateTimeImmutable $deletedAt
	 * @return self
	 */
	public function setDeletedAt(\DateTimeImmutable $deletedAt): self
	{
		$this->deletedAt = $deletedAt;
		return $this;
	}
}