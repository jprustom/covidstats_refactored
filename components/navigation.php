
<section id="navbar">
    <img src=<?php echo((($inside_routes || $inside_utils)?'..':'.')."/images/icon.png") ?> />
    <nav id="links">
        <a id="home" href=<?php echo(Configs::getPathToHome()); ?>>Last Stats</a>
        <a href=<?php echo(Configs::getPathToRoutes("add")); ?>>Add Stats</a>
        <a href=<?php  echo(Configs::getPathToRoutes("add_country")); ?>>Add Country</a>
    </nav>
</section>

<script>
    document.querySelector('#navbar>img').addEventListener('click',()=>{
        document.getElementById('home').click();
    });
</script>

