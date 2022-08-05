<?php
/**
 * 
 */
class VentasModel extends Mysql
{
	private $id_venta;
	private $id_cliente;
	private $fecha;
	private $observaciones;
	private $total_venta;
	private $status_venta;
	
	public function __construct()
	{
		$db = $_SESSION['basedatos'];
		$this->getConexion($db);
	}

	public function selectVentas(){
		$sql = "SELECT v.id_venta, CAST(DATE_FORMAT(v.fecha,'%d/%m/%Y %h:%i %p') as CHAR) as fecha, c.nombre_cliente,
				v.observaciones,v.total_venta,v.status_venta 
				FROM ventas v
				LEFT JOIN cat_clientes c on c.id_cliente = v.id_cliente				
				";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectClientes(){
		$sql = "SELECT id_cliente, nombre_cliente, celular, direccion FROM cat_clientes";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectProductos(){
		$sql = "SELECT id_producto, CONCAT(codigo,' - ',nombre_producto) AS nombre_producto, precio FROM cat_productos";
		$request = $this->select_all($sql);
		return $request;
	}




}

?>