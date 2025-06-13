<?php

namespace Dto;

class MeowFactParametersDto
{
    private ?int $id = null;
    private ?int $count = null;
    private ?string $lang = null;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCount(): int|null
    {
        return $this->count;
    }

    public function setCount(?int $count): void
    {
        $this->count = $count;
    }

    public function getLang(): string|null
    {
        return $this->lang;
    }

    public function setLang(?string $lang): void
    {
        $this->lang = $lang;
    }
}