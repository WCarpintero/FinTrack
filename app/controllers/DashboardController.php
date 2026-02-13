<?php

class DashboardController extends Controller {
    
    public function index() {
        // El método render se encarga de extraer los datos y cargar el archivo
        $this->render('dashboard/index', [
            'titulo' => 'Panel de Supervisión'
        ]);
    }
}