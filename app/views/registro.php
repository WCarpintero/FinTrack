<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            width: 100%;
            max-width: 600px; /* Un poco más ancho para las columnas */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .brand-icon-container {
            background: linear-gradient(135deg, #0d6efd 0%, #003da1 100%);
            width: 50px; height: 50px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px;
            margin: 0 auto 15px;
            box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.3);
        }

        .brand-text {
            font-weight: 800; font-size: 1.75rem;
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .form-label { margin-bottom: 0.4rem; }

        .form-control {
            border-radius: 12px;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.08);
            border-color: #0d6efd;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: #ffffff;
            border-right: none;
            color: #94a3b8;
        }

        .input-group > .form-control {
            border-radius: 0 12px 12px 0;
        }

        .btn-register {
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #0d6efd 0%, #003da1 100%);
            border: none;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(13, 110, 253, 0.4);
        }
        /* CORRECCIÓN PARA EL CAMPO DE CONTRASEÑA */
        .input-group-password .form-control {
            border-right: none !important;
        }
        
        .input-group-password .input-group-text:last-child {
            border-left: none !important;
            border-radius: 0 12px 12px 0 !important;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .input-group-password .input-group-text:last-child:hover {
            color: #0d6efd;
        }

        /* Ajuste para que el foco resalte todo el grupo si quieres, 
           o al menos que no se vea el borde cortado */
        .form-control:focus + .input-group-text {
            border-color: #0d6efd;
        }
    </style>
</head>
<body>
<script>const Config = { BASE_URL: "<?= URL ?>" };</script>

<div id="registroApp" class="auth-card p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="brand-icon-container text-white">
            <i class="bi bi-intersect fs-3"></i>
        </div>
        <span class="brand-text text-uppercase">Fin<span class="fw-light">track</span></span>
        <p class="text-muted small px-4">Crea tu cuenta para comenzar a monitorear tus movimientos financieros.</p>
    </div>

    <form @submit.prevent="handleRegistro">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-bold text-dark">Número de Identificación</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" v-model="usuario.identificacion" class="form-control" placeholder="DNI / Cédula / Pasaporte" required>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Nombre</label>
                <input type="text" v-model="usuario.nombre" class="form-control" placeholder="Ej: Juan" required>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Apellido</label>
                <input type="text" v-model="usuario.apellido" class="form-control" placeholder="Ej: Pérez" required>
            </div>
            
            <div class="col-md-7">
                <label class="form-label small fw-bold text-dark">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" v-model="usuario.email" class="form-control" placeholder="nombre@ejemplo.com" required>
                </div>
            </div>

            <div class="col-md-5">
                <label class="form-label small fw-bold text-dark">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="tel" v-model="usuario.telefono" class="form-control" placeholder="Ej: 321..." required>
                </div>
            </div>

            <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-bold text-dark">Contraseña</label>
                <div class="input-group input-group-password">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input :type="passwordVisible ? 'text' : 'password'" 
                           v-model="usuario.password" 
                           class="form-control" 
                           placeholder="Crea una contraseña segura" 
                           required>
                    <span class="input-group-text bg-white" 
                          style="cursor: pointer;" 
                          @click="passwordVisible = !passwordVisible">
                        <i :class="['bi', passwordVisible ? 'bi-eye-slash' : 'bi-eye']"></i>
                    </span>
                </div>
                <div id="passwordHelp" class="form-text" style="font-size: 0.75rem;">
                    Usa 8 o más caracteres con una mezcla de letras y números.
                </div>
            </div>

            </div>

            <div class="col-12" v-if="mensaje">
                <div :class="['alert py-2 small border-0 shadow-sm', success ? 'alert-success' : 'alert-danger']">
                    <i :class="['bi me-2', success ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill']"></i>
                    {{ mensaje }}
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="form-check small">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label text-muted" for="terms">
                        Acepto los <a href="#" class="text-primary text-decoration-none">Términos de Servicio</a>.
                    </label>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100 btn-register text-white" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                    {{ loading ? 'Procesando...' : 'Registrarme ahora' }}
                </button>
            </div>

            <div class="col-12 text-center mt-4">
                <p class="small text-muted mb-0">¿Ya eres parte de FinTrack? 
                    <a href="<?= URL ?>/login" class="fw-bold text-primary text-decoration-none ms-1">Inicia Sesión</a>
                </p>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= URL ?>/javascript/gestionRegistro.js"></script>
</body>
</html>