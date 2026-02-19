<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL ?>/css/loginEstilos.css">
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-container">
        
        <div id="loginForm" class="login-form-section">
            <div class="mb-4">
                <h3 class="fw-bold text-dark">Bienvenido</h3>
                <p class="text-muted">Ingresa tus credenciales para acceder a FinTrack.</p>
            </div>

            <form @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" v-model="email"    name="email" class="form-control border-start-0" placeholder="nombre@ejemplo.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <a href="#" class="small text-decoration-none">¿La olvidaste?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" v-model="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100 mb-3" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                    {{ loading ? 'Ingresando...' : 'Iniciar Sesión' }}
                </button>
                
                <div v-if="errorMessage" class="alert alert-danger py-2 small border-0 shadow-sm">
                    <i class="bi bi-exclamation-circle me-2"></i> {{ errorMessage }}
                </div>
            </form>
                <div class="mt-4 text-center">
            <p class="small text-muted mb-0">
                ¿No tienes una cuenta? 
                <a href="<?= URL ?>/auth/registro" class="fw-bold text-primary text-decoration-none">Regístrate aquí</a>
            </p>
            </div>
            <!--Se desahabilitará el libre registro
                <p class="text-center small text-muted">
                ¿No tienes cuenta? <a href="#" class="fw-bold text-decoration-none">Contáctanos</a>
            </p>-->
        </div>

        <div class="login-visual-section">
            <div class="position-relative z-3">
                <div class="brand-icon-login">
                    <i class="bi bi-intersect"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">Domina tus inversiones con precisión.</h1>
                <p class="lead opacity-75">Visualiza tus inversiones, analiza tus resultados y toma decisiones inteligentes desde un solo lugar.</p>
                
                <div class="mt-5 d-flex gap-4">
                    <div class="text-center">
                        <h4 class="fw-bold mb-0">100%</h4>
                        <span class="small opacity-50">Seguro</span>
                    </div>
                    <div class="vr opacity-25"></div>
                    <div class="text-center">
                        <h4 class="fw-bold mb-0">Real-time</h4>
                        <span class="small opacity-50">Análisis</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= URL ?>/javascript/login.js"></script>
</body>
</html>