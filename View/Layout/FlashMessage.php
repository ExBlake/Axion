<?php
// flashMessage.php - Mostrar mensajes flash almacenados en la sesión
if (isset($_SESSION['Mensaje'])):
    $tipo = $_SESSION['MensajeTipo'] ?? 'success'; // valores: success | error
?>
<style>
    .alert-box {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        color: #111;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-left: 8px solid #007bff;
        z-index: 9999;
        animation: slide-in 0.4s ease-out;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: opacity 0.3s ease;
        max-width: 90%;
        width: 350px;
        position: fixed;
        overflow: hidden;
    }

    .alert-box.success {
        border-left-color: #28a745;
        background: linear-gradient(to right, #d4edda, #ffffff);
    }

    .alert-box.error {
        border-left-color: #dc3545;
        background: linear-gradient(to right, #f8d7da, #ffffff);
    }

    .alert-message {
        font-size: 18px;
        padding-right: 30px;
    }

    .close-btn {
        position: absolute;
        top: 8px;
        right: 10px;
        font-weight: bold;
        color: #666;
        font-size: 24px;
        line-height: 20px;
        cursor: pointer;
        border: none;
        background: none;
        transition: color 0.2s ease;
    }

    .close-btn:hover {
        color: #000;
    }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(100%); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @media screen and (max-width: 500px) {
        .alert-box {
            right: 10px;
            bottom: 10px;
            width: 90%;
            padding: 16px 20px;
        }

        .alert-message {
            font-size: 16px;
        }
    }
</style>

<div class="alert-box <?= htmlspecialchars($tipo) ?>" id="alertBox">
    <span class="close-btn" onclick="closeAlert()">&times;</span>
    <div class="alert-message"><?= htmlspecialchars($_SESSION['Mensaje']) ?></div>
</div>

<script>
    function closeAlert() {
        const alert = document.getElementById("alertBox");
        if (alert) {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 300);
        }
    }
    setTimeout(closeAlert, 4000);
</script>
<?php
    unset($_SESSION['Mensaje'], $_SESSION['MensajeTipo']);
endif;
?>
