<head>
<!-- Load TensorFlow.js. This is required to use MobileNet. -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.0.1"> </script>
<!-- Load the MobileNet model. -->
<script src="https://cdn.jsdelivr.net/npm/tensorflow-models/mobilenet/dist/mobilenet.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/tensorflow-models/coco-ssd"> </script>
</head>
<body>
<!-- Replace this with your image. Make sure CORS settings allow reading the image! -->
<img id="img" src="/NicerAppWebOS/siteMedia/backgrounds/landscape/favorites/1821.jpg" style="width:90%;left:5%;"></img>

<!-- Place your code in the script tag below. You can also use an external .js file -->
<script>
  // Notice there is no 'import' statement. 'mobilenet' and 'tf' is
  // available on the index-page because of the script tag above.

  const img = document.getElementById('img');

  // Load the model.
  mobilenet.load().then(model => {
    // Classify the image.
    model.classify(img).then(predictions => {
      console.log('Predictions: ', predictions);
    });
  });
</script>
</body>
