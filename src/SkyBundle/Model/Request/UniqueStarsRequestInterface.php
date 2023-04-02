<?php

namespace SkyBundle\Model\Request;

interface UniqueStarsRequestInterface
{
    public function getFoundIn(): ?string;

    public function getNotFoundIn(): string;

    public function getAtoms(): array;

    public function getSortBy(): string;

    public function getViewType(): string;
}