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
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $hijos = $this->hijoModel->getByParentId($padre_id);
        $evaluaciones_hijos = $this->evaluacionModel->getByParentId($padre_id, $page, $limit);
        
        $data = [
            'hijos' => $hijos,
            'evaluaciones_hijos' => $evaluaciones_hijos,
            'current_page' => $page,
            'total_pages' => ceil($this->evaluacionModel->getCountByParent($padre_id) / $limit),
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