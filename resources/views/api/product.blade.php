<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body class="py-5">
    <div class="container">
        <h1 class="text-center text-danger">Laravel Axios API</h1>

        {{-- Show Data --}}
        <div class="row py-5">
            <div class="col-md-8">
                <span id="successMsg"></span>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Description</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="proData">
                        {{--  --}}
                    </tbody>
                </table>
            </div>
            {{-- End Show Data  --}}

            {{-- Create Form --}}
            <div class="col-md-4 text-secondary">
                <form name="myForm" class="bg-dark">
                    <div class="form-group py-1">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" class="form-control"/>
                        <span id="nameError"></span>
                    </div>

                    <div class="form-group py-1">
                        <label for="">Price</label>
                        <input type="number" name="price" id="" class="form-control"/>
                        <span id="priceError"></span>
                    </div>

                    <div class="form-group py-1">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                        <span id="descriptionError"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Create Form  --}}

    <!-- Edit With Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="editForm">
                <div class="modal-body">
                    <div class="form-group py-1">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" class="form-control"/>
                        <span id="nameError"></span>
                    </div>

                    <div class="form-group py-1">
                        <label for="">Price</label>
                        <input type="number" name="price" id="" class="form-control"/>
                        <span id="priceError"></span>
                    </div>

                    <div class="form-group py-1">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                        <span id="descriptionError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    {{-- End Edit Form  --}}

    {{-- Script Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        var paingData = document.getElementById('proData');
        var nameList = document.getElementsByClassName('nameList');
        var priceList = document.getElementsByClassName('priceList');
        var descriptionList = document.getElementsByClassName('descriptionList');
        var idList = document.getElementsByClassName('idList');
        var btnList = document.getElementsByClassName('btnList');

        // ================= List ===========================
        axios.get('/api/product')
             .then(paing => {
                // console.log(paing)
                paing.data.forEach(item =>{
                    displayData(item);
                    // console.log(pro.name)
                    // proData.innerHTML +=
                    // '<tr>'+
                    //     '<td>'+pro.id+'</td>'+
                    //     '<td>'+pro.name+'</td>'+
                    //     '<td>'+pro.price+'</td>'+
                    //     '<td>'+pro.description+'</td>'+
                    //     '<td>'+
                    //         '<button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editPro('+pro.id+')">Edit</button>'+
                    //         '<button class="btn btn-sm btn-danger" type="button" onclick="deletePro('+pro.id+')">Delete</button>'+
                    //     '</td>'+
                    // '</tr>'
                })
             })
             .catch(error =>{
                // console.log(error.response.status)
                if(error.response.status == 404){
                    console.log('page not found');
                }
             });
        // End List

        // ============== Create Form =====================
        var myForm = document.forms['myForm'];
        var nameInput = myForm['name'];
        var priceInput = myForm['price'];
        var descriptionInput = myForm['description'];

        myForm.onsubmit = function(e){
            e.preventDefault();
            // console.log(priceInput.value)
            axios.post('/api/product',{
                name: nameInput.value,
                price: priceInput.value,
                description: descriptionInput.value,
            })
                 .then(response => {
                    var nameEr = document.getElementById('nameError');
                    var priceEr = document.getElementById('priceError');
                    var descriptionEr = document.getElementById('descriptionError');
                    // console.log(response.data)
                    if(response.data.msg == "created successfully"){
                            alertMsg(response.data.msg);
                        // document.getElementById('successMsg').innerHTML =
                        // '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        //     '<strong>'+response.data.msg+'</strong>'+
                        //     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                        // '</div>';
                        myForm.reset();
                        displayData(response.data.productCreate);
                        nameEr.innerHTML = priceEr.innerHTML = descriptionEr.innerHTML = '';
                        // proData.innerHTML +=
                        // '<tr>'+
                        //     '<td>'+response.data[0].id+'</td>'+
                        //     '<td>'+response.data[0].name+'</td>'+
                        //     '<td>'+response.data[0].price+'</td>'+
                        //     '<td>'+response.data[0].description+'</td>'+
                        //     '<td>'+
                        //         '<button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editPro('+response.data[0].id+')">Edit</button>'+
                        //         '<button class="btn btn-sm btn-danger" type="button" onclick="deletePro('+response.data[0].id+')">Delete</button>'+
                        //     '</td>'+
                        // '</tr>'
                    }else{
                        // console.log(response.data.msg.price)
                        // if(nameInput.value == ''){
                        //     nameEr.innerHTML = '<i class="text-danger">'+response.data.msg.name+'</i>'
                        // }else{
                        //     nameEr.innerHTML = '';
                        // }
                        nameEr.innerHTML = nameInput.value == '' ? '<i class="text-danger">'+response.data.msg.name+'</i>' : '';
                        // if(priceInput.value == ''){
                        //     priceEr.innerHTML = '<i class="text-danger">'+response.data.msg.price+'</i>'
                        // }else{
                        //     priceEr.innerHTML = '';
                        // }
                        priceEr.innerHTML = priceInput.value == '' ? '<i class="text-danger">'+response.data.msg.price+'</i>' : '';
                        // if(descriptionInput.value == ''){
                        //     descriptionEr.innerHTML = '<i class="text-danger">'+response.data.msg.description+'</i>'
                        // }else{
                        //     descriptionEr.innerHTML = '';
                        // }
                        descriptionEr.innerHTML = descriptionInput.value == '' ? '<i class="text-danger">'+response.data.msg.description+'</i>' : '';
                    }
                 })
                 .catch(error => {
                    //
                 });
        }
    // End Create Data

    // ==================== Eidt Data ===============================
    var editForm = document.forms['editForm'];
    var editNameInput = editForm['name'];
    var editPriceInput = editForm['price'];
    var editDescriptionInput = editForm['description'];
    var proIDUpdate, oldData;

    function editPro(proID){
        proIDUpdate = proID;
        axios.get('/api/product/'+proID)
             .then(response => {
                // console.log(response.data.name, response.data.price, response.data.description)
                editNameInput.value = oldData = response.data.name;
                editPriceInput.value = response.data.price;
                editDescriptionInput.value = response.data.description;
                // oldData = response.data.name;
             })
             .catch();
    }

    // ===================== Update Data =============================
    editForm.onsubmit = function(event){
        event.preventDefault();
        // console.log(proIDUpdate);
        axios.put('/api/product/'+proIDUpdate, {
            name: editNameInput.value,
            price: editPriceInput.value,
            description: editDescriptionInput.value,
        })
             .then(response => {
                // console.log(response.data.msg);
                    alertMsg(response.data.msg);
                    for(var i=0; i<nameList.length; i++){
                        if(nameList[i].innerHTML == oldData){
                            nameList[i].innerHTML = editNameInput.value;
                            priceList[i].innerHTML = editPriceInput.value;
                            descriptionList[i].innerHTML = editDescriptionInput.value;
                        }
                    }
                // document.getElementById('successMsg').innerHTML =
                // '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                //     '<strong>'+response.data.msg+'</strong>'+
                //     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                // '</div>';
             })
             .catch(error => {
                // console.log(error)
             });
    }

    // ====================== Delete Data =============================
    function deletePro(delPro){
       if(confirm('Are you sure to delete?')){
        axios.delete('api/product/'+delPro)
             .then(response => {
                    alertMsg(response.data.msg);
                    for(i=0; i<nameList.length; i++){
                        if(nameList[i].innerHTML == response.data.deletedProduct.name){
                            idList[i].style.display = 'none';
                            nameList[i].style.display = 'none';
                            priceList[i].style.display = 'none';
                            descriptionList[i].style.display = 'none';
                            btnList[i].style.display = 'none';
                        }
                    }
                    // console.log(response.data.deletedProduct);
                // document.getElementById('successMsg').innerHTML =
                // '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                //     '<strong>'+response.data.msg+'</strong>'+
                //     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                // '</div>';
             })
             .catch();
        }
       }

    // ====================== Helper Function =========================
    function displayData(data){
        proData.innerHTML +=
        '<tr>'+
            '<td class="idList">'+data.id+'</td>'+
            '<td class="nameList">'+data.name+'</td>'+
            '<td class="priceList">'+data.price+'</td>'+
            '<td class="descriptionList">'+data.description+'</td>'+
            '<td class="btnList">'+
                '<button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editPro('+data.id+')">Edit</button>'+
                '<button class="btn btn-sm btn-danger" type="button" onclick="deletePro('+data.id+')">Delete</button>'+
            '</td>'+
        '</tr>'
    }

    // ================= AlertMessage =======================
    function alertMsg(message){
        document.getElementById('successMsg').innerHTML =
        '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
            '<strong>'+message+'</strong>'+
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '</div>';
    }
    </script>
</body>
</html>
