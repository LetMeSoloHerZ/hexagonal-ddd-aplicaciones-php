<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateAplicacionCommand.php';
require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface UpdateAplicacionUseCase
{
    public function execute(UpdateAplicacionCommand $command): AplicacionModel;
}
