if($(".dropzone").length != 0){
  const dropArea = $('.image-dropzone');

  dropArea.on("click", function(event){
    var location = $(this).attr("data-location");
    $('[name="'+ location +'"]')[0].click();
    //handleEvent(event, location);
  });

  dropArea.on("drop", function(event){
    handleEvent(event, $(this).attr("data-location"));
  });

  dropArea.on('dragover', (event) => {
    event.stopPropagation();
    event.preventDefault();
    event.originalEvent.dataTransfer.dropEffect = 'copy';
    dropArea.addClass("dropzone-hover");
  });

  dropArea.on('mouseleave', (event) => {
    event.stopPropagation();
    event.preventDefault();
    dropArea.removeClass("dropzone-hover");
  });

  const handleFileSelection = (fileList, location) => {
    if (fileList[0].type === 'image/png' || fileList[0].type === 'image/jpeg') {
    	if (fileList[0].size <= 2 * 1024 * 1024) { 
        $('[data-location="'+ location +'"]').find(".dropzone-preview").attr("src", URL.createObjectURL(fileList[0]));
      } else {
        alert('Error: File size exceeds the limit of 2MB.');
        $('[name="'+ location +'"]').val(''); 
      }
    } else {
    	alert('Error: Please select a valid image file (PNG or JPEG).');
    	$('[name="'+ location +'"]').val();
    }
  };

  function handleEvent(event, location){
  	event.stopPropagation();
  	event.preventDefault();
  	var fileInput = $('[name="'+ location +'"]');

  	if (event.type === 'drop') {
  		const fileList = event.originalEvent.dataTransfer.files;
  		fileInput[0].files = fileList;
  		handleFileSelection(fileList, location);
  	} else if (event.type === 'click') {
  		fileInput.click();
  	}

  	dropArea.removeClass("dropzone-hover");
  }

  $('.dropzone-file').on('change', (event) => {
    var location = "silver-image";

    const fileList = event.target.files;
    if (fileList.length > 0) {
      handleFileSelection(fileList, location);
    }
  });
}