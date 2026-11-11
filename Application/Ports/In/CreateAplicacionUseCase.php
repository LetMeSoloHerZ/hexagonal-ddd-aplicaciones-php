<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateAplicacionCommand.php';
require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface CreateAplicacionUseCase
{
    public function execute(CreateAplicacionCommand $command): AplicacionModel;
}
