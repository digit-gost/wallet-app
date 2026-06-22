<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class WalletRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM wallets")->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO wallets(code, nom, prenom, telephone, solde)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['code'],
            $data['nom'],
            $data['prenom'],
            $data['telephone'],
            $data['solde']
        ]);
    }

    public function depot($telephone, $montant)
    {
        $this->db->prepare("
            UPDATE wallets SET solde = solde + ?
            WHERE telephone = ?
        ")->execute([$montant, $telephone]);

        $code = $this->getCodeByTelephone($telephone);
        $this->addTransaction($code ?? $telephone, $montant, 'depot', 0);
    }

    public function retrait($telephone, $montant, $frais)
    {
        $total = $montant + $frais;

        $this->db->prepare("
            UPDATE wallets SET solde = solde - ?
            WHERE telephone = ?
        ")->execute([$total, $telephone]);

        $code = $this->getCodeByTelephone($telephone);
        $this->addTransaction($code ?? $telephone, $montant, 'retrait', $frais);
    }

    public function getSolde($telephone)
    {
        $stmt = $this->db->prepare("SELECT solde FROM wallets WHERE telephone = ?");
        $stmt->execute([$telephone]);

        return $stmt->fetch()['solde'] ?? 0;
    }

    public function transactions()
    {
        return $this->db->query("SELECT * FROM transactions ORDER BY dateHeure DESC")->fetchAll();
    }

    private function addTransaction($code, $montant, $type, $frais)
    {
        $stmt = $this->db->prepare("
            INSERT INTO transactions(wallet_code, montant, type, frais)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$code, $montant, $type, $frais]);
    }

    private function getCodeByTelephone($telephone)
    {
        $stmt = $this->db->prepare("SELECT code FROM wallets WHERE telephone = ? LIMIT 1");
        $stmt->execute([$telephone]);
        $row = $stmt->fetch();
        return $row['code'] ?? null;
    }
}