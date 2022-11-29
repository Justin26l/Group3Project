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

<button type="button" class="btn btn-sm btn-primary" onclick="getTable()">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
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

<script>

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
    }
    function getTable(){
        $("#table").hide();
        $("#table").show(250);
        let startdate = parseInt((new Date($("#date").val())).getTime() /1000);
        let enddate   = startdate+86400;
        let DateSQL   = "created_time>="+startdate+"&created_time<="+enddate;
        console.log(DateSQL);
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
                        if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(result[idx][key])+"</td>";
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
    }

    $(document).ready(function(){
        $("#date").val(dateNow());
        getTable();
        // console.log(timestamp_DateTime(Date.now()/1000))
    })
</script>