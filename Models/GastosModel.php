<?php
class GastosModel extends Mysql
{
	private $id_gasto;
	private $fecha;
	private $concepto;
	private $tipo;
	private $importe;
	private $id_orden_servicio;
	private $status;
	private $id_usuario;

	public function __construct()
	{
			//session_start();
			$db = $_SESSION['basedatos'];
			$this->getConexion($db);
	}
	//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super
	public function selectGastos(){
		$sql = "SELECT g.id_gasto, CAST(DATE_FORMAT(g.fecha,'%d/%m/%Y') as CHAR) as fecha, g.concepto,
					g.tipo, g.importe, IFNULL(CONCAT(o.id_orden_servicio,' (',c.nombre_cliente,')'),'') AS orden_servicio	FROM gastos g
					LEFT JOIN ordenes_servicio o on o.id_orden_servicio = g.id_orden_servicio
					LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectGasto($id){
		$this->id_gasto = $id;
		$sql = "SELECT g.id_gasto, CAST(DATE_FORMAT(g.fecha,'%d/%m/%Y') as CHAR) as fecha, g.concepto, IFNULL(g.id_orden_servicio,'') AS id_orden_servicio, g.tipo, g.importe, IFNULL(c.nombre_cliente,'') AS nombre_cliente
		FROM gastos g
		LEFT JOIN ordenes_servicio o on o.id_orden_servicio = g.id_orden_servicio
		LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
		WHERE id_gasto = $this->id_gasto";
		$request = $this->select($sql);
		return $request;

	}
	//$newDate, $strConcepto, $dbImporte, $intIdOrdenServicio, $intTip
	public function insertGasto(string $fecha,  string $concepto, string $importe, int $idorden, int $tipo){
		$this->fecha = $fecha;
		$this->concepto = $concepto;
		$this->tipo = $tipo;
		$this->importe = $importe;
		$this->id_orden_servicio = $idorden;
		$this->status = 'A';
		$this->id_usuario = $_SESSION['id_usuario'];


		if($this->id_orden_servicio == 0)
			$this->id_orden_servicio = null;

		$return = 0;

		
		$query_insert  = "INSERT INTO gastos(fecha, concepto, tipo, importe, id_orden_servicio, status, usercreador, fechacreador)
						  VALUES(?,?,?,?,?,?,?,?)";
    	$arrData = array($this->fecha,
						$this->concepto,
						$this->tipo,
						$this->importe,
						$this->id_orden_servicio,
						$this->status,
						$this->id_usuario, 
						date('Y-m-d H:i:s'));
    	$request_insert = $this->insert($query_insert,$arrData);
    	$return = $request_insert;
		
        return $return;
	}

	public function updateGasto(int $idgasto, string $fecha,  string $concepto, string $importe, int $idorden, int $tipo){

		$this->id_gasto = $idgasto;
		$this->fecha = $fecha;
		$this->concepto = $concepto;
		$this->tipo = $tipo;
		$this->importe = $importe;
		$this->id_orden_servicio = $idorden;
		$this->status = 'A';
		$this->id_usuario = $_SESSION['id_usuario'];

		if($this->id_orden_servicio == 0)
			$this->id_orden_servicio = null;

		$sql = "UPDATE gastos SET fecha = ?, concepto = ?, tipo = ?, importe = ?, id_orden_servicio = ?, usermodif = ?, fechamodif = ?
				WHERE id_gasto = $this->id_gasto ";
		$arrData = array($this->fecha,
						$this->concepto,
						$this->tipo,
						$this->importe,
						$this->id_orden_servicio,
						$this->id_usuario, 
						date('Y-m-d H:i:s'));
			
		$request = $this->update($sql,$arrData);
		
		return $request;
	
	}


	public function deleteGasto(int $idgasto)
	{
		$this->id_gasto = $idgasto;
		$sql = "DELETE FROM gastos where id_gasto = $this->id_gasto";
		$request = $this->delete($sql);
		return $request;
	}

	public function selectSolicitudes(){
		$sql = "SELECT o.id_orden_servicio, c.nombre_cliente,o.importe_presupuesto, o.nombre_equipo
			FROM ordenes_servicio o
			LEFT JOIN cat_clientes c on c.id_cliente = o.id_cliente
			WHERE o.status_servicio = 6";
		$request = $this->select_all($sql);
		return $request;
	}	

	

}





?>