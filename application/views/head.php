<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?=base_url("asset/js/dashboard.js")?>"></script>
    <script type="text/javascript" src="<?=base_url("asset/js/jquery3.min.js")?>"></script>
    <script type="text/javascript" src="<?=base_url("asset/js/qrcode.js")?>"></script>
    <style>
        .flex1{flex:1};
        .table{border-bottom-width:0px !important;}
        .tr{border-bottom-width:0px !important;}
        .td{border-bottom-width:0px !important;}
        .lds-roller { display: inline-block; position: relative; width: 80px; height: 80px;}
        .lds-roller div { animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite; transform-origin: 40px 40px;}
        .lds-roller div:after { content: " "; display: block; position: absolute; width: 7px; height: 7px; border-radius: 50%; background: gray; margin: -4px 0 0 -4px; }
        .lds-roller div:nth-child(1) { animation-delay: -0.036s; }
        .lds-roller div:nth-child(1):after { top: 63px; left: 63px; }
        .lds-roller div:nth-child(2) { animation-delay: -0.072s; }
        .lds-roller div:nth-child(2):after { top: 68px; left: 56px; }
        .lds-roller div:nth-child(3) { animation-delay: -0.108s; }
        .lds-roller div:nth-child(3):after { top: 71px; left: 48px; }
        .lds-roller div:nth-child(4) { animation-delay: -0.144s; }
        .lds-roller div:nth-child(4):after { top: 72px; left: 40px; } 
        .lds-roller div:nth-child(5) { animation-delay: -0.18s; }
        .lds-roller div:nth-child(5):after { top: 71px; left: 32px; }
        .lds-roller div:nth-child(6) { animation-delay: -0.216s; }
        .lds-roller div:nth-child(6):after { top: 68px; left: 24px; }
        .lds-roller div:nth-child(7) { animation-delay: -0.252s; }
        .lds-roller div:nth-child(7):after { top: 63px; left: 17px; }
        .lds-roller div:nth-child(8) { animation-delay: -0.288s; }
        .lds-roller div:nth-child(8):after { top: 56px; left: 12px; }
        @keyframes lds-roller {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
</head>