const { createApp } = Vue;

const getHoy = () => new Date().toISOString().split('T')[0]; 

createApp({
    data() {
        return {
            loading: false,
            mensaje: '',
            success: false,
            usuarios: [],   // Se carga de la DB
            tipos: [],      // Compra, Venta, etc.
            divisas: [],    // Divisas disponibles
            horarios: [],   // Franjas horarias
            historial: [], // Lista para la tabla
            movimiento: {
                usuario_fk: '',
                tipo_movimiento_fk: 1, // Por defecto Compra
                horario_fk: 1, // Por defecto Mañana
                divisa_fk: 3, // Por defecto USDT
                monto: 0,
                utilidad: 0,
                fecha_operacion: getHoy(),
                descripcion: ''
            }
        }
    },
    methods: {
        async registrarMovimiento() {
            this.loading = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/movimientos/registrar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.movimiento)
                });
                const res = await response.json();
                this.loading = false;
                if (res.success) {
                    this.mensaje = "Movimiento registrado con éxito.";
                    this.success = true;
                    this.movimiento = {
                        usuario_fk: '',
                        tipo_movimiento_fk: 1,
                        horario_fk: 1,
                        divisa_fk: 3,
                        monto: 0,
                        fecha_operacion: getHoy(),
                        utilidad: 0,
                        descripcion: ''
                    };
                    this.fetchHistorial(); // Actualizar tabla
                } else {
                    this.mensaje = res.message || "Error al registrar movimiento.";
                    this.success = false;
                }
            } catch (error) {
                this.loading = false;
                this.mensaje = "Error de conexión con el servidor.";
                this.success = false;
            }
        },
        async fetchUsuarios() {
            //this.loading = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/usuarios/api/listar`);
                const res = await response.json();
                if (res.success) this.usuarios = res.data;
            } catch (error) { console.error("Error usuarios:", error); }
        }, async fetchTipos() {
            //this.loading = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/tipos/api/listar`);
                const res = await response.json();
                if (res.success) this.tipos = res.data;
            } catch (error) { console.error("Error tipos:", error); }
        },
        async fetchHorarios() {
            this.loadingTable = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/horarios/listar`);
                const res = await response.json();
                if (res.success) this.horarios = res.data;
            }catch (error) { console.error("Error horarios:", error); }
        },
        async fetchDivisas() {
            this.loadingTable = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/divisas/listar`);
                const res = await response.json();
                if (res.success) this.divisas = res.data;
            }catch (error) { console.error("Error divisas:", error); }
        },
        async fetchHistorial() {
            //Breve historial de movimientos para mostrar en la tabla
            this.loadingTable = true;
            try {
                const response = await fetch(`${Config.BASE_URL}/movimientos/historial`);
                const res = await response.json();
                if (res.success) this.historial = res.data;
            } catch (error) { console.error("Error historial:", error); }
        }
    },
    mounted() {
        // Cargar catálogos al iniciar
        this.fetchUsuarios();
        this.fetchTipos();
        this.fetchHorarios();
        this.fetchDivisas();
        this.fetchHistorial();
    }
}).mount('#movimientosApp');