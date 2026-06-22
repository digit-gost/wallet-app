<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Connexion</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="wrap">
        <h1>Connexion Gestionnaire</h1>

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

        <form method="POST" action="/login">
            <input name="username" placeholder="Username" required>
            <input name="password" type="password" placeholder="Password" required>
            <button>Connexion</button>
        </form>
    </div>
</body>
</html>