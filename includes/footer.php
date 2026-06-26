    </div>
    <!-- End Main Content -->

</div>
<!-- End Wrapper -->

<!-- ==============================
     Back To Top
================================ -->

<button id="backToTop" class="back-to-top">

    <i class="bi bi-arrow-up"></i>

</button>

<!-- ==============================
     Footer
================================ -->

<footer class="footer">

    <div class="container-fluid">

        <div class="row align-items-center">

            <div class="col-md-6">

                <strong>Smart Academic Profile</strong>

                <br>

                <small>

                    Semantic Web Project © <?= date('Y'); ?>

                </small>

            </div>

            <div class="col-md-6 text-md-end">

                <small>

                    Developed by

                    <strong>

                        <?= APP_AUTHOR ?>

                    </strong>

                </small>

            </div>

        </div>

    </div>

</footer>

<!-- ==============================
     Bootstrap JS
================================ -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ==============================
     Main Javascript
================================ -->

<script src="<?= BASE_URL ?>assets/js/app.js"></script>

<!-- ==============================
     Sidebar Toggle
================================ -->

<script>

const toggleButton = document.getElementById("toggleSidebar");

if(toggleButton){

    toggleButton.addEventListener("click",function(){

        document.body.classList.toggle("sidebar-close");

    });

}

</script>

<!-- ==============================
     Back To Top
================================ -->

<script>

const backToTop=document.getElementById("backToTop");

window.addEventListener("scroll",function(){

    if(window.scrollY>300){

        backToTop.classList.add("show");

    }else{

        backToTop.classList.remove("show");

    }

});

backToTop.addEventListener("click",function(){

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

});

</script>

<!-- ==============================
     Auto Close Alert
================================ -->

<script>

setTimeout(function(){

let alert=document.querySelector(".alert");

if(alert){

alert.classList.remove("show");

}

},3000);

</script>

</body>

</html>