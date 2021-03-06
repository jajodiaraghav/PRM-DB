<div class="panel panel-primary">
  <div class="panel-heading" id="table-name-header">
    Select Files/Images to upload
  </div>
  <div class="panel-body">
    <div id="panel-content">

      <form id="fileupload" action="upload_data.php" method="POST" enctype="multipart/form-data">

	<div class="row">
          <div class="col-md-2 col-md-offset-5">
            <h5>Select Folder:</h5>
            <select class="form-control" name="folder">
              <option value="LOGOS">LOGOS</option>
              <option value="PWM">PWM</option>
              <option value="ELISA">ELISA</option>
              <option value="NGS">NGS</option>
              <option value="PDB">PDB</option>
            </select>
          </div>
        </div>
        <hr>

        <div class="row text-center fileupload-buttonbar">
          <span class="btn btn-success btn-sm fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
              <span>Add files...</span>
              <input type="file" name="files[]" multiple>
          </span>
          <button type="submit" class="btn btn-primary btn-sm start">
              <i class="glyphicon glyphicon-upload"></i>
              <span>Start upload</span>
          </button>
          <button type="reset" class="btn btn-warning btn-sm cancel">
              <i class="glyphicon glyphicon-ban-circle"></i>
              <span>Cancel upload</span>
          </button>
          <span class="fileupload-process"></span>
        </div>
    
        <div class="row text-center fileupload-progress fade">
          <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
          </div>
          <div class="progress-extended">&nbsp;</div>
        </div>

        <div class="row text-center">
          <table role="presentation" class="table table-striped">
            <tbody class="files"></tbody>
          </table>
        </div>
      </form>

    </div>
  </div>
</div>
