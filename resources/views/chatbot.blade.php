<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI Chatbot + Image Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 50px;
    }
    textarea {
      width: 400px;
      height: 100px;
      margin-bottom: 10px;
    }
    img {
      width: 400px;
      display: none;
      margin-top: 20px;
      border: 2px solid black;
    }
  </style>
</head>
<body>
    <title>Image Generation with Vertex AI</title>
</head>
<body>
    <input type="file" multiple>
    <input type="text" id="prompt-input" placeholder="Enter your prompt here">
    <button id="generate-button">Generate Image</button>
<h3>AI Response:</h3>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.3.1/firebase-app.js";
    import { getVertexAI, getGenerativeModel } from "https://www.gstatic.com/firebasejs/11.3.1/firebase-vertexai.js";

    const firebaseConfig = {
    apiKey: "AIzaSyDQaxvshnYcXgQ8KYy3Zk7EAetFAOZQrzo",
    authDomain: "recaptcha-d4f01.firebaseapp.com",
    projectId: "recaptcha-d4f01",
    storageBucket: "recaptcha-d4f01.appspot.com",
    messagingSenderId: "1000666075321",
    appId: "1:1000666075321:web:61732e65604721cddf4b68",
    measurementId: "G-82T0RJ76HH"
    };

    const firebaseApp = initializeApp(firebaseConfig);
    const vertexAI = getVertexAI(firebaseApp);
    vertexAI.options = { location: "us-central1" };

    const model = getGenerativeModel(vertexAI, { model: "gemini-2.0-flash" });
    async function fileToGenerativePart(file) {
    const base64EncodedDataPromise = new Promise((resolve) => {
        const reader = new FileReader();
        reader.onloadend = () => resolve(reader.result.split(',')[1]);
        reader.readAsDataURL(file);
    });
    return {
        inlineData: { data: await base64EncodedDataPromise, mimeType: file.type },
    };
    }

    async function generateImage() {
    try {
        // Get the prompt from the input field
        const prompt = document.getElementById("prompt-input").value;

        // Prepare images for input
        const fileInputEl = document.querySelector("input[type=file]");
        const imageParts = await Promise.all(
        [...fileInputEl.files].map(fileToGenerativePart)
        );

        // To generate text output, call generateContent with the text and images
        const result = await model.generateContent([prompt, ...imageParts]);

        const response = result.response;
        const text = await response.text();
        console.log(text);
    } catch (error) {
        console.error("Error generating image:", error);
        alert(`Error: ${error.message}`);
    }
    }

    // Add event listener to the button
    document.getElementById("generate-button").addEventListener("click", generateImage);
</script>
  
</body>
</html>