// sidebar.js

document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.getElementById("menu-button");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const closeButton = document.getElementById("close-button");

  // Open sidebar when the menu button is clicked
  menuButton.addEventListener("click", function () {
    sidebar.classList.add("open");
    overlay.classList.add("show");
  });

  // Close sidebar when the overlay or close button is clicked
  overlay.addEventListener("click", closeSidebar);
  closeButton.addEventListener("click", closeSidebar);

  function closeSidebar() {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
  }

  // Handle selecting a field
  document.querySelectorAll(".card-title").forEach((item) => {
    item.addEventListener("click", function () {
      const selectedField = this.textContent;
      localStorage.setItem("selectedField", selectedField);
      window.location.href = "halamanbooking.html"; // Redirect to the booking page
    });
  });
});



// slider.js

let list = document.querySelector(".slider .list");
let items = document.querySelectorAll(".slider .list .item");
let dots = document.querySelectorAll(".slider .dots li");
let prev = document.getElementById("prev");
let next = document.getElementById("next");

let active = 0;
let lengthItems = items.length - 1;

let refreshSlider; // Declare interval for auto-slide

// Function to reload slider and update active dot
function reloadSlider() {
  let checkLeft = items[active].offsetLeft;
  list.style.left = -checkLeft + "px";

  // Remove active class from the previous active dot
  let lastActiveDot = document.querySelector(".slider .dots li.active");
  if (lastActiveDot) {
    lastActiveDot.classList.remove("active");
  }

  // Add active class to the new active dot
  dots[active].classList.add("active");

  // Reset the interval
  clearInterval(refreshSlider);
  refreshSlider = setInterval(() => {
    next.click();
  }, 5000); // Auto-slide every 5 seconds
}

// Next button functionality
next.onclick = function () {
  if (active + 1 > lengthItems) {
    active = 0; // Loop to first item
  } else {
    active++;
  }
  reloadSlider();
};

// Previous button functionality
prev.onclick = function () {
  if (active - 1 < 0) {
    active = lengthItems; // Loop to last item
  } else {
    active--;
  }
  reloadSlider();
};

// Auto-slide functionality
refreshSlider = setInterval(() => {
  next.click();
}, 5000);

// Dot navigation functionality
dots.forEach((li, key) => {
  li.addEventListener("click", function () {
    active = key;
    reloadSlider();
  });
});

// Initial load
reloadSlider();

// comment.js

// Dummy user login check (Replace with real authentication check)
const user = {
  isLoggedIn: true, // Set to false for non-logged-in user
  username: "Asep Hytam",
};

// Load existing comments (dummy data)
const comments = [
  { username: "John", text: "This is a comment." },
  { username: "Jane", text: "This is another comment." },
];

// Display comments
function loadComments() {
  const commentsList = document.getElementById("comments-list");
  commentsList.innerHTML = ""; // Clear existing comments

  comments.forEach((comment) => {
    const commentDiv = document.createElement("div");
    commentDiv.classList.add("comment");
    commentDiv.innerHTML = `
          <strong>${comment.username}</strong>
          <p>${comment.text}</p>
      `;
    commentsList.appendChild(commentDiv);
  });
}

// Handle comment submission
document.getElementById("commentForm").addEventListener("submit", function (e) {
  e.preventDefault();

  if (!user.isLoggedIn) {
    alert("You must be logged in to leave a comment.");
    return;
  }

  const commentText = document.getElementById("commentText").value;
  if (commentText.trim() === "") return; // Ignore empty comments

  // Add new comment to the array
  comments.push({ username: user.username, text: commentText });
  loadComments();

  // Clear the input field
  document.getElementById("commentText").value = "";
});

// Initialize comments on page load
window.onload = loadComments;
const mainImg = document.getElementById('main-img');
const mainTitle = document.getElementById('main-title');
const mainDesc = document.getElementById('main-desc');
const thumbnails = document.querySelectorAll('.thumb');

thumbnails.forEach(thumb => {
  thumb.addEventListener('click', () => {
    mainImg.src = thumb.getAttribute('data-img');
    mainTitle.textContent = thumb.getAttribute('data-title');
    mainDesc.textContent = thumb.getAttribute('data-desc');
  });
});
