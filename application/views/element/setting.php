<h2>Setting</h2>

<div id="QRbox">
    <div class="d-inline-block rounded-4 shadow text-center p-3">
        <div id="QR" style="width:200px; height:200px; margin: auto;"></div>
        <input id="QRtxt" class="form-control my-2" value='{"branch_id":<?=$admin['branch']?>,"table":0}'>
        <button type="button" class="btn btn-primary" onclick="download($('QR','#QR img').prop('src'))">Download</button>
    </div>
</div>

<script type="text/javascript">
    var QRcount = 0;
    
	function download(name,source){
		const fileName = source.split('/').pop();
		var element = document.createElement("a");
		element.setAttribute("href", source);
		element.setAttribute("download", fileName);
		document.body.appendChild(element);
		element.click();
		element.remove();
	}

    $(document).ready(()=>{
        qrEl = new QRCode(document.querySelector('#QR'), {width: 200,height: 200});
        qrEl.makeCode($("#QRtxt").val());

        $("#QRtxt").keyup(()=>{
            qrEl.makeCode($("#QRtxt").val());
        });
    });
</script>