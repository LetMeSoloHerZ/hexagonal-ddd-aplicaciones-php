<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface UpdateAplicacionPort
{
    public function update(AplicacionModel $aplicacion): AplicacionModel;
}
