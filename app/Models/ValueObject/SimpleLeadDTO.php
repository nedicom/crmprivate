<?php

namespace App\Models\ValueObject;

/**
 * @property string|null $name
 * @property string $phone
 */
class SimpleLeadDTO
{
    // TODO: добавить регулярку по проверке валидации номера телефона
    public function __construct(
        private readonly string|null $name,
        private readonly string $phone,
    ) {}

    public function getClientName(): ?string
    {
        return $this->name;
    }

    public function getClientPhone(): string
    {
        return $this->phone;
    }
}
