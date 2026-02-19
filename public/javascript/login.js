const { createApp } = Vue;

createApp({
    data() {
        return {
            email: '',
            password: '',
            loading: false,
            errorMessage: ''
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.errorMessage = '';

            // los datos para enviar (FormData simula el envío de un form normal)
            const formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);

            try {
                // Hacemos la petición a la ruta que configuramos en el index.php
                const response = await fetch('auth/login', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Si todo está bien, redirigimos según lo que mandó el PHP
                    window.location.href = result.redirect;
                } else {
                    // Si el PHP mandó success: false, mostramos el mensaje
                    this.errorMessage = result.mensaje;
                    this.loading = false;
                }
            } catch (error) {
                this.errorMessage = "Error de conexión con el servidor.";
                this.loading = false;
            }
        }
    }
}).mount('#loginForm');