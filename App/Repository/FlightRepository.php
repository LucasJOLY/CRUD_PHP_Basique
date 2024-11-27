<?php
declare(strict_types=1);



namespace App\Repository;

require_once __DIR__ . '/../Database/Database.php';

use App\Database\Database;
use App\Model\Flight;
use App\Model\FlightImages;
use App\Model\Participant;
use PDO;

class FlightRepository
{

    private Database $database;
    private PDO $pdo;

    public function __construct()
    {
        $this->database = (new Database())->getInstance();
        $this->pdo = $this->database->getConnection();
    }



    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM flight");
        $results = $query->fetchAll();

        $flights = [];
        foreach ($results as $row) {
            $flights[] = $this->mapRowToFlight($row);
        }
        return $flights;
    }

    public function findParticipants(int $id): array
    {
        $query = $this->pdo->prepare("SELECT * FROM participant WHERE id IN (SELECT participant_id FROM flights_participants WHERE flight_id = :id)");
        $query->execute(['id' => $id]);
        $results = $query->fetchAll();

        $participants = [];
        foreach ($results as $row) {
            $participants[] = $this->mapRowToParticipant($row);
        }
        return $participants;
    }

    public function find(int $id): Flight
    {
        $query = $this->pdo->prepare("SELECT * FROM flight WHERE id = :id");
        $query->execute(['id' => $id]);

        $row = $query->fetch();
        return $this->mapRowToFlight($row);
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM flight WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    public function save(Flight $flight, array $participants): void
    {

        if ($flight->getId() === null) {
            $query = $this->pdo->prepare("
                INSERT INTO flight (location, date, time, from_alt, to_alt, comment) 
                VALUES (:location, :date, :time, :from_alt, :to_alt, :comment)
            ");
            $query->execute([
                'location' => $flight->getLocation(),
                'date' => $flight->getDate(),
                'time' => $flight->getTime(),
                'from_alt' => $flight->getFromAlt(),
                'to_alt' => $flight->getToAlt(),
                'comment' => $flight->getComment(),
            ]);
            $flight->setId((int)$this->pdo->lastInsertId());
            foreach ($participants as $participant) {
                $query = $this->pdo->prepare("INSERT INTO flights_participants (flight_id, participant_id) VALUES (:flight_id, :participant_id)");
                $query->execute([
                    'flight_id' => $flight->getId(),
                    'participant_id' => $participant
                ]);
            }

        } else {
            $query = $this->pdo->prepare("
                UPDATE flight 
                SET location = :location, date = :date, time = :time, from_alt = :from_alt, to_alt = :to_alt, comment = :comment
                WHERE id = :id
            ");
            $query->execute([
                'id' => $flight->getId(),
                'location' => $flight->getLocation(),
                'date' => $flight->getDate(),
                'time' => $flight->getTime(),
                'from_alt' => $flight->getFromAlt(),
                'to_alt' => $flight->getToAlt(),
                'comment' => $flight->getComment(),
            ]);
            $query = $this->pdo->prepare("DELETE FROM flights_participants WHERE flight_id = :flight_id");
            $query->execute(['flight_id' => $flight->getId()]);
            foreach ($participants as $participant) {
                $query = $this->pdo->prepare("INSERT INTO flights_participants (flight_id, participant_id) VALUES (:flight_id, :participant_id)");
                $query->execute([
                    'flight_id' => $flight->getId(),
                    'participant_id' => $participant
                ]);
            }
        }
    }




    public function saveImage(int $flightId, string $imageContent): void
    {
        $query = $this->pdo->prepare("
        INSERT INTO flight_images (flight_id, image) 
        VALUES (:flight_id, :image)
    ");
        $query->execute([
            'flight_id' => $flightId,
            'image' => $imageContent,
        ]);
    }

    public function getImages(int $flightId): array
    {
        $query = $this->pdo->prepare("
        SELECT image 
        FROM flight_images 
        WHERE flight_id = :flight_id
    ");
        $query->execute(['flight_id' => $flightId]);
        $results = $query->fetchAll();
        $images = [];
        foreach ($results as $row) {
            $images[] = $this->mapRowToFlightImage($row);
        }
        return $images;
    }


    private function mapRowToFlightImage(array $row): FlightImages
    {
        $flightImage = new FlightImages();
        $flightImage->setImage($row['image']);
        return $flightImage;
    }



    private function mapRowToFlight(array $row): Flight
    {
        $flight = new Flight();
        $flight->setId((int)$row['id']);
        $flight->setLocation($row['location']);
        $flight->setDate($row['date']);
        $flight->setTime((int)$row['time']);
        $flight->setFromAlt((int)$row['from_alt']);
        $flight->setToAlt((int)$row['to_alt']);
        $flight->setComment($row['comment'] ?? null);
        return $flight;
    }


    private function mapRowToParticipant(array $row): Participant
    {
        $participant = new Participant();
        $participant->setId((int)$row['id']);
        $participant->setFirstName($row['firstName']);
        $participant->setLastName($row['lastName']);
        $participant->setLevel($row['level']);
        return $participant;
    }
}
