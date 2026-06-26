/*
==========================================================
SMART ACADEMIC PROFILE
Main Javascript
==========================================================
*/

"use strict";

/* ======================================================
   Sidebar Toggle
====================================================== */

const toggleSidebar = document.getElementById("toggleSidebar");

if (toggleSidebar) {

    toggleSidebar.addEventListener("click", function () {

        document.body.classList.toggle("sidebar-close");

    });

}

/* ======================================================
   Active Menu Hover
====================================================== */

const menuItems = document.querySelectorAll(".sidebar-menu a");

menuItems.forEach(item => {

    item.addEventListener("mouseenter", function () {

        this.style.transition = ".3s";

    });

});

/* ======================================================
   Back To Top
====================================================== */

const backTop = document.getElementById("backToTop");

if (backTop) {

    window.addEventListener("scroll", function () {

        if (window.scrollY > 300) {

            backTop.classList.add("show");

        } else {

            backTop.classList.remove("show");

        }

    });

    backTop.addEventListener("click", function () {

        window.scrollTo({

            top: 0,

            behavior: "smooth"

        });

    });

}

/* ======================================================
   Auto Close Alert
====================================================== */

setTimeout(function () {

    const alert = document.querySelector(".alert");

    if (alert) {

        alert.classList.remove("show");

    }

}, 3000);

/* ======================================================
   Confirm Delete
====================================================== */

const deleteButtons = document.querySelectorAll(".btn-delete");

deleteButtons.forEach(button => {

    button.addEventListener("click", function (e) {

        if (!confirm("Yakin ingin menghapus data ini?")) {

            e.preventDefault();

        }

    });

});

/* ======================================================
   Preview Upload Image
====================================================== */

const uploadInput = document.getElementById("uploadImage");

if (uploadInput) {

    uploadInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {

            const preview = document.getElementById("previewImage");

            if (preview) {

                preview.src = e.target.result;

            }

        };

        reader.readAsDataURL(file);

    });

}

/* ======================================================
   Progress Animation
====================================================== */

const progressBars = document.querySelectorAll(".progress-bar");

progressBars.forEach(bar => {

    const value = bar.getAttribute("aria-valuenow");

    bar.style.width = value + "%";

});

/* ======================================================
   Counter Animation
====================================================== */

const counters = document.querySelectorAll(".counter");

counters.forEach(counter => {

    counter.innerText = "0";

    const updateCounter = () => {

        const target = +counter.getAttribute("data-target");

        const current = +counter.innerText;

        const increment = target / 50;

        if (current < target) {

            counter.innerText = Math.ceil(current + increment);

            setTimeout(updateCounter, 20);

        } else {

            counter.innerText = target;

        }

    };

    updateCounter();

});

/* ======================================================
   Copy JSON-LD
====================================================== */

const copyButton = document.getElementById("copyJson");

if (copyButton) {

    copyButton.addEventListener("click", function () {

        const json = document.getElementById("jsonld");

        if (!json) return;

        navigator.clipboard.writeText(json.innerText);

        alert("JSON-LD berhasil disalin.");

    });

}

/* ======================================================
   Search Table
====================================================== */

const searchInput = document.getElementById("searchTable");

if (searchInput) {

    searchInput.addEventListener("keyup", function () {

        let keyword = this.value.toLowerCase();

        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {

            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ""
                : "none";

        });

    });

}

/* ======================================================
   Like Button
====================================================== */

const likeButton = document.getElementById("likeButton");

if (likeButton) {

    likeButton.addEventListener("click", function () {

        this.classList.toggle("text-danger");

        this.classList.toggle("text-secondary");

    });

}

/* ======================================================
   Tooltip Bootstrap
====================================================== */

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

tooltipTriggerList.forEach(function (tooltipTriggerEl) {

    new bootstrap.Tooltip(tooltipTriggerEl);

});

/* ======================================================
   Loading Finished
====================================================== */

window.addEventListener("load", function () {

    console.log("Smart Academic Profile Loaded Successfully.");

});