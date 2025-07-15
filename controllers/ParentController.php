<?php
require_once 'models/Hijo.php';
require_once 'models/Evaluacion.php';

class ParentController {
    private $hijoModel;
    private $evaluacionModel;
    
    public function __construct() {
        $this->hijoModel = new Hijo();
        $this->evaluacionModel = new Evaluacion();
    }
    
    public function dashboard($padre_id) {
        $hijos = $this->hijoModel->getByParentId($padre_id);
        $evaluaciones_hijos = $this->evaluacionModel->getByParentId($padre_id);
        
        $data = [
            'hijos' => $hijos,
            'evaluaciones_hijos' => $evaluaciones_hijos,
            'page_title' => 'Parent Dashboard'
        ];
        
        $this->loadView('parent/dashboard_padre', $data);
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>