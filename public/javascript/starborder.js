document.addEventListener('DOMContentLoaded', () => {
    const buttonContainer = document.querySelector('.button-star-container');

    buttonContainer.addEventListener('mouseenter', () => {
      createShootingStar(buttonContainer);
    });
  });

  function createShootingStar(container) {
    const star = document.createElement('div');
    star.classList.add('shooting-star');
    container.appendChild(star);

    const containerRect = container.getBoundingClientRect();
    const startX = Math.random() * containerRect.width;
    const startY = 0;
    const endX = startX + 50;
    const endY = containerRect.height + 50;

    const duration = 1000 + Math.random() * 500;

    star.style.left = `${startX}px`;
    star.style.top = `${startY}px`;
    star.style.opacity = 1;
    star.style.transition = transform `${duration}ms linear, opacity ${duration}ms linear`;

    requestAnimationFrame(() => {
      star.style.transform = translate(`${endX - startX}px, ${endY - startY}px`);
      star.style.opacity = 0;
    });

    setTimeout(() => {
      star.remove();
    }, duration);
  }
