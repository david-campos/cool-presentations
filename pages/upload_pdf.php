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
	 
	 
	 
	<form class="form-horizontal" id="primaryButton" onsubmit="return mySubmitFunction(event)" >
	  <div class="form-group">
		<label >Presentation name:</label>
		<input type="text" class="form-control" id="present_name" >
	  </div>
	  <div class="form-group">
		<label>Access code:</label>
		<input class="form-control" type="text" id="code_access" >
	  </div>
	  <div class="checkbox">
		<label><input id='downloable' type="checkbox"> Downloable?</label>
	  </div>
	  <div class="form-group">
		<label>Init time:</label>
		<input type="date" id="diaini" class="form-control"  >
		<input type="time" id="horaini" class="form-control"  >
	  </div>
	  <div class="form-group">
		<label>End time:</label>
		<input type="date" id="diafin" class="form-control" >
		<input type="time" id="horafin" class="form-control" >
	  </div>
	  <div class="form-group">
		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Add Location</button>
		  <div id="demo" class="collapse">
			 <h2>Select a location!</h2>
					<p>Click on a location on the map to select it. Drag the marker to change location.</p>
					<style type="text/css">
					  #map{ width:700px; height: 500px; }
					</style>
					<!--map div-->
					<div id="map"></div>
					
					<!--our form-->
					<!--<h2>Chosen Location</h2>-->
					<input type="text" id="lat"  readonly="yes" style="visibility:hidden"><br>
					<input type="text" id="lng" readonly="yes" style="visibility:hidden">
					
		  </div>
	  </div>
	   <div class="form-group">
		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2">Add Survey</button>
		  <div id="demo2" class="collapse">
			<div class="form-group">
				<label>Question:</label>
				<input type="text" id="question" class="form-control" value="Question">
			</div>
			<div class="form-group">
				<label>Page number:</label>
				<input type="number" id="page" class="form-control" value="0">
			</div>
			<div class="form-group">
				<label>Position X and Y (px):</label>
				<input type="number" id="xcor" class="form-control" value="0">
				<input type="number" id="ycor" class="form-control" value="0">	
			</div>
			<div class="form-group">
				<label>Width and Height (px)</label>
				<input type="number" id="width" class="form-control" value="0">
				<input type="number" id="height" class="form-control" value="0">	
			</div>
			<div class="checkbox">
				<label><input id='multiplechoice' type="checkbox"> Multiple choice allowed?</label>
			</div>
			
			<div class="form-group"id="primer_answer">
				<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo3">Add Answers</button>
				  <div id="demo3" class="collapse">
					<div class="form-group">
						<label>Answer1:</label>
						<input type="text" id="answer1" class="form-control" >
					</div>
					<div class="form-group">
						<label>Answer2:</label>
						<input type="text"  id="answer2" class="form-control" >
					</div>
					<div class="form-group">
						<label>Answer3:</label>
						<input type="text"   id="answer3" class="form-control" >
					</div>
					<div class="form-group">
						<label>Answer4:</label>
						<input type="text"  id="answer4" class="form-control" >
					</div>
					<div class="form-group">
						<label>Answer5:</label>
						<input type="text" id="answer5" class="form-control" >
					</div>
				  </div>
			</div>
			<script type="text/javascript">
				var primer_survery = document.getElementById('demo');
				
			</script>
		  </div>
	  </div>
	</form> 
	<!--
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
				
				<div>
					 <h2>Select a location!</h2>
					<p>Click on a location on the map to select it. Drag the marker to change location.</p>
					
					
					<div id="map"></div>
					
					
	
					<input type="text" id="lat" name="lat" readonly="yes"><br>
					<input type="text" id="lng" name="lng"readonly="yes">
					
				</div>
			</td>
		</tr>
			  	  
	 </table>
	  <input type="submit" id='submitt' style='visibility:hidden'>
	</form>
	-->
	
	
	  
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