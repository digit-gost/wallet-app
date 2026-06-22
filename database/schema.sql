CREATE DATABASE wallet_app;

CREATE TABLE wallets (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    solde NUMERIC(10,2) DEFAULT 0 CHECK (solde >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id SERIAL PRIMARY KEY,
    wallet_code VARCHAR(50) NOT NULL,
    montant NUMERIC(10,2) NOT NULL CHECK (montant > 0),
    type VARCHAR(20) NOT NULL CHECK (type IN ('depot', 'retrait')),
    frais NUMERIC(10,2) DEFAULT 0 CHECK (frais >= 0),
    dateHeure TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE transactions
ADD CONSTRAINT fk_wallet
FOREIGN KEY (wallet_code)
REFERENCES wallets(code)
ON DELETE CASCADE;

INSERT INTO wallets (code, nom, prenom, telephone, solde)
VALUES ('W001', 'SANKHARE', 'Baye', '770000000', 10000);

INSERT INTO transactions (wallet_code, montant, type, frais)
VALUES ('W001', 2000, 'depot', 0);

INSERT INTO users (username, password)
VALUES ('admin', 'admin');