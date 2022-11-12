<h2>Booking</h2>
<p class="d-inline">Limit</p>
<select id="limit" class="form-select-sm">
    <option value=25>25</option>
    <option value=50>50</option>
    <option value=100>100</option>
    <option value=150>150</option>
    <option value=200>200</option>
</select>
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
    function bookUpdate(id,status){
        $.ajax({
            type: "POST",
            url: "<?=base_url("api/update/booking")?>",
            data: {
                "update_where":{"book_id":id},
                "update":{"status":status}
            },
            success: function(respone){
                if(respone['status']=="ok"){getTable();}
                else{getTable();}
            },
        });
    }
    function getTable(){
        $.get(
            "<?=base_url("api/read/booking?book_branch=".intval($admin['branch']))."&limit="?>"+$("#limit").val(), 
            function( data ) {
                // console.log(data);
                let result = data['result'];
                let table = "";
                // console.log(Object.keys(result[0]));
                table += "<thead><tr>";
                Object.keys(result[0]).forEach(function(head) {
                    // console.log(key, result[idx][key]);
                    table += "<th>"+(head=="book_id"?"#":head)+"</th>";
                });
                table += "</tr></thead>";

                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        // console.log(key, result[idx][key]);
                        if (key=="status"){
                            if (result[idx][key]=='accept'){
                                table += "<td class='bg-success bg-opacity-75 text-white'>"+result[idx][key]+"</td>";
                            }else if(result[idx][key]=='denied'){
                                table += "<td class='bg-danger bg-opacity-75 text-white'>"+result[idx][key]+"</td>";
                            }else if(result[idx][key]=='pending'){
                                table += "<td class='btn-group btn-group-sm'><button type='button' class='btn btn-success' onclick='bookUpdate("+result[idx]['book_id']+",\"accept\")'>Accept</button><button type='button' class='btn btn-danger' onclick='bookUpdate("+result[idx]['book_id']+",\"denied\")'>Denied</button></td>";
                            };
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
        $("#bookingTime").change(function(){console.log($("#bookingTime").val())})
        $("#limit").change(function(){getTable();})
        getTable();
    })
</script>