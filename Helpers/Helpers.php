<?php 
	
	function base_url()
	{
		return BASE_URL;
	}

	function media(){
		return BASE_URL."/Assets";
	}

	function headerAdmin($data=""){
		$view_header = "Views/Template/header_admin.php";
		require_once($view_header); 
	}

	function footerAdmin($data=""){
		$view_footer = "Views/Template/footer_admin.php";
		require_once($view_footer); 
	}

	function dep($data)
	{
		$format = print_r('<pre>');
		$format .= print_r($data);
		$format .= print_r('</pre>');
		return $format;
	}

	function getModal(string $nameModal, $data){
		$view_modal = "Views/Template/Modals/{$nameModal}.php";
		require_once($view_modal); 
	}

	function sessionUser(int $idpersona){
        require_once ("Models/LoginModel.php");
        $objLogin = new LoginModel();
        $request = $objLogin->sessionLogin($idpersona);
        return $request;
    }

	function strClean($strCadena){
		$string  = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
		$string = trim($string);
		$string = str_replace("<script>","",$string);
		$string = str_replace("</script>","",$string);
		$string = str_replace("<script src>","",$string);
		$string = str_replace("<script type=>","",$string);
		$string = str_replace("SELECT * FROM","",$string);
		$string = str_replace("DELETE FROM ","",$string);
		$string = str_replace("INSERT INTO","",$string);
		$string = str_replace("SELECT COUNT(*) FROM","",$string);
		$string = str_replace("DROP TABLE","",$string);
		$string = str_replace("OR '1'='1'","",$string);
		$string = str_replace('OR "1"="1"',"",$string);
		$string = str_replace('OR ´1´=´1´',"",$string);
		$string = str_replace("is NULL; --","",$string);
		$string = str_replace('is NULL; --',"",$string);
		$string = str_replace("LIKE '","",$string);
		$string = str_replace('LIKE "',"",$string);
		$string = str_replace('LIKE ´',"",$string);
		$string = str_replace("OR 'a'='a'","",$string);
		$string = str_replace('OR "a"="a"',"",$string);
		$string = str_replace('OR ´a´=´a´',"",$string);
		$string = str_replace("--","",$string);
		$string = str_replace("^","",$string);
		$string = str_replace("[","",$string);
		$string = str_replace("]","",$string);
		$string = str_replace("=","",$string);
		return $string;

	}

	function passGenerator($length = 10)
	{
		$pass = "";
		$longitudPass = $length;
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena=strlen($cadena);

		for($i=1;$i<=$longitudPass;$i++)
		{
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena, $pos,1);
		}
		return $pass;	
	}

	function token()
	{
		$r1 = bin2hex(random_bytes(10));
		$r2 = bin2hex(random_bytes(10));
		$r3 = bin2hex(random_bytes(10));
		$r4 = bin2hex(random_bytes(10));
		$token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
		return $token;
	}

	function formatMoney($cantidad)
	{
		$cantidad = number_format($cantidad, 2,SPD,SPM);
		return $cantidad;
	}

?>
