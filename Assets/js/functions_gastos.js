window.addEventListener('load', function(){
   fntGetSolicitudes();
    
}, false);

let tableGastos;
let rowTable = "";

tableGastos = $('#tableGastos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Gastos/getGastos",
        "dataSrc":""
    },
    "columns":[
        {"data":"id_gasto"},
        {"data":"fecha"},
        {"data":"concepto"},
        {"data":"importe"},     
        {"data":"tipo"},
        {"data":"orden_servicio"},
        {"data":"options"}
    ],
    "columnDefs": [
                    { 'className': "textcenter", "targets": [ 3 ] },
                    { 'className': "textright", "targets": [ 4 ] },
                    { 'className': "textcenter", "targets": [ 5 ] }
                  ],       
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        }
    ],
    "resonsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"desc"]]  
});

window.addEventListener('load', function() {
    if(document.querySelector("#formGasto")){
        let formGastos = document.querySelector("#formGasto");
        formGastos.onsubmit = function(e) {
            e.preventDefault();

            let strFecha = document.querySelector('#txtFecha').value;
            let strConcepto = document.querySelector('#txtConcepto').value;
            let strImporte = document.querySelector('#txtImporte').value;
            let intTipo = document.querySelector('#listTipo').value;
            let intOrdenServicio = document.querySelector('#listOrdenServicio').value;
            
            
            if(strFecha == '' || strConcepto == '' || strImporte == '' || (intTipo == 1 && intOrdenServicio =='') )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
           
            divLoading.style.display = "flex";
            
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Gastos/setGasto'; 
            let formData = new FormData(formGastos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        if(rowTable == ""){
                            tableGastos.api().ajax.reload();
                        }else{
                           htmlTipo = intTipo == 1 ? 
                            '<span class="badge badge-success">Ingreso</span>' : 
                            '<span class="badge badge-danger">Egreso</span>';
                            
                            rowTable.cells[1].textContent = strFecha;
                            rowTable.cells[2].textContent = strConcepto;
                            rowTable.cells[3].textContent = strImporte;
                            rowTable.cells[4].innerHTML =  htmlTipo;
                            rowTable = ""; 
                        }
                         $('#modalFormGasto').modal("hide");
                        formGastos.reset();
                        swal("Gastos", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    //fntGetSolicitudes();
}, false);


function fntViewGasto(idGasto){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Gastos/getGasto/'+idGasto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {
                let obj = objData.data;
                let tipoGasto = obj.tipo == 1 ? 
                '<span class="badge badge-success">Ingreso</span>' : 
                '<span class="badge badge-danger">Egreso</span>';

                document.querySelector("#celFecha").innerHTML = obj.fecha;
                document.querySelector("#celConcepto").innerHTML = obj.concepto;
                document.querySelector("#celImporte").innerHTML = obj.importe;
                document.querySelector("#celOrdenServicio").innerHTML = obj.id_orden_servicio;
                document.querySelector("#celTipo").innerHTML = tipoGasto;             
                
                $('#modalViewGasto').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}

function fntEditGasto(element,idGasto){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Ingreso/Gasto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
     document.querySelector("#formGasto").reset();    
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Gastos/getGasto/'+idGasto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {
                let obj = objData.data;
                document.querySelector("#idGasto").value = obj.id_gasto;
                document.querySelector("#txtFecha").value = obj.fecha;
                document.querySelector("#txtConcepto").value = obj.concepto;
                document.querySelector("#txtImporte").value = obj.importe;
                document.querySelector("#listOrdenServicio").value = obj.id_orden_servicio;
                document.querySelector("#listTipo").value = obj.tipo;
                $('#txtNombreCliente').text('');

                $('#listOrdenServicio').selectpicker('render');
                $('#listTipo').selectpicker('render');
                
                if(obj.tipo == 1) 
                    $('#listOrdenServicio').trigger('change');
                
                $('#listTipo').trigger('change');           
                




                $('#modalFormGasto').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelGasto(idGasto){
    swal({
        title: "Eliminar Ingreso/Gasto",
        text: "¿Realmente quiere eliminar el ingreso/gasto?",
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
            let ajaxUrl = base_url+'/Gastos/delGasto';
            let strData = "idGasto="+idGasto;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableGastos.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}



function fntGetCategorias(){
    if(document.querySelector('#listCategoria')){
        let ajaxUrl = base_url+'/Productos/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}

$('#listOrdenServicio').change(function() {
    var nombre = $('#listOrdenServicio option:selected').attr('data-nombre');
    var importe = $('#listOrdenServicio option:selected').attr('data-importe');
    var equipo = $('#listOrdenServicio option:selected').attr('data-equipo');
   
      $("#txtConcepto").val(equipo);
    $('#txtNombreCliente').text(nombre);
    $("#txtImporte").val(importe);
    
});

$('#listTipo').change(function() {
    var valor = $('#listTipo option:selected').attr('value');
    
    if(valor == 2){
        $('#divOrdenes').hide();
    }else{
        $('#divOrdenes').show();
    }   
   
    //$('#txtNombreCliente').text(nombre);
    //$("#txtImporte").val(importe);
});

function fntGetSolicitudes(){
    if(document.querySelector('#listOrdenServicio'))
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Gastos/getSelectOrdenes'; 
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
               document.querySelector('#listOrdenServicio').innerHTML = request.responseText;     
               $('#listOrdenServicio').selectpicker('render');
               //$('#listOrdenServicio').trigger('change'); 
            }
            
        }
    }
}  
  
function openModal()
{
    rowTable = "";
    document.querySelector('#idGasto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Ingreso/Gasto";
    document.querySelector("#formGasto").reset();    
    $('#modalFormGasto').modal('show');

    $("#txtFecha").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFecha').datepicker("setDate", new Date());
    
     $('#txtNombreCliente').text('');

      //fntGetSolicitudes();

    
}