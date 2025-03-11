document.querySelectorAll('.shiny-button').forEach(button => {
    button.addEventListener('mousemove', (e) => {
      const span = button.querySelector('span');
      const { left, top, width, height } = button.getBoundingClientRect();
      const x = (e.clientX - left) / width * 100;
      const y = (e.clientY - top) / height * 100;

      span.style.background = `radial-gradient(circle at ${x}% ${y}%, #fff, #ff00ff, #00ffff)`;
      span.style.backgroundSize = '200% 200%';
      span.style.webkitBackgroundClip = 'text';
      span.style.webkitTextFillColor = 'transparent';
    });

    button.addEventListener('mouseleave', () => {
      const span = button.querySelector('span');
      span.style.background = 'linear-gradient(90deg, #fff, #ff00ff, #00ffff, #fff)';
      span.style.animation = 'shine 3s linear infinite';
    });
  });
