<?php

class Controller
{
    protected function view(string $viewFile, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require_once BASE_PATH . '/app/Views/' . $viewFile . '.php';
    }
}