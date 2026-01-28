// Main JavaScript file for Easybooking.com
document.addEventListener("DOMContentLoaded", () => {
  // Mobile navigation toggle
  const mobileNavToggle = document.createElement("button")
  mobileNavToggle.className = "mobile-nav-toggle"
  mobileNavToggle.innerHTML = '<i class="fas fa-bars"></i>'

  const navbar = document.querySelector(".navbar")
  if (navbar) {
    navbar.appendChild(mobileNavToggle)

    mobileNavToggle.addEventListener("click", () => {
      const navLinks = document.querySelector(".nav-links")
      navLinks.classList.toggle("show")
    })
  }

  // Flight page tab switching
  const roundtripTab = document.getElementById("roundtrip-tab")
  const onewayTab = document.getElementById("oneway-tab")
  const multicityTab = document.getElementById("multicity-tab")

  if (roundtripTab && onewayTab && multicityTab) {
    const roundtripForm = document.getElementById("roundtrip-form")
    const onewayForm = document.getElementById("oneway-form")
    const multicityForm = document.getElementById("multicity-form")

    // Function to switch between forms
    function switchForm(activeTab, activeForm) {
      // Remove active class from all tabs
      roundtripTab.classList.remove("active")
      onewayTab.classList.remove("active")
      multicityTab.classList.remove("active")

      // Hide all forms
      roundtripForm.style.display = "none"
      onewayForm.style.display = "none"
      multicityForm.style.display = "none"

      // Add active class to the selected tab
      activeTab.classList.add("active")

      // Show the selected form
      activeForm.style.display = "grid"
    }

    // Event listeners for tabs
    roundtripTab.addEventListener("click", () => {
      switchForm(roundtripTab, roundtripForm)
    })

    onewayTab.addEventListener("click", () => {
      switchForm(onewayTab, onewayForm)
    })

    multicityTab.addEventListener("click", () => {
      switchForm(multicityTab, multicityForm)
    })

    // Initialize with Roundtrip form visible
    roundtripTab.classList.add("active")
    roundtripForm.style.display = "grid"
  }

  // Set current date as minimum for date inputs
  const dateInputs = document.querySelectorAll('input[type="date"]')
  if (dateInputs.length > 0) {
    const today = new Date().toISOString().split("T")[0]
    dateInputs.forEach((input) => {
      input.min = today
    })
  }

  // Form validation for contact form
  const contactForm = document.querySelector(".contact-form")
  if (contactForm) {
    contactForm.addEventListener("submit", (event) => {
      if (!contactForm.checkValidity()) {
        event.preventDefault()
        alert("Please fill in all required fields correctly.")
      }
    })
  }

  // Hotel search functionality
  const hotelSearchBtn = document.querySelector(".search-btn")
  if (hotelSearchBtn && window.location.pathname.includes("index.php")) {
    hotelSearchBtn.addEventListener("click", () => {
      const destination = document.getElementById("destination")?.value
      const checkIn = document.getElementById("check-in")?.value
      const checkOut = document.getElementById("check-out")?.value
      const adults = document.getElementById("adults")?.value || 1
      const children = document.getElementById("children")?.value || 0
      const rooms = document.getElementById("rooms")?.value || 1

      if (!destination || !checkIn || !checkOut) {
        alert("Please fill in all required fields")
        return
      }

      // Create form and submit
      const form = document.createElement("form")
      form.method = "GET"
      form.action = "hotel-search.php"

      const addInput = (name, value) => {
        const input = document.createElement("input")
        input.type = "hidden"
        input.name = name
        input.value = value
        form.appendChild(input)
      }

      addInput("destination", destination)
      addInput("check_in", checkIn)
      addInput("check_out", checkOut)
      addInput("adults", adults)
      addInput("children", children)
      addInput("rooms", rooms)

      document.body.appendChild(form)
      form.submit()
    })
  }

  // Flight search functionality
  const flightSearchBtns = document.querySelectorAll(".flight-search .search-btn")
  if (flightSearchBtns.length > 0) {
    flightSearchBtns.forEach((btn) => {
      btn.addEventListener("click", (event) => {
        const form = event.target.closest(".search-box")
        const formId = form.id

        let leavingFrom, goingTo, departureDate, returnDate, passengers, flightClass

        if (formId === "roundtrip-form") {
          leavingFrom = document.getElementById("leaving-from").value
          goingTo = document.getElementById("going-to").value
          departureDate = document.getElementById("departure-date").value
          returnDate = document.getElementById("return-date").value
          passengers = document.getElementById("passengers").value
          flightClass = document.getElementById("class").value

          if (!leavingFrom || !goingTo || !departureDate || !returnDate) {
            alert("Please fill in all required fields")
            return
          }
        } else if (formId === "oneway-form") {
          leavingFrom = document.getElementById("oneway-leaving-from").value
          goingTo = document.getElementById("oneway-going-to").value
          departureDate = document.getElementById("oneway-departure-date").value
          passengers = document.getElementById("oneway-passengers").value
          flightClass = document.getElementById("class").value

          if (!leavingFrom || !goingTo || !departureDate) {
            alert("Please fill in all required fields")
            return
          }
        } else if (formId === "multicity-form") {
          // For simplicity, just check the first segment
          leavingFrom = document.getElementById("multicity-leaving-from-1").value
          goingTo = document.getElementById("multicity-going-to-1").value
          departureDate = document.getElementById("multicity-departure-date-1").value
          passengers = document.getElementById("multicity-passengers").value
          flightClass = document.getElementById("class").value

          if (!leavingFrom || !goingTo || !departureDate) {
            alert("Please fill in all required fields")
            return
          }
        }

        // Create form and submit
        const searchForm = document.createElement("form")
        searchForm.method = "GET"
        searchForm.action = "flight-search.php"

        const addInput = (name, value) => {
          if (value) {
            const input = document.createElement("input")
            input.type = "hidden"
            input.name = name
            input.value = value
            searchForm.appendChild(input)
          }
        }

        addInput("leaving_from", leavingFrom)
        addInput("going_to", goingTo)
        addInput("departure_date", departureDate)
        addInput("return_date", returnDate)
        addInput("passengers", passengers)
        addInput("class", flightClass)
        addInput("trip_type", formId.replace("-form", ""))

        document.body.appendChild(searchForm)
        searchForm.submit()
      })
    })
  }

  // Car rental search functionality
  const carSearchBtn = document.querySelector(".car-rental-search .search-btn")
  if (carSearchBtn) {
    carSearchBtn.addEventListener("click", () => {
      const pickupLocation = document.getElementById("pickup-location").value
      const dropoffLocation = document.getElementById("dropoff-location").value
      const pickupDate = document.getElementById("pickup-date").value
      const pickupTime = document.getElementById("pickup-time").value
      const dropoffDate = document.getElementById("dropoff-date").value
      const dropoffTime = document.getElementById("dropoff-time").value
      const driverAge = document.getElementById("driver-age").value

      if (!pickupLocation || !dropoffLocation || !pickupDate || !pickupTime || !dropoffDate || !dropoffTime) {
        alert("Please fill in all required fields")
        return
      }

      // Create form and submit
      const form = document.createElement("form")
      form.method = "GET"
      form.action = "car-search.php"

      const addInput = (name, value) => {
        const input = document.createElement("input")
        input.type = "hidden"
        input.name = name
        input.value = value
        form.appendChild(input)
      }

      addInput("pickup_location", pickupLocation)
      addInput("dropoff_location", dropoffLocation)
      addInput("pickup_date", pickupDate)
      addInput("pickup_time", pickupTime)
      addInput("dropoff_date", dropoffDate)
      addInput("dropoff_time", dropoffTime)
      addInput("driver_age", driverAge)

      document.body.appendChild(form)
      form.submit()
    })
  }

  // Booking cancellation
  const cancelBookingBtns = document.querySelectorAll(".cancel-booking-btn")
  if (cancelBookingBtns.length > 0) {
    cancelBookingBtns.forEach((btn) => {
      btn.addEventListener("click", function () {
        if (confirm("Are you sure you want to cancel this booking?")) {
          const bookingId = this.getAttribute("data-booking-id")
          const bookingType = this.getAttribute("data-booking-type")

          // Create form and submit
          const form = document.createElement("form")
          form.method = "POST"
          form.action = "cancel-booking.php"

          const idInput = document.createElement("input")
          idInput.type = "hidden"
          idInput.name = "booking_id"
          idInput.value = bookingId
          form.appendChild(idInput)

          const typeInput = document.createElement("input")
          typeInput.type = "hidden"
          typeInput.name = "booking_type"
          typeInput.value = bookingType
          form.appendChild(typeInput)

          document.body.appendChild(form)
          form.submit()
        }
      })
    })
  }
})
