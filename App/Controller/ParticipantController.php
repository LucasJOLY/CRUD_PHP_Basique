<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Participant;
use App\Repository\ParticipantRepository;
use App\Template\TemplateEngine;
use App\Model\Flight;

class ParticipantController
{
    private ParticipantRepository $repository;
    private TemplateEngine $templateEngine;



    public function __construct()
    {
        $this->repository = new ParticipantRepository();
        $this->templateEngine = new TemplateEngine();
    }


    public function list(): void
    {
        $participants = $this->repository->findAll();
        $this->templateEngine->render(__DIR__ . '/../View/Participant/participant_list.html.php', [
            'participants' => $participants,
        ]);
    }


    public function view(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $participant = $this->repository->find($id);
        $flights = $this->repository->findFlightsFromParticipant($id);
        if (!$participant) {
            header('Location: /index.php?controller=participant&action=list');
            exit;
        }

        $this->templateEngine->render(__DIR__ . '/../View/Participant/view_participant.html.php', [
            'participant' => $participant,
            'flights' => $flights
        ]);
    }

    public function add(): void
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $participant = new Participant();
            $participant->setFirstName($_POST['firstName'] ?? null)
                ->setLastName($_POST['lastName'] ?? null)
                ->setLevel($_POST['level'] ?? null);

            if (!empty($_FILES['profilePicture']['tmp_name'])) {
                $fileContent = file_get_contents($_FILES['profilePicture']['tmp_name']);
                $participant->setProfilePicture($fileContent);
            }
            else{
                $errors['profilePicture'] = "La photo de profil est requise.";
            }

            if (!$participant->getFirstName()) {
                $errors['firstName'] = "Le prénom est requis.";
            }

            if (!$participant->getLastName()) {
                $errors['lastName'] = "Le nom est requis.";
            }

            if (!$participant->getLevel()) {
                $errors['level'] = "Le niveau est requis.";
            }



            if ($participant->getFirstName() && $participant->getLastName() && $participant->getLevel() && $participant->getProfilePicture()) {
                $this->repository->save($participant);
                header('Location: index.php?controller=participant&action=list');
                exit;
            }
        }
        $this->templateEngine->render(__DIR__ . '/../View/Participant/add_participant.html.php', [
            'errors' => $errors
        ]);
    }


    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $participant = $this->repository->find($id);
        $errors = [];

        if (!$participant) {
            header('Location: index.php?controller=participant&action=list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $participant->setFirstName($_POST['firstName'] ?? null)
                ->setLastName($_POST['lastName'] ?? null)
                ->setLevel($_POST['level'] ?? null);

            if (!empty($_FILES['profilePicture']['tmp_name'])) {
                $fileContent = file_get_contents($_FILES['profilePicture']['tmp_name']);
                $participant->setProfilePicture($fileContent);
            }
            else{
                $errors['profilePicture'] = "La photo de profil est requise.";
            }

            if (!$participant->getFirstName()) {
                $errors['firstName'] = "Le prénom est requis.";
            }

            if (!$participant->getLastName()) {
                $errors['lastName'] = "Le nom est requis.";
            }

            if (!$participant->getLevel()) {
                $errors['level'] = "Le niveau est requis.";
            }

            if ($participant->getLastName() && $participant->getFirstName() && $participant->getLevel() && $participant->getProfilePicture()) {
                $this->repository->save($participant);
                header('Location: index.php?controller=participant&action=list');
                exit;
            }
        }

        $this->templateEngine->render(__DIR__ . '/../View/Participant/edit_participant.html.php', [
            'participant' => $participant,
            'errors' => $errors

        ]);
    }


    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $participant = $this->repository->find($id);

        if ($participant) {
            $this->repository->delete($id);
        }

        header('Location: index.php?controller=participant&action=list');
        exit;
    }
}
