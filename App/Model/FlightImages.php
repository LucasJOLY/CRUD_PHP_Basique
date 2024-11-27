<?php

namespace App\Model;

class FlightImages
{

    private string $image;
    private int $flight_id;

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getFlightId(): int
    {
        return $this->flight_id;
    }

    public function setFlightId(int $flight_id): self
    {
        $this->flight_id = $flight_id;
        return $this;
    }

}