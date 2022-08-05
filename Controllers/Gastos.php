<?php
class Gastos extends Controllers{
	public function __construct(){
		
			
			 session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				//die();
			}
			parent::__construct();
	}

	public function Gastos(){
		$data['page_tag'] = "Gastos";
		$data['page_title'] = "Gastos <small>Ordenes Servicio</small>";
		$data['page_name'] = "gastos";
		$data['page_functions_js'] = "functions_gastos.js";		
		$this->views->getView($this, "gastos",$data);
	}

	public function getGastos(){
		$arrData = $this->model->selectGastos();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			if($arrData[$i]['tipo'] == 1)
			{
				$arrData[$i]['tipo'] = '<span class="badge badge-success">Ingreso</span>';	
			}else{
				$arrData[$i]['tipo'] = '<span class="badge badge-danger">Egreso</span>';	
			}


			$btnView = '<button class="btn btn-info btn-sm btnViewGasto" onClick="fntViewGasto('.$arrData[$i]['id_gasto'].')" title="Ver gasto"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditGasto" onClick="fntEditGasto(this,'.$arrData[$i]['id_gasto'].')" title="Editar gasto"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelGasto" onClick="fntDelGasto('.$arrData[$i]['id_gasto'].')" title="Eliminar gasto"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}
	//txtFecha , txtConcepto , txtImporte , listTipo , listOrdenServicio
	public function setGasto(){
		if($_POST){			
			if(empty($_POST['txtFecha']) || empty($_POST['txtConcepto']) || empty($_POST['txtImporte']) || empty($_POST['listTipo']) || ($_POST['listTipo'] == 1 && empty($_POST['listOrdenServicio'])) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idGasto = intval($_POST['idGasto']);
				$strFecha = ucwords(strClean($_POST['txtFecha']));
				$resultDate = explode('/', $strFecha);
				$day=$resultDate[0];
				$month=$resultDate[1];
				$year=$resultDate[2];	
				$newDate=$year.'-'.$month.'-'.$day;

				$strConcepto = ucwords(strClean($_POST['txtConcepto']));				
				$dbImporte = doubleval(strClean($_POST['txtImporte']));
				$intIdOrdenServicio = intval(strClean($_POST['listOrdenServicio']));
				$intTipo = intval(strClean($_POST['listTipo']));
				
				if($intTipo == 2)
						$intIdOrdenServicio = 0;

				$request_gasto = "";
				if($idGasto == 0)
				{
					$option = 1;					
					$request_gasto = $this->model->insertGasto($newDate, $strConcepto, $dbImporte, $intIdOrdenServicio, $intTipo);
					
				}else{
					$option = 2;			
					$request_gasto = $this->model->updateGasto($idGasto, $newDate, $strConcepto, $dbImporte, $intIdOrdenServicio, $intTipo);		
				}

				if(intval($request_gasto) > 0)
				{
					if($option == 1){
						$arrResponse = array('success' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('success' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}	

	public function getGasto($id){
		$id_gasto = $id;
		if($id_gasto > 0){
			$arrData = $this->model->selectGasto($id_gasto);
			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delGasto(){
		if($_POST){
			$id_gasto = intval($_POST['idGasto']);
			$requestDelete = $this->model->deleteGasto($id_gasto);
			if($requestDelete)
			{
				$arrResponse = array('success' => true, 'msg' => 'Ingreso/Gasto eliminado correctamente.');
			}else{
				$arrResponse = array('success' => false , 'msg' => 'Error al eliminar el ingreso/gasto.');
			}
			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
		}
		die();
	}

	public function getSelectOrdenes(){
		$htmlOptions = "";
		$arrData = $this->model->selectSolicitudes();
		$htmlOptions .= '<option value="" >Buscar Orden Servicio</option>';
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_orden_servicio'].'" data-nombre="'.$arrData[$i]['nombre_cliente'].'" data-importe="'.$arrData[$i]['importe_presupuesto'].'" data-equipo="'.$arrData[$i]['nombre_equipo'].'">'.$arrData[$i]['id_orden_servicio'].' ('.$arrData[$i]['nombre_cliente'].')'.'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}


}

?>