    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>

        <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'Admin') : ?>
            <div id="marginBox"></div>
            <nav id="nav" class="navbar smart-scroll navbar-expand-lg navbar-light bg-light fixed-top">
                <a class="navbar-brand" id="home" href="/brewsoft/mvc/public/manager/planBatch">BrewSoft</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item active">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/planBatch"><i class="fa fa-calendar-alt" aria-hidden="true"></i>Plan batch <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/batchQueue"><i class="fas fa-th-list" aria-hidden="true"></i>batch queue</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/batchReport"><i class="fa fa-picture-o" aria-hidden="true"></i>batch report</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/completedBatches"><i class="fas fa-clipboard-list" aria-hidden="true"></i>completed batches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/displayOeeForDay"><i class="far fa-chart-bar" aria-hidden="true"></i>Display Oee for day</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/Worker/dashboardWorker"><i class="fas fa-boxes" aria-hidden="true"></i>productionview W</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/managerdashboard"><i class="fas fa-boxes" aria-hidden="true"></i>productionview M</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <li class="nav-item">
                            <form method="post" action="/brewsoft/mvc/public/admin/logout">
                                <button name="logoutbtn" id="logoutbtn" type="submit" class="btn btn-default">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> logout
                                </button>
                            </form>
                        </li>
                    </span>
                </div>
            </nav>
        <?php endif; ?>

        <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'Manager') : ?>
            <div id="marginBox"></div>
            <nav id="nav" class="navbar smart-scroll navbar-expand-lg navbar-light bg-light fixed-top">
                <a class="navbar-brand" id="home" href="/brewsoft/mvc/public/manager/planBatch">BrewSoft</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item active">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/planBatch"><i class="fa fa-calendar-alt" aria-hidden="true"></i>Plan batch <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/batchQueue"><i class="fas fa-th-list" aria-hidden="true"></i>batch queue</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/batchReport"><i class="fa fa-picture-o" aria-hidden="true"></i>batch report</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/completedBatches"><i class="fas fa-clipboard-list" aria-hidden="true"></i>completed batches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/displayOeeForDay"><i class="far fa-chart-bar" aria-hidden="true"></i>Display Oee for day</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/brewsoft/mvc/public/manager/managerdashboard"><i class="fas fa-boxes" aria-hidden="true"></i>productionview</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <li class="nav-item">
                            <form method="post" action="/brewsoft/mvc/public/manager/logout">
                                <button name="logoutbtn" id="logoutbtn" type="submit" class="btn btn-default">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> logout
                                </button>
                            </form>
                        </li>
                    </span>
                </div>
            </nav>

        <?php else : ?>

        <?php endif; ?>
        <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'Worker') : ?>
            <div id="marginBox"></div>
            <nav id="nav" class="navbar smart-scroll navbar-expand-lg navbar-light bg-light fixed-top">
                <a class="navbar-brand" id="home" href="/brewsoft/mvc/public/MachineApi/index">BrewSoft</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item active">
                            <a class="nav-link" href="/brewsoft/mvc/public/MachineApi/index"><i class="fas fa-boxes" aria-hidden="true"></i>Productioninfo <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" href="/brewsoft/mvc/public/breweryworker/"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Text here</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/brewsoft/mvc/public/breweryworker/"><i class="fa fa-picture-o" aria-hidden="true"></i>Text here</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/brewsoft/mvc/public/breweryworker/"><i class="fa fa-users" aria-hidden="true"></i>Text here</a>
                    </li> -->
                    </ul>
                    <span class="navbar-text">
                        <li class="nav-item">
                            <form method="post" action="/brewsoft/mvc/public/MachineApi/logout">
                                <button name="logoutbtn" id="logoutbtn" type="submit" class="btn btn-default">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> logout
                                </button>
                            </form>
                        </li>
                    </span>
                </div>
            </nav>

        <?php endif; ?>
    <?php else : ?>

        <?php include_once '../app/views/home/login.php'; ?>

    <?php endif; ?>
