<h2>Menu</h2>

<div class="table-responsive">

    <p class="d-inline">Limit</p>
    <select id="limit" class="form-select-sm">
        <option value=25>25</option>
        <option value=50>50</option>
        <option value=100>100</option>
        <option value=150>150</option>
        <option value=200>200</option>
    </select>

    <button type="button" class="btn btn-sm btn-primary" onclick="getTable()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
        </svg>
    </button>

    <button type="button" class="btn btn-sm btn-primary" onclick="menu_create_init()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
        </svg>
    </button>

    <table id="table" class="table table-striped table-sm text-center mb-0 shadow">
        <thead>
            <tr>
                <th>#</th>
                <th>#</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <td>#</td>
                <td>#</td>
                <td>#</td>
            </tr>
        </tbody>
    </table>
</div>

<div id="menu_form" style="display:none">
    <h2 id="menu_form_title">Menu Edit</h2>
    
    <img id="imgpreview" style="height:200px;">
    
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_menu_id" disabled>
        <label for="ed_menu_id">id</label>
    </div>

    <form enctype="multipart/form-data" class="row mb-3 mx-1">
        <div class="col-5 border border-1 rounded-3">
            <input name="file" type="file" class="mt-1"/>
            <input type="button" id="button" value="Upload" class="mt-1"/>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="ed_img">
                <label for="ed_img">Menu Image</label>
            </div>
        </div>
    </form>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_category" autocomplete="off" list="catlist">
        <label for="ed_category">Category</label>
        <datalist id="catlist"></datalist>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="ed_prod_name">
        <label for="ed_prod_name">Product Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="ed_price">
        <label for="ed_price">Price</label>
    </div>
    <div class="form-floating mb-3">
        <textarea type="text" class="form-control" id="ed_description"></textarea>
        <label for="ed_description">Description</label>
    </div>
    <div class="text-end">
        <button id="menu_form_btn" type="button" class="btn btn-primary rounded-3 px-4" onclick="menuEdit()">Save</button>
    </div>
</div>

<script>

    function menu_create_init(){
        $("#table").hide();
        $("#menu_form").show(250);
        $("#menu_form_title").html("Create");
        $("#menu_form_btn").attr("onclick","menuCreate()")

        $("#imgpreview").val("");
        $("#ed_img").val("");
        $("#ed_menu_id").val("");
        $("#ed_category").val("");
        $("#ed_prod_name").val("");
        $("#ed_price").val("");
        $("#ed_description").val("");
    }

    function menu_edit_init(id,img,cat,nm,price,desc){
        $("#table").hide();
        $("#menu_form").show(250);
        $("#menu_form_title").html("Edit");
        $("#menu_form_btn").attr("onclick","menuEdit()")

        $("#imgpreview").attr('src','<?=base_url()?>'+img);
        $("#ed_img").val(img);
        $("#ed_menu_id").val(id);
        $("#ed_category").val(cat);
        $("#ed_prod_name").val(nm);
        $("#ed_price").val(price);
        $("#ed_description").val(desc);
    }
    
    // fetch
    function menuCreate(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/create/menu")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "create":{
                    "img":$("#ed_img").val(),
                    "category":$("#ed_category").val(),
                    "prod_name":$("#ed_prod_name").val(),
                    "price":$("#ed_price").val(),
                    "description":$("#ed_description").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){
                    getTable();
                }else{
                    alert(respone['error']);
                }
            },
        });
    }

    function menuEdit(id,arr){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/menu")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "update_where":{"menu_id":$("#ed_menu_id").val()},
                "update":{
                    "img" : $("#ed_img").val(),
                    "category" : $("#ed_category").val(),
                    "prod_name" : $("#ed_prod_name").val(),
                    "price" : $("#ed_price").val(),
                    "description" : $("#ed_description").val(),
                }
            }),
            success: function(respone){
                if(respone['status']=="ok"){
                    getTable();
                }else{
                    alert(respone['error']);
                }
            },
        });
    }

    function menuDelete(id){
        if( ! confirm("Confirm delete product "+id+" ?") ){ return; };
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/delete/menu")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "delete":{"menu_id":id}
            }),
            success: function(respone){
                if(respone['status']=="ok"){
                    getTable();
                }else{
                    alert(respone['error']);
                }
            },
        });
    }
    /** image upload */
    $(':file').on('change', function () {
        var file = this.files[0];
        if (file.size > 1024000) {
            alert('max upload size is 1 mb');
        };
        if (!(file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/png')) {
            alert('only supported jpg, jpeg, png file.');
        };
    });

    $('#button').on('click', function () {
        $.ajax({
            url: "<?=base_url("imgcatch/menu")?>",
            type: 'POST',
            data: new FormData($('form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            complete:(msg)=>{
                let response = JSON.parse(msg.responseText);
                alert(response.result);
                $("#imgpreview").attr('src',response.path);
                $("#ed_img").val(response.path);
            }
        });
    });

    function getTable(){
        $("#menu_form, #table").hide();
        $.get(
            url="<?=base_url("api/read/menu?limit=")?>"+$("#limit").val(),
            success = (data)=>{
                let result = data['result'];
                let table = "";
                
                let duplicate_cat = [];
                let catlist_html = "";

                // build table
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    if (head!="is_deleted"){
                        table += "<th>"+(head=="menu_id"?"#":head)+"</th>";
                    }
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    let id = result[idx]['menu_id'];

                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        if (key=="img"){
                            table += "<td><img width='100px' src='"+result[idx][key]+"'></td>";
                        } 
                        else if( key=="category" && !duplicate_cat.includes(result[idx][key]) ){
                            duplicate_cat.push(result[idx][key]);
                            catlist_html += '<option value="'+result[idx][key]+'">';
                            table += "<td>"+result[idx][key]+"</td>";
                        } 
                        else if (key!="is_deleted"){
                            table += "<td>"+result[idx][key]+"</td>";
                        };

                    });
                        
                    table+=`<td>
                        <div class='btn-group'>
                            <button class='btn btn-sm btn-primary' onclick=\"menu_edit_init('${id}','${result[idx]['img']}','${result[idx]['category']}','${result[idx]['prod_name']}','${result[idx]['price']}','${result[idx]['description']}')\">Edit</button>
                            <button class='btn btn-sm btn-danger' onclick='menuDelete(\"${id}\")'>Delete</button>
                        </div>
                    </td></tr>`;
                });
                console.log(catlist_html);
                // build table end

                table+="</tbody>";
                $("#catlist").html(catlist_html);
                $( "#table" ).html( table );
                $( "#table" ).show(250);
            }
        );
        $("#table").show(250);
    }

    $(document).ready(()=>{
        getTable();
        $("#imgpreview").attr("src",$("#ed_img").val());

        $("#ed_img").change(()=>{
            $("#imgpreview").attr("src",$("#ed_img").val());
        });
    })
</script>