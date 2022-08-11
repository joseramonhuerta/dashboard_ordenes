<?php
/**
 * 
 */
class Solicitudes extends Controllers
{
	
	public function __construct()
	{
		session_start();
		if(empty($_SESSION['login']))
		{
			header('Location:'.base_url().'/login');			
		}
		parent::__construct();
	}

	public function Solicitudes()
	{
		$data['page_tag'] = "Ordenes Servicio";
		$data['page_title'] = "Ordenes Servicio <small>Ordenes Servicio</small>";
		$data['page_name'] = "solicitudes";
		$data['page_functions_js'] = "functions_solicitudes.js";
		$this->views->getView($this, "solicitudes", $data);		
	}

	public function setSolicitud(){
		if($_POST)
		{
			//idOrdenServicio,txtFolio,txtFecha,listCliente,txtNombreEquipo,txtModeloEquipo,txtSerieEquipo,txtDescripcionFalla
			//listTecnico,,,txtPresupuesto,listStatus
			if(empty($_POST['txtFecha']) || empty($_POST['txtNombreEquipo']) || empty($_POST['txtDescripcionFalla']))
			{
				$arrResponse = array("success" => false, "msg" => 'Datos incorrectos.');				
			}else{
				$idOrdenServicio = intval($_POST['idOrdenServicio']);
				$strFecha = ucwords(strClean($_POST['txtFecha']));
				$resultDate = explode('/', $strFecha);
				$day=$resultDate[0];
				$month=$resultDate[1];
				$year=$resultDate[2];	
				$newDate=$year.'-'.$month.'-'.$day;	

				$intClienteId = intval($_POST['listCliente']);
				$strNombreEquipo = ucwords(strClean($_POST['txtNombreEquipo']));
				$strModeloEquipo = ucwords(strClean($_POST['txtModeloEquipo']));
				$strSerieEquipo = ucwords(strClean($_POST['txtSerieEquipo']));
				$strDescripcionFalla = ucwords(strClean($_POST['txtDescripcionFalla']));	
				
				$intTecnicoId = intval($_POST['listTecnico']);	
				$strDescripcionDiagnostico = ucwords(strClean($_POST['txtDescripcionDiagnostico']));
				$strDescripcionReparacion = ucwords(strClean($_POST['txtDescripcionReparacion']));

				$intPresupuesto = intval($_POST['txtPresupuesto']);
				$intStatusId = intval($_POST['listStatus']);

				if($idOrdenServicio == 0){
					$option = 1;
					$request_solicitud = $this->model->insertSolicitud($newDate,
																		$intClienteId,
																		$strNombreEquipo,
																		$strModeloEquipo,
																		$strSerieEquipo,
																		$strDescripcionFalla,
																		$intTecnicoId,
																		$strDescripcionDiagnostico,
																		$strDescripcionReparacion,
																		$intStatusId,
																		$intPresupuesto);	

				}else{
					$option = 2;
					$request_solicitud = $this->model->updateSolicitud($idOrdenServicio,$newDate,
																		$intClienteId,
																		$strNombreEquipo,
																		$strModeloEquipo,
																		$strSerieEquipo,
																		$strDescripcionFalla,
																		$intTecnicoId,
																		$strDescripcionDiagnostico,
																		$strDescripcionReparacion,
																		$intStatusId,
																		$intPresupuesto);

				}

				if($request_solicitud > 0){
					if($option == 1){
						$arrResponse = array("success" => true, "msg" => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array("success" => true, "msg" => 'Datos modificados correctamente.');	
					}

				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}

			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSolicitudes(){
		$arrData = $this->model->selectSolicitudes();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			$btnView = '<button class="btn btn-info btn-sm btnViewSolicitud" onClick="fntViewSolicitud('.$arrData[$i]['id_orden_servicio'].')" title="Ver solicitud"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditSolicitud" onClick="fntEditSolicitud(this,'.$arrData[$i]['id_orden_servicio'].')" title="Editar solicitud"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelSolicitud" onClick="fntDelSolicitud('.$arrData[$i]['id_orden_servicio'].')" title="Eliminar solicitud"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getSolicitud($idordenservicio)
	{
		$id_orden_servicio = intval($idordenservicio);

		if($id_orden_servicio > 0)
		{
			$arrData = $this->model->selectSolicitud($id_orden_servicio);
			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}

		die();

	}

	public function getSolicitudView($idordenservicio)
	{
		$id_orden_servicio = intval($idordenservicio);

		if($id_orden_servicio > 0)
		{
			$arrData = $this->model->selectSolicitud($id_orden_servicio);
			
			/*if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);*/

			$html = getModal("modalVerSolicitud", $arrData);
		}

		//die();

	}

	public function getSelectCliente(){
		$htmlOptions = "";
		$arrData = $this->model->selectClientes();
		//$htmlOptions .= '<option value="0" >Seleccione un cliente...</option>';
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_cliente'].'" data-celular="'.$arrData[$i]['celular'].'">'.$arrData[$i]['nombre_cliente'].'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}

	public function getSelectTecnico(){
		$htmlOptions = "";
		$arrData = $this->model->selectTecnicos();
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_usuario'].'">'.$arrData[$i]['nombre_usuario'].'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}

	public function delSolicitud()
	{
		if($_POST){
		
			$intIdOrdenServicio = intval($_POST['idOrdenServicio']);
			$requestDelete = $this->model->deleteSolicitud($intIdOrdenServicio);
			if($requestDelete)
			{
				$arrResponse = array('success' => true, 'msg' => 'Se ha eliminado la solicitud.');
			}else{
				$arrResponse = array('success' => false, 'msg' => 'Error al eliminar la solicitud.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		
		}
		die();
	}

	public function getReporteRecibidosEntregadosGrafica(){
		if($_POST){
			$fechainicio = date_create_from_format('d/m/Y', $_POST['txtFechaInicio']);
            $fechainicio = date_format($fechainicio, 'Y-m-d');           
            $fechainicio.= ' 00:00:00';

            $fechafin = date_create_from_format('d/m/Y', $_POST['txtFechaFin']);
            $fechafin = date_format($fechafin, 'Y-m-d');     
            $fechafin.= ' 23:59:59';

			$arrData = $this->model->getReporteRecibidosEntregadosGrafica($fechainicio, $fechafin);

			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'No se encontraron datos.');
			}else{	
				$arrResponse = array('success' => true, 'data' => $arrData);
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

		}
		die();
	}

	public function getReporteRecibidos(){
		if($_POST){
			$fechainicio = date_create_from_format('d/m/Y', $_POST['txtFechaInicio']);
            $fechainicio = date_format($fechainicio, 'Y-m-d');           
            $fechainicio.= ' 00:00:00';

            $fechafin = date_create_from_format('d/m/Y', $_POST['txtFechaFin']);
            $fechafin = date_format($fechafin, 'Y-m-d');     
            $fechafin.= ' 23:59:59';

			$arrData = $this->model->getReporteRecibidos($fechainicio, $fechafin);

			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'No se encontraron datos.');
			}else{	
				$arrResponse = array('success' => true, 'data' => $arrData);
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

		}
		die();
	}

	public function getReporteEntregados(){
		if($_POST){
			$fechainicio = date_create_from_format('d/m/Y', $_POST['txtFechaInicio']);
            $fechainicio = date_format($fechainicio, 'Y-m-d');           
            $fechainicio.= ' 00:00:00';

            $fechafin = date_create_from_format('d/m/Y', $_POST['txtFechaFin']);
            $fechafin = date_format($fechafin, 'Y-m-d');     
            $fechafin.= ' 23:59:59';

			$arrData = $this->model->getReporteEntregados($fechainicio, $fechafin);

			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'No se encontraron datos.');
			}else{	
				$arrResponse = array('success' => true, 'data' => $arrData);
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

		}
		die();
	}

}


?>