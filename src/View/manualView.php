<?php include 'src/View/Cabecalho/index.php'; ?>
<style>
    /* Container principal  */
    .manual-container {
        background-color: #2d2d2d;
        padding: 30px;
        border-radius: 8px;
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .manual-header {
        width: 100%;
        border-bottom: 2px solid #2ecc71;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .pdf-viewer {
        width: 100%;
        height: 75vh;
        border: none;
        border-radius: 4px;
        background: #1a1a1a;
    }

    .btn-download {
        background-color: #2ecc71;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: bold;
        margin-top: 20px;
        transition: background 0.3s;
    }

    .btn-download:hover {
        background-color: #27ae60;
    }
</style>

<div class="manual-container">
    <div class="manual-header">
        <h2 style="color: white; margin: 0;">ðŸŒ¿ Manual de Cuidados com Plantas</h2>
        <p style="color: #aaa; margin: 5px 0 0 0;">Guia bÃ¡sico para manter as suas plantas saudÃ¡veis</p>
    </div>

    <iframe src="public/assets/manual_cuidados.pdf" class="pdf-viewer"></iframe>

    <a href="public/assets/manual_cuidados.pdf" download class="btn-download">
        Baixar Guia Completo (PDF)
    </a>
</div>
