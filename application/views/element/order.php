<h2>Order</h2>
<p class="d-inline">Date</p>

<input id="date" type="date" value="">

<p class="ms-4 d-inline">Limit</p>
<select id="limit" class="form-select-sm">
    <option value=100 selected>100</option>
    <option value=250>250</option>
    <option value=500>500</option>
    <option value=750>750</option>
    <option value=1000>1000</option>
    <option value=1000>2000</option>
</select>

<button type="button" class="btn btn-sm btn-primary" onclick="get_table_init()">
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
    <div class="">
        <h5 class="text-secondary">Branch : <?=$admin['branch']?></h5>
        <br>

        <div class="btn-group" role="group">
            <button id="dine" type="button" class="btn btn-lg border border-2 btn-primary" onclick="$(this).addClass('btn-primary');$('#deli').removeClass('btn-warning');$('#deliInfo').hide('fast');" >Dine In</button>
            <button id="deli" type="button" class="btn btn-lg border border-2" onclick="$(this).addClass('btn-warning');$('#dine').removeClass('btn-primary');$('#deliInfo').show('fast');" >Deliver</button>
        </div>
        <br><br>

        <div id="OrderMenu">
            <div id="MenuCat" class="row"></div>
            <div id="MenuItem" class="py-4"></div>
        </div>

        <div id="deliInfo" style="display:none;">
            <label for="address" class="form-label">Address</label>
            <input id="address"  class="form-control">

            <label for="recive" class="form-label">Reciver Name</label>
            <input id="recive"  class="form-control">
        </div>
        
        <label for="comment" class="form-label">Comment</label>
        <textarea id="comment"  class="form-control"></textarea>

    </div>
</div>

<div id="receipt" class="rounded-3 shadow mt-4 p-2" >
style="display:none;"
</div>

<script>

    // table //
    function get_table_init(){
        getTable();
        $("#new_order").hide();
    }
    function orderUpdate(id,status){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/order")?>",
            data: {
                "update_where":{"order_id":id},
                "update":{"status":status}
            },
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    };

    function getTable(){
        $("#table").hide();
        let startdate = parseInt((new Date($("#date").val())).getTime() /1000);
        let enddate   = startdate+86400;
        let DateSQL   = "created_time>="+startdate+"&created_time<="+enddate;
        // console.log(DateSQL);
        $.get(
            "<?= base_url("api/read/order?".($admin['superadmin']!=1 ? "order_branch=".intval($admin['branch'])."&" : ""))?>"+DateSQL, 
            function( data ) {
                // console.log(data);
                let result = data['result'];
                let table = "";
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
                        if(result[idx][key]==null){
                            result[idx][key]="-";
                        };

                        if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
                        }else if(key=="deliver"){
                            table += "<td>"+( result[idx][key]==1 ? "YES" : "NO")+"</td>";
                        }else{
                            table += "<td>"+result[idx][key]+"</td>";
                        }
                    });
                    table+="</tr>";
                });
                table+="</tbody>";
                $( "#table" ).html( table );
            }
        );
        $("#table").show(250);
    };

    // new order //

    var menuList = {};
    var cart = {};

    function create_order_init(){
        $("#table").hide();
        getMenu()
    }

    function cart_minus(jar){
        if(cart[jar]==undefined){
            // console.log("nothing in cart to remove");
        }else if(cart[jar]>1){
            cart[jar]-=1;
        }else if(cart[jar]==1){
            delete cart[jar];
        };
    }

    function cart_plus(jar){
        if(cart[jar]==undefined){
            cart[jar]=1;
        }else{
            cart[jar]+=1;
        }
    }

    function getMenu(){
        $("#new_order").hide();
        $("#MenuItem, #MenuCat").html("");
        $.get(
            "<?=base_url("api/read/menu")?>",
            (data)=>{
                let result = data['result'];
                let MenuCat ="";
                menuList = {};
                result.forEach(function(xx) {
                    menuList[xx['menu_id']] = xx;
                    let itemBox = '<div id="'+xx['category']+'" class="row itembox" style="display:none;"></div>';
                    let item = '<div class="col-3"><div class="text-center rounded-4 shadow"><img class="img-fluid rounded-4" src="'+xx['img']+'"><h4>'+xx['prod_name']+' ('+xx['menu_id']+')</h4><div class="d-flex"><p class="flex1 ps-2 pt-2 text-start">$ '+xx['price']+'</p><div class="flex1 btn-group p-2"><button class="btn btn-sm btn-primary fw-bold" onclick="cart_minus('+xx['menu_id']+')">-</button><button class="btn btn-sm btn-primary fw-bold" onclick="cart_plus('+xx['menu_id']+')">+</button></div></div></div></div>';

                    if(document.querySelector("#"+xx['category']) == null ){
                        MenuCat+='<div class="col-3"><div class="rounded-2 text-center py-2 bg-black text-white" onclick="$(\'.itembox\').hide();$(\'#'+xx['category']+'\').show();"><h3>'+xx['category']+'</h3></div></div>';
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
        console.log(menuList);
    };

    function buildRecipt(){
        let rcp = $("#receipt");
        rcp.hide();

        let reciept=[];
        let recieptView="";
        let reciptPrice=0;

        Object.keys(cart).forEach((key)=>{
            let val = cart[key];
            reciept.push({
                "i":parseInt(key),
                "n":menuList[key]['prod_name'],
                "p":parseFloat(menuList[key]['price']),
                "q":val,
                "s":parseFloat((menuList[key]['price']*val).toFixed(2)),
            });
        });

        // build receipt
        recieptView += '<table class="w-100 text-center">';
        reciept.forEach((yy)=>{
            reciptPrice += yy.s;
            recieptView += '<tr class="py-4"><td>('+yy.i+')</td><td class="px-2">'+yy.n+'</td><td class="px-2">'+yy.p+'</td><td class="px-2">x'+yy.q+'</td><td class="px-2">'+yy.s+'</td></tr>';
        })
        reciptPrice = reciptPrice.toFixed(2);
        recieptView += '<tr class="py-3 text-end"><td colspan="100%"><span>total : </span><h1 class="d-inline">'+reciptPrice+'</h1></td></tr></table>';

        // output
        console.log(reciept);
        rcp.html(recieptView);
        rcp.show("fast");
    }

    $(document).ready(function(){
        $("#date").val(dateNow());
        getTable();

    })
</script>