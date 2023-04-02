<?php

namespace ApiBundle\Model\Request;

use SkyBundle\Model\Element;
use SkyBundle\Model\Request\UniqueStarsRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UniqueStarsRequest implements UniqueStarsRequestInterface
{
    /**
     * @Assert\NotBlank
     * @var string
     */
    private $foundIn;

    /**
     * @Assert\NotBlank
     * @var string
     */
    private $notFoundIn;

    /**
     * @Assert\NotNull
     * @Assert\Choice(callback={Element::class, "getElementList"}, multiple=true, min=1)
     * @var array
     */
    private $atoms;

    /**
     * @Assert\Choice({"size", "temperature"})
     * @var string
     */
    private $sortBy = 'size';

    /**
     * @Assert\Choice({"basic"})
     * @var string
     */
    private $viewType = 'basic';

    public function getFoundIn(): string
    {
        return $this->foundIn;
    }

    public function setFoundIn(string $foundIn): void
    {
        $this->foundIn = $foundIn;
    }

    public function getNotFoundIn(): string
    {
        return $this->notFoundIn;
    }

    public function setNotFoundIn(string $notFoundIn): void
    {
        $this->notFoundIn = $notFoundIn;
    }

    public function getAtoms(): array
    {
        return $this->atoms;
    }

    public function setAtoms(array $atoms): void
    {
        $this->atoms = $atoms;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function setSortBy(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    public function getViewType(): string
    {
        return $this->viewType;
    }

    public function setViewType(string $viewType): void
    {
        $this->viewType = $viewType;
    }
}