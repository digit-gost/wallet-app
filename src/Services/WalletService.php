<?php

namespace App\Services;

use App\Repositories\WalletRepository;

class WalletService
{
    private WalletRepository $repo;

    public function __construct()
    {
        $this->repo = new WalletRepository();
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function getTransactions()
    {
        return $this->repo->transactions();
    }

    public function create($data)
    {
        if (
            empty($data['telephone']) ||
            empty($data['nom']) ||
            empty($data['prenom']) ||
            empty($data['code'])
        ) {
            return;
        }

        if ($data['solde'] < 0) return false;

        $this->repo->create($data);
        return true;
    }

    public function depot($data)
    {
        if ($data['montant'] <= 0) return false;

        $this->repo->depot($data['telephone'], $data['montant']);
        return true;
    }

    public function retrait($data)
    {
        $montant = $data['montant'];

        if ($montant <= 0) return false;

        $solde = $this->repo->getSolde($data['telephone']);

        $frais = min($montant * 0.01, 5000);
        $total = $montant + $frais;

        if ($total > $solde) return false;

        $this->repo->retrait($data['telephone'], $montant, $frais);
        return true;
    }
}