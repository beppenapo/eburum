<header id="header">
    <div id="titleWrap" class="head">
        <h1 class="textShadow">Eburum</h1>
        <h2 class="textShadow">Mappa di comunità delle evidenze storiche, archeologiche e naturalistiche del territorio di Eboli</h2>
    </div>
    <div id="headMenuWrap" class="head">
        <ul class="headmenu">
            <li><a href="#" class="openScheda textShadow" title="cerca un punto di interesse"><i class="fa fa-search"></i></a></li>
            <li>
                <?php if(!isset($_SESSION['id'])){?>
                <a href="#" class="openLogin textShadow" title="entra nell'area di lavoro"><i class="fa fa-user"></i></a></li>
                <?php } ?>
        </ul>
    </div> 
</header>
