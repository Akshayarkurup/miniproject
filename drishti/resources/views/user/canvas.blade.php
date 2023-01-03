<x-app-layout>
	<x-slot:head>
		Detect Color
	</x-slot:head>

	<div class="container m-3">
		<h6 class="m-3" id="result"></h6>
		<h3 class="mt-3">Canvas</h3>
		<img src="{{ asset('storage/'.$img->img) }}" id="hiddenImg" hidden>
		<div class="output p-2" style="z-index: 99;position:fixed;">
			<button class="btn btn-secondary m-2" type="button" title="Load Image" onClick="DrawCanvas();">Load Image</button>
			<button class="btn btn-secondary m-2" type="button" title="Zoom out" onClick="ZoomOut()">Zoom Out</button>
			<button class="btn btn-secondary m-2" type="button" title="Zoom in" onClick="ZoomIn()">Zoom In</button>
			<input type="text" id="preview" readonly="readonly" style="font-size:20px; width:60px; padding:8px; border:2px #ccc solid">
			<input type="text" id="code" readonly style="font-size:20px; width:95px; padding:8px; margin-left:0px" placeholder="#HEX">
			<input type="text" id="rgb" readonly style="font-size:20px; width:130px; padding:8px; margin-left:0px" placeholder="(R,G,B)">
			<input type="text" id="cname" readonly style="font-size:20px; width:130px; padding:8px; margin-left:0px" placeholder="Color name">
		</div>
		<canvas id="canvas"></canvas>
	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		var imgID = '{{$img->id}}';
		canvas = document.getElementById('canvas');
		canvas.style.display = 'none';
		canvas.onclick = function(event) {
			canvas = document.getElementById('canvas');
			p = GetPos(canvas, event);
			x = p.x * xcan0 / xcan;
			y = p.y * ycan0 / ycan;
			var pixelData = canvas.getContext('2d').getImageData(x, y, 1, 1).data;

			var code = document.getElementById('code');
			var rgb = document.getElementById('rgb');
			var name = document.getElementById('cname');
			var preview = document.getElementById('preview');

			var num = pixelData[0] * 65536 + pixelData[1] * 256 + pixelData[2];
			var hex = num.toString(16).toUpperCase();
			var len = hex.length;
			if (len < 6)
				for (i = 0; i < (6 - len); i++)
					hex = '0' + hex;
			code.value = '#' + hex;
			rgb.value = '(' + pixelData[0] + ',' + pixelData[1] + ',' + pixelData[2] + ')';
			name.value = GetColorName(pixelData[0], pixelData[1], pixelData[2]);
			preview.style.background = code.value;

			var value = imgID+'-'+name.value+'-'+pixelData[0] + ',' + pixelData[1] + ',' + pixelData[2]+'-'+x+'-'+y;
			var result = document.getElementById('result');
			$.ajax({
				url: '/user/color-data',
				method: 'GET',
				data: {
					data: value,
				},
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
				success: function(response) {
					if(response.length == 29){
						result.classList.remove('text-danger');
						result.classList.add('text-success');
						result.innerHTML = response;
					}
					else{
						result.classList.remove('text-success');
						result.classList.add('text-danger');
						result.innerHTML = response;
					}
				},
				error: function(response) {}
			});
			// var imagedata = canvas.getContext('2d').getImageData(0, 0, 5, 5);
			// canvas.getContext('2d').putImageData(imagedata,x,y);
			var Marker = function () {
				this.Sprite = new Image();
				this.Sprite.src = "{{ asset('assets/images/map-marker.png') }}"
				this.Width = 100;
				this.Height = 150;
				this.XPos = x-50;
				this.YPos = y-150;
			}
			var tempMarker = new Marker();
			canvas.getContext('2d').drawImage(tempMarker.Sprite, tempMarker.XPos, tempMarker.YPos, tempMarker.Width, tempMarker.Height);
		};

		//code to draw on hostory page
		// Draw markers
		/*for (var i = 0; i < Markers.length; i++) {
        var tempMarker = Markers[i];
        // Draw marker
        context.drawImage(tempMarker.Sprite, tempMarker.XPos, tempMarker.YPos, tempMarker.Width, tempMarker.Height);

        // Calculate position text
        var markerText = "Postion (X:" + tempMarker.XPos + ", Y:" + tempMarker.YPos;

        // Draw a simple box so you can see the position
        var textMeasurements = context.measureText(markerText);
        context.fillStyle = "#666";
        context.globalAlpha = 0.7;
        context.fillRect(tempMarker.XPos - (textMeasurements.width / 2), tempMarker.YPos - 15, textMeasurements.width, 20);
        context.globalAlpha = 1;

        // Draw position above
        context.fillStyle = "#000";
        context.fillText(markerText, tempMarker.XPos, tempMarker.YPos);
    	}*/

		function DrawCanvas() {
			img = document.getElementById('hiddenImg');
			canvas = document.getElementById('canvas');
			canvas.width = img.width;
			canvas.height = img.height;
			canvas.style.width = img.width + 'px';
			canvas.style.height = img.height + 'px';
			xcan0 = xcan = img.width;
			ycan0 = ycan = img.height;
			canvas.getContext("2d").drawImage(img, 0, 0);
			canvas.style.display = '';
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
			ZoomOut();
		}

		function GetPos(obj, e) {
			x = event.offsetX;
			y = event.offsetY;
			return {
				x: x,
				y: y
			};
		}

		function ZoomOut() {
			canvas = document.getElementById('canvas');
			xcan *= 0.9;
			ycan *= 0.9;
			x = Math.round(xcan);
			y = Math.round(ycan);
			canvas.style.width = x + 'px';
			canvas.style.height = y + 'px';
		}

		function cancel() {
			document.getElementById('canvas').style.display = 'none';
			document.getElementById('code').value = '';
			document.getElementById('rgb').value = '';
			document.getElementById('cname').value = '';
			document.getElementById('preview').style.background = 'white';
			document.getElementById('form').reset();
		}

		function ZoomIn() {
			canvas = document.getElementById('canvas');
			xcan /= 0.9;
			ycan /= 0.9;
			x = Math.round(xcan);
			y = Math.round(ycan);
			canvas.style.width = x + 'px';
			canvas.style.height = y + 'px';
		}

		function GetColorName(R, G, B) {
			console.log(R, G, B);
			tbl = [{
					R: 0,
					G: 0,
					B: 0,
					Name: "black"
				},
				{
					R: 192,
					G: 192,
					B: 192,
					Name: "silver"
				},
				{
					R: 128,
					G: 128,
					B: 128,
					Name: "gray"
				},
				{
					R: 255,
					G: 255,
					B: 255,
					Name: "white"
				},
				{
					R: 128,
					G: 0,
					B: 0,
					Name: "maroon"
				},
				{
					R: 255,
					G: 0,
					B: 0,
					Name: "red"
				},
				{
					R: 128,
					G: 0,
					B: 128,
					Name: "purple"
				},
				{
					R: 255,
					G: 0,
					B: 255,
					Name: "fuchsia"
				},
				{
					R: 0,
					G: 128,
					B: 0,
					Name: "green"
				},
				{
					R: 0,
					G: 255,
					B: 0,
					Name: "lime"
				},
				{
					R: 128,
					G: 128,
					B: 0,
					Name: "olive"
				},
				{
					R: 255,
					G: 255,
					B: 0,
					Name: "yellow"
				},
				{
					R: 0,
					G: 0,
					B: 128,
					Name: "navy"
				},
				{
					R: 0,
					G: 0,
					B: 255,
					Name: "blue"
				},
				{
					R: 0,
					G: 128,
					B: 128,
					Name: "teal"
				},
				{
					R: 0,
					G: 255,
					B: 255,
					Name: "aqua"
				},
				{
					R: 255,
					G: 165,
					B: 0,
					Name: "orange"
				}
			];
			var d = 0,
				dmin = 255,
				imin = 0;
			for (var i = 0; i < tbl.length; i++) {
				d += Math.pow((tbl[i].R - R), 2);
				d += Math.pow((tbl[i].G - G), 2);
				d += Math.pow((tbl[i].B - B), 2);
				d = Math.round(Math.sqrt(d));
				if (d < dmin) {
					dmin = d;
					imin = i;
				}
			}
			return tbl[imin].Name;
		}


	</script>
</x-app-layout>