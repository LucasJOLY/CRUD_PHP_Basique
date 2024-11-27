<?php
declare(strict_types=1);



namespace App\Repository;

require_once __DIR__ . '/../Database/Database.php';

use App\Database\Database;
use App\Model\Flight;
use App\Model\Participant;
use PDO;

class ParticipantRepository
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
        $query = $this->pdo->query("SELECT * FROM participant");
        $results = $query->fetchAll();

        $participants = [];
        foreach ($results as $row) {
            $participants[] = $this->mapRowToParticipant($row);
        }
        return $participants;
    }








    public function find(int $id): Participant
    {
        $query = $this->pdo->prepare("SELECT * FROM participant WHERE id = :id");
        $query->execute(['id' => $id]);

        $row = $query->fetch();
        return $this->mapRowToParticipant($row);
    }

    public function findFlightsFromParticipant(int $id): array
    {
        $query = $this->pdo->prepare("
            SELECT *
            FROM flight 
            WHERE id IN (
                SELECT flight_id
                FROM flights_participants
                WHERE participant_id = :id
            )
        ");
        $query->execute(['id' => $id]);

        $results = $query->fetchAll();
        $flights = [];
        foreach ($results as $row) {
            $flight = new Flight();
            $flight->setId((int)$row['id']);
            $flight->setLocation($row['location']);
            $flight->setDate($row['date']);
            $flights[] = $flight;
        }
        return $flights;
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM participant WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    public function save(Participant $participant): void
    {

        if ($participant->getId() === null) {
            // Création d'un nouveau vol
            $query = $this->pdo->prepare("
                INSERT INTO participant (firstName, lastName, level, profile_picture) 
                VALUES (:firstName, :lastName, :level, :profile_picture)
            ");
            $query->execute([
                'firstName' => $participant->getFirstName(),
                'lastName' => $participant->getLastName(),
                'level' => $participant->getLevel(),
                'profile_picture' => $participant->getProfilePicture(),
            ]);

        } else {
            $query = $this->pdo->prepare("
                UPDATE participant
                SET firstName = :firstName, lastName = :lastName, level = :level, profile_picture = :profile_picture
                WHERE id = :id 
            ");
            $query->execute([
                'id' => $participant->getId(),
                'firstName' => $participant->getFirstName(),
                'lastName' => $participant->getLastName(),
                'level' => $participant->getLevel(),
                'profile_picture' => $participant->getProfilePicture(),
            ]);
        }
    }

    private function mapRowToParticipant(array $row): Participant
    {
        $participant = new Participant();
        $participant->setId((int)$row['id']);
        $participant->setFirstName($row['firstName']);
        $participant->setLastName($row['lastName']);
        $participant->setLevel($row['level']);
        $participant->setProfilePicture($row['profile_picture'] ?? null);
        return $participant;
    }
}
