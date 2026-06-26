<nav class="top-navbar">

    <div class="navbar-left">

        <button id="toggleSidebar">

            <i class="bi bi-list"></i>

        </button>

        <h5>

            <?= $pageTitle ?? "Dashboard"; ?>

        </h5>

    </div>

    <div class="navbar-right">

        <div class="profile-info">

            <img src="<?= BASE_URL ?>assets/images/default-user.png"
                 class="profile-photo"
                 alt="Profile">

            <div>

                <strong>Munirotun Ni'mah</strong>

                <small>Ilmu Komputer</small>

            </div>

        </div>

    </div>

</nav>

<div class="main-content">