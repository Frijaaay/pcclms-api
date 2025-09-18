<?php

namespace App\Contracts\Repositories;

interface SettingRepositoryInterface
{
    public function getRule(string $name);

    public function updateRule(array $rule);
}
