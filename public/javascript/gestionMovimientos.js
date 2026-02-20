const { createApp } = Vue;

createApp({
    data() {
        return {
            loading: false,
            mensaje: '',
            success: false,
            usuarios: [],   // Se carga de la DB
            tipos: [],      // Compra, Venta, etc.
            horarios: [],   // Franjas horarias
            movimientos: [], // Lista para la tabla
            movimiento: {
                usuario_fk: '',
                tipo_movimiento_fk: 1, // Por defecto Compra
                horario_fk: '',
                monto: 0,
                ganancia: 0,
                perdida: 0,
                descripcion: ''
            }
        }
    },
    methods: {
        async registrarMovimiento() {
            // Aquí enviarías los datos a un endpoint como /movimientos/registrar
            // Recuerda que el backend debe actualizar el saldo_actual del usuario en cascada
        },
        async fetchUsuarios() {
            this.loadingTable = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/usuarios/api/listar`);
                const res = await response.json();
                if (res.success) this.usuarios = res.data;
            } catch (error) { console.error("Error usuarios:", error); }
        }
        // ... otros métodos (fetchUsuarios, fetchHorarios, etc.)
    },
    mounted() {
        // Cargar catálogos al iniciar
        this.fetchUsuarios();
        this.fetchTipos();
        this.fetchHorarios();
    }
}).mount('#movimientosApp');