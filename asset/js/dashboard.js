var loader = "<div class='lds-roller'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
function timestamp_DateTime(timestamp){
    var a = new Date(timestamp * 1000);
    var year = a.getFullYear();
    var month = a.getMonth()+1;
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = year + '-' + month + '-' + date + ' ' + hour + ':' + min + ':' + sec ;
    return time;
}

function Date_Timestamp(){
    var myDate = "26-02-2012";
    myDate = myDate.split("-");
    var newDate = new Date( myDate[2], myDate[1] - 1, myDate[0]);
    console.log(newDate.getTime());
}