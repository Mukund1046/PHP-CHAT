const registrationSection = document.getElementById('registration-section');

registrationSection.style.transition = 'transform 0.2s ease-out'; // Smooth transition on reset

registrationSection.addEventListener('mousemove', (e) => {
  requestAnimationFrame(() => {
    const { left, top, width, height } = registrationSection.getBoundingClientRect();
    const x = e.clientX - left;
    const y = e.clientY - top;
    const centerX = width / 2;
    const centerY = height / 2;

    const rotateX = ((centerY - y) / centerY) * 10; // Scaled for a smoother effect
    const rotateY = ((x - centerX) / centerX) * 10; // Scaled for a smoother effect

    registrationSection.style.transform = `perspective(500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
  });
});

registrationSection.addEventListener('mouseleave', () => {
  requestAnimationFrame(() => {
    registrationSection.style.transform = 'perspective(500px) rotateX(0deg) rotateY(0deg)';
  });
});
