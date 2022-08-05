
let tableProductos;
let rowTable = "";

tableProductos = $('#tableProductos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Productos/getProductos",
        "dataSrc":""
    },
    "columns":[
        {"data":"id_producto"},
        {"data":"nombre_producto"},
        {"data":"codigo"},
        {"data":"descripcion"},      
        {"data":"nombre_categoria"},     
        {"data":"precio"},
         {"data":"precio_mayoreo"},
        {"data":"status_producto"},
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
    if(document.querySelector("#formProducto")){
        let formProductos = document.querySelector("#formProducto");
        formProductos.onsubmit = function(e) {
            e.preventDefault();

            let strNombre = document.querySelector('#txtNombre').value;
            let strCodigo = document.querySelector('#txtCodigo').value;
            let strDescripcion = document.querySelector('#txtDescripcionProducto').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let strPrecioMayoreo = document.querySelector('#txtPrecioMayoreo').value;
            let intCategoria = document.querySelector('#listCategoria').value;
            let strStatus = document.querySelector('#listStatus').value;
            
            if(strNombre == '' || strCodigo == '' || strPrecio == '' || strPrecioMayoreo == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
           
            divLoading.style.display = "flex";
            
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto'; 
            let formData = new FormData(formProductos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        if(rowTable == ""){
                            tableProductos.api().ajax.reload();
                        }else{
                           htmlStatus = strStatus == 'A' ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strCodigo;
                            rowTable.cells[3].textContent = strDescripcion;
                            rowTable.cells[4].textContent = document.querySelector("#listCategoria").selectedOptions[0].text;
                            rowTable.cells[5].textContent = strPrecio;
                            rowTable.cells[6].textContent = strPrecioMayoreo;
                            rowTable.cells[7].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                         $('#modalFormProducto').modal("hide");
                        formProductos.reset();
                        swal("Productos", objData.msg ,"success");
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    fntGetCategorias();
}, false);


function fntViewProducto(idProducto){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {
                let objProducto = objData.data;
                let estadoProducto = objProducto.status_producto == 'A' ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celNombre").innerHTML = objProducto.nombre_producto;
                document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;
                document.querySelector("#celPrecioMayoreo").innerHTML = objProducto.precio_mayoreo;
                document.querySelector("#celCategoria").innerHTML = objProducto.nombre_categoria;
                document.querySelector("#celEstado").innerHTML = estadoProducto;             
               
                $('#modalViewProducto').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}

function fntEditProducto(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.success)
            {
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.id_producto;
                document.querySelector("#txtNombre").value = objProducto.nombre_producto;
                document.querySelector("#txtDescripcionProducto").value = objProducto.descripcion;
                document.querySelector("#txtCodigo").value = objProducto.codigo;
                document.querySelector("#txtPrecio").value = objProducto.precio;
                document.querySelector("#txtPrecioMayoreo").value = objProducto.precio_mayoreo;
                document.querySelector("#listCategoria").value = objProducto.id_categoria;
                document.querySelector("#listStatus").value = objProducto.status_producto;
                 
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
                          
                $('#modalFormProducto').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelProducto(idProducto){
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
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
            let ajaxUrl = base_url+'/Productos/delProducto';
            let strData = "idProducto="+idProducto;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.success)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableProductos.api().ajax.reload();
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

function openModal()
{
    rowTable = "";
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProducto").reset();    
    $('#modalFormProducto').modal('show');

}