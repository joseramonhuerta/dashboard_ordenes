<?php
/**
 * 
 */
class SolicitudesModel extends Mysql
{
	private $id_orden_servicio;
	private $id_cliente;
	private $id_tecnico;
	private $fecha;
	private $nombre_equipo;
	private $modelo_equipo;
	private $serie_equipo;
	private $descripcion_falla;	
	private $descripcion_diagnostico;
	private $descripcion_reparacion;
	private $importe_presupuesto;
	private $status_servicio;
	
	public function __construct()
	{
		$db = $_SESSION['basedatos'];
		$this->getConexion($db);
	}

	public function selectSolicitudes(){
		$sql = "SELECT p.id_orden_servicio, CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y') as CHAR) as fecha, c.nombre_cliente, 
				p.descripcion_falla,CASE p.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio,
				IFNULL(u.nombre_usuario,'') as nombre_tecnico  
				FROM ordenes_servicio p
				LEFT JOIN cat_clientes c on c.id_cliente = p.id_cliente
				LEFT JOIN cat_usuarios u on u.id_usuario = p.id_tecnico
				";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectSolicitud($id)
	{
		$this->id_orden_servicio = $id;
		$sql = "SELECT p.id_orden_servicio,p.id_cliente,u.id_usuario AS id_tecnico, CAST(DATE_FORMAT(p.fecha,'%d/%m/%Y') AS CHAR) AS fecha, c.nombre_cliente,c.celular,
				p.nombre_equipo, p.modelo_equipo, p.serie_equipo, p.descripcion_diagnostico, p.descripcion_reparacion, p.importe_presupuesto, 
				p.descripcion_falla,p.status_servicio,CASE p.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion,
				IFNULL(u.nombre_usuario,'') AS nombre_tecnico, p.imagen, p.imagen_back  
				FROM ordenes_servicio p
				LEFT JOIN cat_clientes c ON c.id_cliente = p.id_cliente
				LEFT JOIN cat_usuarios u ON u.id_usuario = p.id_tecnico
				WHERE p.id_orden_servicio = $this->id_orden_servicio";
		$request = $this->select($sql);
		return $request;		
	}

	public function insertSolicitud(string $strFecha,int $intClienteId,string $strNombreEquipo,string $strModeloEquipo,string $strSerieEquipo,string $strDescripcionFalla,int $intTecnicoId,	string $strDescripcionDiagnostico,string $strDescripcionReparacion,int $intStatusId, float $intPresupuesto){
			
		$this->id_cliente = $intClienteId;
		$this->id_tecnico = $intTecnicoId;
		$this->fecha = $strFecha;
		$this->nombre_equipo = $strNombreEquipo;
		$this->modelo_equipo = $strModeloEquipo;
		$this->serie_equipo = $strSerieEquipo;
		$this->descripcion_falla = $strDescripcionFalla;	
		$this->descripcion_diagnostico = $strDescripcionDiagnostico;
		$this->descripcion_reparacion = $strDescripcionReparacion;
		$this->importe_presupuesto = $intPresupuesto;
		$this->status_servicio = $intStatusId;

		
		$return = 0;
					 
		$query_insert  = "INSERT INTO ordenes_servicio( fecha, 
												id_cliente,
												id_tecnico, 
												nombre_equipo, 
												modelo_equipo, 
												serie_equipo, 
												descripcion_falla, 
												descripcion_diagnostico, 
												descripcion_reparacion, 
												importe_presupuesto, 
												status_servicio) 
						  VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    	$arrData = array($this->fecha,
    					 $this->id_cliente,
						 $this->id_tecnico,							
						 $this->nombre_equipo,
						 $this->modelo_equipo,
						 $this->serie_equipo, 
						 $this->descripcion_falla,
						 $this->descripcion_diagnostico,
						 $this->descripcion_reparacion,
						 $this->importe_presupuesto,
						 $this->status_servicio);
    	$request_insert = $this->insert($query_insert,$arrData);
    	$return = $request_insert;
		
        return $return;
	}

	public function updateSolicitud(int $idordenservicio, string $strFecha,int $intClienteId,string $strNombreEquipo,string $strModeloEquipo,string $strSerieEquipo,string $strDescripcionFalla,int $intTecnicoId,	string $strDescripcionDiagnostico,string $strDescripcionReparacion,int $intStatusId, float $intPresupuesto){

		$this->id_orden_servicio = $idordenservicio;
		$this->id_cliente = $intClienteId;
		$this->id_tecnico = $intTecnicoId;
		$this->fecha = $strFecha;
		$this->nombre_equipo = $strNombreEquipo;
		$this->modelo_equipo = $strModeloEquipo;
		$this->serie_equipo = $strSerieEquipo;
		$this->descripcion_falla = $strDescripcionFalla;	
		$this->descripcion_diagnostico = $strDescripcionDiagnostico;
		$this->descripcion_reparacion = $strDescripcionReparacion;
		$this->importe_presupuesto = $intPresupuesto;
		$this->status_servicio = $intStatusId;
		
			
		$sql = "UPDATE ordenes_servicio SET id_cliente=?, id_tecnico=?, fecha=?
				, nombre_equipo=?
				, modelo_equipo=?
				, serie_equipo=?
				, descripcion_falla=?
				, descripcion_diagnostico=?
				, descripcion_reparacion=?
				, importe_presupuesto=?
				, status_servicio=?
				WHERE id_orden_servicio = $this->id_orden_servicio ";
		$arrData = array($this->id_cliente,
						$this->id_tecnico,
						$this->fecha,
						$this->nombre_equipo,
						$this->modelo_equipo,
						$this->serie_equipo,
						$this->descripcion_falla,
						$this->descripcion_diagnostico,
						$this->descripcion_reparacion,
						$this->importe_presupuesto,
						$this->status_servicio);
		
		$request = $this->update($sql, $arrData);
		
		return $request;
	
	}

	public function selectClientes(){
		$sql = "SELECT id_cliente, nombre_cliente, celular, direccion FROM cat_clientes";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectTecnicos(){
		$sql = "SELECT id_usuario, nombre_usuario FROM cat_usuarios WHERE rol = 4 AND status = 'A'";
		$request = $this->select_all($sql);
		return $request;
	}

	public function deleteSolicitud(int $idordenservicio)
	{
		$this->id_orden_servicio = $idordenservicio;
		$sql = "DELETE FROM ordenes_servicio where id_orden_servicio = $this->id_orden_servicio";
		$request = $this->delete($sql);
		return $request;
	}	

	public function getReporteRecibidosEntregados(string $fechainicio,  string $fechafin){
		$sql = "SELECT  o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') AS CHAR) AS fecha, o.nombre_equipo, IFNULL(c.nombre_usuario, 'NO ASIGNADO') AS nombre_usuario,
		CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion
		FROM ordenes_servicio o
		LEFT JOIN cat_usuarios c ON c.id_usuario = o.id_tecnico
		WHERE o.fecha BETWEEN '$fechainicio' AND '$fechafin'
		ORDER BY o.fecha";

		$request = $this->select_all($sql);

		return $request;
	}

	public function getReporteRecibidosEntregadosGrafica(string $fechainicio,  string $fechafin){
		$sql = "SELECT CAST(DATE_FORMAT(fecha,'%d/%m/%Y') AS CHAR) AS fecha,COUNT(id_orden_servicio) AS cantidad,0 AS importe, 1 AS tipo FROM ordenes_servicio
		WHERE fecha BETWEEN '$fechainicio' AND '$fechafin' 
		GROUP BY fecha
		UNION ALL
		SELECT CAST(DATE_FORMAT(fecha_entrega,'%d/%m/%Y') AS CHAR) AS fecha,COUNT(id_orden_servicio) AS cantidad,SUM(CASE status_servicio WHEN 6 THEN importe_presupuesto ELSE 0 END) AS importe,2 AS tipo FROM ordenes_servicio
		WHERE fecha_entrega BETWEEN '$fechainicio' AND '$fechafin' 
		GROUP BY fecha_entrega";

		$request = $this->select_all($sql);

		return $request;

	}

	public function getReporteRecibidos(string $fechainicio,  string $fechafin){
		$sql = "SELECT  o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') AS CHAR) AS fecha, o.nombre_equipo, IFNULL(c.nombre_usuario, 'NO ASIGNADO') AS nombre_usuario,
		CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion
		FROM ordenes_servicio o
		LEFT JOIN cat_usuarios c ON c.id_usuario = o.id_tecnico
		WHERE o.fecha BETWEEN '$fechainicio' AND '$fechafin'
		ORDER BY o.fecha";

		$request = $this->select_all($sql);

		return $request;

	}

	public function getReporteEntregados(string $fechainicio,  string $fechafin){
		$sql = "SELECT  o.id_orden_servicio, CAST(DATE_FORMAT(o.fecha,'%d/%m/%Y') AS CHAR) AS fecha, o.nombre_equipo, IFNULL(c.nombre_cliente, o.nombre_cliente) AS nombre_cliente,
		CAST(DATE_FORMAT(o.fecha_entrega,'%d/%m/%Y') AS CHAR) AS fecha_entrega,
		CASE o.status_servicio WHEN 1 THEN 'RECIBIDO' WHEN 2 THEN 'EN REVISIÓN' WHEN 3 THEN 'COTIZADO' WHEN 4 THEN 'EN REPARACIÓN' WHEN 5 THEN 'REPARADO' WHEN 6 THEN 'ENTREGADO' WHEN 7 THEN 'DEVOLUCION' END AS status_servicio_descripcion
		FROM ordenes_servicio o
		LEFT JOIN cat_clientes c ON c.id_cliente = o.id_cliente
		WHERE o.fecha_entrega BETWEEN '$fechainicio' AND '$fechafin' AND o.status_servicio IN (6,7)
		ORDER BY o.fecha_entrega";

		$request = $this->select_all($sql);

		return $request;

	}


}


?>