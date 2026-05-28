//  Initializing variables
var defaultFontSize = 20;
var defaultFont = "Arial";
var defaultColor = "black";
var prevX = 0;
var prevY = 0;

// Defining Canvas
var canvas = document.getElementById("certificatecanvas");
var ctx = canvas.getContext("2d");
var certBackground = new Image();
//certImage.crossOrigin = '*'; 

// Defining DOM Elements
var Inputs = document.getElementById("inputs");
var downloadTypeButton = document.getElementById("downloadtype");
var downloadButton = document.getElementById("downloadbutton");
var downloadCertificate = document.getElementById("download-certificate");

// On Document Load
document.addEventListener("DOMContentLoaded", function () {
  // Creating Image from PNG file
  certBackground.src = defaultCertPNG;
  var dimentionRatio = certBackground.width / certBackground.height;

  // When Image Loads Successfully
  certBackground.onload = async function () {
    // Setting Canvas Size
    canvas.width = certBackground.width;
    canvas.height = certBackground.height;
    defaultFontSize = canvas.width / 100;

    const fontsToLoad = getGoogleFontNames();
    const fontsLoaded = await loadCustomFonts(fontsToLoad);
    
    drawTextfromInputs();
    drawQR();
    drawCertImages();

    if (!fontsLoaded) {
      var shouldReload = confirm("One or more custom fonts did not load. Do you want to reload the page?");
      if (shouldReload) {
        location.reload();
      } else {
        promptFontLoadError();
      }
    }
  };
});

function promptFontLoadError() {
  var alertContainer = document.createElement("div");
  alertContainer.classList.add("alert", "alert-custom", "alert-outline-2x", "alert-outline-danger", "bg-light-danger");
  alertContainer.innerHTML = 'Warning: The certificate may not look as expected due to missing fonts. <a class="ml-1 alert-link font-weight-bolder text-danger" href="#" onclick="location.reload(); return false;">Refresh</a>';

  var certificateContainer = document.querySelector(".certificate-container");
  certificateContainer.parentNode.insertBefore(alertContainer, certificateContainer);
}

// Function to load multiple custom fonts
async function loadCustomFonts(fonts) {
  const fontPromises = fonts.map((font) => {
    const customFont = new FontFaceObserver(font);
    return customFont.load();
  });

  try {
    await Promise.all(fontPromises);
    // All fonts are loaded successfully
    return true;
  } catch (error) {
    // At least one font failed to load
    console.error('One or more custom fonts did not load:', error);
    return false;
  }
}

function getGoogleFontNames() {
  const linkElement = document.querySelector("link[rel='stylesheet'][href^='https://fonts.googleapis.com/css2']");
  if (linkElement) {
    const url = new URL(linkElement.href);
    const params = new URLSearchParams(url.search);
    const fontFamilies = params.getAll('family');
    return fontFamilies.map((fontFamily) => {
      const [familyName] = fontFamily.split(':');
      return familyName.replace(/\+/g, ' ');
    });
  } else {
    return [];
  }
}


function drawTextfromInputs() {
  // Clearing Canvas with white background
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.fillStyle = "black";

  ctx.drawImage(certBackground, 0, 0, canvas.width, canvas.height);

  /****  DRAW TEXTS ****/
  // Getting Inputs
  var textInputs = document.getElementsByClassName("certinputs");
  var textInputsLength = textInputs.length;

  // Looping through Inputs
  for (var i = 0; i < textInputsLength; i++) {
    // Getting Input
    var textInput = textInputs[i];

    // Getting Input Values
    var text = textInput.value;
    var position = [textInput.dataset.x, textInput.dataset.y];
    var fontSize = textInput.dataset.fontsize;
    var font = textInput.dataset.font;
    var textAlign = textInput.dataset.textalign;
    var opacity = textInput.dataset.opacity;
    var color = textInput.dataset.color;
    var bold = textInput.dataset.bold;
    var italic = textInput.dataset.italic;
    var editable = textInput.dataset.editable;
    

    // Adding Text
    addText(
      ctx,
      text,
      position,
      fontSize,
      font,
      textAlign,
      opacity,
      color,
      bold,
      italic,
      textInputs[i],
      editable
    );
  }
}

function drawCertImages() {
  var certImages = document.getElementsByClassName("certimages");
  var certImagesLength = certImages.length;
  for (var i = 0; i < certImagesLength; i++) {
    (function() {
      var certImage = certImages[i];
      var base_image = new Image(); // Now a new 'base_image' is created for each iteration
      base_image.src = certImage.value;

      base_image.onload = function() {
        var imageWidthPercent = certImage.getAttribute("img-width");
        var imageWidth, imageHeight;

        if (imageWidthPercent) {
          imageWidth = canvas.width * (parseInt(imageWidthPercent) / 100);
          imageHeight = (this.height / this.width) * imageWidth; // 'this' refers to the image that triggered the onload event
        } else {
          imageWidth = this.width;
          imageHeight = this.height;
        }

        var xPos = Number(certImage.dataset.x * (canvas.width / 100));
        var yPos = Number(certImage.dataset.y * (canvas.height / 100));
        ctx.drawImage(this, xPos, yPos, imageWidth, imageHeight); // 'this' refers to the correct image
      };
    })(); // Immediately-invoked function expression
  }
}


function drawQR(){
  /****  DRAW QR ****/
  var QRCodeDetails = document.getElementsByClassName("qrcode");
  if(QRCodeDetails.length > 0){ 
    
    var canvasQR = $("#certificatecanvas");
    var QR = QRCodeDetails[0];

    canvasQR.qrcode({
      text: QR.value,
      minVersion: Number(QR.dataset.minversion),
      render: QR.dataset.render,
      background: QR.dataset.background,
      size: Number(QR.dataset.size),
      mode: Number(QR.dataset.mode),
      top: Number(QR.dataset.top),
      left: Number(QR.dataset.left),
      quiet: Number(QR.dataset.quiet),
      radius: Number(QR.dataset.radius),
      fill: QR.dataset.fill,
    }); 
  }
}

function addText(
  ctx = ctx,
  text = "Default Text",
  position = [0, 0],
  fontSize = 5 * defaultFontSize,
  font = defaultFont,
  textAlign = "center",
  opacity = 1,
  color = defaultColor,
  bold = false,
  italic = false,
  dom,
  editable = "1"
) {
  // Setting Font
  ctx.font =
    (Number(bold) ? "bold " : "") +
    (Number(italic) ? "italic " : "") +
    Number(fontSize) * defaultFontSize +
    "px " +
    font;

  // Set color
  ctx.fillStyle = color;

  // Setting Opacity
  ctx.globalAlpha = Number(opacity) / 100;

  // Setting Text Alignment
  ctx.textAlign = textAlign;

  // Setting Text Position
  ctx.textBaseline = "top";
  if (editable == "0") {
    text = "{{" + text + "}}";
  }

  // Measure Height & Width of Text
  var textWidth = ctx.measureText(text).width * (100 / canvas.width);
  var textHeight = fontSize;
  dom.dataset.width = textWidth;
  dom.dataset.height = textHeight;

  // Setting Text Position
  const xPos = Number(position[0] * (canvas.width / 100));
  const yPos = Number(position[1] * (canvas.height / 100));

  ctx.fillText(text, xPos, yPos);
}

downloadCertificate.addEventListener("click", function () {
  var image = canvas.toDataURL("image/jpg");
  var link = document.createElement("a");
  link.download = code + ".jpg";
  link.href = image;
  link.click();
});