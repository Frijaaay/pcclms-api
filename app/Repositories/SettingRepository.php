<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    /** Dependency Injection */
    private Setting $model;
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function getRule(string $name)
    {
        return $this->model->where('rule_name', $name)->value('rule_value');
    }
}
