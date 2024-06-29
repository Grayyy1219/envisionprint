window.addEventListener("load", function () {
  initializeSlideshow();
});
function initializeSlideshow() {
  var i = 0;
  const slideshowContainer = document.querySelector(".slideshow-container");
  const slidesContainer = document.querySelector(".slides-container");
  const slides = document.querySelectorAll(".slide");
  const totalSlides = slides.length;
  let currentSlideIndex = 0;
  let timer;
  function createDots() {
    const dotContainer = document.querySelector(".dot-container");
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement("span");
      dot.className = "dot";
      dotContainer.appendChild(dot);
      dot.addEventListener("click", () => {
        currentSlideIndex = i;
        showSlide(currentSlideIndex);
        resetTimer();
      });
    }
    updateDots();
  }
  function updateDots() {
    const dots = document.querySelectorAll(".dot");
    dots.forEach((dot, index) => {
      if (index === currentSlideIndex) {
        dot.classList.add("active-dot");
      } else {
        dot.classList.remove("active-dot");
      }
    });
  }
  function nextSlide() {
    currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
    showSlide(currentSlideIndex);
    updateDots();
  }
  function prevSlide() {
    currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
    console.log(i);
    i++;
    showSlide(currentSlideIndex);
  }
  function startTimer() {
    timer = setInterval(nextSlide, 3500);
  }
  function resetTimer() {
    clearInterval(timer);
    startTimer();
  }
  function showSlide(slideIndex) {
    slidesContainer.style.transform = `translateX(-${slideIndex * 100}%)`;
    slides.forEach((slide) => slide.classList.remove("active"));
    slides[slideIndex].classList.add("active");
    updateDots();
  }
  slideshowContainer.addEventListener("mouseover", () => {
    clearInterval(timer);
  });
  slideshowContainer.addEventListener("mouseout", () => {
    resetTimer();
  });
  const prevButton = document.querySelector(".prev-button");
  const nextButton = document.querySelector(".next-button");
  prevButton.addEventListener("click", prevSlide);
  nextButton.addEventListener("click", nextSlide);
  createDots();
  startTimer();
}
