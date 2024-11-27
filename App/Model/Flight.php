<?php
declare(strict_types=1);

namespace App\Model;

class Flight
{
    private ?int $id = null;
    private string $location;
    private string $date;
    private int $time;
    private int $fromAlt;
    private int $toAlt;
    private ?string $comment = null;

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getFromAlt(): int
    {
        return $this->fromAlt;
    }

    public function setFromAlt(int $fromAlt): self
    {
        $this->fromAlt = $fromAlt;
        return $this;
    }

    public function getToAlt(): int
    {
        return $this->toAlt;
    }

    public function setToAlt(int $toAlt): self
    {
        $this->toAlt = $toAlt;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }
}
