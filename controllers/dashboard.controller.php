<?php

class DashboardController{

    static public function ctrTotalProductos(){
        $dashboard = DashboardModel::mdlTotalProductos();
        return $dashboard;
    }
    static public function ctrTotalConejos(){
        $dashboard = DashboardModel:: mdlTotalConejos();
        return $dashboard;
    }

    static public function ctrTotalEmpleado(){
        $dashboard = DashboardModel::mdlTotalEmpleado();
        return $dashboard;
    }
    static public function ctrTotalAlmacen(){
        $dashboard = DashboardModel:: mdlTotalAlmacen();
        return $dashboard;
    }

  
    static public function ctrTotalVCP($idAlmacen){
        $dashboard = DashboardModel:: mdlTotalVCP($idAlmacen);
        return $dashboard;
    }
    
    
}
