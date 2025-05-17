document.addEventListener('DOMContentLoaded', function() {
    // Testimonial Data
    const testimonials = [
      {
        name: "Eva Sawyer",
        job: "Adventure Enthusiast",
        image: "https://images.pexels.com/photos/774095/pexels-photo-774095.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
        testimonial: "TravelWiz transformed my Paris vacation! Their attention to detail and personalized recommendations made me feel like a local rather than a tourist. The hidden cafés and viewpoints they suggested were absolute gems.",
        destination: "Paris, France"
      },
      {
        name: "Katey Topaz",
        job: "Digital Nomad",
        image: "https://images.pexels.com/photos/762020/pexels-photo-762020.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
        testimonial: "As someone who works while traveling, finding reliable accommodations with good internet is crucial. TravelWiz understood my needs perfectly and found me the ideal spots in Bali with stunning views and perfect connectivity.",
        destination: "Bali, Indonesia"
      },
      {
        name: "Jae Robin",
        job: "Family Travel Blogger",
        image: "https://images.pexels.com/photos/1065084/pexels-photo-1065084.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
        testimonial: "Traveling with three kids can be overwhelming, but TravelWiz made our Greek island hopping adventure seamless. Their family-friendly recommendations and thoughtful itinerary planning made it our best family trip yet!",
        destination: "Santorini, Greece"
      },
      {
        name: "Nicola Blakely",
        job: "Luxury Travel Consultant",
        image: "https://images.pexels.com/photos/1933873/pexels-photo-1933873.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
        testimonial: "Even as a travel professional myself, I'm impressed with TravelWiz's service. Their connections with luxury properties and ability to arrange exclusive experiences for my clients are unmatched in the industry.",
        destination: "Global Experiences"
      },
    ];
  
    // Mobile Menu Toggle
    const hamMenu = document.getElementById('ham-menu');
    const navLinks = document.querySelector('.nav-links');
  
    if (hamMenu) {
      hamMenu.addEventListener('change', function() {
        if (this.checked) {
          navLinks.style.right = '0';
        } else {
          navLinks.style.right = '-100%';
        }
      });
    }
  
    // Handle scroll animation
    function revealOnScroll() {
      const elements = document.querySelectorAll('.box, .destination-card');
      
      elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
          element.classList.add('animate-fade-in');
        }
      });
    }
  
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); // Run once on load
  
    // Testimonials
    let currentTestimonial = 0;
    const testimonialContainer = document.getElementById('testimonial-container');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const dotsContainer = document.getElementById('testimonial-dots');
  
    // Create the dots for testimonials
    function createTestimonialDots() {
      dotsContainer.innerHTML = '';
      testimonials.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === currentTestimonial) {
          dot.classList.add('active');
        }
        dot.addEventListener('click', () => {
          currentTestimonial = index;
          displayTestimonial();
        });
        dotsContainer.appendChild(dot);
      });
    }
  
    // Display current testimonial
    function displayTestimonial() {
      const { testimonial, image, name, job, destination } = testimonials[currentTestimonial];
      
      testimonialContainer.innerHTML = `
        <p class="testimonial-text">"${testimonial}"</p>
        <img class="testimonial-image" src="${image}" alt="${name}">
        <h3 class="testimonial-name">${name}</h3>
        <p class="testimonial-job">${job}</p>
        ${destination ? `<div class="testimonial-location"><i class="fas fa-map-marker-alt"></i> ${destination}</div>` : ''}
      `;
  
      // Update dots
      const dots = document.querySelectorAll('.dot');
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentTestimonial);
      });
    }
  
    // Next and Previous buttons
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        displayTestimonial();
      });
    }
  
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
        displayTestimonial();
      });
    }
  
    // Auto-advance testimonials
    let testimonialInterval = setInterval(() => {
      currentTestimonial = (currentTestimonial + 1) % testimonials.length;
      displayTestimonial();
    }, 6000);
  
    // Pause auto-advance on hover
    if (testimonialContainer) {
      testimonialContainer.addEventListener('mouseenter', () => {
        clearInterval(testimonialInterval);
      });
  
      testimonialContainer.addEventListener('mouseleave', () => {
        testimonialInterval = setInterval(() => {
          currentTestimonial = (currentTestimonial + 1) % testimonials.length;
          displayTestimonial();
        }, 6000);
      });
    }
  
    // Email subscription
    const subscribeBtn = document.getElementById('subscribe-btn');
    const emailInput = document.getElementById('email-input');
    const subscribeMessage = document.getElementById('subscribe-message');
  
    if (subscribeBtn) {
      subscribeBtn.addEventListener('click', () => {
        const email = emailInput.value.trim();
        const emailRegex = /^\S+@\S+\.\S+$/;
        
        if (email && emailRegex.test(email)) {
          subscribeMessage.textContent = 'Thank you for subscribing!';
          subscribeMessage.className = 'subscribe-message success';
          emailInput.value = '';
          // In a real app, you would send this to a backend
          console.log("Subscribing email:", email);
        } else {
          subscribeMessage.textContent = 'Please enter a valid email address';
          subscribeMessage.className = 'subscribe-message error';
        }
      });
    }
  
    // Initialize testimonials
    createTestimonialDots();
    displayTestimonial();
  
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80, // Offset for navbar
            behavior: 'smooth'
          });
        }
  
        // Close mobile menu if open
        if (hamMenu && hamMenu.checked) {
          hamMenu.checked = false;
          navLinks.style.right = '-100%';
        }
      });
    });
  
    // Destination cards hover effect
    const destinationCards = document.querySelectorAll('.destination-card');
    destinationCards.forEach(card => {
      const img = card.querySelector('img');
      card.addEventListener('mouseenter', () => {
        img.style.transform = 'scale(1.1)';
      });
      card.addEventListener('mouseleave', () => {
        img.style.transform = 'scale(1)';
      });
    });
  
    // Explore buttons click handler
    const exploreButtons = document.querySelectorAll('.explore-btn');
    exploreButtons.forEach(button => {
      button.addEventListener('click', function() {
        const destinationName = this.closest('.destination-card').querySelector('h3').textContent;
        alert(`You're about to explore ${destinationName}! In a real app, this would take you to a detailed page about this destination.`);
      });
    });
  
    // Call to action scroll animation
    window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY;
      const windowHeight = window.innerHeight;
      const documentHeight = document.body.scrollHeight;
      
      // Show back-to-top button when user scrolls down
      const scrollPercentage = (scrollPosition / (documentHeight - windowHeight)) * 100;
      if (scrollPercentage > 20) {
        // You could add a back-to-top button here
      }
    });
  });