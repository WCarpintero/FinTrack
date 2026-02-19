const { createApp } = Vue;

createApp({
    data() {
        return {
            usuario: {
                identificacion: '',
                nombre: '',
                apellido: '',
                email: '',
                telefono: '',
                password: ''
            },
            // Nueva variable de estado
            passwordVisible: false, 
            loading: false,
            mensaje: '',
            success: false
        }
    },
    methods: {
        async handleRegistro() {
            this.loading = true;
            this.mensaje = '';
            
            try {
                // Preparamos los datos para enviar
                const formData = new FormData();
                Object.keys(this.usuario).forEach(key => {
                    formData.append(key, this.usuario[key]);
                });

                // Enviamos al endpoint definido en tu index.php
                const response = await fetch(`${Config.BASE_URL}/auth/registro`, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    this.success = true;
                    this.mensaje = "¡Cuenta creada con éxito! Redirigiendo al login...";
                    
                    // Limpiar formulario
                    this.resetForm();

                    // Redirigir después de 2 segundos
                    setTimeout(() => {
                        window.location.href = 'index';
                    }, 2500);
                } else {
                    this.success = false;
                    this.mensaje = result.mensaje || 'Error al procesar el registro.';
                }

            } catch (error) {
                this.success = false;
                this.mensaje = 'Error de conexión con el servidor.';
                console.error("Error registro:", error);
            } finally {
                this.loading = false;
            }
        },

        resetForm() {
            this.usuario = {
                identificacion: '',
                nombre: '',
                apellido: '',
                email: '',
                telefono: '',
                password: ''
            };
        }
    }
}).mount('#registroApp');