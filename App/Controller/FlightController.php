<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\FlightRepository;
use App\Repository\ParticipantRepository;
use App\Template\TemplateEngine;
use App\Model\Flight;

class FlightController
{
    private FlightRepository $repository;

    private ParticipantRepository $participantRepository;
    private TemplateEngine $templateEngine;



    public function __construct()
    {
        $this->repository = new FlightRepository();
        $this->participantRepository = new ParticipantRepository();
        $this->templateEngine = new TemplateEngine();
    }


    public function list(): void
    {
        $flights = $this->repository->findAll();
        $this->templateEngine->render(__DIR__ . '/../View/Flight/flight_list.html.php', [
            'flights' => $flights,
        ]);
    }


    public function view(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $flight = $this->repository->find($id);

        $images = $this->repository->getImages($id);
        $finalImages = [];
        foreach ($images as $image) {
            $finalImages[] = $image->getImage();
        }


        $participants = $this->repository->findParticipants($id);

        if (!$flight) {
            header('Location: index.php?controller=flight&action=list');
            exit;
        }

        $this->templateEngine->render(__DIR__ . '/../View/Flight/view_flight.html.php', [
            'flight' => $flight,
            'participants' => $participants,
            'images' => $finalImages
        ]);
    }

    public function add(): void
    {

        $errors = [];
        $participants = $this->participantRepository->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $flight = new Flight();
            $flight->setLocation($_POST['location'] ?? null)
                ->setDate($_POST['date'] ?? 'now')
                ->setFromAlt((int) $_POST['from_alt'] ?? 0)
                ->setToAlt((int) $_POST['to_alt'] ?? 0)
                ->setComment($_POST['comment'] ?? null)
                ->setTime((int) $_POST['time'] ?? 0);
            $participants = $_POST['participants'];

            if($flight->getFromAlt() < $flight->getToAlt()){
                $errors[] = 'L\'altitude de départ doit être inférieure à l\'altitude d\'arrivée';
            }
            if (empty($errors)) {
                $this->repository->save($flight, $participants);



                if (!empty($_FILES['images']['name'][0])) {
                    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $fileContent = file_get_contents($tmpName);
                        $this->repository->saveImage($flight->getId(), $fileContent);

                    }
                }

                header('Location: index.php?controller=flight&action=list');
                exit;
            }
        }

        $this->templateEngine->render(__DIR__ . '/../View/Flight/add_flight.html.php', [
            'participants' => $participants,
            'errors' => $errors
        ]);
    }


    public function edit(): void
    {
        $errors = [];
        $id = (int)($_GET['id'] ?? 0);
        $flight = $this->repository->find($id);
        $participants = $this->participantRepository->findAll();
        $actualParticipants = $this->repository->findParticipants($id);
        $listIds = [];
        foreach ($actualParticipants as $participant) {
            $listIds[] = $participant->getId();
        }


        if (!$flight) {
            header('Location: index.php?controller=flight&action=list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $flight->setLocation($_POST['location'] ?? null)
                ->setDate($_POST['date'] ?? 'now')
                ->setFromAlt((int) $_POST['from_alt'] ?? 0)
                ->setToAlt((int) $_POST['to_alt'] ?? 0)
                ->setComment($_POST['comment'] ?? null)
                ->setTime((int) $_POST['time'] ?? 0);
            $participants = $_POST['participants'];
            if($flight->getFromAlt() < $flight->getToAlt()){
                $errors[] = 'L\'altitude de départ doit être inférieure à l\'altitude d\'arrivée';
            }
            if (empty($errors)) {
                $this->repository->save($flight, $participants);
                if (!empty($_FILES['images']['name'][0])) {
                    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $fileContent = file_get_contents($tmpName);
                        $this->repository->saveImage($flight->getId(), $fileContent);

                    }
                }

                header('Location: index.php?controller=flight&action=list');
                exit;
            }
        }

        $this->templateEngine->render(__DIR__ . '/../View/Flight/edit_flight.html.php', [
            'flight' => $flight,
            'participants' => $participants,
            'listIds' => $listIds,
            'errors' => $errors
        ]);
    }


    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $flight = $this->repository->find($id);

        if ($flight) {
            $this->repository->delete($id);
        }

        header('Location: index.php?controller=flight&action=list');
        exit;
    }
}
