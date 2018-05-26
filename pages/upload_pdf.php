<main role="main" class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          
          <!-- Our markup, the important part here! -->
          <div id="drag-and-drop-zone" class="dm-uploader p-5">
            <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop files here</h3>

            <div class="btn btn-primary btn-block mb-5">
                <span>Open the file Browser</span>
                <input type="file" title='Click to add Files' />
            </div>
          </div><!-- /uploader -->

        </div>
        <div class="col-md-6 col-sm-12">
          <div class="card h-100">
            <div class="card-header">
              File List
            </div>

            <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
              <li class="text-muted text-center empty">No files uploaded.</li>
            </ul>
          </div>
        </div>
      </div><!-- /file list -->
	 
	<form id="primaryButton"  action="upload2.php" onsubmit="setTimeout(function () { window.location.reload(); }, 10)">
	<table>
		<tr>
			<td>
				Nombre presentación:<br>
			  <input type="text" name="present_name" value="Nombre_presentación"><br>
			</td>
			<td>
				Código acceso:<br>
			  <input type="text" name="code_access" value="Access_code"><br>
			</td>
			<td >
				¿Descargable?
				<input  type="checkbox" name='downloable'></input>
			</td>
		<tr>
			<td>
				Tiempo ini:<br>
			  <input type="date" name="diaini" value="Time start" ><br>
			  <input type="time" name="horaini" value="Time start" ><br>
			</td>
			<td>
				Tiempo fin:<br>
			  <input type="date" name="diafin" value="Time stop"><br>
			  <input type="time" name="horafin" value="Time stop"><br>
			</td>
			<td>
				¿Añadir ubicación?
				<input  type="checkbox" id='addlocation' onclick="myFunction1()"></input>
			</td>
		</tr>
		<tr id="lastr">
			<td>
				<style type="text/css">
					  #map{ width:700px; height: 500px; }
				</style>
				<div>
					 <h2>Select a location!</h2>
					<p>Click on a location on the map to select it. Drag the marker to change location.</p>
					
					<!--map div-->
					<div id="map"></div>
					
					<!--our form-->
					<!--<h2>Chosen Location</h2>-->
					<input type="text" id="lat" name="lat" readonly="yes"><br>
					<input type="text" id="lng" name="lng"readonly="yes">
					
				</div>
			</td>
		</tr>
			  	  
	 </table>
	  <input type="submit" id='submitt' style='visibility:hidden'>
	</form>
	
	  
	  <div class="mt-2">
		<a href="#" class="btn btn-primary" id="btnApiStart">
			<i class="fa fa-play"></i> Start
		</a>
		<a href="#" class="btn btn-danger" id="btnApiCancel">
			<i class="fa fa-stop"></i> Stop
		</a>
		<a href="#" class="btn btn-danger" id="btnApiReset" style="margin-left:100px">
			<i class="fa fa-stop"></i> Reset
		</a>
	  </div>
	  
	
	
	
	
	
      <!--<div class="row">
        <div class="col-12">
           <div class="card h-100">
            <div class="card-header">
              Debug Messages
            </div>

            <ul class="list-group list-group-flush" id="debug">
              <li class="list-group-item text-muted empty">Loading plugin....</li>
            </ul>
          </div>
        </div>
      </div> <!-- /debug -->

    </main> <!-- /container -->
</main>