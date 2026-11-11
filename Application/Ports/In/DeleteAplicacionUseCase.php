<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteAplicacionCommand.php';

interface DeleteAplicacionUseCase
{
    public function execute(DeleteAplicacionCommand $command): void;
}
