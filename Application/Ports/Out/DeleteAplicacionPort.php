<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionId.php';

interface DeleteAplicacionPort
{
    public function delete(AplicacionId $id): void;
}
