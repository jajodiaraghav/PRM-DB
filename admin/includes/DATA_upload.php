<div class="panel panel-primary">
  <div class="panel-heading" id="table-name-header">Please upload a CSV/TSV File</div>
  <div class="panel-body">
    <div id="panel-content">
      <div id='fields'>
        <strong>Only CSV or TSV files are supported with the following fields:</strong>
        <p style='font-size:0.7em'>
        	Protein Name, Domain Group, Uniprot ID, Peptide Begin, Peptide End, Pfam Family Name, ELISA_Sequence, Logo, is_validated, No of Logos, Species, HAL Peptides, NGS Peptides, PDB_ID, Type
        </p>
      </div>
      <form id="ul-form" action="upload_file.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <div>
          <label>
            <input type="radio" name="action" value="add" checked>
            Append this data to the table
          </label>
        </div>
        <div>
          <label>
            <input type="radio" name="action" value="replace">
            Replace the ENTIRE table with this data
          </label>
        </div>
        <button class="btn btn-sm btn-primary pull-right" type="submit">Submit</button>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ulSubmit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">File Uploading</h4>
      </div>
      <div class="modal-body">
        <p>Please wait while the file is uploaded. This may take several minutes depending on the file size. Check the bottom left part of the browser to get upload progress.</p>
      </div>
    </div>
  </div>
</div>
