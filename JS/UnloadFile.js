function onChangeSelectedFile(fileInputElementId, imageElementId) {
    var imagePreview = document.getElementById(imageElementId);
    var fileInputElement = document.getElementById(fileInputElementId);

    if(fileInputElement.files && fileInputElement.files[0]){
        var reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(fileInputElement.files[0]);
    }
}
