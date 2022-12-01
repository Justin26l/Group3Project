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

function dateNow(){
    let a = new Date();
    let year = a.getFullYear();
    let month = a.getMonth()+1;
    let date = a.getDate();
    let time = month + '/' + date+ '/' +year;
    return time;
}