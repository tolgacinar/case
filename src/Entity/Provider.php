<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private $params;

    /**
     * @ORM\OneToOne(targetEntity=Task::class, mappedBy="provider", cascade={"persist", "remove"})
     */
    private $task;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getParams(): ?string
    {
        return $this->params;
    }

    public function setParams(string $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        // set the owning side of the relation if necessary
        if ($task->getProvider() !== $this) {
            $task->setProvider($this);
        }

        $this->task = $task;

        return $this;
    }
}
