$(document).ready(function () {
    // Initialize SPApp
    var app = $.spapp({ defaultView: "home", pagenotfound: "error_404" });

  // def routes
  app.route({ view: "home", load: "home.html" });
  app.route({ view: "reviews", load: "reviews.html" });
  app.route({ view: "about", load: "about.html" });
  app.route({ view: "contact", load: "contact.html" });
  app.route({ view: "login", load: "login.html" });
  app.route({ view: "register", load: "register.html" });

  app.run();

  let currentGadget = ""; // Stores the current gadget being reviewed
  let reviewData = JSON.parse(sessionStorage.getItem("reviewData")) || {}; // Retrieve stored reviews

  // Handle "View Reviews" button clicks
  $(document).on("click", ".review-btn", function () {
      currentGadget = $(this).data("gadget"); // Store selected gadget
      sessionStorage.setItem("currentGadget", currentGadget); // Store gadget in sessionStorage
      window.location.hash = "#reviews"; // vodi na reviews page
  });

  // Ensure the correct gadget is loaded when on the Reviews page
  $(document).on("spapp.load", function (e, page) {
      if (page === "reviews") {
          currentGadget = sessionStorage.getItem("currentGadget"); // Retrieve stored gadget

          if (!currentGadget) {
              $("#review-title").text("Select a gadget to view reviews.");
              $("#review-form-container").hide(); // Hide form if no gadget selected -
          } else {
              $("#review-title").text(`Reviews for ${currentGadget.replace("-", " ")}`);
              $("#review-form-container").show(); // Show form when a gadget is selected -
              updateReviewList(); // loadaj postojece reviews
          }
      }
  });

  // Handle review submissions
  $(document).on("click", "#submit-review", function () {
      let reviewText = $("#review-input").val().trim();

      if (!currentGadget) {
          alert("Please select a gadget before submitting a review.");
          return;
      }

      if (reviewText) {
          if (!reviewData[currentGadget]) {
              reviewData[currentGadget] = []; // Initialize ako prazno
          }

          reviewData[currentGadget].push(reviewText); // store review
          sessionStorage.setItem("reviewData", JSON.stringify(reviewData)); // save session in storage
          $("#review-input").val(""); // clear input field
          updateReviewList(); // refresha reviews na stranici
      }
  });

  // Function to update the review list
  function updateReviewList() {
      let reviewList = $("#review-list");
      reviewList.empty(); // da ocisti prijasnje reviews

      if (!reviewData[currentGadget] || reviewData[currentGadget].length === 0) {
          reviewList.append(`<div class="alert alert-info mt-2">No reviews yet. Be the first to review!</div>`);
      } else {
          reviewData[currentGadget].forEach(review => {
              reviewList.append(`
                  <div class="card mt-2 shadow-sm">
                      <div class="card-body">
                          <p class="card-text">${review}</p>
                      </div>
                  </div>
              `);
          });
      }
  }
});