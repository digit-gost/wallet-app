<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\WalletService;

class WalletController extends Controller
{
    private WalletService $service;

    public function __construct()
    {
        $this->service = new WalletService();
    }


    public function create()
    {
        $ok = $this->service->create($_POST);
        if ($ok) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Wallet créé avec succès.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: données invalides ou solde négatif.'];
        }
        header("Location: /");
    }

    public function depot()
    {
        $ok = $this->service->depot($_POST);
        if ($ok) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Dépôt effectué avec succès.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: montant invalide.'];
        }
        header("Location: /");
    }

    public function retrait()
    {
        $ok = $this->service->retrait($_POST);
        if ($ok) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Retrait effectué avec succès.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: montant invalide ou solde insuffisant.'];
        }
        header("Location: /");
    }

    public function index(){
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $this->view('wallet', [
            'wallets' => $this->service->getAll(),
            'transactions' => $this->service->getTransactions()
        ]);
    }
}

