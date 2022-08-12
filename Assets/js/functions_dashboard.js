let myChart;
let myChartIngreso;

let tableSolicitudesRecibidas;
let tableSolicitudesEntregadas;

let cargaAutomatica = true;

//fillMeses();
//fillYears();

var divLoading = document.querySelector("#divLoading");

window.addEventListener('load', function(){
    /*
    $("#txtFechaInicio").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFechaInicio').datepicker("setDate", new Date());

    $("#txtFechaFin").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFechaFin').datepicker("setDate", new Date());*/
}, false);



document.addEventListener('DOMContentLoaded', function(){
    $("#txtFechaInicio").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFechaInicio').datepicker("setDate", new Date());

    $("#txtFechaFin").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFechaFin').datepicker("setDate", new Date());

    if(document.querySelector("#formReporteGraficas")){
        let formReporteGraficas = document.querySelector("#formReporteGraficas");
        formReporteGraficas.onsubmit = function(e){
            e.preventDefault();            
            cargaAutomatica = false;
            obtenerGraficas();

        }
    }

    obtenerGraficas();
});

function getGraficas(){
    obtenerGraficas();
    //crearGraficaIngreso();
}

function obtenerGraficas(){
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let titulo = [];
    let cantidadRecibidos = [];
    let cantidadEntregados = [];
    let colores = [];
    let coloresRecibidos = [];
    let coloresEntregados = [];
    let importes = [];
    
    
    var ajaxUrl = base_url+'/Solicitudes/getReporteRecibidosEntregadosGrafica'; 
    var formData = new FormData(formReporteGraficas);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            let datos = objData.data;
            if(objData.success)
            {             

                
                for(var i = 0; i < datos.length; i++){
                   
                    if(datos[i].tipo == 1){
                        cantidadRecibidos.push(datos[i].cantidad);
                        coloresRecibidos.push(colorRGB(8));
                        titulo.push(datos[i].fecha);  
                    }else{
                        cantidadEntregados.push(datos[i].cantidad);
                        coloresEntregados.push(colorRGB(7));
                        importes.push(datos[i].importe);
                        colores.push(random_rgba());       
                    }                    
                    
                }
                /*        
                {
                    type: 'bar',
                    label: 'Dataset 1',
                    backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                    borderColor: Utils.CHART_COLORS.red,
                    data: Utils.numbers(NUMBER_CFG),
                  }
                */
                crearGrafica(titulo, cantidadRecibidos, cantidadEntregados, coloresRecibidos, coloresEntregados,'bar', 'myChart');

                crearGraficaIngreso(titulo, importes, colores, 'pie', 'Ingresos','myChartIngreso');

                getReporteRecibidos();
                getReporteEntregados();
                //window.location.reload(false);
            }else{
                if(!cargaAutomatica)
                    swal("Atención", objData.msg, "error");							
            }

            
        }else{
            if(!cargaAutomatica)
                swal("Atención","Error en el proceso", "error");
        }
        divLoading.style.display = "none";
        return false;
    }
}



function crearGrafica(labels, cantidadRecibidos, cantidadEntregados, coloresRecibidos, coloresEntregados, tipo,  id){
    let ctx = document.getElementById(id);
    
    if (myChart) {
        myChart.destroy();
    }
    
    myChart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: labels,
            datasets: [{
                label: 'Recibidos',
                data: cantidadRecibidos,
                backgroundColor: coloresRecibidos,
                borderColor: coloresRecibidos,
                borderWidth: 1
                
                
            },
            {
                label: 'Entregados',
                data: cantidadEntregados,
                backgroundColor: coloresEntregados,
                borderColor: coloresEntregados,
                borderWidth: 1
                
                
            }    
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

}

function crearGraficaIngreso(titulo, cantidad, colores,  tipo, encabezado, id){
    let ctx = document.getElementById(id);
    
    if (myChartIngreso) {
        myChartIngreso.destroy();
    }
    
    myChartIngreso = new Chart(ctx, {
        type: tipo,
        data: {
            labels: titulo,
            datasets: [{
                label: encabezado,
                data: cantidad,
                backgroundColor: colores,
                borderColor: colores,
                borderWidth: 1
                
                
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

}

function generarNumero(numero){
    return (Math.random()*numero).toFixed(0);
}

function colorRGB(opcion){
    let color = [
        "0,255,255",
        "0,0,128",
        "255,255,0",
        "255,128,128",
        "153,204,0",
        "0,51,0",
        "255,0,0",
        "128,128,128",
        "51,102,255",
        "255,0,255",
        "255,153,0",
        "0,0,255"];
    
    return "rgb(" + color[opcion] + ")";
}

function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}

function fillYears()
{
    let fechaActual = new Date();
    let year = fechaActual.getFullYear();
    var cadena = "";

    for(var i = year - 10; i < year + 1; i++)
    {
        cadena += "<option value=" + i + ">" + i + "</option>";
    }

    $("#select_anio").html(cadena);
    $("#select_anio").val(year);
}

function fillMeses(){
    const meses = ['Todos','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    var cadena = "";

    for(var i = 0; i < meses.length; i++)
    {
        cadena += "<option value=" + i + ">" +  meses[i] + "</option>";
    }

    $("#select_mes").html(cadena);

}

function getReporteRecibidos(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let arrUsuarios = [];
            var ajaxUrl = base_url + '/Solicitudes/getReporteRecibidos';
            var formData = new FormData(formReporteGraficas);
            request.open("POST", ajaxUrl, true);  
            request.send(formData);
            
            request.onreadystatechange = function(){        
                if(request.readyState != 4) return;
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    let datos = objData.data;
                    
                    //swal("Atención", objData.msg, "error");
                    if(objData.success)
                    {
                        fillTableRecibidos(datos);


                    }else{
         
                        //swal("Atención", objData.msg, "error");
            
                    }
                }else{
                    //swal("Atención","Error en el proceso", "error");
                }
                //divLoading.style.display = "none";
                return false;
            }
}

function fillTableRecibidos(datos){
   

    
    tableSolicitudesRecibidas = $('#tableSolicitudesRecibidas').dataTable({
        
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "data": datos,
        "columns":[         
            {"data":"id_orden_servicio"},   
            {"data":"fecha"},
            {"data":"nombre_equipo"},
            {"data":"nombre_usuario"},
            {"data":"status_servicio_descripcion"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10
    });
}

function getReporteEntregados(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let arrUsuarios = [];
            var ajaxUrl = base_url + '/Solicitudes/getReporteEntregados';
            var formData = new FormData(formReporteGraficas);
            request.open("POST", ajaxUrl, true);  
            request.send(formData);
            
            request.onreadystatechange = function(){        
                if(request.readyState != 4) return;
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    let datos = objData.data;
                    
                    //swal("Atención", objData.msg, "error");
                    if(objData.success)
                    {
                        fillTableEntregados(datos);


                    }else{
         
                        //swal("Atención", objData.msg, "error");
            
                    }
                }else{
                    //swal("Atención","Error en el proceso", "error");
                }
                //divLoading.style.display = "none";
                return false;
            }
}

function fillTableEntregados(datos){
   

    
    tableSolicitudesEntregadas = $('#tableSolicitudesEntregadas').dataTable({
        
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "data": datos,
        "columns":[         
            {"data":"id_orden_servicio"},   
            {"data":"fecha"},
            {"data":"nombre_equipo"},
            {"data":"nombre_cliente"},
            {"data":"fecha_entrega"},
            {"data":"status_servicio_descripcion"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10
    });
}

