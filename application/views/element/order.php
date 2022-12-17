<h2>Order</h2>

<p class="d-inline">Date</p>
<input id="date" type="date" value="">

<p class="ms-4 d-inline">Filter</p>
<select id="limit" class="form-select-sm">
    <option value=100 selected>100 row</option>
    <option value=250>250 row</option>
    <option value=500>500 row</option>
    <option value=750>750 row</option>
    <option value=1000>1000 row</option>
    <option value=1000>2000 row</option>
</select>

<select id="sortby" class="form-select-sm">
    <option value="DESC">Newest Order</option>
    <option value="ASC">Oldest Order</option>
</select>

<button type="button" class="btn btn-sm btn-primary" onclick="getTable()()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
    </svg>
</button>

<button type="button" class="btn btn-sm btn-primary" onclick="create_order_init()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
    </svg>
</button>

<div class="table-responsive shadow">
    <table id="table" class="table table-striped table-sm text-center mb-0">
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

<div id="new_order" class="rounded-3 shadow mt-4 p-2" style="display:none;">
    <h2>Create Order</h2>
    <div class="my-4">
        <h5 class="text-secondary">Branch : <?=$admin['branch']?></h5>
        <br>

        <div class="btn-group" role="group">
            <button id="dine" type="button" class="btn btn-lg border border-2 btn-primary" onclick="setDine('dine')" >Dine In</button>
            <button id="deli" type="button" class="btn btn-lg border border-2" onclick="setDeli('deli')" >Take Away</button>
        </div>
        <br><br>

        <div id="deliInfo" style="display:none;">
            <label for="address" class="form-label">Time</label>
            <input type="datetime-local" id="address" class="form-control">

            <label for="recive" class="form-label">Name</label>
            <input id="recive"  class="form-control">
        </div>
        
        <div id="dineInfo"  style="display:block;" >
            <label for="table_no" class="form-label">Table</label>
            <input id="table_no" class="form-control">
        </div>

        <label for="comment" class="form-label">Comment</label>
        <input id="comment" class="form-control">
        <br>

        <div id="OrderMenu">
            <div id="MenuCat" class="row"></div>
            <div id="MenuItem" class="py-4"></div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" onclick="buildRecipt()">Confirm</button>
            </div>
            <br>
        </div>

    </div>
</div>

<div id="receipt" class="rounded-3 shadow mt-4 p-2" style="display:none;" >
</div>

<script>

    function hideAll_order() {
        $("#table,#new_order,#receipt").hide();
    };

    function orderUpdate(id,status){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/order")?>",
            data: {
                "update_where":{"order_id":id},
                "update":{
                    "status":"closed",
                    "paid":status
                }
            },
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    };

    function orderCreate(){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/create/order")?>",
            contentType : "application/json",
            data: JSON.stringify({
                "create": order
            }),
            success: function(respone){
                if(respone['status']=="ok"){
                    getTable();
                }
                else{
                    alert(respone['error']);
                }
            },
        });
    }


    // table //

    function getTable(){
        hideAll_order();
        $("#table").show().html(loader);
        let sort      = $("#sortby").val();
        let startdate = parseInt((new Date($("#date").val())).getTime() /1000);
        let enddate   = startdate+86400;
        let Request   = "created_time>="+(startdate+tzoffset)+"&created_time<="+(enddate+tzoffset)+"&limit="+$("#limit").val()+"&order=created_time "+sort;

        $.ajax({
            url : "<?= base_url("api/read/order?".($admin['superadmin']!=1 ? "order_branch=".intval($admin['branch'])."&" : ""))?>"+Request, 
            success : ( data )=>{
                let result = data['result'];
                let table = "";

                if(result.length == 0){
                    $( "#table" ).html( "<h1>No Data Found !<h1/>" );
                    return;
                }

                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    table += "<th>"+(head=="order_id"?"#":head)+"</th>";
                });
                table += "</tr></thead>";
                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        let itm = result[idx][key];
                        if(key=="paid"){
                            if(itm=='pending'){
                                table += "<td class='bg-warning'><b>"+itm+"</b><br><div class='btn-group btn-group'><button type='button' class='btn btn-success' onclick='orderUpdate("+result[idx]['order_id']+",\"cash\")'>CASH</button><button type='button' class='btn btn-primary' onclick='orderUpdate("+result[idx]['order_id']+",\"stripe\")'>Stripe</button><button type='button' class='btn btn-danger' onclick='orderUpdate("+result[idx]['order_id']+",\"denied\")'>Denied</button></div></td>";
                            }else if(itm.includes('->pending')){
                                table += "<td class='bg-primary bg-opacity-75 text-white'><b>"+itm+"</b><br><div class='btn-group btn-group'><button type='button' class='btn btn-success' onclick='orderUpdate("+result[idx]['order_id']+",\""+itm.replace('->pending','')+"\")'>Accept</button><button type='button' class='btn btn-danger' onclick='orderUpdate("+result[idx]['order_id']+",\"denied\")'>Denied</button></div></td>";
                            }else if (itm=='denied'){
                                table += "<td class='bg-danger bg-opacity-75 text-white'>"+itm+"</td>";
                            }else{
                                table += "<td>"+itm+"</td>";
                            };
                        }else if (key=="status"){
                            if(itm=='pending'){
                                table += "<td class='bg-warning bg-opacity-75 text-white'>"+itm+"</td>";
                            }else{
                                table += "<td>"+itm+"</td>";
                            };
                        }else if(key=="items"){
                            xyz = "";
                            zz = JSON.parse(itm);
                            zz.forEach((y)=>{ xyz+="("+y.i +") "+ y.n +" @"+ y.p +" x"+ y.q +" = [ "+ y.s+" ]</br>" });
                            table += "<td>"+ xyz +"</td>";
                        }else if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(itm)+"</td>";
                        }else if(key=="is_dine"){
                            table += "<td>"+( itm==1 ? "YES" : "NO")+"</td>";
                        }else{
                            table += "<td>"+itm+"</td>";
                        }
                    });
                    table+="</tr>";
                });
                table+="</tbody>";
                $( "#table" ).html( table );
            },
            error : ()=>{
                $( "#table" ).html( "Request Error !" );
            }
        });
    };

    // new order //
    var order    = {};
    var menuList = {};
    var cart     = {};

    function create_order_init(){
        hideAll_order();
        getMenu();
        order = {
            is_dine : 1,
            address : null,
            order_by: null,
            items   : [],
            total   : 0,
        };
    }

    function setDine(x){
        $('#'+x).addClass('btn-primary');
        $('#deli').removeClass('btn-warning');
        $('#deliInfo').hide('fast');
        $('#dineInfo').show('fast');
        order.is_dine = 1;
        order.address = null;
        order.order_by= null;
    }

    function setDeli(x){
        $('#'+x).addClass('btn-warning');
        $('#dine').removeClass('btn-primary');
        $('#dineInfo').hide('fast');
        $('#deliInfo').show('fast');
        order.is_dine = 0;
    }

    function cart_minus(jar){
        if(cart[jar]==undefined){
            $("#m_"+jar).val(0);
        }else if(cart[jar]>1){
            cart[jar]-=1;
            $("#m_"+jar).val(cart[jar]);
        }else if(cart[jar]==1){
            delete cart[jar];
            $("#m_"+jar).hide("fast");
            $("#m_"+jar).val("");
        };
    }

    function cart_plus(jar){
        if(cart[jar]==undefined){
            cart[jar]=1;
            $("#m_"+jar).val(cart[jar]);
            $("#m_"+jar).show("fast");
        }else{
            cart[jar]+=1;
            $("#m_"+jar).val(cart[jar]);
        }
    }

    function getMenu(){
        hideAll_order();
        $("#MenuItem, #MenuCat").html("");
        menuList = {};
        cart = {};
        $.get(
            "<?=base_url("api/read/menu")?>",
            (data)=>{
                let result = data['result'];
                let MenuCat ="";

                result.forEach(function(xx) {
                    menuList[xx['menu_id']] = xx;
                    let itemBox = '<div id="'+xx['category']+'" class="row itembox" style="display:none;"></div>';
                    let item = '<div class="col-lg-3 col-md-4 col-6 py-1"><div class="text-center rounded-4 shadow"><img class="img-fluid rounded-4" onclick="cart_plus('+xx['menu_id']+')" src="'+xx['img']+'"><h4>'+xx['prod_name']+' ('+xx['menu_id']+')</h4><div class="d-flex"><p class="flex1 ps-2 pt-2 text-start">$ '+xx['price']+'</p><div class="flex1 btn-group p-2"><button class="btn btn-sm btn-primary fw-bold" onclick="cart_minus('+xx['menu_id']+')">-</button><input id="m_'+xx['menu_id']+'" style="width:30%;display:none;"></input><button class="btn btn-sm btn-primary fw-bold" onclick="cart_plus('+xx['menu_id']+')">+</button></div></div></div></div>';

                    if(document.querySelector("#"+xx['category']) == null ){
                        MenuCat+='<div class="col-lg-3 col-md-4 col-6"><div class="rounded-2 text-center py-2 bg-black text-white" onclick="$(\'.itembox\').hide();$(\'#'+xx['category']+'\').show();"><h3>'+xx['category']+'</h3></div></div>';
                        $("#MenuItem").append(itemBox);
                        $("#"+xx['category']).append(item);
                        // console.log("New "+xx['category'])
                    }else{
                        $("#"+xx['category']).append(item);
                        // console.log("Exist "+xx['category'])
                    };
                });
                $("#MenuCat").html(MenuCat);
            }
        );
        $("#new_order").show("fast");
        // console.log(menuList);
    };

    function buildRecipt(){
        hideAll_order();
        let rcp = $("#receipt");
        rcp.html("");

        let reciept=[];
        let recieptView="";
        order.items = [];
        order.total = 0;
        order.order_by= $("#table_no").val();

        Object.keys(cart).forEach((key)=>{
            let val = cart[key];
            order.items.push({
                "i":parseInt(key),
                "n":menuList[key]['prod_name'],
                "p":parseFloat(menuList[key]['price']),
                "q":val,
                "s":parseFloat((menuList[key]['price']*val).toFixed(2)),
            });
        });

        // build receipt
        recieptView += '<table class="w-100 text-center">';
        order.items.forEach((yy)=>{
            order.total += yy.s;
            recieptView += '<tr class="py-4"><td>('+yy.i+')</td><td class="px-2">'+yy.n+'</td><td class="px-2">'+yy.p+'</td><td class="px-2">x'+yy.q+'</td><td class="px-2">'+yy.s+'</td></tr>';
        })
        order.total = parseFloat(order.total.toFixed(2));
        recieptView += '<tr class="py-3 text-end"><td colspan="100%"><span>total : </span><h1 class="d-inline">'+order.total+'</h1></td></tr></table> <div class="d-grid gap-2 col-6 mx-auto"><button class="btn btn-primary" onclick="orderCreate()">Create Order</button></div>';
        
        // output
        // console.log(order.items);
        rcp.html(recieptView);
        rcp.show("fast");
    }

    $(document).ready(function(){
        let isoNow = new Date(Date.now()-tzoffset* 1000).toISOString();
        console.log(isoNow)
        document.querySelector("#date").value = isoNow.slice(0, 10);
        document.querySelector("#address").min = isoNow.slice(0, 19);

        getTable();
        $("#date, #limit, #sortby").change(()=>{getTable()});
    })
</script>