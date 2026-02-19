const { createApp } = Vue;

createApp({
    data() {
        return {
            usuarios: [],
            pares: [],
            buscar: '',
            loading: false,      // Para el Registro de nuevos usuarios
            loadingEdit: false,  // EXCLUSIVO para el modal de edición (esto arregla tu problema)
            loadingTable: false, // Para el feedback de la tabla
            mensaje: '',
            success: false,
            mensajeEdit: '',
            usuarioEdit: {}, 
            successEdit: false,
            nuevo: {
                identificacion: '',
                nombre: '',
                apellido: '',
                email: '',
                telefono: '',
                activo: 1,
                rol: '2',
                total_invertido_pesos: 0,
                invertido_cripto: 0,
                inicio_operaciones: new Date().toISOString().split('T')[0],
                par_operar_fk: '',
                regalos_bonos: 0,
                saldo_actual: 0
            }
        }
    },
    computed: {
        usuariosFiltrados() {
            return this.usuarios.filter(user => {
                const busqueda = this.buscar.toLowerCase();
                const nombreCompleto = `${user.nombre} ${user.apellido}`.toLowerCase();
                const email = user.email ? user.email.toLowerCase() : '';
                const id = user.identificacion ? user.identificacion.toString() : '';
                return nombreCompleto.includes(busqueda) || email.includes(busqueda) || id.includes(busqueda);
            });
        }
    },
    methods: {
        async fetchPares() {
            try {
                const response = await fetch(`${Config.BASE_URL}/usuarios/api/get_pares`);
                const res = await response.json();
                if (res.success) this.pares = res.data;
            } catch (error) { console.error("Error pares:", error); }
            finally {
                this.loadingTable = false;
            }
        },
        async fetchUsuarios() {
            this.loadingTable = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/usuarios/api/listar`);
                const res = await response.json();
                if (res.success) this.usuarios = res.data;
            } catch (error) { console.error("Error usuarios:", error); }
        },
        prepararEdicion(user) {
            this.loadingEdit = false;
            this.mensajeEdit = '';
            this.successEdit = false;
            this.usuarioEdit = JSON.parse(JSON.stringify(user));
            const modalEl = document.getElementById('modalEditar');
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        },
        async actualizarUsuario() {
            this.loadingEdit = true;
            try {
                const formData = new FormData();
                formData.append('id', this.usuarioEdit.id);
                formData.append('nombre', this.usuarioEdit.nombre);
                formData.append('apellido', this.usuarioEdit.apellido);
                formData.append('email', this.usuarioEdit.email);
                formData.append('telefono', this.usuarioEdit.telefono);
                formData.append('estado', this.usuarioEdit.estado);

                const response = await fetch(`${Config.BASE_URL}/usuarios/actualizar`, {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                
                if (res.success) {
                    this.successEdit = true;
                    this.mensajeEdit = "Perfil actualizado con éxito";
                    this.fetchUsuarios(); 
                    setTimeout(() => {
                        const modalEl = document.getElementById('modalEditar');
                        bootstrap.Modal.getInstance(modalEl).hide();
                    }, 1500);
                } else {
                    this.successEdit = false;
                    this.mensajeEdit = res.mensaje;
                }
            } catch (error) { this.mensajeEdit = "Error de conexión"; }
            finally { this.loadingEdit = false; }
        },
        async confirmarCambioEstado(user) {
            // Si está activo (1), queremos enviarlo a 0. Si está inactivo (0), a 1.
            const nuevoEstado = user.estado == 1 ? 0 : 1;
            const accion = nuevoEstado === 1 ? 'habilitar' : 'inhabilitar';

            if (confirm(`¿Estás seguro de que deseas ${accion} al usuario ${user.nombre}?`)) {
                try {
                    const formData = new FormData();
                    formData.append('id', user.id);
                    formData.append('estado', nuevoEstado); // Enviar el nuevo estado

                    const response = await fetch(`${Config.BASE_URL}/usuarios/cambiar_estado`, {
                        method: 'POST',
                        body: formData
                    });
                    const res = await response.json();

                    if (res.success) {
                        this.fetchUsuarios(); // Recargar la lista
                    } else {
                        alert(res.mensaje);
                    }
                } catch (error) {
                    console.error("Error al cambiar estado:", error);
                }
            }
        },
        validarYEnviar() {
            const camposRequeridos = ['identificacion', 'nombre', 'apellido', 'email', 'telefono', 'par_operar_fk'];
            for (let campo of camposRequeridos) {
                if (!this.nuevo[campo] || this.nuevo[campo].toString().trim() === "") {
                    this.success = false;
                    this.mensaje = `El campo ${campo.replace('_', ' ')} es obligatorio.`;
                    return;
                }
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.nuevo.email)) {
                this.success = false;
                this.mensaje = "Ingresa un correo válido.";
                return;
            }
            this.registrarUsuario();
        },
        async registrarUsuario() {
            this.loading = true;
            this.mensaje = '';
            try {
                const formData = new FormData();
                for (const key in this.nuevo) { formData.append(key, this.nuevo[key]); }

                const response = await fetch(`${Config.BASE_URL}/auth/registrar_completo`, {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                this.success = res.success;
                this.mensaje = res.mensaje;

                if (res.success) {
                    setTimeout(() => {
                        this.resetFormulario();
                        this.fetchUsuarios();
                        const modalReg = document.getElementById('modalRegistro');
                        bootstrap.Modal.getInstance(modalReg).hide();
                    }, 1500);
                }
            } catch (error) {
                this.success = false;
                this.mensaje = "Error de conexión.";
            } finally { this.loading = false; }
        },
        resetFormulario() {
            this.nuevo = {
                identificacion: '', nombre: '', apellido: '', email: '',
                telefono: '', activo: 1, rol: '2', total_invertido_pesos: 0,
                invertido_cripto: 0, inicio_operaciones: new Date().toISOString().split('T')[0],
                par_operar_fk: '', regalos_bonos: 0, saldo_actual: 0
            };
            this.mensaje = '';
        }
    },
    mounted() {
        this.fetchUsuarios();
        this.fetchPares();
    }
}).mount('#usuariosApp');