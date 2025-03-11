const canvas = document.createElement("canvas");
const ctx = canvas.getContext("2d");
canvas.style.position = "fixed";
canvas.style.top = "0";
canvas.style.left = "0";
canvas.style.width = "100%";
canvas.style.height = "100%";
canvas.style.pointerEvents = "none"; // Ensures it doesn't interfere with user interactions
canvas.style.zIndex = "100"; // Puts it above everything subtly
document.body.appendChild(canvas);

function generateNoise() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  const imageData = ctx.createImageData(canvas.width, canvas.height);
  const pixels = imageData.data;

  for (let i = 0; i < pixels.length; i += 4) {
    const value = Math.random() * 255;
    pixels[i] = pixels[i + 1] = pixels[i + 2] = value; // Grayscale noise
    pixels[i + 3] = 25; // Alpha (adjust for more/less visibility)
  }

  ctx.putImageData(imageData, 0, 0);
}

// Generate noise every 50ms for a subtle animated effect
setInterval(generateNoise, 50);

// Adjust size on window resize
window.addEventListener("resize", generateNoise);
