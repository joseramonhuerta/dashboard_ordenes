<?php

class Ventas extends Controllers{


	public function __construct()
	{
		session_start();
		if(empty($_SESSION['login']))
		{
			header('Location:'.base_url().'/login');			
		}
		parent::__construct();
	}

	public function Ventas()
	{
		$data['page_tag'] = "Ventas";
		$data['page_title'] = "Ventas <small>Ordenes Servicio</small>";
		$data['page_name'] = "ventas";
		$data['page_functions_js'] = "functions_ventas.js";
		$this->views->getView($this, "ventas", $data);		
	}

	public function getVentas(){
		$arrData = $this->model->selectVentas();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			$btnView = '<button class="btn btn-info btn-sm btnViewVenta" onClick="fntViewVenta('.$arrData[$i]['id_venta'].')" title="Ver venta"><i class="far fa-eye"></i></button>';
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelVenta" onClick="fntDelVenta('.$arrData[$i]['id_venta'].')" title="Cancelar venta"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getSelectCliente(){
		$htmlOptions = "";
		$arrData = $this->model->selectClientes();
		//$htmlOptions .= '<option value="0" >Seleccione un cliente...</option>';
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_cliente'].'" >'.$arrData[$i]['nombre_cliente'].'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}

	public function getSelectProducto(){
		$htmlOptions = "";
		$arrData = $this->model->selectProductos();
		$htmlOptions .= '<option value="" >Seleccione un producto...</option>';
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_producto'].'" data-precio="'.$arrData[$i]['precio'].'">'.$arrData[$i]['nombre_producto'].'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}





}

?>