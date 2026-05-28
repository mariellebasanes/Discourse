//  Initializing variables
var defaultFontSize = 20;
var defaultFont = "Arial";
var defaultColor = "black";
var prevX = 0;
var prevY = 0;

// Defining Canvas
var canvas = document.getElementById("certificatecanvas");
var ctx = canvas.getContext("2d");
var certImage = new Image();
certImage.crossOrigin = '*';  

var canvasOffset = canvas.getBoundingClientRect();
var offsetX = canvasOffset.left;
var offsetY = canvasOffset.top;
var scrollX = window.pageXOffset;
var scrollY = window.pageYOffset;
var startX = 0;
var startY = 0;
var selectedElement = null;
var dragMode = false;

// Defining DOM Elements
var Inputs = document.getElementById("inputs");
var downloadTypeButton = document.getElementById("downloadtype");
var downloadButton = document.getElementById("downloadbutton");

// On Document Load
document.addEventListener("DOMContentLoaded", function () {
  // Creating Image from PNG file
  certImage.src = defaultCertPNG;
  var dimentionRatio = certImage.width / certImage.height;

  // When Image Loads Successfully
  certImage.onload = function () {
    // Setting Canvas Size
    canvas.width = certImage.width;
    canvas.height = certImage.height;
    defaultFontSize = canvas.width / 100;
    drawTextfromInputs();
  };
});


function drawTextfromInputs() {
  // Clearing Canvas with white background
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.fillStyle = "black";

  ctx.drawImage(certImage, 0, 0, canvas.width, canvas.height);

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
  if (selectedElement != null) {
    drawBorderForSelected();
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
  // console.log(textWidth,textHeight);

  // Setting Text Position
  const xPos = Number(position[0] * (canvas.width / 100));
  const yPos = Number(position[1] * (canvas.height / 100));

  ctx.fillText(text, xPos, yPos);
}

downloadButton.addEventListener("click", function () {
  selectedElement = null;
  drawTextfromInputs();

  // Getting the Download Type
  var downloadType = downloadTypeButton.value;

  if (downloadType == "png" || downloadType == "jpg") {
    // Creating Image from Canvas
    var image = canvas.toDataURL("image/" + downloadType);

    // Creating Download Link
    var link = document.createElement("a");
    link.download = "certificate." + downloadType;
    link.href = image;
    link.click();
  } else if (downloadType == "pdf") {
    var pdf = new jsPDF('l', 'mm', [279.4, 215.9]);
    pdf.addImage(canvas.toDataURL("image/png"), "PNG", 0, 0);
    pdf.save("certificate.pdf");
  }
});