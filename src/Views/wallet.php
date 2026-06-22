<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gestion Wallet</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="wrap">
    <h1>GESTION WALLET 💰</h1>
    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="toast-wrap">
        <?php $f = $_SESSION['flash']; ?>
        <div id="toast" class="toast <?= $f['type'] ?>">
          <div class="msg"><?= htmlspecialchars($f['message']) ?></div>
          <button class="close" onclick="hideToast()">×</button>
        </div>
      </div>
      <?php unset($_SESSION['flash']); ?>
      <script>
        function hideToast(){
          const t = document.getElementById('toast');
          if(!t) return; t.classList.add('hide');
        }
        setTimeout(()=>{ hideToast(); }, 4000);
      </script>
    <?php endif; ?>

    <h2>Créer Wallet</h2>
    <form method="POST" action="/wallet/create">
        <input name="code" placeholder="Code">
        <input name="nom" placeholder="Nom">
        <input name="prenom" placeholder="Prénom">
        <input name="telephone" placeholder="Téléphone">
        <input name="solde" type="number" placeholder="Solde">
        <button>Créer</button>
    </form>

    <hr>

    <h2>Dépôt</h2>
    <form method="POST" action="/wallet/depot">
        <input name="telephone" placeholder="Téléphone">
        <input name="montant" type="number">
        <button>Déposer</button>
    </form>

    <h2>Retrait</h2>
    <form method="POST" action="/wallet/retrait">
        <input name="telephone" placeholder="Téléphone">
        <input name="montant" type="number">
        <button>Retirer</button>
    </form>

    <hr>

    <h2>Transactions</h2>
    <table>
    <tr>
        <th>Code</th>
        <th>Montant</th>
        <th>Type</th>
        <th>Frais</th>
        <th>Date</th>
    </tr>

    <?php foreach($transactions as $t): ?>
    <tr>
        <td><?= $t['wallet_code'] ?></td>
        <td><?= $t['montant'] ?></td>
        <td><?= $t['type'] ?></td>
        <td><?= $t['frais'] ?></td>
        <td><?= $t['dateheure'] ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
  </div>
</body>
</html>