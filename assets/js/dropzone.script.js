var dropzone = new Dropzone ("#mydropzone", {
 
    
  });
  dropzone.on("addedfile", function(file) {

    if (this.files.length > 1) {
        this.removeFile(this.files[0]);
      }
    // Create the remove button
    var removeButton = Dropzone.createElement("<button class='btn  dark'>Effacer le fichier</button>");

    // Listen to the click event
    removeButton.addEventListener("click", function(e) {
        // Make sure the button click doesn't submit the form:
        e.preventDefault();
        e.stopPropagation();

        // Remove the file preview.
        dropzone.removeFile(file);
        // If you want to the delete the file on the server as well,
        // you can do the AJAX request here.
    });

    // Add the button to the file preview element.
    file.previewElement.appendChild(removeButton);

    $("#file_image").removeClass("display_input");
    
});


Dropzone.prototype.defaultOptions.init = function () {

    this.hiddenFileInput.removeAttribute('multiple');
    this.on("maxfilesexceeded", function (file) {
        this.removeAllFiles();
        this.addFile(file);
    });
};

dropzone.on("removedfile", function(file){

var name = file.name; 
$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});        
$.ajax({
    type: 'POST',
    url: '/product/remove_img/'+ file.previewElement.id,
    data: "id="+file.previewElement.id,
    type: 'delete',
});

});


dropzone.on("success", function(file, response) {
    
    file.previewElement.id = response.id;


    
});


