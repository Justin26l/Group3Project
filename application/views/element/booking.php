<h2>Booking</h2>

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
        $("#table").html(loader);
        let sort      = $("#sortby").val();
        let startdate = parseInt((new Date($("#date").val())).getTime() /1000);
        let enddate   = startdate+86400;
        let Request   = "created_time>="+(startdate+tzoffset)+"&created_time<="+(enddate+tzoffset)+"&limit="+$("#limit").val()+"&order=created_time "+sort;

        $.ajax({
            url : "<?=base_url("api/read/booking?".($admin['superadmin']==0 ? "book_branch=".intval($admin['branch'])."&" : ""))?>"+Request, 
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
                    table += "<th>"+(head=="book_id"?"#":head)+"</th>";
                });
                table += "</tr></thead>";
                table+="<tbody class='table-group-divider'>";
                Object.keys(result).forEach(function(idx) {
                    // console.log(idx, result[idx]);
                    table+="<tr>";
                    Object.keys(result[idx]).forEach(function(key) {
                        let itm = result[idx][key];
                        if (key=="status"){
                            if(itm=='pending'){
                                table += "<td class='bg-warning'><div class='btn-group btn-group'><button type='button' class='btn btn-success' onclick='bookUpdate("+result[idx]['book_id']+",\"accept\")'>Accept</button><button type='button' class='btn btn-danger' onclick='bookUpdate("+result[idx]['book_id']+",\"denied\")'>Denied</button></div></td>";
                            }else if (itm=='accept'){
                                table += "<td class='bg-success bg-opacity-75 text-white'>"+itm+"</td>";
                            }else if(itm=='denied'){
                                table += "<td class='bg-danger bg-opacity-75 text-white'>"+itm+"</td>";
                            }else{
                                table += "<td>"+itm+"</td>";
                            };
                        }else if(key=="created_time"){
                            table += "<td>"+timestamp_DateTime(itm)+"</td>";
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
    }

    $(document).ready(function(){
        document.querySelector("#date").value = new Date(Date.now()-tzoffset* 1000).toISOString().slice(0, 10);
        getTable();
        $("#date, #limit, #sortby").change(()=>{getTable()});
    })
</script>