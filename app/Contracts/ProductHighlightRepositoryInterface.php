<?php

namespace App\Contracts;

interface ProductHighlightRepositoryInterface
{
    public function getHighlight();
    public function update(array $data);
}