const dropArea = document.getElementById('image-dropzone');
dropArea.addEventListener('click', (event) => {
  document.getElementById("dropzone-file").click();
});

dropArea.addEventListener('dragover', (event) => {
  event.stopPropagation(); event.preventDefault();
  event.dataTransfer.dropEffect = 'copy';
  dropArea.classList.add("dropzone-hover");
});

dropArea.addEventListener('mouseleave', (event) => {
  event.stopPropagation(); event.preventDefault();
  dropArea.classList.remove("dropzone-hover");
});

dropArea.addEventListener('drop', (event) => {
  event.stopPropagation();
  event.preventDefault();
  const fileList = event.dataTransfer.files;
  document.getElementById("dropzone-file").files = fileList;
  
  if(fileList[0].type == "image/png" || fileList[0].type == "image/jpeg"){
  	$("#dropzone-preview").attr("src", URL.createObjectURL(fileList[0]));
  } else if(fileList[0].type == "text/csv"){
  	var reader = new FileReader();
  	reader.readAsText(fileList[0]);
  	reader.onload = function(event) {
        var csvData = reader.result;
        $("#student_id").val(csvData);
    };
  } 

});