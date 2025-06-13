<?php

declare(strict_types=1);

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

    /**
     * Process request to DTO instance and returns finished instance
     *
     * @return $this
     */
    public function getInstanceFromRequest(): self
    {
        if (isset($_GET['id'])) {
            $this->setId(intval($_GET['id']));
        }

        if (isset($_GET['count'])) {
            $this->setCount(intval($_GET['count']));
        }

        if (isset($_GET['lang'])) {
            $this->setLang(\Helpers\SanitizerHelper::sanitizeString($_GET['lang']));
        }

        return $this;
    }
}