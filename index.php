<?php
require __DIR__ . "/connect.php";

$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUANTUM // Interface de Dados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="quantum-bg">
        <div class="glow-orb cyan-orb"></div>
        <div class="glow-orb purple-orb"></div>
        
        <div class="particle-system">
            <?php for($i = 1; $i <= 40; $i++): ?>
                <i class="particle" style="animation-delay: <?= $i * 0.075 ?>s; transform: rotate(<?= $i * 9 ?>deg) translate3d(150px, 0, 0);"></i>
            <?php endfor; ?>
        </div>
    </div>

    <div class="layout-wrapper">
        
        <header class="cyber-header glass-panel fade-in-down">
            <div class="brand">
                <div class="logo-spinner"></div>
                <h1>QUANTUM<span class="highlight">_CORE</span></h1>
            </div>
            <div class="sys-metrics">
                <div class="metric">
                    <span class="metric-label">STATUS</span>
                    <span class="metric-value text-cyan blink">ONLINE</span>
                </div>
                <div class="metric">
                    <span class="metric-label">REGISTROS</span>
                    <span class="metric-value text-purple"><?= str_pad(count($users), 3, '0', STR_PAD_LEFT) ?></span>
                </div>
            </div>
        </header>

        <div class="main-grid">
            
            <aside class="glass-panel input-station fade-in-left">
                <div class="panel-heading">
                    <h2>NOVO PROTOCOLO</h2>
                    <p>Insira os dados na matriz principal</p>
                </div>
                
                <form action="store.php" method="post" class="futuristic-form">
                    <div class="input-box">
                        <input type="text" name="name" required autocomplete="off">
                        <label>NOME DO OPERADOR</label>
                        <span class="scanner-line"></span>
                    </div>

                    <div class="input-box">
                        <input type="email" name="email" required autocomplete="off">
                        <label>ENDEREÇO DE E-MAIL</label>
                        <span class="scanner-line"></span>
                    </div>

                    <div class="input-box">
                        <input type="text" name="document" required autocomplete="off">
                        <label>CHAVE DO CURSO</label>
                        <span class="scanner-line"></span>
                    </div>

                    <button type="submit" class="magnetic-btn cyber-btn">
                        <span>CADASTRAR OPERADOR</span>
                        <div class="btn-flare"></div>
                    </button>
                </form>
            </aside>

            <main class="glass-panel data-station fade-in-right">
                <div class="table-container">
                    <table class="perspective-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>OPERADOR</th>
                                <th>E-MAIL</th>
                                <th>CURSO</th>
                                <th>TIMESTAMP</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr class="data-row" style="animation-delay: <?= $index * 0.1 ?>s">
                                    <td><span class="id-tag">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span></td>
                                    <td class="operator-name"><?= htmlspecialchars($user["name"]) ?></td>
                                    <td class="text-dimmed"><?= htmlspecialchars($user["email"]) ?></td>
                                    <td><span class="course-badge"><?= htmlspecialchars($user["document"]) ?></span></td>
                                    <td class="text-dimmed font-mono"><?= date("d.m.Y", strtotime($user["created_at"])) ?></td>
                                    <td class="actions">
                                        <a href="edit.php?id=<?= $user["id"] ?>" class="action-icon edit-icon" title="Modificar">
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        </a>
                                        <a href="delete.php?id=<?= $user["id"] ?>" class="action-icon delete-icon" title="Purgar" onclick="return confirm('AVISO: Excluir dados da matriz?')">
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

    <script>
        // Lógica do Cursor Customizado
        const cursorDot = document.querySelector('.cursor-dot');
        const cursorOutline = document.querySelector('.cursor-outline');

        window.addEventListener('mousemove', function(e) {
            const posX = e.clientX;
            const posY = e.clientY;

            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;

            // O outline segue com um leve atraso suave (efeito premium)
            cursorOutline.animate({
                left: `${posX}px`,
                top: `${posY}px`
            }, { duration: 500, fill: "forwards" });
        });

        // Botões Magnéticos
        const magnetBtns = document.querySelectorAll('.magnetic-btn');
        magnetBtns.forEach(btn => {
            btn.addEventListener('mousemove', function(e) {
                const position = btn.getBoundingClientRect();
                const x = e.pageX - position.left - position.width / 2;
                const y = e.pageY - position.top - position.height / 2;
                
                btn.style.transform = `translate(${x * 0.3}px, ${y * 0.5}px)`;
            });
            
            btn.addEventListener('mouseout', function() {
                btn.style.transform = 'translate(0px, 0px)';
            });
        });
    </script>
</body>
</html>