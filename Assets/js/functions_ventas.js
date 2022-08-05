window.addEventListener('load', function(){
    fntGetClientes();
    fntGetProductos();
}, false);

let tableVentas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableVentas = $('#tableVentas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Ventas/getVentas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_venta"},
            {"data":"fecha"},
            {"data":"nombre_cliente"},
            {"data":"observaciones"},
            {"data":"total_venta"},
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
    
	const formDetalle = document.getElementById("formDetalle");
    const txtCantidad = document.getElementById("txtCantidad");    
    const listProducto = document.getElementById("listProducto");
    const txtPrecio = document.getElementById("txtPrecio");
    const txtSubtotal = document.getElementById("txtSubtotal");
    const tableDetalles = document.getElementById("tableDetalles");

    let arregloDetalle =[];

    const  redibujarTablaDetalles =  function(){
        tableDetalles.innerHTML = "";
        arregloDetalle.forEach((detalle) => {
            let fila = document.createElement("tr");
            fila.innerHTML = `<td>${detalle.cant}</td>
                               <td>${detalle.descripcion}</td>
                               <td>${detalle.precio}</td>
                               <td>${detalle.subtotal}</td>`;
            let tdEliminar = document.createElement("td");
            let botonEliminar = document.createElement("button");
            botonEliminar.classList.add("btn","btn-danger");
            botonEliminar.innerText = "Eliminar";
            tdEliminar.appendChild(botonEliminar);                                
            fila.appendChild(tdEliminar);
            tableDetalles.appendChild(fila);    
        });
    };



    formDetalle.onsubmit = function(e) {
        e.preventDefault();
        //Objeto detalle

        const objDetalle = {
            cant: txtCantidad.value,
            descripcion: listProducto.value,
            precio: txtPrecio.value,
            subtotal: txtSubtotal.value
        };

       arregloDetalle.push(objDetalle);
       redibujarTablaDetalles();       


    }
    

}, false);



function fntGetClientes(){
    if(document.querySelector('#listCliente'))
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Ventas/getSelectCliente'; 
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

function fntGetProductos(){
    if(document.querySelector('#listProducto'))
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Ventas/getSelectProducto'; 
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
               document.querySelector('#listProducto').innerHTML = request.responseText;     
               $('#listProducto').selectpicker('render'); 
            }
            
        }
    }
}

$('#listProducto').change(function() {
    var precio = $('#listProducto option:selected').attr('data-precio');
    $("#txtPrecio").val(precio);

     fntCalSub();
});

$('#txtCantidad').change(function() {
    fntCalSub();
});

$('#txtPrecio').change(function() {
    fntCalSub();
});

function fntCalSub(){
    let precio = document.querySelector('#txtPrecio').value; 
    let cant = document.querySelector('#txtCantidad').value;

    var subtotal = cant * precio;


    $("#txtSubtotal").val(subtotal);
}

function openModal()
{
    rowTable = "";
    //document.querySelector('#idVenta').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Venta";
    document.querySelector("#formVenta").reset();
    $('#modalFormVenta').modal('show');

    $("#txtFecha").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $('#txtFecha').datepicker("setDate", new Date());

     $("#txtCantidad").val(1);

   
}