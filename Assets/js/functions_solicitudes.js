window.addEventListener('load', function(){
    fntGetClientes();
    fntGetTecnicos();
}, false);


let tableSolicitudes; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableSolicitudes = $('#tableSolicitudes').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Solicitudes/getSolicitudes",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_orden_servicio"},
            {"data":"fecha"},
            {"data":"nombre_cliente"},
            {"data":"descripcion_falla"},
            {"data":"nombre_tecnico"},
            {"data":"status_servicio"},
            {"data":"options"}
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
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });
    
	if(document.querySelector("#formSolicitud")){
        let formSolicitud = document.querySelector("#formSolicitud");
        formSolicitud.onsubmit = function(e) {
            e.preventDefault();

            let strFecha = document.querySelector('#txtFecha').value;
            let strNombreEquipo = document.querySelector('#txtNombreEquipo').value;
            let strDescripcionFalla = document.querySelector('#txtDescripcionFalla').value;
            
            

            if(strFecha == '' || strNombreEquipo == '' || strDescripcionFalla == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Solicitudes/setSolicitud'; 
            let formData = new FormData(formSolicitud);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        
                        tableSolicitudes.api().ajax.reload();
                        
                        $('#modalFormSolicitud').modal("hide");
                        formSolicitud.reset();
                        swal("Solicitudes", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    

}, false);

function fntGetClientes(){
    if(document.querySelector('#listCliente'))
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Solicitudes/getSelectCliente'; 
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
               document.querySelector('#listCliente').innerHTML = request.responseText;     
               $('#listCliente').selectpicker('render'); 
            }
            
        }
    }
}

function fntGetTecnicos(){
    if(document.querySelector('#listTecnico'))
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Solicitudes/getSelectTecnico'; 
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
               document.querySelector('#listTecnico').innerHTML = request.responseText;     
               $('#listTecnico').selectpicker('render'); 
            }
            
        }
    }
}

function fntViewSolicitud(idordenservicio){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Solicitudes/getSolicitud/'+idordenservicio;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {           
               

                document.querySelector("#celFecha").innerHTML = objData.data.fecha;
                document.querySelector("#celNombreCliente").innerHTML = objData.data.nombre_cliente;
                document.querySelector("#celCelular").innerHTML = objData.data.celular;
                document.querySelector("#celNombreEquipo").innerHTML = objData.data.nombre_equipo;
                document.querySelector("#celModeloEquipo").innerHTML = objData.data.modelo_equipo;
                document.querySelector("#celSerieEquipo").innerHTML = objData.data.serie_equipo;
                document.querySelector("#celDescripcionFalla").innerHTML = objData.data.descripcion_falla;
                document.querySelector("#celNombreTecnico").innerHTML = objData.data.nombre_tecnico;
                document.querySelector("#celModeloEquipo").innerHTML = objData.data.modelo_equipo;
                document.querySelector("#celDescripcionDiagnostico").innerHTML = objData.data.descripcion_diagnostico;
                document.querySelector("#celDescripcionReparacion").innerHTML = objData.data.descripcion_reparacion;
                document.querySelector("#celImportePresupuesto").innerHTML = objData.data.importe_presupuesto;
                document.querySelector("#celEstatus").innerHTML = objData.data.status_servicio;

                $('#modalViewSolicitud').modal('show');
                 //document.querySelector('#contentAjax').innerHTML = request.responseText;
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditSolicitud(element, idordenservicio){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Orden Servicio";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Solicitudes/getSolicitud/'+idordenservicio;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {
                document.querySelector("#idOrdenServicio").value = objData.data.id_orden_servicio;
                document.querySelector("#txtFolio").value = objData.data.id_orden_servicio;
                document.querySelector("#txtFecha").value = objData.data.fecha;
                document.querySelector("#listCliente").value = objData.data.id_cliente;
                document.querySelector("#txtCelular").value = objData.data.celular;
                document.querySelector("#txtNombreEquipo").value = objData.data.nombre_equipo;
                document.querySelector("#txtModeloEquipo").value = objData.data.modelo_equipo;
                document.querySelector("#txtSerieEquipo").value = objData.data.serie_equipo;
                document.querySelector("#txtDescripcionFalla").value = objData.data.descripcion_falla;
                document.querySelector("#listTecnico").value = objData.data.id_tecnico;
                document.querySelector("#txtDescripcionDiagnostico").value = objData.data.descripcion_diagnostico;
                document.querySelector("#txtDescripcionReparacion").value = objData.data.descripcion_reparacion;
                document.querySelector("#txtPresupuesto").value = objData.data.importe_presupuesto;
                document.querySelector("#listStatus").value = objData.data.status_servicio;
                $('#listCliente').selectpicker('render');
                $('#listTecnico').selectpicker('render');
                $('#listStatus').selectpicker('render');      
            }
        }
        $('#modalFormSolicitud').modal('show');
    }
}

function fntDelSolicitud(idordenservicio){
    swal({
        title: "Eliminar Solicitud",
        text: "¿Realmente quiere eliminar la Solicitud?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Solicitudes/delSolicitud';
            let strData = "idOrdenServicio="+idordenservicio;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableSolicitudes.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}



$('#listCliente').change(function() {
    var cel = $('#listCliente option:selected').attr('data-celular');
    $("#txtCelular").val(cel);
});

function openModal()
{
    rowTable = "";
    document.querySelector('#idOrdenServicio').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Solicitud";
    document.querySelector("#formSolicitud").reset();
    $('#modalFormSolicitud').modal('show');

    $("#txtFecha").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFecha').datepicker("setDate", new Date());
}